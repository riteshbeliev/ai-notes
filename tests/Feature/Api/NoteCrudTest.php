<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;

use App\Models\Note;
use App\Services\NoteService;
use App\Services\AI\GeminiService;

class NoteCrudTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_notes_can_be_listed(): void {
        Note::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/notes');

        $response->assertOk()->assertJsonPath('success', true)->assertJsonCount(3, 'data.items');
    }

    // public function test_notes_can_be_created(): void {
    //     $this->mock(NoteService::class, function($mock){
    //         $mock->shouldReceive('create')->once()->andReturn(
    //             Note::factory()->make([
    //                 'id' => 1,
    //                 'title' => 'Test Note',
    //                 'content' => 'This is test content.',
    //                 'summary' => 'Test summary.'
    //             ])
    //         );
    //     });

    //     $response = $this->postJson('/api/v1/notes', [
    //         'title' => 'Test Note',
    //         'content' => 'This is test content.',
    //     ]);

    //     $response->assertCreated()->assertJsonPath('success', true)->assertJsonPath('data.title', 'Test Note')->assertJsonPath('data.summary', 'Test summary.');
    // }

    public function test_note_can_be_created(): void {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateSummary')
                ->once()
                ->with('This is test content.')
                ->andReturn('Test summary.');
        });

        $response = $this->postJson('/api/v1/notes', [
            'title' => 'Test Note',
            'content' => 'This is test content.',
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.title', 'Test Note')
            ->assertJsonPath('data.summary', 'Test summary.');

        $this->assertDatabaseHas('notes', [
            'title' => 'Test Note',
            'content' => 'This is test content.',
            'summary' => 'Test summary.',
        ]);
    }

    public function test_note_creation_requires_title_and_content(): void {
        $response = $this->postJson('/api/v1/notes', []);

        $response->assertUnprocessable()->assertJsonValidationErrors(['title', 'content']);
    }

    public function test_existing_note_can_be_shown(): void {
        $note = Note::factory()->create();

        $response = $this->getJson('/api/v1/notes/'. $note->id);

        $response->assertOk()->assertJsonPath('success', true)->assertJsonPath('data.id', $note->id)->assertJsonPath('data.title', $note->title);
    }

    public function test_missing_note_returns_404(): void {
        $response = $this->getJson('/api/v1/notes/999999');
        $response->assertNotFound();
    }

    public function test_note_can_be_updated(): void {
        $note = Note::factory()->create();

        $response = $this->putJson('/api/v1/notes/'. $note->id, [
            'title' => 'Updated Note',
            'content' => 'Updated content.'
        ]);

        $response->assertOk()->assertJsonPath('success', true)->assertJsonPath('data.title', 'Updated Note')->assertJsonPath('data.content', 'Updated content.');

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => 'Updated Note'
        ]);

    } 

    public function test_note_can_be_deleted(): void {
        $note = Note:: factory()->create();

        $response = $this->deleteJson('/api/v1/notes/' . $note->id);

        $response->assertOk()->assertJsonPath('success', true);

        $this->assertSoftDeleted('notes', [
            'id' => $note->id,
        ]);
    }

    public function test_deleted_note_cannot_be_retrieved(): void {
        $note = Note::factory()->create();

        $note->delete();

        $response = $this->getJson('/api/v1/notes/' . $note->id);

        $response->assertNotFound();
    }
}
