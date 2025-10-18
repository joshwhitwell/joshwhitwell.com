// Service worker for PWA
const CACHE_NAME = 'laravel-pwa-v4'; // Incremented version number
const ASSETS_CACHE_NAME = 'assets-cache-v3';
const ICON_CACHE_NAME = 'icon-cache-v1';
const urlsToCache = [
    // Offline page is the highest priority
    '/offline.html',
    '/',
    '/favicon.ico',
    '/favicon.svg',
    '/apple-touch-icon.png',
    '/icon-192.png',
    '/icon-512.png',
    '/icon-maskable-192.png',
    '/icon-maskable-512.png',
    '/site.webmanifest',
];

// Dynamically cache the main assets - they have hashed filenames
const cacheAssets = async () => {
    const cache = await caches.open(ASSETS_CACHE_NAME);

    try {
        // Cache CSS and JS files
        const mainResponse = await fetch('/');
        const mainText = await mainResponse.text();

        // Extract asset URLs from the HTML response
        const cssMatches = mainText.match(/href="\/build\/assets\/[^"]+\.css/g);
        const jsMatches = mainText.match(/src="\/build\/assets\/[^"]+\.js/g);

        if (cssMatches) {
            for (const match of cssMatches) {
                const cssUrl = match.replace('href="', '');
                try {
                    const cssRes = await fetch(cssUrl);
                    if (cssRes.status === 200) {
                        await cache.put(cssUrl, cssRes);
                        console.log('Cached:', cssUrl);
                    }
                } catch (err) {
                    console.warn('Failed to cache CSS:', cssUrl, err);
                }
            }
        }

        if (jsMatches) {
            for (const match of jsMatches) {
                const jsUrl = match.replace('src="', '');
                try {
                    const jsRes = await fetch(jsUrl);
                    if (jsRes.status === 200) {
                        await cache.put(jsUrl, jsRes);
                        console.log('Cached:', jsUrl);
                    }
                } catch (err) {
                    console.warn('Failed to cache JS:', jsUrl, err);
                }
            }
        }
    } catch (err) {
        console.warn('Failed to cache assets:', err);
    }
};

// Install event - cache assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        (async () => {
            const cache = await caches.open(CACHE_NAME);

            // Cache core assets one by one to prevent a single failure from stopping everything
            for (const url of urlsToCache) {
                try {
                    const response = await fetch(url);
                    if (response.status === 200) {
                        await cache.put(url, response);
                        console.log('Cached:', url);
                    } else {
                        console.warn(
                            `Failed to cache: ${url} - status: ${response.status}`,
                        );
                    }
                } catch (err) {
                    console.warn(`Failed to cache: ${url}`, err);
                }
            }

            // Cache CSS and JS assets
            await cacheAssets();

            await self.skipWaiting();
        })(),
    );
});

// Activate event - clean up old caches and claim clients
self.addEventListener('activate', (event) => {
    const currentCaches = [CACHE_NAME, ASSETS_CACHE_NAME, ICON_CACHE_NAME];

    event.waitUntil(
        (async () => {
            // Clean up old caches
            const cacheNames = await caches.keys();
            await Promise.all(
                cacheNames
                    .filter((cacheName) => !currentCaches.includes(cacheName))
                    .map((cacheName) => {
                        console.log('Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }),
            );

            // Take control of all clients
            await self.clients.claim();
            console.log('Service worker activated and controlling all clients');
        })(),
    );
});

// Fetch event - serve from cache or network with improved strategy
self.addEventListener('fetch', (event) => {
    // Skip cross-origin requests
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Skip API requests or POST/PUT/DELETE etc.
    if (event.request.url.includes('/api/') || event.request.method !== 'GET') {
        return;
    }

    // Special handling for the offline page
    const url = new URL(event.request.url);
    if (url.pathname === '/offline.html') {
        event.respondWith(caches.match('/offline.html'));
        return;
    }

    // Special handling for icon resources - always re-fetch from network first
    if (
        url.pathname.match(
            /\/(favicon|icon|apple-touch-icon|site\.webmanifest)/,
        )
    ) {
        // Check if the URL has a version parameter
        if (url.search && url.search.includes('v=')) {
            // If versioned, we can use cache-first approach
            event.respondWith(
                caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    return fetch(event.request)
                        .then((networkResponse) => {
                            if (networkResponse.ok) {
                                const clonedResponse = networkResponse.clone();
                                caches.open(ICON_CACHE_NAME).then((cache) => {
                                    cache.put(event.request, clonedResponse);
                                });
                            }
                            return networkResponse;
                        })
                        .catch(() => {
                            // Fallback to any cached version if available
                            return caches.match(url.pathname);
                        });
                }),
            );
        } else {
            // If not versioned, we use network-first approach
            event.respondWith(
                fetch(event.request)
                    .then((networkResponse) => {
                        if (networkResponse.ok) {
                            const clonedResponse = networkResponse.clone();
                            caches.open(ICON_CACHE_NAME).then((cache) => {
                                cache.put(event.request, clonedResponse);
                            });
                        }
                        return networkResponse;
                    })
                    .catch((err) => {
                        return caches.match(event.request);
                    }),
            );
        }
        return;
    }

    event.respondWith(
        (async () => {
            try {
                // Try to get from cache first
                const cachedResponse = await caches.match(event.request);
                if (cachedResponse) {
                    return cachedResponse;
                }

                // If not in cache, try network
                const networkResponse = await fetch(event.request);

                // Cache valid responses
                if (
                    networkResponse.status === 200 &&
                    networkResponse.type === 'basic'
                ) {
                    const cache = await caches.open(CACHE_NAME);
                    cache.put(event.request, networkResponse.clone());
                }

                return networkResponse;
            } catch (err) {
                console.log(
                    'Fetch failed; returning offline page instead.',
                    err,
                );

                // If this is a navigation request (for a page)
                if (event.request.mode === 'navigate') {
                    // Return the cached offline page
                    const offlineResponse = await caches.match('/offline.html');
                    if (offlineResponse) {
                        return offlineResponse;
                    }

                    // Fallback if offline page isn't cached
                    return new Response(
                        '<html><head><title>Offline</title><meta name="viewport" content="width=device-width, initial-scale=1"></head><body style="padding: 2rem; text-align: center; font-family: system-ui, sans-serif;"><h1>You\'re Offline</h1><p>Please check your connection and try again.</p></body></html>',
                        {
                            status: 200,
                            headers: { 'Content-Type': 'text/html' },
                        },
                    );
                }

                // For image requests, return a transparent placeholder
                if (event.request.destination === 'image') {
                    return new Response('', {
                        status: 200,
                        headers: new Headers({
                            'Content-Type': 'image/svg+xml',
                        }),
                    });
                }

                // For JavaScript or CSS, return empty response to prevent errors
                if (
                    event.request.destination === 'script' ||
                    event.request.destination === 'style'
                ) {
                    return new Response('', {
                        status: 200,
                        headers: new Headers({
                            'Content-Type':
                                event.request.destination === 'script'
                                    ? 'application/javascript'
                                    : 'text/css',
                        }),
                    });
                }

                // Couldn't serve from cache or network
                return new Response('Network error', {
                    status: 408,
                    statusText: 'Network error',
                });
            }
        })(),
    );
});
