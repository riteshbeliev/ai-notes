<?php

namespace Tests\Unit\Services\AI;

use Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

use App\Services\AI\GeminiService;


class GeminiServiceTest extends TestCase
{
    protected GeminiService $gemini;

    protected function setUp(): void {
        parent::setUp();
        $this->gemini = new GeminiService();
    }

    public function test_it_generates_a_summary_successfully(): void {
        Http::fake([
            '*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'This is an AI generated summary.']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $result = $this->gemini->generateSummary('Test note content.');

        $this->assertSame('This is an AI generated summary.', $result);

        Http::assertSent(function (Request $request) {
            return str_contains( $request->url(), ':generateContent') && $request['contents'][0]['parts'][0]['text'] !=='';
        });
    }

    public function test_it_returns_null_when_summary_api_fails(): void {
        Http::fake([
            '*' => Http::response([
                'error'=> ['message' => 'API error']
            ], 500),
        ]);

        $result = $this->gemini->generateSummary('Test content.');

        $this->assertNull($result);
    }

    public function test_it_returns_null_for_invalid_summary_response(): void {
        Http::fake([
            '*' => Http::response(['unexpected' => 'response'], 200),
        ]);
        $result = $this->gemini->generateSummary('Test content.');
        $this->assertNull($result);
    }

    public function test_it_generates_embedding_successfully(): void {
        $expectedEmbedding = [0.12, 0.34, 0.56, 0.78];

        Http::fake([
            '*' => Http::response([
                'embedding' =>['values' => $expectedEmbedding]
            ], 200),
        ]);

        $result = $this->gemini->generateEmbedding('Test content.');

        $this->assertSame($expectedEmbedding, $result);

        Http::assertSent(function (Request $request){
            return str_contains($request->url(), ':embedContent') && $request['content']['parts'][0]['text'] === 'Test content.';
        });
    }

    public function test_it_returns_null_when_embedding_api_fails(): void {
        Http::fake([
            '*' => Http::response([
                'error' => ['message' => 'Embedding API error']
            ], 500),
        ]);

        $result = $this->gemini->generateEmbedding('Test content.');
        $this->assertNull($result);
    }

    public function test_it_returns_null_for_invalid_embedding_response(): void{
        Http::fake([
            '*' => Http::response(['unexpected' => 'response'], 200),
        ]);

        $result = $this->gemini->generateEmbedding('Test content.');
        $this->assertNull($result);
    }
}
