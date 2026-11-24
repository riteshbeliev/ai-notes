<?php

namespace Tests\Feature\Api;

use App\Models\Note;
use App\Services\AI\GeminiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_semantic_search_returns_matching_notes(): void
    {
        $note = Note::factory()->create([
            'title' => 'Water Management',
            'content' => 'Water management is important.',
            'embedding' => [1.0, 0.0],
        ]);

        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateEmbedding')
                ->once()
                ->with('water management')
                ->andReturn([1.0, 0.0]);
        });

        $response = $this->postJson('/api/v1/notes/search', [
            'query' => 'water management',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('results.0.id', $note->id)
            ->assertJsonPath('results.0.title', 'Water Management');
    }

    public function test_search_results_are_sorted_by_similarity(): void
    {
        $bestMatch = Note::factory()->create([
            'title' => 'Best Match',
            'embedding' => [1.0, 0.0],
        ]);

        $secondMatch = Note::factory()->create([
            'title' => 'Second Match',
            'embedding' => [0.8, 0.6],
        ]);

        $thirdMatch = Note::factory()->create([
            'title' => 'Third Match',
            'embedding' => [0.0, 1.0],
        ]);

        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateEmbedding')
                ->once()
                ->andReturn([1.0, 0.0]);
        });

        $response = $this->postJson('/api/v1/notes/search', [
            'query' => 'water',
        ]);

        $response->assertOk();

        $results = $response->json('results');

        $this->assertSame($bestMatch->id, $results[0]['id']);
        $this->assertSame($secondMatch->id, $results[1]['id']);
        $this->assertSame($thirdMatch->id, $results[2]['id']);

        $this->assertGreaterThan(
            $results[1]['score'],
            $results[0]['score']
        );

        $this->assertGreaterThan(
            $results[2]['score'],
            $results[1]['score']
        );
    }

    public function test_search_requires_a_query(): void
    {
        $response = $this->postJson('/api/v1/notes/search', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['query']);
    }

    public function test_search_returns_500_when_embedding_generation_fails(): void
    {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateEmbedding')
                ->once()
                ->andReturn(null);
        });

        $response = $this->postJson('/api/v1/notes/search', [
            'query' => 'water management',
        ]);

        $response->assertStatus(500)
            ->assertJsonPath('success', false);
    }
}
