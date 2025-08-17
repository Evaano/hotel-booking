<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Laravel") }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />

        <!-- Scripts -->
        <style></style>
        @vite(["resources/css/app.css", "resources/js/app.js"])
        @stack("styles")
        <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
        <script
            defer
            src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"
        ></script>
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include("layouts.navigation")

            <!-- Page Heading -->
            @isset($header)
                <header
                    class="bg-white/80 backdrop-blur-sm shadow-soft ring-1 ring-muted-200/50 border-b border-white/20"
                >
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield("content")
                @endisset
            </main>
            @stack("scripts")
            <!-- No external UI kit JS: keep app lightweight and conflict-free -->
        </div>
    </body>
</html>
