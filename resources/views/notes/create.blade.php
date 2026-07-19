@extends('layouts.app')

@section('title', 'Create Note')

@section('page-title', 'Create Note')

@section('content')

<div class="space-y-8">

    <!-- Breadcrumb -->

    <nav class="flex items-center text-sm text-slate-500">

        <a href="{{ route('notes.dashboard') }}" class="hover:text-blue-600">
            Dashboard
        </a>

        <i class="bi bi-chevron-right mx-2 text-xs"></i>

        <span class="text-slate-700 font-medium">
            Create Note
        </span>

    </nav>

    <!-- Page Header -->

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">

                Create New Note

            </h2>

            <p class="text-slate-500 mt-2">

                Capture your ideas and let AI organize them later.

            </p>

        </div>

    </div>

    <!-- Main Grid -->

    <div class="grid lg:grid-cols-3 gap-8">

        <!-- Form -->

        <div class="lg:col-span-2">

            <div class="bg-white rounded-2xl shadow-lg border border-slate-200">

                <div class="border-b px-8 py-6">

                    <h3 class="text-xl font-semibold">

                        Note Information

                    </h3>

                </div>

                <div class="p-8">

                    <form id="createNoteForm">

                        @csrf

                        <!-- Title -->

                        <div class="mb-6">

                            <label class="block text-sm font-semibold mb-2">

                                Note Title

                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                placeholder="Enter note title..."
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                            <small id="titleError" class="text-red-600"></small>

                        </div>

                        <!-- Content -->

                        <div class="mb-6">

                            <label class="block text-sm font-semibold mb-2">

                                Note Content

                            </label>

                            <textarea
                                id="content"
                                name="content"
                                rows="12"
                                placeholder="Write your note here..."
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"></textarea>

                            <div class="flex justify-between mt-2">

                                <small id="contentError" class="text-red-600"></small>

                                <small class="text-slate-500">

                                    Characters:
                                    <span id="characterCount">0</span>

                                </small>

                            </div>

                        </div>

                        <!-- Buttons -->

                        <div class="flex flex-wrap gap-4">

                            <button
                                type="submit"
                                id="saveButton"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition">

                                <i class="bi bi-check-circle"></i>

                                Save Note

                            </button>

                            <a href="{{ route('notes.index') }}"
                                class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-xl transition">

                                <i class="bi bi-arrow-left"></i>

                                Cancel

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <!-- Sidebar -->

        <div>

            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 sticky top-24">

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">

                        <i class="bi bi-stars text-blue-600 text-xl"></i>

                    </div>

                    <div>

                        <h3 class="font-bold">

                            AI Assistant

                        </h3>

                        <p class="text-sm text-slate-500">

                            Ready to enhance your notes

                        </p>

                    </div>

                </div>

                <div class="space-y-4">

                    <div class="flex gap-3">

                        <i class="bi bi-check-circle-fill text-green-500 mt-1"></i>

                        <div>

                            <h4 class="font-semibold">

                                AI Summary

                            </h4>

                            <p class="text-sm text-slate-500">

                                Automatic summaries will be generated after AI integration.

                            </p>

                        </div>

                    </div>

                    <div class="flex gap-3">

                        <i class="bi bi-check-circle-fill text-green-500 mt-1"></i>

                        <div>

                            <h4 class="font-semibold">

                                Semantic Search

                            </h4>

                            <p class="text-sm text-slate-500">

                                Search by meaning instead of keywords.

                            </p>

                        </div>

                    </div>

                    <div class="flex gap-3">

                        <i class="bi bi-check-circle-fill text-green-500 mt-1"></i>

                        <div>

                            <h4 class="font-semibold">

                                OpenAI Embeddings

                            </h4>

                            <p class="text-sm text-slate-500">

                                Vector embeddings will power intelligent search.

                            </p>

                        </div>

                    </div>

                </div>

                <hr class="my-6">

                <div>

                    <h4 class="font-semibold mb-3">

                        Tips

                    </h4>

                    <ul class="space-y-2 text-sm text-slate-600">

                        <li>• Use meaningful titles.</li>

                        <li>• Write detailed content.</li>

                        <li>• AI performs better with structured notes.</li>

                        <li>• Avoid very short descriptions.</li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection