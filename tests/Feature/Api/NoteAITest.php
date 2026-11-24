<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Note;
use App\Services\AI\GeminiService;


class NoteAITest extends TestCase
{
    use RefreshDatabase;

    public function test_summary_can_be_generated_for_a_note(): void {
        $note = Note::factory()->create([
            'content' => 'Water management is important.',
        ]);

        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateSummary')
                ->once()
                ->andReturn('Water management is essential.');
        });

        $response = $this->postJson(
            "/api/v1/notes/{$note->id}/summary"
        );

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath(
                'summary',
                'Water management is essential.'
            );

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'summary' => 'Water management is essential.',
        ]);
    }

    public function test_embedding_can_be_generated_for_a_note(): void {
        $note = Note::factory()->create([
            'content' => 'Water management is important.',
        ]);

        $embedding = [0.12, 0.34, 0.56, 0.78];

        $this->mock(GeminiService::class, function ($mock) use ($embedding) {
            $mock->shouldReceive('generateEmbedding')
                ->once()
                ->andReturn($embedding);
        });

        $response = $this->postJson(
            "/api/v1/notes/{$note->id}/embedding"
        );

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('dimensions', 4);

        $note->refresh();


        $this->assertSame(json_encode($embedding), $note->embedding);
    }

    public function test_summary_generation_failure_returns_500(): void {
        $note = Note::factory()->create();

        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateSummary')
                ->once()
                ->andReturn(null);
        });

        $response = $this->postJson(
            "/api/v1/notes/{$note->id}/summary"
        );

        $response->assertStatus(500)
            ->assertJsonPath('success', false);
    }

    public function test_embedding_generation_failure_returns_500(): void {
        $note = Note::factory()->create();

        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateEmbedding')
                ->once()
                ->andReturn(null);
        });

        $response = $this->postJson(
            "/api/v1/notes/{$note->id}/embedding"
        );

        $response->assertStatus(500)
            ->assertJsonPath('success', false);
    }
}
