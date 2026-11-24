<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Services\AI\GeminiService;
use App\Services\AI\VectorSearchService;

class NoteSearchController extends Controller
{
    public function __construct(
        protected GeminiService $gemini,
        protected VectorSearchService $vectorSearch
    ) {}

    public function search(Request $request)
    {
        $request->validate([
            'query' => ['required', 'string']
        ]);

        $query = $request->input('query');

        $queryEmbedding = $this->gemini->generateEmbedding($query);

        if (!$queryEmbedding) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to generate embedding.'
            ], 500);

        }

        $notes = Note::whereNotNull('embedding')->get();

        $results = [];

        foreach ($notes as $note) {

            // $embedding = json_decode($note->embedding, true);
            
            // if (!$embedding) {
            //     continue;
            // }


            $embedding = is_string($note->embedding) ? json_decode($note->embedding, true) : $note->embedding;

            if (!is_array($embedding)) {
                return null;
            }

            $score = $this->vectorSearch->cosineSimilarity(
                $queryEmbedding,
                $embedding
            );

            $results[] = [

                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'summary' => $note->summary,
                'score' => round($score, 4),
                'updated_at' => $note->updated_at,

            ];

        }

        usort($results, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return response()->json([
            'success' => true,
            'results' => $results,
        ]);
    }
}
