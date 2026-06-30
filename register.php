<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>Create account — NomNom</title>

  <link rel="manifest" href="./manifest.webmanifest">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/css/nomnom.css" rel="stylesheet">
</head>
<body>

  <nav class="nn-navbar">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="./index.php" class="nn-brand">
        <span class="nn-brand-mark">N</span>
        <span>NomNom</span>
      </a>
      <a href="./login.php" class="nn-btn nn-btn-ghost nn-btn-sm">Already a member? Sign in</a>
    </div>
  </nav>

  <div class="nn-auth-wrap">
    <div class="nn-auth-card">
      <div class="text-center mb-4">
        <h1 class="h3">Create your account 🍽️</h1>
        <p class="text-muted-soft mb-0">Order in seconds. No commitment.</p>
      </div>

      <!-- Real version: action="/register" with method="post", CSRF token, server-side validation -->
      <form onsubmit="event.preventDefault(); window.NomNom.toast('Account created (demo)'); setTimeout(function(){location.href='./login.php'}, 900);">
        <input type="hidden" name="csrf_token" value="DUMMY_CSRF_TOKEN_REPLACE_SERVER_SIDE">

        <div class="row g-3">
          <div class="col-12 col-md-6 nn-form-group">
            <label class="nn-form-label" for="first_name">First name</label>
            <input class="nn-form-control" id="first_name" name="first_name" type="text" required autocomplete="given-name">
          </div>
          <div class="col-12 col-md-6 nn-form-group">
            <label class="nn-form-label" for="last_name">Last name</label>
            <input class="nn-form-control" id="last_name" name="last_name" type="text" required autocomplete="family-name">
          </div>
        </div>

        <div class="nn-form-group">
          <label class="nn-form-label" for="email">Email address</label>
          <input class="nn-form-control" id="email" name="email" type="email" required autocomplete="email" placeholder="you@example.com">
          <div class="nn-form-help">We'll send order confirmations here.</div>
        </div>

        <div class="nn-form-group">
          <label class="nn-form-label" for="phone">Mobile number</label>
          <input class="nn-form-control" id="phone" name="phone" type="tel" required autocomplete="tel" placeholder="+60 12 345 6789">
          <div class="nn-form-help">Used by riders to contact you.</div>
        </div>

        <div class="nn-form-group">
          <label class="nn-form-label" for="password">Password</label>
          <input class="nn-form-control" id="password" name="password" type="password" required autocomplete="new-password" minlength="8">
          <div class="nn-form-help">At least 8 characters, mix of letters and numbers.</div>
        </div>

        <div class="nn-form-group">
          <label class="nn-form-label" for="password_confirm">Confirm password</label>
          <input class="nn-form-control" id="password_confirm" name="password_confirm" type="password" required autocomplete="new-password" minlength="8">
        </div>

        <div class="nn-form-group d-flex align-items-start gap-2">
          <input type="checkbox" id="terms" name="terms" value="1" required class="mt-1">
          <label for="terms" class="mb-0" style="font-size:0.9rem;">
            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
          </label>
        </div>

        <button type="submit" class="nn-btn nn-btn-primary nn-btn-block nn-btn-lg">Create account</button>

        <p class="text-center mt-4 mb-0" style="font-size:0.9rem;">
          Already have an account? <a href="./login.php">Sign in</a>
        </p>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
</body>
</html>
