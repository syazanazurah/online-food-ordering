<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>Tony's Pizzeria — NomNom</title>

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

  <!-- ============================================================ BREADCRUMB -->
  <div class="container nn-section pt-3 pb-0">
    <nav style="font-size:0.85rem;" aria-label="breadcrumb">
      <a href="./index.php">Home</a> ·
      <a href="./restaurants.php">Restaurants</a> ·
      <span class="text-muted-soft">Tony's Pizzeria</span>
    </nav>
  </div>

  <!-- ============================================================ RESTAURANT HERO -->
  <section class="container nn-section pt-3">
    <div class="nn-restaurant-hero">
      <div class="nn-restaurant-hero-content">
        <h1 class="mb-1" style="font-size:2rem;">🍕 Tony's Pizzeria</h1>
        <div class="d-flex flex-wrap gap-3 align-items-center" style="font-size:0.95rem;">
          <span>★ 4.8 (1,240 reviews)</span>
          <span>·</span>
          <span>Italian, Pizza</span>
          <span>·</span>
          <span>30–40 min</span>
          <span>·</span>
          <span>RM 5 delivery</span>
        </div>
        <div class="mt-2">
          <span class="nn-tag" style="background:rgba(255,255,255,0.25);color:#fff;">Open until 11:00 PM</span>
          <span class="nn-tag nn-tag-success">Free drink with orders &gt; RM 50</span>
        </div>
      </div>
    </div>

    <!-- ===================================================== LAYOUT: menu + sticky cart -->
    <div class="row g-4">
      <!-- ============= MENU ============= -->
      <div class="col-12 col-lg-8">
        <!-- Category nav (jump links) -->
        <div class="nn-chip-group">
          <a href="#popular" class="nn-chip active">⭐ Popular</a>
          <a href="#pizzas" class="nn-chip">🍕 Pizzas</a>
          <a href="#pasta" class="nn-chip">🍝 Pasta</a>
          <a href="#sides" class="nn-chip">🥗 Sides</a>
          <a href="#drinks" class="nn-chip">🥤 Drinks</a>
          <a href="#desserts" class="nn-chip">🍰 Desserts</a>
        </div>

        <!-- ====== Popular ====== -->
        <h2 id="popular" class="mt-4">⭐ Popular</h2>
        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Margherita Classic</div>
            <div class="nn-menu-item-desc">San Marzano tomato, fresh mozzarella, basil, extra virgin olive oil.</div>
            <div class="nn-menu-item-price">RM 28.00</div>
          </div>
          <div class="nn-menu-item-img">🍕</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m1"
                  data-name="Margherita Classic"
                  data-price="28.00"
                  data-img="🍕"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Pepperoni Supreme</div>
            <div class="nn-menu-item-desc">Spicy pepperoni, mozzarella, oregano on hand-stretched sourdough crust.</div>
            <div class="nn-menu-item-price">RM 34.00</div>
          </div>
          <div class="nn-menu-item-img">🍕</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m2"
                  data-name="Pepperoni Supreme"
                  data-price="34.00"
                  data-img="🍕"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <!-- ====== Pizzas ====== -->
        <h2 id="pizzas" class="mt-4">🍕 Pizzas</h2>
        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Quattro Formaggi</div>
            <div class="nn-menu-item-desc">Mozzarella, gorgonzola, parmesan, taleggio. For cheese lovers.</div>
            <div class="nn-menu-item-price">RM 38.00</div>
          </div>
          <div class="nn-menu-item-img">🧀</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m3"
                  data-name="Quattro Formaggi"
                  data-price="38.00"
                  data-img="🧀"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Hawaiian</div>
            <div class="nn-menu-item-desc">Smoked ham, pineapple, mozzarella. The classic argument starter.</div>
            <div class="nn-menu-item-price">RM 30.00</div>
          </div>
          <div class="nn-menu-item-img">🍍</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m4"
                  data-name="Hawaiian"
                  data-price="30.00"
                  data-img="🍍"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">BBQ Chicken</div>
            <div class="nn-menu-item-desc">Grilled chicken, smoky BBQ sauce, red onion, coriander.</div>
            <div class="nn-menu-item-price">RM 32.00</div>
          </div>
          <div class="nn-menu-item-img">🍗</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m5"
                  data-name="BBQ Chicken"
                  data-price="32.00"
                  data-img="🍗"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <!-- ====== Pasta ====== -->
        <h2 id="pasta" class="mt-4">🍝 Pasta</h2>
        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Spaghetti Carbonara</div>
            <div class="nn-menu-item-desc">Egg yolk, pecorino, guanciale, freshly cracked black pepper.</div>
            <div class="nn-menu-item-price">RM 26.00</div>
          </div>
          <div class="nn-menu-item-img">🍝</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m6"
                  data-name="Spaghetti Carbonara"
                  data-price="26.00"
                  data-img="🍝"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Penne Arrabbiata</div>
            <div class="nn-menu-item-desc">Spicy tomato sauce with garlic, chilli, and fresh parsley.</div>
            <div class="nn-menu-item-price">RM 22.00</div>
          </div>
          <div class="nn-menu-item-img">🌶️</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m7"
                  data-name="Penne Arrabbiata"
                  data-price="22.00"
                  data-img="🌶️"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <!-- ====== Sides ====== -->
        <h2 id="sides" class="mt-4">🥗 Sides</h2>
        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Garlic Bread</div>
            <div class="nn-menu-item-desc">Toasted ciabatta with garlic butter and parsley.</div>
            <div class="nn-menu-item-price">RM 12.00</div>
          </div>
          <div class="nn-menu-item-img">🥖</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m8"
                  data-name="Garlic Bread"
                  data-price="12.00"
                  data-img="🥖"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Caesar Salad</div>
            <div class="nn-menu-item-desc">Cos lettuce, croutons, parmesan, anchovy dressing.</div>
            <div class="nn-menu-item-price">RM 18.00</div>
          </div>
          <div class="nn-menu-item-img">🥗</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m9"
                  data-name="Caesar Salad"
                  data-price="18.00"
                  data-img="🥗"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <!-- ====== Drinks ====== -->
        <h2 id="drinks" class="mt-4">🥤 Drinks</h2>
        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">San Pellegrino</div>
            <div class="nn-menu-item-desc">Sparkling mineral water, 500 ml.</div>
            <div class="nn-menu-item-price">RM 8.00</div>
          </div>
          <div class="nn-menu-item-img">💧</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m10"
                  data-name="San Pellegrino"
                  data-price="8.00"
                  data-img="💧"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <!-- ====== Desserts ====== -->
        <h2 id="desserts" class="mt-4">🍰 Desserts</h2>
        <div class="nn-menu-item">
          <div class="nn-menu-item-info">
            <div class="nn-menu-item-name">Tiramisu</div>
            <div class="nn-menu-item-desc">Mascarpone, espresso-soaked savoiardi, cocoa.</div>
            <div class="nn-menu-item-price">RM 15.00</div>
          </div>
          <div class="nn-menu-item-img">🍰</div>
          <button class="nn-btn nn-btn-primary nn-btn-sm align-self-center"
                  data-add-to-cart
                  data-id="m11"
                  data-name="Tiramisu"
                  data-price="15.00"
                  data-img="🍰"
                  data-restaurant="Tony's Pizzeria">+ Add</button>
        </div>

        <!-- ===================================================== ABOUT / INFO -->
        <hr class="nn-divider mt-5">
        <h2>About Tony's</h2>
        <p class="text-muted-soft">Family-owned Italian kitchen serving wood-fired pizza and hand-rolled pasta in the heart of KL since 2008. All ingredients sourced fresh daily.</p>
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <strong>Address</strong>
            <div class="text-muted-soft" style="font-size:0.9rem;">Lot 24, Jalan Telawi, Bangsar Baru, 59100 Kuala Lumpur</div>
          </div>
          <div class="col-12 col-md-6">
            <strong>Hours</strong>
            <div class="text-muted-soft" style="font-size:0.9rem;">Mon–Sun: 11:00 AM – 11:00 PM</div>
          </div>
        </div>
      </div>

      <!-- ============= CART SIDEBAR (sticky on desktop) ============= -->
      <div class="col-12 col-lg-4">
        <div class="nn-card" style="position:sticky; top:88px;">
          <div class="nn-card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h3 class="mb-0" style="font-size:1.1rem;">Your order</h3>
              <a href="./cart.php" class="nn-btn nn-btn-ghost nn-btn-sm">View cart →</a>
            </div>
            <hr>
            <div class="text-center text-muted-soft" id="empty-cart-msg">
              <div style="font-size:2.5rem;">🛒</div>
              <p class="mb-0" style="font-size:0.9rem;">Your cart is empty.<br>Add items to get started.</p>
            </div>
            <p class="small text-muted-soft mt-3 mb-0" style="font-size:0.8rem;">
              Items are saved automatically. Continue browsing — your cart follows you.
            </p>
            <a href="./cart.php" class="nn-btn nn-btn-primary nn-btn-block mt-3">Go to checkout</a>
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
