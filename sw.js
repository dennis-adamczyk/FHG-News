var CACHE_NAME = 'duispaper-v1.0.6';
var urlsToCache = [
  '/',
  '/css/layout.css',
  'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700',
  'https://fonts.googleapis.com/icon?family=Material+Icons',
  'https://code.jquery.com/jquery-latest.min.js',
  '/error/offline.php',
  '/additional-content/',
  '/additional-content/qr/index.php',
  '/additional-content/qr/index.json',
  '/about/',
  '/additional-content/qr/2/AbschlussfahrtDer9er/',
  '/additional-content/qr/2/EnglandfahrtDer8er/',
  '/additional-content/qr/2/Filme/',
  '/additional-content/qr/2/FrankreichfahrtDer8er/',
  '/additional-content/qr/2/YouTube-Kanaele/'
];
var OFFLINE_URL = '/error/offline.php';

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', function(event) {
  if(event.request.url.includes('/editorial')) {
    return;
  }
  if(event.request.url.includes('/includes/header.php')) {
    return;
  }
});

self.addEventListener('activate', function(event) {

  var cacheWhitelist = [CACHE_NAME];

  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});
