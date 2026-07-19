<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\NoteAIController;
use App\Http\Controllers\Api\NoteSearchController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::apiResource('notes', NoteController::class);

    Route::post('/notes/{note}/summary', [NoteAIController::class, 'generateSummary']);

    Route::post('/notes/{note}/embedding', [NoteAIController::class, 'generateEmbedding']);

    Route::post('/notes/search', [NoteSearchController::class, 'search']);
})->middleware('throttle:60,1');

