<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff6b35">
  <title>You're offline — NomNom</title>

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
    </div>
  </nav>

  <section class="container nn-section">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6 text-center">
        <div class="nn-card">
          <div class="nn-card-body py-5">
            <div style="font-size:4rem; margin-bottom:1rem;">📡</div>
            <h1 class="h2 mb-3">You're offline</h1>
            <p class="text-muted-soft mb-4">
              Looks like you've lost connection. Don't worry — anything you've already viewed is still available, and any orders you submit will be sent the moment you're back online.
            </p>

            <div class="d-flex justify-content-center gap-2 flex-wrap">
              <button class="nn-btn nn-btn-primary" onclick="location.reload();">Try again</button>
              <a href="./cart.php" class="nn-btn nn-btn-outline">View cached cart</a>
            </div>

            <hr class="nn-divider">

            <h3 class="h6 mb-3">Available offline</h3>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
              <a href="./index.php" class="nn-chip">Home</a>
              <a href="./restaurants.php" class="nn-chip">Restaurants</a>
              <a href="./profile.php" class="nn-chip">My profile</a>
            </div>
          </div>
        </div>

        <p class="text-muted-soft mt-4" style="font-size:0.85rem;">
          NomNom is a Progressive Web App. Even without internet, your previously visited pages stay available.
        </p>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="./assets/js/nomnom.js"></script>
</body>
</html>
