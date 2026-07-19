<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class NotePageController extends Controller
{
    /**
     * Dashboard / Notes Listing
     */
    public function index(): View
    {
        return view('notes.index');
    }

    /**
     * Create Note Page
     */
    public function create(): View
    {
        return view('notes.create');
    }

    /**
     * View Note Page
     */
    public function show(int $note): View
    {
        return view('notes.show', [
            'note' => $note,
        ]);
    }

    /**
     * Edit Note Page
     */
    public function edit(int $note): View
    {
        return view('notes.edit', [
            'note' => $note,
        ]);
    }
}