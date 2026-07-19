<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotePageController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('notes')->name('notes.')->group(function () {

    Route::get('/', [NotePageController::class, 'index'])->name('dashboard');

    Route::get('/create', [NotePageController::class, 'create'])->name('create');

    Route::get('/{note}', [NotePageController::class, 'show'])->name('show');

    Route::get('/{note}/edit', [NotePageController::class, 'edit'])->name('edit');

});