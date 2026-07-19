<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name') }}</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    <style>

        body{
            font-family:'Inter',sans-serif;
        }

        .hero-bg{
            background:
            radial-gradient(circle at top left,#2563eb 0%,transparent 35%),
            radial-gradient(circle at bottom right,#38bdf8 0%,transparent 30%),
            linear-gradient(135deg,#0f172a,#1e293b);
        }

    </style>

</head>
<body class="bg-slate-50">

<!-- ================= NAVBAR ================= -->

<nav class="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-slate-900/70 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center h-20">

            <a href="/"
               class="text-3xl font-extrabold text-white tracking-wide">

                <i class="bi bi-journal-richtext"></i>

                AI Notes Pro

            </a>

            <div class="hidden md:flex items-center gap-10">

                <a href="/"
                   class="text-white hover:text-blue-300 transition">

                    Home

                </a>

                <a href="/notes"
                   class="text-white hover:text-blue-300 transition">

                    Notes

                </a>

                <a href="/api/documentation"
                   class="text-white hover:text-blue-300 transition">

                    API Docs

                </a>

            </div>

            <a href="/notes"
               class="hidden md:inline-flex px-5 py-3 rounded-xl bg-white text-blue-700 font-semibold shadow-lg hover:scale-105 transition">

                Get Started

            </a>

        </div>

    </div>

</nav>

<!-- ================= HERO ================= -->

<section class="py-24 bg-slate-100">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid lg:grid-cols-2 gap-14 items-center">

            <!-- LEFT -->

            <div>

                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold mb-6">

                    <i class="bi bi-stars"></i>

                    Laravel 12 + Gemini AI Powered

                </span>

                <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight">

                    AI Notes Pro

                    <span class="text-blue-400">

                        Management

                    </span>

                    System

                </h1>

                <p class="mt-8 text-slate-900 text-xl leading-9">

                    Create, organize, summarize and intelligently search your
                    notes using Artificial Intelligence.

                    Built with Laravel 12, REST APIs and Gemini AI.

                </p>

                <div class="mt-10 flex flex-wrap gap-5">

                    <a href="/notes"
                       class="px-8 py-4 rounded-xl bg-blue-600 text-white font-semibold shadow-xl hover:bg-white hover:text-slate-900 transition">

                        <i class="bi bi-journal-plus"></i>

                        Open Dashboard

                    </a>

                    <a href="/api/documentation"
                       class="px-8 py-4 rounded-xl bg-blue-600 border border-white text-white hover:bg-white hover:text-slate-900 transition">

                        <i class="bi bi-code-slash"></i>

                        API Documentation

                    </a>

                </div>

                <div class="mt-12 flex flex-wrap gap-8 text-slate-900">

                    <div>

                        <h3 class="text-4xl font-bold">

                            CRUD

                        </h3>

                        <p class="text-slate-400">

                            Complete Note Management

                        </p>

                    </div>

                    <div>

                        <h3 class="text-4xl font-bold">

                            AI

                        </h3>

                        <p class="text-slate-400">

                            Smart Summaries

                        </p>

                    </div>

                    <div>

                        <h3 class="text-4xl font-bold">

                            Search

                        </h3>

                        <p class="text-slate-400">

                            Semantic Search

                        </p>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="relative">

                <div class="bg-white rounded-3xl shadow-2xl p-8">

                    <div class="flex justify-between items-center mb-6">

                        <h3 class="font-bold text-2xl">

                            Recent Note

                        </h3>

                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full">

                            AI Ready

                        </span>

                    </div>

                    <div class="space-y-6">

                        <div>

                            <h4 class="font-bold text-lg">

                                Laravel Assessment

                            </h4>

                            <p class="text-slate-500 mt-2">

                                Build a modern AI-powered Notes application
                                with CRUD, summaries and semantic search.

                            </p>

                        </div>

                        <hr>

                        <div>

                            <h5 class="font-semibold mb-3">

                                AI Summary

                            </h5>

                            <p class="text-slate-600">

                                This project demonstrates modern Laravel
                                development practices with AI integration,
                                RESTful APIs, Gemini AI summaries and
                                intelligent note search.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= FEATURES ================= -->

<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->

        <div class="text-center mb-16">

            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold">

                <i class="bi bi-stars"></i>

                Powerful Features

            </span>

            <h2 class="mt-6 text-4xl lg:text-5xl font-extrabold text-slate-900">

                Why Choose

                <span class="text-blue-600">

                    AI Notes Pro

                </span>

            </h2>

            <p class="mt-6 text-lg text-slate-600 max-w-3xl mx-auto">

                A modern note management platform combining Laravel,
                RESTful APIs and Artificial Intelligence to help users
                create, organize and discover information effortlessly.

            </p>

        </div>

        <!-- Cards -->

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

            <!-- CRUD -->

            <div class="group-hover:scale-110 transition bg-slate-50 rounded-3xl p-8 shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center mb-6">

                    <i class="bi bi-journal-check text-3xl text-blue-600"></i>

                </div>

                <h3 class="text-2xl font-bold text-slate-900">

                    Notes CRUD

                </h3>

                <p class="mt-4 text-slate-600 leading-7">

                    Create, edit, update and organize notes using a clean
                    and intuitive dashboard.

                </p>

            </div>

            <!-- AI Summary -->

            <div class="bg-slate-50 rounded-3xl p-8 shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center mb-6">

                    <i class="bi bi-robot text-3xl text-green-600"></i>

                </div>

                <h3 class="text-2xl font-bold text-slate-900">

                    AI Summary

                </h3>

                <p class="mt-4 text-slate-600 leading-7">

                    Automatically generate concise summaries using
                    Gemini AI to save time and improve productivity.

                </p>

            </div>

            <!-- Search -->

            <div class="bg-slate-50 rounded-3xl p-8 shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center mb-6">

                    <i class="bi bi-search text-3xl text-purple-600"></i>

                </div>

                <h3 class="text-2xl font-bold text-slate-900">

                    Semantic Search

                </h3>

                <p class="mt-4 text-slate-600 leading-7">

                    Find relevant notes using intelligent AI-powered
                    semantic search instead of simple keywords.

                </p>

            </div>

            <!-- API -->

            <div class="bg-slate-50 rounded-3xl p-8 shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <div class="w-16 h-16 rounded-2xl bg-orange-100 flex items-center justify-center mb-6">

                    <i class="bi bi-code-slash text-3xl text-orange-600"></i>

                </div>

                <h3 class="text-2xl font-bold text-slate-900">

                    REST API

                </h3>

                <p class="mt-4 text-slate-600 leading-7">

                    Secure Laravel APIs with Resources,
                    Validation, Pagination and Swagger
                    documentation.

                </p>

            </div>

        </div>

    </div>

</section>

<!-- ================= TECHNOLOGY STACK ================= -->

<section class="py-24 bg-slate-100">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->

        <div class="text-center mb-16">

            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold">

                <i class="bi bi-cpu"></i>

                Modern Technology Stack

            </span>

            <h2 class="mt-6 text-4xl lg:text-5xl font-extrabold text-slate-900">

                Built With

                <span class="text-blue-600">

                    Industry Standard Technologies

                </span>

            </h2>

            <p class="mt-6 text-lg text-slate-600 max-w-3xl mx-auto">

                AI Notes Pro is built using a modern technology stack focused on
                performance, scalability, maintainability, and developer productivity.

            </p>

        </div>

        <!-- Technology Grid -->

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            <!-- Laravel -->

            <div class="bg-white rounded-3xl p-8 text-center shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <i class="bi bi-layers text-5xl text-red-500"></i>

                <h4 class="mt-5 text-xl font-bold">

                    Laravel 13

                </h4>

                <p class="mt-2 text-slate-500">

                    PHP Framework

                </p>

            </div>

            <!-- PHP -->

            <div class="bg-white rounded-3xl p-8 text-center shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <i class="bi bi-filetype-php text-5xl text-indigo-600"></i>

                <h4 class="mt-5 text-xl font-bold">

                    PHP 8+

                </h4>

                <p class="mt-2 text-slate-500">

                    Backend Language

                </p>

            </div>

            <!-- Tailwind -->

            <div class="bg-white rounded-3xl p-8 text-center shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <i class="bi bi-palette text-5xl text-cyan-500"></i>

                <h4 class="mt-5 text-xl font-bold">

                    Tailwind CSS

                </h4>

                <p class="mt-2 text-slate-500">

                    Modern UI

                </p>

            </div>

            <!-- MySQL -->

            <div class="bg-white rounded-3xl p-8 text-center shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <i class="bi bi-database text-5xl text-amber-500"></i>

                <h4 class="mt-5 text-xl font-bold">

                    SqlLite

                </h4>

                <p class="mt-2 text-slate-500">

                    Database

                </p>

            </div>

            <!-- Gemini AI -->

            <div class="bg-white rounded-3xl p-8 text-center shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <i class="bi bi-robot text-5xl text-green-600"></i>

                <h4 class="mt-5 text-xl font-bold">

                    Gemini AI

                </h4>

                <p class="mt-2 text-slate-500">

                    AI Integration

                </p>

            </div>

            <!-- REST API -->

            <div class="bg-white rounded-3xl p-8 text-center shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <i class="bi bi-cloud-arrow-up text-5xl text-blue-500"></i>

                <h4 class="mt-5 text-xl font-bold">

                    REST API

                </h4>

                <p class="mt-2 text-slate-500">

                    JSON Resources

                </p>

            </div>

            <!-- Swagger -->

            <div class="bg-white rounded-3xl p-8 text-center shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <i class="bi bi-file-earmark-code text-5xl text-emerald-500"></i>

                <h4 class="mt-5 text-xl font-bold">

                    Swagger

                </h4>

                <p class="mt-2 text-slate-500">

                    API Documentation

                </p>

            </div>

            <!-- Axios -->

            <div class="bg-white rounded-3xl p-8 text-center shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">

                <i class="bi bi-lightning-charge text-5xl text-yellow-500"></i>

                <h4 class="mt-5 text-xl font-bold">

                    Axios

                </h4>

                <p class="mt-2 text-slate-500">

                    API Communication

                </p>

            </div>

        </div>

        <!-- Bottom Stats -->

        <div class="mt-20 grid grid-cols-2 lg:grid-cols-4 gap-8">

            <div class="text-center">

                <h3 class="text-5xl font-extrabold text-blue-600">

                    100%

                </h3>

                <p class="mt-2 text-slate-600">

                    RESTful APIs

                </p>

            </div>

            <div class="text-center">

                <h3 class="text-5xl font-extrabold text-green-600">

                    AI

                </h3>

                <p class="mt-2 text-slate-600">

                    Powered Summaries

                </p>

            </div>

            <div class="text-center">

                <h3 class="text-5xl font-extrabold text-purple-600">

                    MVC

                </h3>

                <p class="mt-2 text-slate-600">

                    Clean Architecture

                </p>

            </div>

            <div class="text-center">

                <h3 class="text-5xl font-extrabold text-orange-500">

                    CRUD

                </h3>

                <p class="mt-2 text-slate-600">

                    Complete Note Management

                </p>

            </div>

        </div>

    </div>

</section>

<!-- ================= HOW IT WORKS ================= -->

<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->

        <div class="text-center mb-20">

            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold">

                <i class="bi bi-diagram-3"></i>

                Project Workflow

            </span>

            <h2 class="mt-6 text-4xl lg:text-5xl font-extrabold text-slate-900">

                How

                <span class="text-blue-600">

                    AI Notes Pro

                </span>

                Works

            </h2>

            <p class="mt-6 text-lg text-slate-600 max-w-3xl mx-auto">

                A simple yet powerful workflow that combines Laravel,
                REST APIs and Artificial Intelligence to make note
                management faster and smarter.

            </p>

        </div>

        <!-- Workflow -->

        <div class="grid md:grid-cols-4 gap-8">

            <!-- Step 1 -->

            <div class="relative text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold shadow-lg">

                    1

                </div>

                <div class="mt-8">

                    <i class="bi bi-journal-plus text-5xl text-blue-600"></i>

                    <h3 class="mt-5 text-2xl font-bold">

                        Create Note

                    </h3>

                    <p class="mt-4 text-slate-600 leading-7">

                        Create and organize notes through a clean Laravel interface.

                    </p>

                </div>

            </div>

            <!-- Step 2 -->

            <div class="relative text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-green-600 text-white flex items-center justify-center text-3xl font-bold shadow-lg">

                    2

                </div>

                <div class="mt-8">

                    <i class="bi bi-robot text-5xl text-green-600"></i>

                    <h3 class="mt-5 text-2xl font-bold">

                        AI Summary

                    </h3>

                    <p class="mt-4 text-slate-600 leading-7">

                        Generate concise summaries automatically using Gemini AI.

                    </p>

                </div>

            </div>

            <!-- Step 3 -->

            <div class="relative text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-purple-600 text-white flex items-center justify-center text-3xl font-bold shadow-lg">

                    3

                </div>

                <div class="mt-8">

                    <i class="bi bi-search text-5xl text-purple-600"></i>

                    <h3 class="mt-5 text-2xl font-bold">

                        Semantic Search

                    </h3>

                    <p class="mt-4 text-slate-600 leading-7">

                        Search notes intelligently using AI-powered semantic matching.

                    </p>

                </div>

            </div>

            <!-- Step 4 -->

            <div class="relative text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-orange-500 text-white flex items-center justify-center text-3xl font-bold shadow-lg">

                    4

                </div>

                <div class="mt-8">

                    <i class="bi bi-cloud-arrow-up text-5xl text-orange-500"></i>

                    <h3 class="mt-5 text-2xl font-bold">

                        REST API

                    </h3>

                    <p class="mt-4 text-slate-600 leading-7">

                        Access notes securely through documented REST APIs and Swagger.

                    </p>

                </div>

            </div>

        </div>

        <!-- Bottom Banner -->

        <div class="mt-20 rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 text-white p-10 text-center shadow-2xl">

            <h3 class="text-3xl font-bold">

                One Platform. Multiple AI Capabilities.

            </h3>

            <p class="mt-5 text-slate-300 text-lg max-w-3xl mx-auto">

                AI Notes Pro combines note management, AI-generated summaries,
                semantic search and RESTful APIs into a single modern Laravel application.

            </p>

        </div>

    </div>

</section>

<!-- ================= CALL TO ACTION ================= -->

<section class="py-24 bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-500">

    <div class="max-w-7xl mx-auto px-6">

        <div class="bg-white rounded-3xl shadow-2xl p-12 lg:p-16">

            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <!-- Left -->

                <div>

                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold">

                        <i class="bi bi-rocket-takeoff-fill"></i>

                        Ready to Explore?

                    </span>

                    <h2 class="mt-6 text-4xl lg:text-5xl font-extrabold text-slate-900">

                        Experience the Power of

                        <span class="text-blue-600">

                            AI Notes Pro

                        </span>

                    </h2>

                    <p class="mt-6 text-lg text-slate-600 leading-8">

                        A modern Laravel application showcasing REST APIs,
                        AI-powered summaries, semantic search and a clean,
                        responsive user interface.

                    </p>

                </div>

                <!-- Right -->

                <div class="flex flex-col gap-5">

                    <a href="/notes"
                       class="flex items-center justify-center gap-3 rounded-xl bg-blue-600 text-white py-4 text-lg font-semibold hover:bg-blue-700 transition">

                        <i class="bi bi-journal-richtext"></i>

                        Open Notes Dashboard

                    </a>

                    <a href="/api/documentation"
                       class="flex items-center justify-center gap-3 rounded-xl border-2 border-slate-300 py-4 text-lg font-semibold hover:bg-slate-100 transition">

                        <i class="bi bi-code-slash"></i>

                        View API Documentation

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ================= FOOTER ================= -->

<footer class="bg-slate-950 text-slate-300">

    <div class="max-w-7xl mx-auto px-6 py-16">

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">

            <!-- About -->

            <div>

                <h3 class="text-2xl font-bold text-white mb-5">

                    <i class="bi bi-journal-richtext text-blue-400"></i>

                    AI Notes Pro

                </h3>

                <p class="leading-7 text-slate-400">

                    AI Notes Pro is a Laravel-based application built for
                    managing notes with AI-generated summaries,
                    semantic search and RESTful APIs.

                </p>

            </div>

            <!-- Features -->

            <div>

                <h4 class="text-lg font-semibold text-white mb-5">

                    Features

                </h4>

                <ul class="space-y-3">

                    <li>✔ Notes CRUD</li>

                    <li>✔ AI Summary</li>

                    <li>✔ Semantic Search</li>

                    <li>✔ REST API</li>

                    <li>✔ Swagger Documentation</li>

                </ul>

            </div>

            <!-- Technology -->

            <div>

                <h4 class="text-lg font-semibold text-white mb-5">

                    Technology

                </h4>

                <ul class="space-y-3">

                    <li>Laravel 13</li>

                    <li>PHP 8+</li>

                    <li>Tailwind CSS</li>

                    <li>Gemini AI API</li>

                    <li>Axios</li>

                    <li>MySQL</li>

                </ul>

            </div>

            <!-- Quick Links -->

            <div>

                <h4 class="text-lg font-semibold text-white mb-5">

                    Quick Links

                </h4>

                <ul class="space-y-3">

                    <li>
                        <a href="/" class="hover:text-white">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="/notes" class="hover:text-white">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="/api/documentation" class="hover:text-white">
                            API Docs
                        </a>
                    </li>

                </ul>

            </div>

        </div>

        <hr class="my-10 border-slate-800">

        <div class="flex flex-col md:flex-row justify-between items-center gap-5">

            <p>

                © {{ date('Y') }} AI Notes Pro. Built with Laravel 13.

            </p>

            <div class="flex gap-4 text-xl">

                <span class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition">

                    <i class="bi bi-github"></i>

                </span>

                <span class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition">

                    <i class="bi bi-linkedin"></i>

                </span>

                <span class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition">

                    <i class="bi bi-envelope-fill"></i>

                </span>

            </div>

        </div>

    </div>

</footer>

</body>
</html>