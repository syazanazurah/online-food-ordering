<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name="theme-color" content="#ff6b35">
  <meta name="description" content="Order food from your favourite local restaurants for delivery or pickup.">
  <title>NomNom — Order from your favourite restaurants</title>

  <link rel="manifest" href="./manifest.webmanifest">
  <link rel="apple-touch-icon" href="./assets/icons/icon-192.png">

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
        <a href="./index.php" class="nn-nav-link active">Home</a>
        <a href="./restaurants.php" class="nn-nav-link">Restaurants</a>
        <a href="./profile.php" class="nn-nav-link">Profile</a>
        <a href="./cart.php" class="nn-nav-link nn-cart-badge">
          🛒 Cart
          <span class="nn-cart-count" style="display:none">0</span>
        </a>
        <a href="./login.php" class="nn-btn nn-btn-outline nn-btn-sm">Sign in</a>
      </div>
      <a href="./cart.php" class="d-lg-none nn-cart-badge">
        🛒
        <span class="nn-cart-count" style="display:none">0</span>
      </a>
    </div>
  </nav>

  <!-- ============================================================ HERO -->
  <section class="container nn-section">
    <div class="nn-hero p-4 p-md-5 text-center">
      <h1>Hungry? We've got you. 🍜</h1>
      <p>Order from <strong>800+ restaurants</strong> in your area. Delivered hot, right to your door.</p>
      <form class="nn-search-bar mx-auto" onsubmit="event.preventDefault(); location.href='./restaurants.php';">
        <input type="text" placeholder="Search for restaurants or dishes…" aria-label="Search">
        <button class="nn-btn nn-btn-primary" type="submit">Search</button>
      </form>
    </div>

    <!-- ===================================================== CATEGORIES -->
    <div class="nn-section-title">
      <h2>Browse by cuisine</h2>
    </div>
    <div class="nn-chip-group">
      <a href="./restaurants.php" class="nn-chip active">All</a>
      <a href="./restaurants.php" class="nn-chip">🍕 Pizza</a>
      <a href="./restaurants.php" class="nn-chip">🍔 Burgers</a>
      <a href="./restaurants.php" class="nn-chip">🍣 Japanese</a>
      <a href="./restaurants.php" class="nn-chip">🍜 Asian</a>
      <a href="./restaurants.php" class="nn-chip">🌯 Mexican</a>
      <a href="./restaurants.php" class="nn-chip">🥗 Healthy</a>
      <a href="./restaurants.php" class="nn-chip">🍰 Desserts</a>
      <a href="./restaurants.php" class="nn-chip">☕ Cafe</a>
    </div>

    <!-- ================================================== FEATURED RESTAURANTS -->
    <div class="nn-section-title mt-5">
      <h2>Popular near you</h2>
      <a href="./restaurants.php" class="nn-btn nn-btn-ghost nn-btn-sm">View all →</a>
    </div>

    <div class="row g-4">
      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">🍕</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">Tony's Pizzeria</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.8</span>
                <span>30–40 min</span>
                <span>RM 5 delivery</span>
              </div>
              <div class="mt-2">
                <span class="nn-tag">Italian</span>
                <span class="nn-tag nn-tag-success">Promo: Free drink</span>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">🍣</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">Sakura Sushi</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.7</span>
                <span>25–35 min</span>
                <span>RM 4 delivery</span>
              </div>
              <div class="mt-2">
                <span class="nn-tag">Japanese</span>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">🍔</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">Smash House Burgers</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.6</span>
                <span>20–30 min</span>
                <span>RM 5 delivery</span>
              </div>
              <div class="mt-2">
                <span class="nn-tag">American</span>
                <span class="nn-tag nn-tag-warning">Busy now</span>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">🍜</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">Wok &amp; Roll</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.5</span>
                <span>30–45 min</span>
                <span>Free delivery</span>
              </div>
              <div class="mt-2">
                <span class="nn-tag">Chinese</span>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">🌯</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">El Taco Loco</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.4</span>
                <span>25–35 min</span>
                <span>RM 6 delivery</span>
              </div>
              <div class="mt-2">
                <span class="nn-tag">Mexican</span>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">🥗</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">Greenhouse Bowls</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.9</span>
                <span>15–25 min</span>
                <span>RM 4 delivery</span>
              </div>
              <div class="mt-2">
                <span class="nn-tag">Healthy</span>
                <span class="nn-tag nn-tag-success">Featured</span>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- ===================================================== HOW IT WORKS -->
    <hr class="nn-divider mt-5">
    <div class="nn-section-title">
      <h2>How NomNom works</h2>
    </div>
    <div class="row g-4 mb-5">
      <div class="col-12 col-md-4">
        <div class="nn-card nn-card-body text-center" style="height:100%;">
          <div style="font-size:2.5rem;margin-bottom:8px;">📍</div>
          <h3 class="h5">1. Pick a place</h3>
          <p class="text-muted-soft mb-0">Browse hundreds of restaurants in your area, filter by cuisine, rating, or price.</p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="nn-card nn-card-body text-center" style="height:100%;">
          <div style="font-size:2.5rem;margin-bottom:8px;">🛒</div>
          <h3 class="h5">2. Build your order</h3>
          <p class="text-muted-soft mb-0">Add items to cart, customise, and check out securely with online payment.</p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="nn-card nn-card-body text-center" style="height:100%;">
          <div style="font-size:2.5rem;margin-bottom:8px;">🛵</div>
          <h3 class="h5">3. Track &amp; enjoy</h3>
          <p class="text-muted-soft mb-0">Get push notifications as the kitchen prepares and your rider arrives.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================ FOOTER -->
  <footer class="nn-footer">
    <div class="container">
      <div class="row g-4">
        <div class="col-12 col-md-4">
          <div class="nn-brand mb-2"><span class="nn-brand-mark">N</span> NomNom</div>
          <p class="mb-0">A web-based food ordering platform. Built as a coursework prototype for CBSC4103 Software Construction.</p>
        </div>
        <div class="col-6 col-md-2">
          <h4 class="h6">Discover</h4>
          <a href="./restaurants.php" class="d-block">Restaurants</a>
          <a href="./index.php" class="d-block">Cuisines</a>
          <a href="./index.php" class="d-block">Promotions</a>
        </div>
        <div class="col-6 col-md-2">
          <h4 class="h6">Account</h4>
          <a href="./login.php" class="d-block">Sign in</a>
          <a href="./register.php" class="d-block">Register</a>
          <a href="./profile.php" class="d-block">My profile</a>
        </div>
        <div class="col-12 col-md-4">
          <h4 class="h6">Stay in the loop</h4>
          <form class="nn-search-bar" onsubmit="event.preventDefault(); window.NomNom.toast('Subscribed (demo).');">
            <input type="email" placeholder="you@example.com" aria-label="Email">
            <button class="nn-btn nn-btn-primary nn-btn-sm" type="submit">Join</button>
          </form>
        </div>
      </div>
      <hr class="nn-divider">
      <div class="text-center">© 2026 NomNom Demo · Built with PHP, jQuery, Bootstrap 5 · PWA-enabled</div>
    </div>
  </footer>

  <!-- ============================================================ MOBILE BOTTOM NAV -->
  <nav class="nn-bottom-nav">
    <a href="./index.php" class="nn-bottom-nav-item active">
      <span class="nn-bottom-nav-icon">🏠</span>Home
    </a>
    <a href="./restaurants.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">🍽️</span>Browse
    </a>
    <a href="./cart.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">🛒</span>Cart
    </a>
    <a href="./profile.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">👤</span>Profile
    </a>
  </nav>

  <!-- ============================================================ INSTALL PROMPT -->
  <div class="nn-install-banner">
    <div class="flex-grow-1">
      <strong>Install NomNom</strong>
      <div style="font-size:0.85rem;opacity:0.8;">Add to home screen for the full app experience.</div>
    </div>
    <button class="nn-btn nn-btn-primary nn-btn-sm" data-install-pwa>Install</button>
    <button class="nn-btn nn-btn-ghost nn-btn-sm" data-dismiss-install style="color:#fff;">✕</button>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
</body>
</html>
