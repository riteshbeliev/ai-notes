<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    /**
     * Generate an AI summary.
     */
    public function generateSummary(string $content): ?string
    {
        try {

            $response = Http::timeout(60)
                ->post(
                    config('gemini.base_url')
                    . '/models/'
                    . config('gemini.model')
                    . ':generateContent?key='
                    . config('gemini.api_key'),
                    [

                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' =>
                                            "Summarize the following note in 2-3 concise professional sentences.\n\n"
                                            . $content,
                                    ],
                                ],
                            ],
                        ],

                    ]
                );

            if (!$response->successful()) {

                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }

            $data = $response->json();

            return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        } catch (\Throwable $e) {

            Log::error('Gemini Exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Generate vector embedding for semantic search.
     */
    public function generateEmbedding(string $content): ?array
    {
        try {

            $model = config('gemini.embedding_model');

            $response = Http::withoutVerifying()
                ->timeout(60)
                ->post(
                    config('gemini.base_url')
                    . "/models/{$model}:embedContent?key="
                    . config('gemini.api_key'),
                    [

                        'model' => "models/{$model}",

                        'content' => [

                            'parts' => [
                                [
                                    'text' => $content,
                                ],
                            ],

                        ],

                    ]
                );

            if (!$response->successful()) {

                Log::error('Gemini Embedding API Error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return null;
            }

            $data = $response->json();

            return $data['embedding']['values'] ?? null;

        } catch (\Throwable $e) {

            Log::error('Gemini Embedding Exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }
}