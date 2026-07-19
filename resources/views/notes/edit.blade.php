@extends('layouts.app')

@section('title', 'Edit Note')

@section('page-title', 'Edit Note')

@section('content')

<div class="space-y-8">

    <!-- Breadcrumb -->

    <nav class="flex items-center text-sm text-slate-500">

        <a href="{{ route('notes.dashboard') }}" class="hover:text-blue-600">
            Dashboard
        </a>

        <i class="bi bi-chevron-right mx-2 text-xs"></i>

        <span class="text-slate-700 font-medium">
            Edit Note
        </span>

    </nav>

    <!-- Page Header -->

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">

                Edit Note

            </h2>

            <p class="text-slate-500 mt-2">

                Update your note and keep your knowledge organized.

            </p>

        </div>

    </div>

    <div class="grid lg:grid-cols-3 gap-8">

        <!-- Main Form -->

        <div class="lg:col-span-2">

            <div class="bg-white rounded-2xl shadow-lg border border-slate-200">

                <div class="border-b px-8 py-6 flex items-center justify-between">

                    <h3 class="text-xl font-semibold">

                        Note Details

                    </h3>

                    <span id="loadingBadge"
                        class="hidden px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">

                        Loading...

                    </span>

                </div>

                <div class="p-8">

                    <form id="editNoteForm">

                        @csrf

                        <input type="hidden"
                            id="noteId"
                            value="{{ $note }}">

                        <!-- Title -->

                        <div class="mb-6">

                            <label class="block text-sm font-semibold mb-2">

                                Note Title

                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                            <small id="titleError"
                                class="text-red-600"></small>

                        </div>

                        <!-- Content -->

                        <div class="mb-6">

                            <label class="block text-sm font-semibold mb-2">

                                Note Content

                            </label>

                            <textarea id="content" name="content" rows="12" class="w-full rounded-xl border border-slate-300 px-4 py-3 resize-none focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>

                            <div class="flex justify-between mt-2">

                                <small id="contentError"
                                    class="text-red-600"></small>

                                <small class="text-slate-500">

                                    Characters:
                                    <span id="characterCount">0</span>

                                </small>

                            </div>

                            <div class="mt-8">

                                <div class="flex items-center justify-between mb-3">

                                    <label class="font-semibold text-slate-700">
                                        AI Summary
                                    </label>

                                    <button
                                        type="button"
                                        id="generateSummaryBtn"
                                        class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm">

                                        <i class="bi bi-stars"></i>

                                        Generate Summary

                                    </button>

                                </div>

                                <div id="summaryPreview"
                                    class="rounded-xl bg-violet-50 border border-violet-200 p-5 text-slate-700">

                                    AI summary will appear here.

                                </div>

                            </div>

                        </div>

                        

                        <!-- Buttons -->

                        <div class="flex gap-4">

                            <button
                                type="submit"
                                id="updateButton"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition">

                                <i class="bi bi-pencil-square"></i>

                                Update Note

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

                <div class="flex items-center gap-3 mb-6">

                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">

                        <i class="bi bi-pencil-square text-blue-600 text-xl"></i>

                    </div>

                    <div>

                        <h3 class="font-bold">

                            Note Information

                        </h3>

                        <p class="text-sm text-slate-500">

                            Current note status

                        </p>

                    </div>

                </div>

                <div class="space-y-5">

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Status

                        </span>

                        <span class="font-semibold text-green-600">

                            Active

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            AI Summary

                        </span>

                        <span id="summaryStatus"
                            class="font-semibold text-slate-700">

                            Pending

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Embeddings

                        </span>

                        <span class="font-semibold text-slate-700">

                            Pending

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Created

                        </span>

                        <span id="createdDate"
                            class="font-semibold">

                            --

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Last Updated

                        </span>

                        <span id="updatedDate"
                            class="font-semibold">

                            --

                        </span>

                    </div>

                </div>

                <hr class="my-6">

                <div>

                    <h4 class="font-semibold mb-3">

                        Editing Tips

                    </h4>

                    <ul class="space-y-2 text-sm text-slate-600">

                        <li>• Keep titles short and descriptive.</li>

                        <li>• Add detailed content for better AI summaries.</li>

                        <li>• Save changes regularly.</li>

                        <li>• Semantic search improves with richer content.</li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <div id="summaryLoading" class="hidden mt-3 text-violet-600 text-sm">

        <i class="bi bi-arrow-repeat animate-spin"></i>

        Generating AI Summary...

    </div>

</div>

@endsection