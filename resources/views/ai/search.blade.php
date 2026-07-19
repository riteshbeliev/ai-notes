@extends('layouts.app')

@section('title', 'Semantic Search')

@section('page-title', 'Semantic Search')

@section('content')

<div class="space-y-8">

    <!-- Header -->

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">

                Semantic Search

            </h2>

            <p class="mt-2 text-slate-500">

                Search your notes using AI-powered semantic similarity instead of exact keyword matching.

            </p>

        </div>

        <div
            class="inline-flex items-center gap-2 rounded-full bg-violet-100 px-4 py-2 text-sm font-semibold text-violet-700">

            <i class="bi bi-stars"></i>

            Powered by Gemini Embeddings

        </div>

    </div>

    <!-- Search Card -->

    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">

        <label class="block font-semibold text-slate-700 mb-3">

            Search Query

        </label>

        <div class="flex flex-col lg:flex-row gap-4">

            <input
                id="searchQuery"
                type="text"
                placeholder="Example: Laravel authentication, PHP framework, AI notes..."
                class="flex-1 rounded-xl border border-slate-300 px-5 py-4 focus:ring-2 focus:ring-violet-500 focus:outline-none">

            <button
                id="searchBtn"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-violet-600 px-6 py-4 text-white hover:bg-violet-700 transition">

                <i class="bi bi-search"></i>

                Search

            </button>

            <button
                id="clearButton"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-200 px-6 py-4 text-slate-700 hover:bg-slate-300 transition">

                <i class="bi bi-arrow-clockwise"></i>

                Clear

            </button>

        </div>

    </div>

    <!-- Loading -->

    <div
        id="searchLoader"
        class="hidden bg-white rounded-2xl shadow-lg border border-slate-200 p-10">

        <div class="flex flex-col items-center">

            <div
                class="w-12 h-12 border-4 border-violet-600 border-t-transparent rounded-full animate-spin">
            </div>

            <p class="mt-4 text-slate-500">

                Searching similar notes...

            </p>

        </div>

    </div>

    <!-- Empty State -->

    <div
        id="emptySearchState"
        class="hidden bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">

        <div class="text-6xl mb-4">

            🔍

        </div>

        <h3 class="text-2xl font-bold text-slate-700">

            No Matching Notes

        </h3>

        <p class="mt-3 text-slate-500">

            Try another search phrase.

        </p>

    </div>

    <!-- Search Results -->

    <div
        id="searchResults"
        class="space-y-6">

        <!-- Results will be inserted dynamically -->

    </div>

</div>

@endsection