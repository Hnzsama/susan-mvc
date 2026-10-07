<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title><?= $judul ?? 'NyamCenter - Food & Bistro Mobile' ?></title>
  <meta name="description" content="Pusat pemesanan makanan online NyamCenter mobile application.">
  
  <!-- Google Fonts: Plus Jakarta Sans -->  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Icon Library: Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220%200%2032%2032%22><text y=%2226%22 font-size=%2226%22>🍲</text></svg>">

  <!-- Bundled CSS & JS with Vite -->
  <?= vite(['resources/css/app.css', 'resources/js/app.js']) ?>
</head>
<body class="mobile-only-body">

  <div class="mobile-app-container">
    <!-- ================= NAVBAR ================= -->
    <?php include_view('partials/navbar'); ?>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-grow-1">
      <?= $slot ?? '' ?>
    </main>

    <!-- ================= BOTTOM NAVIGATION ================= -->
    <?php include_view('partials/bottom-nav'); ?>

    <!-- ================= MODALS & DRAWERS ================= -->
    <?php include_view('partials/modals/custom-menu'); ?>
    <?php include_view('partials/modals/cart-drawer'); ?>
    <?php include_view('partials/modals/checkout'); ?>
    <?php include_view('partials/modals/qris'); ?>
    <?php include_view('partials/modals/tracker'); ?>
    <?php include_view('partials/toast'); ?>
  </div>

</body>
</html>
