<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Bliss Films</title>
        <link rel="icon" href="/images/icon.svg" type="image/svg+xml">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- PWA Manifest & Theme Color -->
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#111827">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles') 
    </head>
    <body class="font-sans antialiased bg-primary px-2.5">
        <div class="min-h-screen bg-primary">
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
             
            {{-- Include the bottom navigation bar for mobile --}}
            @include('layouts.bottom-nav')
        </div>

        <!-- PWA Install Button for Android/Windows -->
        <button id="install-button" class="hidden fixed bottom-20 sm:bottom-4 right-4 bg-accent text-white font-bold py-3 px-5 rounded-lg shadow-lg hover:bg-orange-600 transition-transform hover:scale-105 z-50">
            Install App
        </button>

        <!-- iOS Install Instructions Banner -->
        <div id="ios-install-banner" class="hidden fixed bottom-16 left-0 w-full bg-gray-700 text-white p-4 text-center z-50 sm:hidden">
            To install, tap the Share button
            <svg class="inline-block w-5 h-5 mx-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 4.5a2.5 2.5 0 11.702 4.342L10.5 12.2a2.5 2.5 0 11-3.403-3.66l3.2-2.84a2.5 2.5 0 012.701-1.158zM8.5 15.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"></path></svg>
            and then "Add to Home Screen".
        </div>

        <!-- All page scripts will be injected here -->
        @stack('scripts')

        <!-- Combined PWA & Activity Tracking Logic -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                
                // --- PWA INSTALLATION LOGIC ---
                let deferredPrompt;
                const installButton = document.getElementById('install-button');

                window.addEventListener('beforeinstallprompt', (e) => {
                    e.preventDefault();
                    deferredPrompt = e;
                    if (installButton) {
                        installButton.classList.remove('hidden');
                    }
                });

                if (installButton) {
                    installButton.addEventListener('click', async () => {
                        installButton.classList.add('hidden');
                        if (deferredPrompt) {
                            deferredPrompt.prompt();
                            const { outcome } = await deferredPrompt.userChoice;
                            console.log(`User response to the install prompt: ${outcome}`);
                            deferredPrompt = null;
                        }
                    });
                }
                
                window.addEventListener('appinstalled', () => {
                    if (installButton) {
                        installButton.classList.add('hidden');
                    }
                    deferredPrompt = null;
                    console.log('PWA was installed');
                });

                // --- iOS BANNER LOGIC ---
                const isIos = () => /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
                const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);

                const iosBanner = document.getElementById('ios-install-banner');
                if (isIos() && !isInStandaloneMode() && iosBanner) {
                    iosBanner.classList.remove('hidden');
                }

                // --- DEVICE ACTIVITY TRACKING LOGIC (runs only if user is logged in) ---
                @auth
                    // Define the heartbeat function globally so other scripts can call it
                    window.sendHeartbeat = async function() {
                        if (!navigator.onLine) { return; }
                        
                        const getDeviceIdentifier = () => {
                            let deviceId = localStorage.getItem('device_identifier');
                            if (!deviceId) {
                                deviceId = 'device_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                                localStorage.setItem('device_identifier', deviceId);
                            }
                            return deviceId;
                        };
                        
                        const data = {
                            device_identifier: getDeviceIdentifier(),
                            battery_level: null,
                            network_type: null,
                        };

                        if ('getBattery' in navigator) {
                            try {
                                const battery = await navigator.getBattery();
                                data.battery_level = `${Math.round(battery.level * 100)}%` + (battery.charging ? ' (Charging)' : '');
                            } catch (error) { /* fail silently */ }
                        }

                        if ('connection' in navigator) {
                            data.network_type = navigator.connection.effectiveType;
                        }

                        try {
                            // const response = await fetch('/api/activity/heartbeat', {
                            const response = await fetch('/activity/heartbeat', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(data)
                            });
                            if (!response.ok) console.error('Heartbeat failed:', response.status);
                        } catch (error) {
                            console.error('Heartbeat fetch error:', error);
                        }
                    };

                    // Send a heartbeat on the initial page load
                    window.sendHeartbeat();
                @endauth
            });
        </script>
    </body>
</html> 