var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/css/app.css',
    '/js/app.js',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
];

const CACHE_NAME = 'MTF';
// Install a service worker
self.addEventListener('install', event => {
    console.log('Opened cache');
});
// Cache and return request
self.addEventListener('fetch', event => {
    event.respondWith(
        fetch(event.request).then(res => {
            const resClone = res.clone();
            caches
                .open(CACHE_NAME)
                .then(cache => {
                    cache.put(event.request, resClone);
                });
            return res;
        }).catch(err => caches.match(event.request).then(res => res))
    );
});
// Update a service worker
self.addEventListener('activate', event => {
    const cacheWhitelist = [];
    cacheWhitelist.push(CACHE_NAME);
    event.waitUntil(
        caches.keys().then((cacheNames) => Promise.all(
            cacheNames.map((cacheName) => {
                if (!cacheWhitelist.includes(cacheName)) {
                    return caches.delete(cacheName);
                }
            })
        ))
    );
});
