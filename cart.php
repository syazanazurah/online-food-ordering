<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>Your cart — NomNom</title>

  <link rel="manifest" href="./manifest.webmanifest">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/css/nomnom.css" rel="stylesheet">
</head>
<body>

  <!-- ============================================================ NAVBAR -->
  <nav class="nn-navbar">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="./index.php" class="nn-brand">
        <span class="nn-brand-mark">N</span>
        <span>NomNom</span>
      </a>
      <div class="d-none d-lg-flex align-items-center gap-2">
        <a href="./index.php" class="nn-nav-link">Home</a>
        <a href="./restaurants.php" class="nn-nav-link">Restaurants</a>
        <a href="./profile.php" class="nn-nav-link">Profile</a>
        <a href="./cart.php" class="nn-nav-link active nn-cart-badge">
          🛒 Cart
          <span class="nn-cart-count" style="display:none">0</span>
        </a>
        <a href="./login.php" class="nn-btn nn-btn-outline nn-btn-sm">Sign in</a>
      </div>
    </div>
  </nav>

  <section class="container nn-section">
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
      <h1 class="mb-0">Your cart</h1>
      <a href="./restaurants.php" class="nn-btn nn-btn-ghost nn-btn-sm">← Continue browsing</a>
    </div>

    <div class="row g-4">
      <!-- ============= LEFT: cart items ============= -->
      <div class="col-12 col-lg-8">
        <div id="cart-items-wrap">
          <!-- Empty state shown when cart is empty -->
          <div class="nn-empty nn-card" id="empty-state">
            <div class="nn-empty-icon">🛒</div>
            <h3 class="h5">Your cart is empty</h3>
            <p>Looks like you haven't added anything yet.</p>
            <a href="./restaurants.php" class="nn-btn nn-btn-primary mt-2">Browse restaurants</a>
          </div>

          <!-- Items render here when cart has items -->
          <div id="cart-items" style="display:none;"></div>
        </div>

        <div id="cart-tools" style="display:none;" class="mt-3 d-flex justify-content-between align-items-center">
          <span class="text-muted-soft" style="font-size:0.9rem;" id="item-count-label">0 items</span>
          <button class="nn-btn nn-btn-ghost nn-btn-sm text-danger" id="clear-cart-btn">Clear cart</button>
        </div>

        <!-- Promo code -->
        <div class="nn-card mt-4" id="promo-card" style="display:none;">
          <div class="nn-card-body">
            <h3 class="h6 mb-3">Have a promo code?</h3>
            <form class="d-flex gap-2" onsubmit="event.preventDefault(); window.NomNom.toast('Code applied (demo)');">
              <input type="text" class="nn-form-control" placeholder="Enter promo code">
              <button type="submit" class="nn-btn nn-btn-outline">Apply</button>
            </form>
          </div>
        </div>
      </div>

      <!-- ============= RIGHT: order summary ============= -->
      <div class="col-12 col-lg-4">
        <div class="nn-card" style="position:sticky;top:88px;" id="summary-card">
          <div class="nn-card-body">
            <h3 class="h5 mb-3">Order summary</h3>

            <div class="nn-summary-row">
              <span>Subtotal</span>
              <span id="subtotal">RM 0.00</span>
            </div>
            <div class="nn-summary-row">
              <span>Delivery fee</span>
              <span id="delivery-fee">RM 5.00</span>
            </div>
            <div class="nn-summary-row">
              <span>Service charge (6%)</span>
              <span id="service-charge">RM 0.00</span>
            </div>

            <div class="nn-summary-row nn-total">
              <span>Total</span>
              <span id="total">RM 0.00</span>
            </div>

            <a href="./checkout.php" class="nn-btn nn-btn-primary nn-btn-block nn-btn-lg mt-3" id="checkout-btn">
              Proceed to checkout
            </a>
            <p class="text-muted-soft text-center mt-2 mb-0" style="font-size:0.8rem;">
              🔒 Secure checkout · Free cancellation before kitchen confirms
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================ MOBILE BOTTOM NAV -->
  <nav class="nn-bottom-nav">
    <a href="./index.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">🏠</span>Home
    </a>
    <a href="./restaurants.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">🍽️</span>Browse
    </a>
    <a href="./cart.php" class="nn-bottom-nav-item active">
      <span class="nn-bottom-nav-icon">🛒</span>Cart
    </a>
    <a href="./profile.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">👤</span>Profile
    </a>
  </nav>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
  <script>
  $(function () {
    const Cart = window.NomNom.Cart;
    const fmt = window.NomNom.fmt;

    function render() {
      const items = Cart.get();
      const $list = $("#cart-items").empty();

      if (items.length === 0) {
        $("#empty-state").show();
        $("#cart-items").hide();
        $("#cart-tools, #promo-card").hide();
        $("#checkout-btn").addClass("disabled").css({"pointer-events":"none","opacity":"0.5"});
        $("#subtotal, #service-charge, #total").text("RM 0.00");
        $("#delivery-fee").text("RM 0.00");
        return;
      }

      $("#empty-state").hide();
      $("#cart-items").show();
      $("#cart-tools, #promo-card").show();
      $("#checkout-btn").removeClass("disabled").css({"pointer-events":"auto","opacity":"1"});

      items.forEach(function (item) {
        const lineTotal = item.price * item.qty;
        const $row = $(
          '<div class="nn-cart-item">' +
            '<div class="nn-cart-item-img">' + (item.img || "🍽️") + '</div>' +
            '<div class="flex-grow-1">' +
              '<div class="d-flex justify-content-between">' +
                '<div>' +
                  '<div style="font-weight:600;">' + item.name + '</div>' +
                  '<div class="text-muted-soft" style="font-size:0.85rem;">' + (item.restaurant || '') + '</div>' +
                '</div>' +
                '<div style="font-weight:700;">' + fmt(lineTotal) + '</div>' +
              '</div>' +
              '<div class="d-flex justify-content-between align-items-center mt-2">' +
                '<div class="nn-qty-control">' +
                  '<button class="nn-qty-btn" data-action="dec" data-id="' + item.id + '">−</button>' +
                  '<span class="nn-qty-value">' + item.qty + '</span>' +
                  '<button class="nn-qty-btn" data-action="inc" data-id="' + item.id + '">+</button>' +
                '</div>' +
                '<button class="nn-btn nn-btn-ghost nn-btn-sm text-danger" data-action="remove" data-id="' + item.id + '">Remove</button>' +
              '</div>' +
            '</div>' +
          '</div>'
        );
        $list.append($row);
      });

      const subtotal = Cart.subtotal();
      const delivery = subtotal > 0 ? 5 : 0;
      const service = subtotal * 0.06;
      const total = subtotal + delivery + service;

      $("#subtotal").text(fmt(subtotal));
      $("#delivery-fee").text(fmt(delivery));
      $("#service-charge").text(fmt(service));
      $("#total").text(fmt(total));
      $("#item-count-label").text(Cart.count() + " item" + (Cart.count() === 1 ? "" : "s"));
    }

    $(document).on("click", '[data-action="inc"]', function () {
      const id = $(this).data("id");
      const item = Cart.get().find(function (i) { return i.id === id; });
      if (item) Cart.updateQty(id, item.qty + 1);
      render();
    });
    $(document).on("click", '[data-action="dec"]', function () {
      const id = $(this).data("id");
      const item = Cart.get().find(function (i) { return i.id === id; });
      if (item) Cart.updateQty(id, item.qty - 1);
      render();
    });
    $(document).on("click", '[data-action="remove"]', function () {
      Cart.remove($(this).data("id"));
      render();
    });
    $("#clear-cart-btn").on("click", function () {
      if (confirm("Clear all items from your cart?")) {
        Cart.clear();
        render();
      }
    });

    render();
  });
  </script>
</body>
</html>
