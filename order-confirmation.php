<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>Order confirmed — NomNom</title>

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
      <a href="./profile.php" class="nn-nav-link">My orders</a>
    </div>
  </nav>

  <section class="container nn-section">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">

        <!-- ===== Success banner ===== -->
        <div class="nn-card text-center mb-4">
          <div class="nn-card-body py-5">
            <div class="nn-success-icon">✓</div>
            <h1 class="h2 mb-2">Order confirmed!</h1>
            <p class="text-muted-soft mb-3">
              Thanks for your order. The kitchen has been notified.
            </p>
            <div class="d-inline-block px-4 py-2" style="background:var(--nn-primary-light); border-radius:var(--nn-radius); font-weight:600; color:var(--nn-primary);">
              Order #NN-2026-04821
            </div>
          </div>
        </div>

        <!-- ===== Tracker ===== -->
        <div class="nn-card mb-4">
          <div class="nn-card-body">
            <h2 class="h5 mb-4">Order status</h2>

            <div class="d-flex justify-content-between align-items-start position-relative" style="padding:0 12px;">
              <!-- progress line -->
              <div style="position:absolute; top:18px; left:32px; right:32px; height:3px; background:var(--nn-border); z-index:0;"></div>
              <div style="position:absolute; top:18px; left:32px; width:33%; height:3px; background:var(--nn-primary); z-index:0;"></div>

              <!-- step 1 -->
              <div class="text-center" style="flex:1; position:relative; z-index:1;">
                <div class="nn-success-icon" style="width:36px; height:36px; font-size:1rem; margin:0 auto 8px;">✓</div>
                <div style="font-size:0.85rem; font-weight:600;">Confirmed</div>
                <div class="text-muted-soft" style="font-size:0.75rem;">Just now</div>
              </div>

              <!-- step 2 -->
              <div class="text-center" style="flex:1; position:relative; z-index:1;">
                <div class="nn-success-icon" style="width:36px; height:36px; font-size:1rem; margin:0 auto 8px; background:var(--nn-primary);">2</div>
                <div style="font-size:0.85rem; font-weight:600;">Preparing</div>
                <div class="text-muted-soft" style="font-size:0.75rem;">In progress</div>
              </div>

              <!-- step 3 -->
              <div class="text-center" style="flex:1; position:relative; z-index:1;">
                <div class="nn-success-icon" style="width:36px; height:36px; font-size:1rem; margin:0 auto 8px; background:var(--nn-border); color:var(--nn-text-soft);">3</div>
                <div style="font-size:0.85rem; font-weight:600;">On the way</div>
                <div class="text-muted-soft" style="font-size:0.75rem;">~25 min</div>
              </div>

              <!-- step 4 -->
              <div class="text-center" style="flex:1; position:relative; z-index:1;">
                <div class="nn-success-icon" style="width:36px; height:36px; font-size:1rem; margin:0 auto 8px; background:var(--nn-border); color:var(--nn-text-soft);">4</div>
                <div style="font-size:0.85rem; font-weight:600;">Delivered</div>
                <div class="text-muted-soft" style="font-size:0.75rem;">~40 min</div>
              </div>
            </div>

            <hr class="nn-divider">

            <div class="d-flex justify-content-between flex-wrap gap-3">
              <div>
                <div class="text-muted-soft" style="font-size:0.85rem;">Estimated delivery</div>
                <div style="font-weight:700; font-size:1.1rem;">5:25 PM – 5:40 PM</div>
              </div>
              <div>
                <div class="text-muted-soft" style="font-size:0.85rem;">Delivering to</div>
                <div style="font-weight:600;">No. 24, Jalan Telawi 3, 59100 KL</div>
              </div>
              <div>
                <div class="text-muted-soft" style="font-size:0.85rem;">Payment</div>
                <div style="font-weight:600;">Visa •••• 4242</div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== PWA notification opt-in ===== -->
        <div class="nn-card mb-4" style="background:var(--nn-primary-light); border-color:var(--nn-primary);">
          <div class="nn-card-body d-flex align-items-center gap-3 flex-wrap">
            <div style="font-size:2rem;">🔔</div>
            <div class="flex-grow-1">
              <strong>Get push notifications</strong>
              <div class="text-muted-soft" style="font-size:0.9rem;">We'll ping you the moment your rider is on the way.</div>
            </div>
            <button class="nn-btn nn-btn-primary" onclick="window.NomNom.toast('Notifications enabled (demo)');">Enable</button>
          </div>
        </div>

        <!-- ===== Items ordered ===== -->
        <div class="nn-card mb-4">
          <div class="nn-card-body">
            <h2 class="h5 mb-3">Items ordered</h2>
            <div class="d-flex justify-content-between mb-2">
              <span>1× Margherita Classic</span>
              <span>RM 28.00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>1× Spaghetti Carbonara</span>
              <span>RM 26.00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>2× Garlic Bread</span>
              <span>RM 24.00</span>
            </div>
            <hr>
            <div class="nn-summary-row">
              <span>Subtotal</span><span>RM 78.00</span>
            </div>
            <div class="nn-summary-row">
              <span>Delivery fee</span><span>RM 5.00</span>
            </div>
            <div class="nn-summary-row">
              <span>Service charge (6%)</span><span>RM 4.68</span>
            </div>
            <div class="nn-summary-row nn-total">
              <span>Total paid</span><span>RM 87.68</span>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
          <a href="./profile.php" class="nn-btn nn-btn-primary">View my orders</a>
          <a href="./restaurants.php" class="nn-btn nn-btn-outline">Order something else</a>
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
  <script>
  // Clear cart on confirmation page (real PHP would do this server-side)
  $(function () {
    if (window.NomNom && window.NomNom.Cart) {
      window.NomNom.Cart.clear();
    }
  });
  </script>
</body>
</html>
