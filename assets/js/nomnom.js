/* =============================================================================
   NomNom — Shared client-side JS (jQuery)
   This is the dummy layer. In the real PHP build, AJAX endpoints will be wired
   to /api/*.php with CSRF tokens and prepared statements server-side.
   ============================================================================= */

(function ($) {
  "use strict";

  // ---------------------------------------------------------------------------
  // Cart state (localStorage stub — real version uses PHP session + Redis)
  // ---------------------------------------------------------------------------
  const CART_KEY = "nomnom_cart";

  const Cart = {
    get() {
      try {
        return JSON.parse(localStorage.getItem(CART_KEY)) || [];
      } catch (e) {
        return [];
      }
    },
    save(items) {
      localStorage.setItem(CART_KEY, JSON.stringify(items));
      this.refreshBadge();
    },
    add(item) {
      const items = this.get();
      const existing = items.find((i) => i.id === item.id);
      if (existing) {
        existing.qty += 1;
      } else {
        items.push({ ...item, qty: 1 });
      }
      this.save(items);
    },
    updateQty(id, qty) {
      const items = this.get().map((i) =>
        i.id === id ? { ...i, qty: Math.max(0, qty) } : i
      ).filter((i) => i.qty > 0);
      this.save(items);
    },
    remove(id) {
      this.save(this.get().filter((i) => i.id !== id));
    },
    clear() {
      this.save([]);
    },
    count() {
      return this.get().reduce((sum, i) => sum + i.qty, 0);
    },
    subtotal() {
      return this.get().reduce((sum, i) => sum + i.price * i.qty, 0);
    },
    refreshBadge() {
      const count = this.count();
      $(".nn-cart-count").text(count).toggle(count > 0);
    },
  };

  // Expose for page scripts
  window.NomNom = window.NomNom || {};
  window.NomNom.Cart = Cart;

  // ---------------------------------------------------------------------------
  // Format Malaysian Ringgit
  // ---------------------------------------------------------------------------
  window.NomNom.fmt = function (value) {
    return "RM " + value.toFixed(2);
  };

  // ---------------------------------------------------------------------------
  // Toast (lightweight)
  // ---------------------------------------------------------------------------
  window.NomNom.toast = function (msg) {
    const $t = $('<div class="nn-toast"></div>').text(msg).appendTo("body");
    $t.css({
      position: "fixed",
      bottom: "100px",
      left: "50%",
      transform: "translateX(-50%)",
      background: "#1a1a1a",
      color: "#fff",
      padding: "12px 20px",
      borderRadius: "12px",
      zIndex: 2000,
      boxShadow: "0 12px 32px rgba(0,0,0,0.18)",
      fontSize: "0.9rem",
    });
    setTimeout(() => $t.fadeOut(200, () => $t.remove()), 1800);
  };

  // ---------------------------------------------------------------------------
  // Add to cart click handler (delegated)
  // ---------------------------------------------------------------------------
  $(document).on("click", "[data-add-to-cart]", function (e) {
    e.preventDefault();
    const $btn = $(this);
    Cart.add({
      id: $btn.data("id"),
      name: $btn.data("name"),
      price: parseFloat($btn.data("price")),
      img: $btn.data("img") || "🍽️",
      restaurant: $btn.data("restaurant") || "",
    });
    window.NomNom.toast($btn.data("name") + " added to cart");
  });

  // ---------------------------------------------------------------------------
  // PWA: register service worker
  // ---------------------------------------------------------------------------
  if ("serviceWorker" in navigator) {
    window.addEventListener("load", function () {
      navigator.serviceWorker
        .register("./sw.js")
        .then(function (reg) {
          console.log("[NomNom] Service worker registered:", reg.scope);
        })
        .catch(function (err) {
          console.warn("[NomNom] Service worker registration failed:", err);
        });
    });
  }

  // ---------------------------------------------------------------------------
  // PWA: install prompt
  // ---------------------------------------------------------------------------
  let deferredPrompt;
  window.addEventListener("beforeinstallprompt", function (e) {
    e.preventDefault();
    deferredPrompt = e;
    $(".nn-install-banner").css("display", "flex");
  });

  $(document).on("click", "[data-install-pwa]", function () {
    if (deferredPrompt) {
      deferredPrompt.prompt();
      deferredPrompt.userChoice.then(() => {
        deferredPrompt = null;
        $(".nn-install-banner").hide();
      });
    }
  });

  $(document).on("click", "[data-dismiss-install]", function () {
    $(".nn-install-banner").hide();
  });

  // ---------------------------------------------------------------------------
  // Init on ready
  // ---------------------------------------------------------------------------
  $(function () {
    Cart.refreshBadge();
  });
})(jQuery);
