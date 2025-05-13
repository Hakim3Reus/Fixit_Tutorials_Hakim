<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('steps', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tutorial_id')->constrained()->onDelete('cascade');
        $table->text('instructions');
        $table->text('translated_instructions')->nullable();
        $table->integer('order')->default(0);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
