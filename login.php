<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>Sign in — NomNom</title>

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
      <a href="./register.php" class="nn-btn nn-btn-ghost nn-btn-sm">New here? Register</a>
    </div>
  </nav>

  <div class="nn-auth-wrap">
    <div class="nn-auth-card">
      <div class="text-center mb-4">
        <h1 class="h3">Welcome back 👋</h1>
        <p class="text-muted-soft mb-0">Sign in to order from your favourite restaurants.</p>
      </div>

      <!-- Real version: action="/login" with method="post" + CSRF token -->
      <form onsubmit="event.preventDefault(); window.NomNom.toast('Signing in… (demo)'); setTimeout(function(){location.href='./index.php'}, 800);">
        <input type="hidden" name="csrf_token" value="DUMMY_CSRF_TOKEN_REPLACE_SERVER_SIDE">

        <div class="nn-form-group">
          <label class="nn-form-label" for="email">Email address</label>
          <input class="nn-form-control" id="email" name="email" type="email" required autocomplete="email" placeholder="you@example.com">
        </div>

        <div class="nn-form-group">
          <div class="d-flex justify-content-between align-items-center">
            <label class="nn-form-label" for="password">Password</label>
            <a href="#" class="small">Forgot?</a>
          </div>
          <input class="nn-form-control" id="password" name="password" type="password" required autocomplete="current-password" minlength="8">
        </div>

        <div class="nn-form-group d-flex align-items-center gap-2">
          <input type="checkbox" id="remember" name="remember" value="1">
          <label for="remember" class="mb-0">Remember me on this device</label>
        </div>

        <button type="submit" class="nn-btn nn-btn-primary nn-btn-block nn-btn-lg">Sign in</button>

        <div class="text-center my-3 text-muted-soft" style="font-size:0.85rem;">or continue with</div>

        <div class="d-grid gap-2">
          <button type="button" class="nn-btn nn-btn-outline nn-btn-block">🔵 Google</button>
          <button type="button" class="nn-btn nn-btn-outline nn-btn-block">📘 Facebook</button>
        </div>

        <p class="text-center mt-4 mb-0" style="font-size:0.9rem;">
          Don't have an account? <a href="./register.php">Register here</a>
        </p>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
</body>
</html>
