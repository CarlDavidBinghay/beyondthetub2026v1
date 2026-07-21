/**
 * Beyond The Tub — Kitchen app service worker.
 *
 * Two jobs:
 *   1. Keep the admin shell usable when the connection drops.
 *   2. Handle taps on order notifications, so they open the order desk.
 *
 * Deliberately small. Admin data is never cached — a stale order list would be
 * worse than no order list, so every request for real data goes to the network.
 */

const CACHE = 'btt-kitchen-v1';
const SHELL = [
  'assets/brand/app-icon-192.png',
  'assets/brand/app-icon-512.png',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE).then((cache) => cache.addAll(SHELL)).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(keys.filter((k) => k !== CACHE).map((k) => caches.delete(k))))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const url = new URL(event.request.url);

  // Never cache PHP or the order pulse — always ask the server.
  if (url.pathname.endsWith('.php') || url.pathname.includes('/actions/')) {
    return;
  }

  // Images and icons: serve from cache when we have them, otherwise fetch and keep.
  if (event.request.method === 'GET' && /\.(png|jpg|jpeg|webp|svg|ico)$/i.test(url.pathname)) {
    event.respondWith(
      caches.match(event.request).then((hit) =>
        hit || fetch(event.request).then((res) => {
          const copy = res.clone();
          caches.open(CACHE).then((cache) => cache.put(event.request, copy));
          return res;
        }).catch(() => hit)
      )
    );
  }
});

/* Tapping an order notification brings the kitchen to the front. */
self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  event.waitUntil(
    self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clients) => {
      for (const client of clients) {
        if (client.url.includes('admin.php') && 'focus' in client) {
          return client.focus();
        }
      }
      return self.clients.openWindow('admin.php');
    })
  );
});

/* Web Push, if a push service is ever wired up server-side. */
self.addEventListener('push', (event) => {
  let body = 'Open the kitchen to see it.';
  try {
    if (event.data) body = event.data.text();
  } catch (_) {}

  event.waitUntil(
    self.registration.showNotification('New order', {
      body,
      icon: 'assets/brand/app-icon-192.png',
      badge: 'assets/brand/app-icon-192.png',
      tag: 'btt-order',
      renotify: true,
      requireInteraction: true,
      vibrate: [200, 100, 200],
    })
  );
});
