<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>My profile — NomNom</title>

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
        <a href="./profile.php" class="nn-nav-link active">Profile</a>
        <a href="./cart.php" class="nn-nav-link nn-cart-badge">
          🛒 Cart
          <span class="nn-cart-count" style="display:none">0</span>
        </a>
      </div>
    </div>
  </nav>

  <section class="container nn-section">
    <!-- ===== Profile header ===== -->
    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
      <div style="width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,#ff6b35,#ff8a5c); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.75rem; font-weight:700;">
        AS
      </div>
      <div class="flex-grow-1">
        <h1 class="mb-1">Aiman Syazwan</h1>
        <div class="text-muted-soft" style="font-size:0.95rem;">aiman@example.com · Member since May 2026</div>
      </div>
      <a href="./login.php" class="nn-btn nn-btn-outline nn-btn-sm">Sign out</a>
    </div>

    <!-- ===== Tabs ===== -->
    <ul class="nav nav-tabs mb-4" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#orders" role="tab">My orders</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addresses" role="tab">Addresses</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#payments" role="tab">Payment methods</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#account" role="tab">Account</a></li>
    </ul>

    <div class="tab-content">

      <!-- ============= MY ORDERS ============= -->
      <div class="tab-pane fade show active" id="orders" role="tabpanel">
        <div class="row g-3">

          <!-- Order 1 (in progress) -->
          <div class="col-12">
            <div class="nn-card">
              <div class="nn-card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                  <div>
                    <div class="d-flex gap-2 align-items-center mb-1">
                      <strong>Order #NN-2026-04821</strong>
                      <span class="nn-tag nn-tag-warning">Preparing</span>
                    </div>
                    <div class="text-muted-soft" style="font-size:0.9rem;">Tony's Pizzeria · 18 May 2026 · 5:05 PM</div>
                  </div>
                  <div class="text-end">
                    <div style="font-weight:700; font-size:1.1rem;">RM 87.68</div>
                    <a href="./order-confirmation.php" class="small">Track order →</a>
                  </div>
                </div>
                <hr>
                <div style="font-size:0.9rem;" class="text-muted-soft">
                  1× Margherita Classic · 1× Spaghetti Carbonara · 2× Garlic Bread
                </div>
              </div>
            </div>
          </div>

          <!-- Order 2 (delivered) -->
          <div class="col-12">
            <div class="nn-card">
              <div class="nn-card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                  <div>
                    <div class="d-flex gap-2 align-items-center mb-1">
                      <strong>Order #NN-2026-04702</strong>
                      <span class="nn-tag nn-tag-success">Delivered</span>
                    </div>
                    <div class="text-muted-soft" style="font-size:0.9rem;">Sakura Sushi · 16 May 2026 · 8:22 PM</div>
                  </div>
                  <div class="text-end">
                    <div style="font-weight:700; font-size:1.1rem;">RM 64.20</div>
                    <a href="#" class="small">Reorder</a>
                  </div>
                </div>
                <hr>
                <div style="font-size:0.9rem;" class="text-muted-soft">
                  1× Salmon Sashimi · 1× Chicken Teriyaki Bento · 1× Miso Soup
                </div>
              </div>
            </div>
          </div>

          <!-- Order 3 (delivered) -->
          <div class="col-12">
            <div class="nn-card">
              <div class="nn-card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                  <div>
                    <div class="d-flex gap-2 align-items-center mb-1">
                      <strong>Order #NN-2026-04498</strong>
                      <span class="nn-tag nn-tag-success">Delivered</span>
                    </div>
                    <div class="text-muted-soft" style="font-size:0.9rem;">Greenhouse Bowls · 12 May 2026 · 1:10 PM</div>
                  </div>
                  <div class="text-end">
                    <div style="font-weight:700; font-size:1.1rem;">RM 32.00</div>
                    <a href="#" class="small">Reorder</a>
                  </div>
                </div>
                <hr>
                <div style="font-size:0.9rem;" class="text-muted-soft">
                  1× Mediterranean Bowl · 1× Kombucha (citrus)
                </div>
              </div>
            </div>
          </div>

          <!-- Order 4 (cancelled) -->
          <div class="col-12">
            <div class="nn-card">
              <div class="nn-card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                  <div>
                    <div class="d-flex gap-2 align-items-center mb-1">
                      <strong>Order #NN-2026-04302</strong>
                      <span class="nn-tag" style="background:#fde2e2; color:var(--nn-danger);">Cancelled</span>
                    </div>
                    <div class="text-muted-soft" style="font-size:0.9rem;">Smash House Burgers · 8 May 2026</div>
                  </div>
                  <div class="text-end">
                    <div style="font-weight:700; font-size:1.1rem;">RM 0.00</div>
                    <div class="text-muted-soft small">Refunded</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ============= ADDRESSES ============= -->
      <div class="tab-pane fade" id="addresses" role="tabpanel">
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="nn-card">
              <div class="nn-card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <strong>🏠 Home</strong>
                  <span class="nn-tag">Default</span>
                </div>
                <p class="text-muted-soft mb-3" style="font-size:0.9rem;">
                  No. 24, Jalan Telawi 3<br>
                  Bangsar Baru, 59100 Kuala Lumpur
                </p>
                <button class="nn-btn nn-btn-outline nn-btn-sm">Edit</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="nn-card">
              <div class="nn-card-body">
                <strong>🏢 Office</strong>
                <p class="text-muted-soft mb-3 mt-2" style="font-size:0.9rem;">
                  Level 18, Menara KL<br>
                  Jalan Punchak, 50250 Kuala Lumpur
                </p>
                <button class="nn-btn nn-btn-outline nn-btn-sm">Edit</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <button class="nn-btn nn-btn-outline nn-btn-block" style="height:100%; min-height:120px;">
              + Add new address
            </button>
          </div>
        </div>
      </div>

      <!-- ============= PAYMENTS ============= -->
      <div class="tab-pane fade" id="payments" role="tabpanel">
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="nn-card">
              <div class="nn-card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <strong>💳 Visa •••• 4242</strong>
                    <div class="text-muted-soft" style="font-size:0.85rem;">Expires 12/28</div>
                  </div>
                  <span class="nn-tag">Default</span>
                </div>
                <button class="nn-btn nn-btn-ghost nn-btn-sm text-danger mt-3">Remove</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="nn-card">
              <div class="nn-card-body">
                <strong>📱 Touch 'n Go eWallet</strong>
                <div class="text-muted-soft" style="font-size:0.85rem;">Linked May 2026</div>
                <button class="nn-btn nn-btn-ghost nn-btn-sm text-danger mt-3">Remove</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <button class="nn-btn nn-btn-outline nn-btn-block" style="height:100%; min-height:120px;">
              + Add payment method
            </button>
          </div>
        </div>
      </div>

      <!-- ============= ACCOUNT ============= -->
      <div class="tab-pane fade" id="account" role="tabpanel">
        <div class="nn-card">
          <div class="nn-card-body">
            <h3 class="h5 mb-3">Personal information</h3>
            <form onsubmit="event.preventDefault(); window.NomNom.toast('Profile updated (demo)');">
              <input type="hidden" name="csrf_token" value="DUMMY_CSRF_TOKEN_REPLACE_SERVER_SIDE">
              <div class="row g-3">
                <div class="col-12 col-md-6 nn-form-group">
                  <label class="nn-form-label" for="first_name">First name</label>
                  <input class="nn-form-control" id="first_name" name="first_name" type="text" value="Aiman">
                </div>
                <div class="col-12 col-md-6 nn-form-group">
                  <label class="nn-form-label" for="last_name">Last name</label>
                  <input class="nn-form-control" id="last_name" name="last_name" type="text" value="Syazwan">
                </div>
                <div class="col-12 nn-form-group">
                  <label class="nn-form-label" for="email">Email</label>
                  <input class="nn-form-control" id="email" name="email" type="email" value="aiman@example.com">
                </div>
                <div class="col-12 nn-form-group">
                  <label class="nn-form-label" for="phone">Mobile</label>
                  <input class="nn-form-control" id="phone" name="phone" type="tel" value="+60 12 345 6789">
                </div>
              </div>
              <button type="submit" class="nn-btn nn-btn-primary">Save changes</button>
            </form>

            <hr class="nn-divider">

            <h3 class="h5 mb-3">Notifications</h3>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <strong>Push notifications</strong>
                <div class="text-muted-soft" style="font-size:0.85rem;">Order updates and rider arrival.</div>
              </div>
              <label class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" checked>
              </label>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <strong>Promotional emails</strong>
                <div class="text-muted-soft" style="font-size:0.85rem;">Promos, new restaurants, weekly picks.</div>
              </div>
              <label class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox">
              </label>
            </div>

            <hr class="nn-divider">

            <h3 class="h5 mb-3 text-danger">Danger zone</h3>
            <button class="nn-btn nn-btn-outline" style="border-color:var(--nn-danger); color:var(--nn-danger);">
              Delete account
            </button>
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
    <a href="./cart.php" class="nn-bottom-nav-item">
      <span class="nn-bottom-nav-icon">🛒</span>Cart
    </a>
    <a href="./profile.php" class="nn-bottom-nav-item active">
      <span class="nn-bottom-nav-icon">👤</span>Profile
    </a>
  </nav>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
</body>
</html>
