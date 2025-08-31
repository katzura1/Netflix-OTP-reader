<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col">
    <!-- Content -->
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        <div class="py-10 lg:py-14 w-full">
            <!-- Title -->
            <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto text-center">
                <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl">
                    Selamat Datang di Netflix OTP
                </h1>
                <p class="mt-3 text-gray-600">
                    Layanan verifikasi email untuk Netflix OTP
                </p>
            </div>
        </div>
        <!-- End Title -->

        <!-- Email Message -->
        <div id="email-box" role="button" tabindex="0"
            class="max-w-2xl w-full py-6 px-4 sm:px-6 mx-auto bg-white rounded-lg shadow-md flex flex-col sm:flex-row items-start gap-y-4 sm:gap-x-4 border border-gray-200 cursor-pointer">
            <div class="flex-shrink-0 lg:mb-4 mb-0 hidden lg:block">
                <svg class="w-10 h-10 text-[#E50914]" fill="none" viewBox="0 0 40 40">
                    <rect width="40" height="40" rx="8" fill="#E50914" />
                    <path d="M12 14l8 6 8-6" stroke="#fff" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <rect x="12" y="14" width="16" height="12" rx="2" stroke="#fff" stroke-width="2" />
                </svg>
            </div>
            <div class="w-full">
                <h2 class="font-semibold text-gray-800 text-lg mb-1">Your Inbox</h2>
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