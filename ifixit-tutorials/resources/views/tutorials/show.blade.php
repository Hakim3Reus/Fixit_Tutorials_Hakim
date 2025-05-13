@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <a href="/tutorials" class="text-blue-600 hover:underline">&larr; Tornar</a>

    <h1 class="text-3xl font-bold mt-2">{{ $tutorial->title }}</h1>
    <p class="text-gray-700 mt-2">{{ $tutorial->description }}</p>

    <div class="mt-6 space-y-8">
        @foreach($tutorial->steps->sortBy('order') as $step)
        <div class="border-t pt-6">
            <p class="text-lg font-semibold text-gray-800">Pas {{ $loop->iteration }}</p>
            <p class="mt-2">{{ $step->translated_instructions }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                @foreach($step->images as $img)
                <img src="{{ $img->url }}" class="rounded-lg shadow-md">
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
