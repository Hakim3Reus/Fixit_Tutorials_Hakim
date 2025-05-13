<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IFixitService;
use App\Models\Tutorial;
use App\Models\Step;
use App\Models\Image;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class ImportTutorials extends Command
{
    protected $signature = 'import:tutorials';
    protected $description = 'Importar tutorials des de l API d iFixit';

    public function handle()
    {
        $service = new IFixitService();
        $translator = new GoogleTranslate('ca');

        $tutorials = array_slice($service->getTutorials('Smartphones'), 3, 20);

        foreach ($tutorials as $guide) {
            $details = $service->getTutorialDetails($guide['guideid']);

            $translatedTitle = $this->translateText($translator, $guide['title']);
            $translatedDescription = $this->translateText($translator, $guide['summary'] ?? $guide['description'] ?? '');

            $tutorial = Tutorial::create([
                'title' => $translatedTitle,
                'description' => $translatedDescription,
                'category' => $guide['category'],
                'original_content' => json_encode($guide)
            ]);

            if (empty($details['steps'])) {
                Log::warning("No hi ha passos per al tutorial: {$guide['guideid']}");
                continue;
            }

            foreach ($details['steps'] as $step) {
                Log::info("Processant pas - Guide ID: {$guide['guideid']}", ['step' => $step]);

                $originalText = '';
                if (!empty($step['lines'])) {
                    foreach ($step['lines'] as $line) {
                        if (!empty($line['text_raw'])) {
                            $originalText .= $line['text_raw'] . "\n";
                        }
                    }
                    $originalText = trim($originalText);
                }

                if (empty($originalText)) {
                    $originalText = $step['text'] ?? $step['title'] ?? $step['description'] ?? '';
                }

                if (trim($originalText) === '') {
                    Log::warning("Text original buit", [
                        'guide_id' => $guide['guideid'],
                        'step_id' => $step['stepid']
                    ]);
                    $originalText = '[Sense text original]';
                    $translatedInstructions = '[Text no disponible]';
                } else {
                    try {
                        $translatedInstructions = $this->translateText($translator, $originalText);
                    } catch (\Exception $e) {
                        Log::error("Error traduint pas: " . $e->getMessage());
                        $translatedInstructions = '[Error de traduccio]';
                    }
                }

                try {
                    $stepModel = Step::create([
                        'tutorial_id' => $tutorial->id,
                        'instructions' => $originalText,
                        'translated_instructions' => $translatedInstructions,
                        'order' => $step['order'] ?? $step['stepid'] ?? 0
                    ]);

                    Log::info("Pas creat correctament - ID: {$stepModel->id}");

                    if (isset($step['media']['data'])) {
                        Log::info("Processant imatges per al pas: {$step['stepid']}");
                        foreach ($step['media']['data'] as $image) {
                            $imageUrl = $image['original'] ?? $image['standard'] ?? $image['thumbnail'] ?? 'https://placehold.co/600x400';

                            Image::create([
                                'step_id' => $stepModel->id,
                                'url' => $imageUrl
                            ]);
                        }
                    } else {
                        Log::warning("No hi ha imatges per al pas: {$step['stepid']}");
                    }

                } catch (\Exception $e) {
                    Log::error("Error creant pas: " . $e->getMessage());
                    continue;
                }

                sleep(2);
            }

            $this->info("Tutorial importat: {$translatedTitle}");
        }
    }

    protected function translateText($translator, $text)
    {
        if (empty($text)) {
            return '[Text no disponible]';
        }

        try {
            Log::info("Traduint: {$text}");
            $translatedText = $translator->translate($text);
            Log::info("Traduccio correcta: {$translatedText}");
            return $translatedText;
        } catch (\Exception $e) {
            Log::error("Error traduint: " . $e->getMessage());
            sleep(10);
            return '[Error en traduccio]';
        }
    }
}
