<?php

namespace Tests\Unit\Services;

use App\Models\Note;
use App\Services\AI\GeminiService;
use App\Services\NoteService;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_note_with_generated_summary(): void
    {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateSummary')
                ->once()
                ->with('Water management is important.')
                ->andReturn('Water management is essential.');
        });

        $service = app(NoteService::class);

        $note = $service->create([
            'title' => 'Water Management',
            'content' => 'Water management is important.',
        ]);

        $this->assertInstanceOf(Note::class, $note);
        $this->assertSame('Water management is essential.', $note->summary);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => 'Water Management',
            'summary' => 'Water management is essential.',
        ]);
    }

    public function test_it_updates_note_content_and_regenerates_summary(): void
    {
        $note = Note::factory()->create([
            'title' => 'Old Title',
            'content' => 'Old content.',
            'summary' => 'Old summary.',
        ]);

        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateSummary')
                ->once()
                ->with('Updated water management content.')
                ->andReturn('Updated summary.');
        });

        $service = app(NoteService::class);

        $updatedNote = $service->update($note, [
            'title' => 'Updated Title',
            'content' => 'Updated water management content.',
        ]);

        $this->assertSame('Updated Title', $updatedNote->title);
        $this->assertSame('Updated summary.', $updatedNote->summary);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => 'Updated Title',
            'summary' => 'Updated summary.',
        ]);
    }

    public function test_it_does_not_regenerate_summary_when_only_title_is_updated(): void
    {
        $note = Note::factory()->create([
            'title' => 'Old Title',
            'content' => 'Existing content.',
            'summary' => 'Existing summary.',
        ]);

        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldNotReceive('generateSummary');
        });

        $service = app(NoteService::class);

        $updatedNote = $service->update($note, [
            'title' => 'New Title',
        ]);

        $this->assertSame('New Title', $updatedNote->title);
        $this->assertSame('Existing summary.', $updatedNote->summary);
    }

    public function test_it_creates_note_even_when_summary_generation_fails(): void
    {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateSummary')
                ->once()
                ->andReturn(null);
        });

        $service = app(NoteService::class);

        $note = $service->create([
            'title' => 'Water Management',
            'content' => 'Water management is important.',
        ]);

        $this->assertInstanceOf(Note::class, $note);
        $this->assertNull($note->summary);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'summary' => null,
        ]);
    }
}
