@extends('layouts.app')

@section('title', 'Notes Dashboard')

@section('page-title', 'Notes Dashboard')

@section('content')

<div class="space-y-8">

    <!-- Header -->

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">

                Welcome Back 👋

            </h2>

            <p class="text-slate-500 mt-2">

                Manage your notes, generate AI summaries and perform semantic searches.

            </p>

        </div>

        <a href="{{ route('notes.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg transition">

            <i class="bi bi-plus-circle"></i>

            Create Note

        </a>

    </div>

    <!-- Statistics -->

    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-slate-500">

                        Total Notes

                    </p>

                    <h3 class="text-4xl font-bold mt-3">

                        <span id="totalNotes">0</span>

                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

                    <i class="bi bi-journal-text text-blue-600 text-2xl"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-slate-500">

                        AI Summaries

                    </p>

                    <h3 class="text-4xl font-bold mt-3">

                        <span id="totalSummaries">0</span>


                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">

                    <i class="bi bi-robot text-green-600 text-2xl"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-slate-500">

                        Searches

                    </p>

                    <h3 class="text-4xl font-bold mt-3">

                        <span id="totalSearches">0</span>

                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center">

                    <i class="bi bi-search text-purple-600 text-2xl"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-slate-500">

                        API Status

                    </p>

                    <h3 class="text-2xl font-bold text-green-600 mt-4">

                        <span id="apiStatus">Live</span>

                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center">

                    <i class="bi bi-cloud-check text-orange-600 text-2xl"></i>

                </div>

            </div>

        </div>
    </div>

    <!-- AI Semantic Search -->

    <div class="bg-white rounded-2xl shadow p-6">

        <div class="flex items-center gap-3 mb-5">

            <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center">

                <i class="bi bi-stars text-violet-600 text-xl"></i>

            </div>

            <div>

                <h3 class="text-xl font-bold text-slate-800">

                    AI Semantic Search

                </h3>

                <p class="text-sm text-slate-500">

                    Search notes by meaning instead of exact keywords.

                </p>

            </div>

        </div>

        <div class="flex flex-col lg:flex-row gap-4">

            <div class="relative flex-1">

                <i class="bi bi-search absolute left-4 top-4 text-slate-400"></i>

                <input
                    id="semanticSearch"
                    type="text"
                    placeholder="Example: Laravel authentication, PHP framework, deployment..."
                    class="w-full rounded-xl border border-slate-300 pl-12 pr-4 py-3 focus:ring-2 focus:ring-violet-500 focus:outline-none">

            </div>

            <button
                id="searchButton"
                class="inline-flex items-center justify-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-6 py-3 rounded-xl transition">

                <i class="bi bi-search"></i>

                Search

            </button>

            <button
                id="clearSearch"
                class="inline-flex items-center justify-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-xl transition">

                <i class="bi bi-x-circle"></i>

                Clear

            </button>

        </div>

        <div
            id="searchStatus"
            class="hidden mt-5 rounded-xl bg-violet-50 border border-violet-200 px-4 py-3 text-sm text-violet-700">

        </div>

    </div>

    <!-- Notes Table -->

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="px-6 py-5 border-b">

            <h3 class="text-xl font-bold">

                Recent Notes

            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="text-left px-6 py-4 font-semibold">

                            Title

                        </th>

                        <th class="text-left px-6 py-4 font-semibold">

                            Summary

                        </th>

                        <th class="text-left px-6 py-4 font-semibold">
                            Similarity
                        </th>

                        <th class="text-left px-6 py-4 font-semibold">
                            Updated
                        </th>

                        <th class="text-center px-6 py-4 font-semibold">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody id="notesTableBody">

                </tbody>

            </table>

        </div>

    </div>

    <!-- Pagination -->

    <div id="paginationContainer" class="flex justify-end gap-2 mt-6">

        

    </div>

    <div id="loadingSpinner" class="hidden py-10">

        <div class="flex flex-col items-center justify-center">

            <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>

            <p class="mt-4 text-slate-500">

                Loading notes...

            </p>

        </div>

    </div>

    <div id="emptyState" class="hidden py-16 text-center">

        <div class="text-6xl mb-5">

            📄

        </div>

        <h3 class="text-2xl font-bold text-slate-700">

            No Notes Found

        </h3>

        <p class="text-slate-500 mt-3">

            Start by creating your first AI-powered note.

        </p>

        <a href="{{ route('notes.create') }}"
        class="inline-flex items-center gap-2 mt-8 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition">

            <i class="bi bi-plus-circle"></i>

            Create Note

        </a>

    </div>
</div>

@endsection