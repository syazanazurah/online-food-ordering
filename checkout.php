<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>Checkout — NomNom</title>

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
      <a href="./cart.php" class="nn-btn nn-btn-ghost nn-btn-sm">← Back to cart</a>
    </div>
  </nav>

  <section class="container nn-section">
    <h1 class="mb-4">Checkout</h1>

    <!-- Real version: action="/checkout" with method="post", CSRF token -->
    <form id="checkout-form" onsubmit="event.preventDefault(); window.NomNom.toast('Processing payment… (demo)'); setTimeout(function(){location.href='./order-confirmation.php'}, 1200);">
      <input type="hidden" name="csrf_token" value="DUMMY_CSRF_TOKEN_REPLACE_SERVER_SIDE">

      <div class="row g-4">
        <!-- ============= LEFT: form ============= -->
        <div class="col-12 col-lg-8">

          <!-- ===== Delivery method ===== -->
          <div class="nn-card mb-4">
            <div class="nn-card-body">
              <h3 class="h5 mb-3">1. Delivery method</h3>
              <div class="row g-2">
                <div class="col-12 col-md-6">
                  <label class="nn-card nn-card-body d-flex align-items-center gap-3" style="cursor:pointer;">
                    <input type="radio" name="delivery_method" value="delivery" checked>
                    <div>
                      <strong>🛵 Delivery</strong>
                      <div class="text-muted-soft" style="font-size:0.85rem;">30–40 min · RM 5.00</div>
                    </div>
                  </label>
                </div>
                <div class="col-12 col-md-6">
                  <label class="nn-card nn-card-body d-flex align-items-center gap-3" style="cursor:pointer;">
                    <input type="radio" name="delivery_method" value="pickup">
                    <div>
                      <strong>🏃 Pickup</strong>
                      <div class="text-muted-soft" style="font-size:0.85rem;">Ready in 20 min · No fee</div>
                    </div>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- ===== Delivery address ===== -->
          <div class="nn-card mb-4">
            <div class="nn-card-body">
              <h3 class="h5 mb-3">2. Delivery address</h3>
              <div class="row g-3">
                <div class="col-12 nn-form-group">
                  <label class="nn-form-label" for="address_line1">Street address</label>
                  <input class="nn-form-control" id="address_line1" name="address_line1" type="text" required placeholder="No. 24, Jalan Telawi 3" autocomplete="address-line1">
                </div>
                <div class="col-12 nn-form-group">
                  <label class="nn-form-label" for="address_line2">Unit / floor (optional)</label>
                  <input class="nn-form-control" id="address_line2" name="address_line2" type="text" placeholder="Unit 12-3A" autocomplete="address-line2">
                </div>
                <div class="col-12 col-md-6 nn-form-group">
                  <label class="nn-form-label" for="postal_code">Postal code</label>
                  <input class="nn-form-control" id="postal_code" name="postal_code" type="text" required pattern="[0-9]{5}" placeholder="59100" autocomplete="postal-code">
                </div>
                <div class="col-12 col-md-6 nn-form-group">
                  <label class="nn-form-label" for="city">City</label>
                  <input class="nn-form-control" id="city" name="city" type="text" required value="Kuala Lumpur" autocomplete="address-level2">
                </div>
                <div class="col-12 nn-form-group">
                  <label class="nn-form-label" for="instructions">Delivery instructions (optional)</label>
                  <textarea class="nn-form-control" id="instructions" name="instructions" rows="2" placeholder="e.g. ring the bell at door B"></textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- ===== Contact ===== -->
          <div class="nn-card mb-4">
            <div class="nn-card-body">
              <h3 class="h5 mb-3">3. Contact details</h3>
              <div class="row g-3">
                <div class="col-12 col-md-6 nn-form-group">
                  <label class="nn-form-label" for="full_name">Full name</label>
                  <input class="nn-form-control" id="full_name" name="full_name" type="text" required autocomplete="name">
                </div>
                <div class="col-12 col-md-6 nn-form-group">
                  <label class="nn-form-label" for="phone">Mobile number</label>
                  <input class="nn-form-control" id="phone" name="phone" type="tel" required placeholder="+60 12 345 6789" autocomplete="tel">
                </div>
              </div>
            </div>
          </div>

          <!-- ===== Payment ===== -->
          <div class="nn-card mb-4">
            <div class="nn-card-body">
              <h3 class="h5 mb-3">4. Payment method</h3>
              <div class="row g-2">
                <div class="col-12 col-md-6">
                  <label class="nn-card nn-card-body d-flex align-items-center gap-3" style="cursor:pointer;">
                    <input type="radio" name="payment_method" value="card" checked>
                    <div><strong>💳 Credit/debit card</strong><div class="text-muted-soft" style="font-size:0.85rem;">Visa, Mastercard</div></div>
                  </label>
                </div>
                <div class="col-12 col-md-6">
                  <label class="nn-card nn-card-body d-flex align-items-center gap-3" style="cursor:pointer;">
                    <input type="radio" name="payment_method" value="fpx">
                    <div><strong>🏦 FPX online banking</strong><div class="text-muted-soft" style="font-size:0.85rem;">Maybank, CIMB, etc.</div></div>
                  </label>
                </div>
                <div class="col-12 col-md-6">
                  <label class="nn-card nn-card-body d-flex align-items-center gap-3" style="cursor:pointer;">
                    <input type="radio" name="payment_method" value="ewallet">
                    <div><strong>📱 E-wallet</strong><div class="text-muted-soft" style="font-size:0.85rem;">Touch 'n Go, Boost</div></div>
                  </label>
                </div>
                <div class="col-12 col-md-6">
                  <label class="nn-card nn-card-body d-flex align-items-center gap-3" style="cursor:pointer;">
                    <input type="radio" name="payment_method" value="cod">
                    <div><strong>💵 Cash on delivery</strong><div class="text-muted-soft" style="font-size:0.85rem;">Pay rider on arrival</div></div>
                  </label>
                </div>
              </div>

              <!-- Card form (only shown when 'card' is selected — JS toggle could go here) -->
              <div class="mt-3" id="card-fields">
                <div class="row g-3">
                  <div class="col-12 nn-form-group">
                    <label class="nn-form-label" for="card_number">Card number</label>
                    <input class="nn-form-control" id="card_number" name="card_number" type="text" inputmode="numeric" placeholder="1234 5678 9012 3456" autocomplete="cc-number">
                  </div>
                  <div class="col-6 nn-form-group">
                    <label class="nn-form-label" for="card_expiry">Expiry</label>
                    <input class="nn-form-control" id="card_expiry" name="card_expiry" type="text" placeholder="MM/YY" autocomplete="cc-exp">
                  </div>
                  <div class="col-6 nn-form-group">
                    <label class="nn-form-label" for="card_cvc">CVC</label>
                    <input class="nn-form-control" id="card_cvc" name="card_cvc" type="text" inputmode="numeric" placeholder="123" autocomplete="cc-csc">
                  </div>
                </div>
                <div class="text-muted-soft" style="font-size:0.8rem;">
                  🔒 Card details are tokenised by our payment provider. We never store your full card number.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ============= RIGHT: summary ============= -->
        <div class="col-12 col-lg-4">
          <div class="nn-card" style="position:sticky;top:88px;">
            <div class="nn-card-body">
              <h3 class="h5 mb-3">Order summary</h3>

              <div id="checkout-summary-items" class="mb-3" style="font-size:0.9rem;">
                <!-- populated by JS -->
              </div>

              <hr>

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

              <button type="submit" class="nn-btn nn-btn-primary nn-btn-block nn-btn-lg mt-3">
                Place order
              </button>
              <p class="text-muted-soft text-center mt-2 mb-0" style="font-size:0.8rem;">
                By placing this order you agree to our <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.
              </p>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
  <script>
  $(function () {
    const Cart = window.NomNom.Cart;
    const fmt = window.NomNom.fmt;

    function render() {
      const items = Cart.get();
      const $list = $("#checkout-summary-items").empty();

      if (items.length === 0) {
        $list.html('<div class="text-muted-soft text-center py-2">No items in cart. <a href="./restaurants.php">Add some →</a></div>');
      } else {
        items.forEach(function (item) {
          $list.append(
            '<div class="d-flex justify-content-between mb-2">' +
              '<span>' + item.qty + '× ' + item.name + '</span>' +
              '<span>' + fmt(item.price * item.qty) + '</span>' +
            '</div>'
          );
        });
      }

      const isPickup = $('input[name="delivery_method"]:checked').val() === "pickup";
      const subtotal = Cart.subtotal();
      const delivery = isPickup || subtotal === 0 ? 0 : 5;
      const service = subtotal * 0.06;
      const total = subtotal + delivery + service;

      $("#subtotal").text(fmt(subtotal));
      $("#delivery-fee").text(fmt(delivery));
      $("#service-charge").text(fmt(service));
      $("#total").text(fmt(total));
    }

    $('input[name="delivery_method"]').on("change", render);
    render();
  });
  </script>
</body>
</html>
