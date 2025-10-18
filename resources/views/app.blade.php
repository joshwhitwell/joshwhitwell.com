<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- PWA Meta Tags -->
        <meta name="application-name" content="{{ config('app.name', 'Laravel') }}">
        <meta name="theme-color" content="#ffffff">
        <meta name="theme-color" content="#111111" media="(prefers-color-scheme: dark)">
        <meta name="description" content="Progressive Web App built with Laravel and Vue">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name', 'Laravel') }}">

        <link rel="manifest" href="/site.webmanifest">
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Apple PWA specific icons -->
        <link rel="apple-touch-icon" sizes="192x192" href="/icon-192.png">
        <link rel="apple-touch-icon" sizes="512x512" href="/icon-512.png">
        <link rel="mask-icon" href="/favicon.svg" color="#ff2d20">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead

        <!-- PWA Service Worker Registration -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    // Force update the service worker to get the latest version
                    navigator.serviceWorker.register('/sw.js?v=2').then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);

                        // Check for updates on each page load
                        registration.update();

                        // Detect SW updates and offer reload
                        registration.addEventListener('updatefound', () => {
                            const newWorker = registration.installing;

                            newWorker.addEventListener('statechange', function() {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    if (confirm('New content is available! Click OK to refresh.')) {
                                        window.location.reload();
                                    }
                                }
                            });
                        });

                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });

                    // Listen for controller change events
                    navigator.serviceWorker.addEventListener('controllerchange', function() {
                        console.log('New service worker activated');
                    });
                });
            }

            // Add to homescreen prompt helper
            let deferredPrompt;
            window.addEventListener('beforeinstallprompt', (e) => {
                // Prevent Chrome from showing the native prompt
                e.preventDefault();
                // Stash the event so it can be triggered later
                deferredPrompt = e;
                // Optionally, show your own install button
                console.log('App can be installed, showing custom install UI');
                // You could show your install button here
            });
        </script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
