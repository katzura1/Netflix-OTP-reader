<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="https://assets.nflxext.com/us/ffe/siteui/common/icons/nficon2023.ico" />
    <link rel="apple-touch-icon" href="https://assets.nflxext.com/us/ffe/siteui/common/icons/nficon2016.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script>
        // Immediately apply saved theme to avoid flash
        (function() {
            try {
                var stored = localStorage.getItem('theme');
                if (stored === 'dark') {
                    document.documentElement.classList.add('dark');
                } else if (stored === 'light') {
                    document.documentElement.classList.remove('dark');
                } else {
                    // follow system preference
                    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    }
                }
            } catch (e) {
                // ignore
            }
        })();
    </script>
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#e6e6e6] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col">
    <!-- Content -->
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        <div class="py-10 lg:py-14 w-full">
            <!-- Title -->
            <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto text-center">
                <div class="flex items-center justify-center gap-4">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 sm:text-4xl">
                        Selamat Datang di Netflix OTP
                    </h1>

                    <!-- Theme toggle -->
                    <button id="theme-toggle" aria-label="Toggle theme" title="Toggle theme"
                        class="ml-2 inline-flex items-center justify-center p-2 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <svg id="icon-sun" class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v2M12 19v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4M12 7a5 5 0 100 10 5 5 0 000-10z" />
                        </svg>
                        <svg id="icon-moon" class="w-5 h-5 text-gray-200 hidden" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>
                    </button>

                </div>

                <p class="mt-3 text-gray-600 dark:text-gray-400">
                    Layanan verifikasi email untuk Netflix OTP
                </p>
            </div>
        </div>
        <!-- End Title -->

        <!-- Email Message -->
        <div id="email-box" role="button" tabindex="0"
            class="max-w-2xl w-full py-6 px-4 sm:px-6 mx-auto bg-white dark:bg-[#0f1113] rounded-lg shadow-md dark:shadow-none flex flex-col sm:flex-row items-start gap-y-4 sm:gap-x-4 border border-gray-200 dark:border-gray-800 cursor-pointer">
            <div class="flex-shrink-0 lg:mb-4 mb-0 hidden lg:block">
                <svg class="w-10 h-10 text-[#E50914]" fill="none" viewBox="0 0 40 40">
                    <rect width="40" height="40" rx="8" fill="#E50914" />
                    <path d="M12 14l8 6 8-6" stroke="#fff" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <rect x="12" y="14" width="16" height="12" rx="2" stroke="#fff" stroke-width="2" />
                </svg>
            </div>
            <div class="w-full">
                <h2 class="font-semibold text-gray-800 text-lg mb-1 dark:text-white">Your Inbox</h2>
                @foreach ($inbox as $item)
                <a href="{{ $item['account_link'] }}" target="_blank">
                    <x-message-card sender="{{ $item['from'] }}" time="{{ $item['date'] }}"
                        title="{{ $item['subject'] }}" statusDotColor="bg-green-500"
                        human_date="{{ $item['human_date'] }}">
                        {{ $item['text_body'] }}
                    </x-message-card>
                </a>
                @endforeach
            </div>
        </div>
        <!-- End Email Message -->
    </div>
    <!-- End Content -->
</body>

</html>

<script>
    // DOM-ready theme toggle wiring
    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('theme-toggle');
        if (!btn) return;
        var iconSun = document.getElementById('icon-sun');
        var iconMoon = document.getElementById('icon-moon');

        function updateIcons() {
            var isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                iconSun.classList.add('hidden');
                iconMoon.classList.remove('hidden');
            } else {
                iconSun.classList.remove('hidden');
                iconMoon.classList.add('hidden');
            }
        }

        updateIcons();

        btn.addEventListener('click', function(e) {
            var isDark = document.documentElement.classList.toggle('dark');
            try { localStorage.setItem('theme', isDark ? 'dark' : 'light'); } catch (err) {}
            updateIcons();
        });
    });
</script>