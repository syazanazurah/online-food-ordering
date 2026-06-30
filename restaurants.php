<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>Browse restaurants — NomNom</title>

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
        <a href="./restaurants.php" class="nn-nav-link active">Restaurants</a>
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

  <!-- ============================================================ PAGE HEADER -->
  <section class="container nn-section">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
      <div>
        <h1 class="mb-1">All restaurants</h1>
        <p class="text-muted-soft mb-0">Showing <strong>24</strong> places near <strong>Kuala Lumpur</strong></p>
      </div>
      <form class="nn-search-bar" style="max-width:380px;" onsubmit="event.preventDefault();">
        <input type="text" placeholder="Search restaurants or dishes…" aria-label="Search">
        <button class="nn-btn nn-btn-primary nn-btn-sm" type="submit">Go</button>
      </form>
    </div>

    <!-- ===================================================== FILTERS -->
    <div class="row g-3 mb-3">
      <div class="col-12">
        <div class="nn-chip-group mb-0">
          <a href="#" class="nn-chip active">All</a>
          <a href="#" class="nn-chip">🍕 Pizza</a>
          <a href="#" class="nn-chip">🍔 Burgers</a>
          <a href="#" class="nn-chip">🍣 Japanese</a>
          <a href="#" class="nn-chip">🍜 Asian</a>
          <a href="#" class="nn-chip">🌯 Mexican</a>
          <a href="#" class="nn-chip">🥗 Healthy</a>
          <a href="#" class="nn-chip">🍰 Desserts</a>
          <a href="#" class="nn-chip">☕ Cafe</a>
        </div>
      </div>
      <div class="col-12 d-flex flex-wrap gap-2 align-items-center">
        <span class="text-muted-soft" style="font-size:0.9rem;">Sort by:</span>
        <select class="nn-form-control" style="width:auto;">
          <option>Recommended</option>
          <option>Rating: high to low</option>
          <option>Delivery time: fastest</option>
          <option>Delivery fee: lowest</option>
          <option>Price: low to high</option>
        </select>
        <span class="text-muted-soft mx-2">·</span>
        <label class="d-inline-flex align-items-center gap-2 mb-0" style="font-size:0.9rem;">
          <input type="checkbox"> Open now
        </label>
        <label class="d-inline-flex align-items-center gap-2 mb-0" style="font-size:0.9rem;">
          <input type="checkbox"> Free delivery
        </label>
        <label class="d-inline-flex align-items-center gap-2 mb-0" style="font-size:0.9rem;">
          <input type="checkbox"> Promo
        </label>
      </div>
    </div>

    <hr class="nn-divider mt-3">

    <!-- ===================================================== RESTAURANT GRID -->
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
                <span class="nn-tag nn-tag-success">Promo</span>
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
              <div class="mt-2"><span class="nn-tag">Japanese</span></div>
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
                <span class="nn-tag nn-tag-warning">Busy</span>
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
              <div class="mt-2"><span class="nn-tag">Chinese</span></div>
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
              <div class="mt-2"><span class="nn-tag">Mexican</span></div>
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

      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">🍰</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">Sweet Spot Bakery</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.6</span>
                <span>20–30 min</span>
                <span>RM 4 delivery</span>
              </div>
              <div class="mt-2"><span class="nn-tag">Desserts</span></div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">☕</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">Brew &amp; Bean Cafe</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.7</span>
                <span>15–20 min</span>
                <span>Free delivery</span>
              </div>
              <div class="mt-2"><span class="nn-tag">Cafe</span></div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <a href="./restaurant-detail.php" class="text-reset" style="text-decoration:none;">
          <div class="nn-card h-100">
            <div class="nn-card-img">🍱</div>
            <div class="nn-card-body">
              <h3 class="nn-card-title">Bento Box Express</h3>
              <div class="nn-card-meta">
                <span class="nn-rating">★ 4.3</span>
                <span>25–35 min</span>
                <span>RM 5 delivery</span>
              </div>
              <div class="mt-2"><span class="nn-tag">Japanese</span></div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- ===================================================== PAGINATION -->
    <nav class="d-flex justify-content-center mt-5" aria-label="Pagination">
      <ul class="pagination">
        <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </section>

  <!-- ============================================================ FOOTER -->
  <footer class="nn-footer">
    <div class="container text-center">
      <div class="nn-brand mb-2 justify-content-center"><span class="nn-brand-mark">N</span> NomNom</div>
      <div>© 2026 NomNom Demo · Built with PHP, jQuery, Bootstrap 5 · PWA-enabled</div>
    </div>
  </footer>

  <!-- ============================================================ MOBILE BOTTOM NAV -->
  <nav class="nn-bottom-nav">
    <a href="./index.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">🏠</span>Home
    </a>
    <a href="./restaurants.php" class="nn-bottom-nav-item active">
      <span class="nn-bottom-nav-icon">🍽️</span>Browse
    </a>
    <a href="./cart.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">🛒</span>Cart
    </a>
    <a href="./profile.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">👤</span>Profile
    </a>
  </nav>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
</body>
</html>
