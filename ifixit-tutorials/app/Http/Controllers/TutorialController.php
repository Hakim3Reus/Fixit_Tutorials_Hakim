<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $tutorials = Tutorial::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%");
        })->paginate(6);

        return view('tutorials.index', compact('tutorials', 'search'));
    }

    public function show($id)
    {
        $tutorial = Tutorial::with('steps.images')->findOrFail($id);
        return view('tutorials.show', compact('tutorial'));
    }
}

