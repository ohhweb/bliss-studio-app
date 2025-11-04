<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background-color: #111827;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- PWA Manifest & Theme Color -->
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#111827">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="padding-left:10px; padding-right:10px;">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
             {{-- Include the bottom navigation bar --}}
            @include('layouts.bottom-nav')
        </div>

        <!-- PWA Install Button for Android/Windows -->
        <button id="install-button" class="hidden fixed bottom-4 right-4 bg-amber-500 text-white font-bold py-3 px-5 rounded-lg shadow-lg hover:bg-amber-600 transition-transform hover:scale-105 z-50">
            Install App
        </button>

        <!-- iOS Install Instructions Banner -->
        <div id="ios-install-banner" class="hidden fixed bottom-0 left-0 w-full bg-gray-700 text-white p-4 text-center z-50">
            To install this app on your iPhone, tap the Share button
            <!-- Share Icon SVG -->
            <svg class="inline-block w-5 h-5 mx-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M13.21 6.166a.75.75 0 011.06 0l2.5 2.5a.75.75 0 010 1.06l-2.5 2.5a.75.75 0 11-1.06-1.06L14.44 10 13.21 8.79a.75.75 0 010-1.06zM7.844 13.209a.75.75 0 01-1.06 0l-2.5-2.5a.75.75 0 010-1.06l2.5-2.5a.75.75 0 111.06 1.06L6.654 10l1.19 1.149a.75.75 0 010 1.06z" clip-rule="evenodd" />
            </svg>
            and then "Add to Home Screen".
        </div>

        <!-- PWA Logic Script -->
        <script>
            // Logic for Android/Windows Install Prompt
            let deferredPrompt;
            const installButton = document.getElementById('install-button');

            window.addEventListener('beforeinstallprompt', (e) => {
                // Prevent the default mini-infobar from appearing
                e.preventDefault();
                // Stash the event so it can be triggered later.
                deferredPrompt = e;
                // Show our custom install button
                installButton.classList.remove('hidden');
            });

            installButton.addEventListener('click', async () => {
                // Hide the custom button
                installButton.classList.add('hidden');
                if (deferredPrompt) {
                    // Show the browser's install prompt
                    deferredPrompt.prompt();
                    // Wait for the user to respond to the prompt
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`User response to the install prompt: ${outcome}`);
                    // We've used the prompt, so clear it
                    deferredPrompt = null;
                }
            });

            window.addEventListener('appinstalled', () => {
                // Hide the install button & clear the prompt
                installButton.classList.add('hidden');
                deferredPrompt = null;
                console.log('PWA was installed');
            });

            // Logic for iOS Install Instructions Banner
            const isIos = () => {
                const userAgent = window.navigator.userAgent.toLowerCase();
                return /iphone|ipad|ipod/.test(userAgent);
            }
            const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);

            if (isIos() && !isInStandaloneMode()) {
                const iosBanner = document.getElementById('ios-install-banner');
                iosBanner.classList.remove('hidden');
            }
        </script>

    </body>
</html>