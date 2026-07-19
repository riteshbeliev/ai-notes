<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Services\AI\GeminiService;
use Illuminate\Http\JsonResponse;

class NoteAIController extends Controller
{
    public function __construct(
        protected GeminiService $gemini
    ) {}

    public function generateSummary(Note $note): JsonResponse
    {
        $summary = $this->gemini->generateSummary($note->content);

        if (!$summary) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to generate summary.'
            ], 500);
        }

        $note->update([
            'summary' => $summary
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Summary generated successfully.',
            'summary' => $summary
        ]);
    }

    public function generateEmbedding(Note $note): JsonResponse
    {
        $embedding = $this->gemini->generateEmbedding($note->content);

        if (!$embedding) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to generate embedding.'
            ], 500);
        }

        $note->update([
            'embedding' => json_encode($embedding)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Embedding generated successfully.',
            'dimensions' => count($embedding)
        ]);
    }
}