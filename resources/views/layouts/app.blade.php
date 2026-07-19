<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'AI Notes Pro')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-slate-100 font-[Inter]">

<div class="flex min-h-screen">

    <!-- ================= SIDEBAR ================= -->

    <aside class="w-72 bg-slate-900 text-white flex flex-col shadow-2xl">

        <!-- Logo -->

        <div class="h-20 flex items-center justify-center border-b border-slate-800">

            <a href="/" class="text-3xl font-extrabold tracking-wide">

                <i class="bi bi-journal-richtext text-blue-400"></i>

                AI Notes Pro

            </a>

        </div>

        <!-- Menu -->

        <nav class="flex-1 p-6">

            <p class="uppercase text-xs text-slate-400 mb-4 tracking-widest">

                Navigation

            </p>

            <ul class="space-y-2">

                <li>

                    <a href="/"

                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                        <i class="bi bi-house"></i>

                        Home

                    </a>

                </li>

                <li>

                    <a href="/notes"

                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                        <i class="bi bi-journal-text"></i>

                        Notes

                    </a>

                </li>

                <li>

                    <a href="/api/documentation"

                        target="_blank"

                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                        <i class="bi bi-file-earmark-code"></i>

                        API Docs

                    </a>

                </li>

            </ul>

        </nav>

        <!-- Footer -->

        <div class="border-t border-slate-800 p-6 text-sm text-slate-400">

            Laravel 13

            <br>

            AI Notes Assessment by Ritesh Kumar

        </div>

    </aside>

    <!-- ================= CONTENT ================= -->

    <div class="flex-1 flex flex-col">

        <!-- Top Bar -->

        <header class="bg-white shadow-sm h-20 flex items-center justify-between px-10">

            <div>

                <h1 class="text-2xl font-bold text-slate-800">

                    @yield('page-title')

                </h1>

            </div>

            <div class="flex items-center gap-5">

                <!-- Notification -->

                <button
                    class="w-11 h-11 rounded-full bg-slate-100 hover:bg-slate-200 transition">

                    <i class="bi bi-bell"></i>

                </button>

                <!-- User -->

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">

                        A

                    </div>

                    <div>

                        <p class="font-semibold">

                            Admin

                        </p>

                        <small class="text-slate-500">

                            Laravel Developer

                        </small>

                    </div>

                </div>

            </div>

        </header>

        <!-- Main Content -->

        <main class="flex-1 p-10">

            @yield('content')

        </main>

    </div>

</div>

</body>

</html>