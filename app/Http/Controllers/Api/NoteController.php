<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\NoteService;   

use OpenApi\Attributes as OA;

class NoteController extends Controller
{
    use ApiResponseTrait;
    
    protected NoteService $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }


    /**
     * Display a listing of notes.
     */
    #[OA\Get(
        path: "/api/v1/notes",
        operationId: "getNotes",
        tags: ["Notes"],
        summary: "Get all notes",
        description: "Returns paginated notes",
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function index(): JsonResponse
    {
        try {
            $limit = request()->integer('limit', 10);
            $limit = max(1, min($limit, 100));

            //$limit = request()->get('limit', 10);

            $notes = Note::latest()->paginate($limit);

            return $this->successResponse([
                'items' => NoteResource::collection($notes),
                'pagination' => [
                    'current_page' => $notes->currentPage(),
                    'last_page' => $notes->lastPage(),
                    'per_page' => $notes->perPage(),
                    'total' => $notes->total(),
                    'next_page_url' => $notes->nextPageUrl(),
                    'prev_page_url' => $notes->previousPageUrl(),
                ]
            ], 'Notes retrieved successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to retrieve notes.', [
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Failed to retrieve notes.',
                [],
                500
            );
        }
    }

    /**
     * Store a newly created note.
     */
    #[OA\Post(
        path: "/api/v1/notes",
        operationId: "createNote",
        tags: ["Notes"],
        summary: "Create Note",
        responses: [
            new OA\Response(
                response: 201,
                description: "Created"
            )
        ]
    )]
    public function store(StoreNoteRequest $request): JsonResponse
    {
        try {
            // $note = Note::create($request->validated());

            $note = $this->noteService->create( $request->validated() );

            Log::info('Note created successfully.', [
                'note_id' => $note->id
            ]);

            return $this->successResponse(
                new NoteResource($note),
                'Note created successfully.',
                201
            );
        } catch (\Throwable $e) {
            Log::error('Failed to create note.', [
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Failed to create note.',
                [],
                500
            );
        }
    }

    /**
     * Display the specified note.
     */
    #[OA\Get(
        path: "/api/v1/notes/{id}",
        operationId: "showNote",
        tags: ["Notes"],
        summary: "Show Note",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function show(Note $note): JsonResponse
    {
        return $this->successResponse(
            new NoteResource($note),
            'Note retrieved successfully.'
        );
    }

    /**
     * Update the specified note.
     */
    #[OA\Put(
        path: "/api/v1/notes/{id}",
        operationId: "updateNote",
        tags: ["Notes"],
        summary: "Update Note",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Updated"
            )
        ]
    )]
    public function update(UpdateNoteRequest $request, Note $note): JsonResponse
    {
        try {
            // $note->update($request->validated());
            $note = $this->noteService->update( $note, $request->validated() );

            Log::info('Note updated successfully.', [
                'note_id' => $note->id
            ]);

            // return $this->successResponse(
            //     new NoteResource($note->fresh()),
            //     'Note updated successfully.'
            // );
            return $this->successResponse(
                new NoteResource($note),
                'Note updated successfully.'
            );
        } catch (\Throwable $e) {
            Log::error('Failed to update note.', [
                'note_id' => $note->id,
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Failed to update note.',
                [],
                500
            );
        }
    }

    /**
     * Remove the specified note.
     */
    #[OA\Delete(
        path: "/api/v1/notes/{id}",
        operationId: "deleteNote",
        tags: ["Notes"],
        summary: "Delete Note",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Deleted"
            )
        ]
    )]
    public function destroy(Note $note): JsonResponse
    {
        try {
            $note->delete();

            Log::info('Note deleted successfully.', [
                'note_id' => $note->id
            ]);

            return $this->successResponse(
                null,
                'Note deleted successfully.'
            );
        } catch (\Throwable $e) {
            Log::error('Failed to delete note.', [
                'note_id' => $note->id,
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Failed to delete note.',
                [],
                500
            );
        }
    }
}