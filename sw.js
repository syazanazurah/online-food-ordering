/* =============================================================================
   NomNom — Service Worker (PWA offline shell)
   Strategy:
     - Pre-cache the app shell on install
     - Network-first for HTML pages (fall back to cache when offline)
     - Cache-first for static assets (CSS, JS, images, icons)
   ============================================================================= */

const CACHE_NAME = "nomnom-v2";
const APP_SHELL = [
  "./",
  "./index.php",
  "./restaurants.php",
  "./restaurant-detail.php",
  "./cart.php",
  "./checkout.php",
  "./order-confirmation.php",
  "./login.php",
  "./register.php",
  "./profile.php",
  "./offline.php",
  "./assets/css/nomnom.css",
  "./assets/js/nomnom.js",
  "./manifest.webmanifest",
  "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css",
  "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js",
  "https://code.jquery.com/jquery-3.7.1.min.js",
];

// -----------------------------------------------------------------------------
// Install — pre-cache the shell
// -----------------------------------------------------------------------------
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches
      .open(CACHE_NAME)
      .then((cache) => cache.addAll(APP_SHELL))
      .then(() => self.skipWaiting())
  );
});

// -----------------------------------------------------------------------------
// Activate — clean up old caches
// -----------------------------------------------------------------------------
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches
      .keys()
      .then((keys) =>
        Promise.all(
          keys
            .filter((key) => key !== CACHE_NAME)
            .map((key) => caches.delete(key))
        )
      )
      .then(() => self.clients.claim())
  );
});

// -----------------------------------------------------------------------------
// Fetch
// -----------------------------------------------------------------------------
self.addEventListener("fetch", (event) => {
  const { request } = event;

  // Only handle GET
  if (request.method !== "GET") return;

  const url = new URL(request.url);

  // Network-first for navigations (HTML pages)
  if (request.mode === "navigate") {
    event.respondWith(
      fetch(request)
        .then((response) => {
          const copy = response.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(request, copy));
          return response;
        })
        .catch(() =>
          caches.match(request).then((cached) => cached || caches.match("./offline.php"))
        )
    );
    return;
  }

  // Cache-first for static assets
  event.respondWith(
    caches.match(request).then((cached) => {
      return (
        cached ||
        fetch(request).then((response) => {
          if (
            response.ok &&
            (url.origin === self.location.origin ||
              url.hostname.includes("jsdelivr") ||
              url.hostname.includes("jquery"))
          ) {
            const copy = response.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(request, copy));
          }
          return response;
        })
      );
    })
  );
});

// -----------------------------------------------------------------------------
// Push notifications (order status)
// -----------------------------------------------------------------------------
self.addEventListener("push", (event) => {
  const data = event.data ? event.data.json() : {};
  const title = data.title || "NomNom";
  const options = {
    body: data.body || "Your order status has been updated.",
    icon: "./assets/icons/icon-192.png",
    badge: "./assets/icons/icon-192.png",
    data: { url: data.url || "./profile.php" },
  };
  event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener("notificationclick", (event) => {
  event.notification.close();
  event.waitUntil(clients.openWindow(event.notification.data.url || "./"));
});
