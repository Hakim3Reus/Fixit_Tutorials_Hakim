@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Tutorials</h1>

    <form method="GET" class="mb-6">
        <input type="text" name="q" placeholder="Cerca un tutorial..." value="{{ $search }}"
               class="border p-2 rounded w-full md:w-1/3">
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($tutorials as $tutorial)
        <a href="{{ url('/tutorials/'.$tutorial->id) }}"
           class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
            <h2 class="text-xl font-semibold">{{ $tutorial->title }}</h2>
            <p class="text-gray-600 text-sm mt-2">{{ Str::limit($tutorial->description, 100) }}</p>
        </a>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $tutorials->links() }}
    </div>
</div>
@endsection
