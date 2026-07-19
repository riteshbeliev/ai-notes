<?php

namespace App\Services;

use App\Models\Note;
use App\Services\AI\GeminiService;
use Illuminate\Support\Facades\Log;

class NoteService
{
    public function __construct(
        protected GeminiService $gemini
    ) {}

    /**
     * Create a note with AI summary.
     */
    public function create(array $data): Note
    {
        $summary = $this->gemini->generateSummary($data['content']);

        $data['summary'] = $summary;

        return Note::create($data);
    }

    /**
     * Update note with regenerated summary.
     */
    public function update(Note $note, array $data): Note
    {
        if (isset($data['content'])) {
            $data['summary'] = $this->gemini->generateSummary($data['content']);
        }

        $note->update($data);

        return $note->fresh();
    }
}