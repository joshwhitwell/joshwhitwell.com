// Service worker for PWA
const CACHE_NAME = 'laravel-pwa-v2'; // Incremented version number
const ASSETS_CACHE_NAME = 'assets-cache-v1';
const urlsToCache = [
    '/',
    '/offline.html',
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
    const currentCaches = [CACHE_NAME, ASSETS_CACHE_NAME];

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

    event.respondWith(
        (async () => {
            // Try to get from cache first
            const cachedResponse = await caches.match(event.request);
            if (cachedResponse) {
                return cachedResponse;
            }

            try {
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
                // Network failed, try to return appropriate fallback
                const url = new URL(event.request.url);

                // For navigation requests, show the offline page
                if (event.request.mode === 'navigate') {
                    return caches.match('/offline.html');
                }

                // For image requests, maybe return a placeholder
                if (event.request.destination === 'image') {
                    return new Response('', {
                        status: 200,
                        headers: new Headers({
                            'Content-Type': 'image/svg+xml',
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
