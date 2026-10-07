<?php
/**
 * @var string|null $judul
 */
$judul = $judul ?? 'Aplikasi PHP MVC';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul ?? 'Aplikasi PHP MVC' ?> - Inainu MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    
    <!-- Navbar MVC -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= BASEURL ?>home">
                <i class="bi bi-box-seam me-2 text-primary"></i>Inainu <span class="badge bg-primary">MVC</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL ?>home">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL ?>product">
                            <i class="bi bi-box me-1"></i>Kelola Produk
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRelasi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-diagram-3 me-1"></i>Tabel Relasi
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0 rounded-3" aria-labelledby="navbarDropdownRelasi">
                            <li>
                                <a class="dropdown-item py-2" href="<?= BASEURL ?>product-detail">
                                    <i class="bi bi-card-checklist text-primary me-2"></i>Detail Spesifikasi <span class="badge bg-secondary-subtle text-secondary small ms-1">1 to 1</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="<?= BASEURL ?>review">
                                    <i class="bi bi-star-half text-warning me-2"></i>Ulasan & Rating <span class="badge bg-secondary-subtle text-secondary small ms-1">1 to Many</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="<?= BASEURL ?>tag">
                                    <i class="bi bi-tags text-success me-2"></i>Master Tags <span class="badge bg-secondary-subtle text-secondary small ms-1">Many to Many</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL ?>student">
                            <i class="bi bi-people me-1"></i>Tabel Siswa
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <a href="<?= BASEURL ?>docs" target="_blank" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark shadow-sm">
                        <i class="bi bi-book-half me-1"></i> Dokumentasi SPA
                    </a>
                    <a href="../../php-non-mvc/index.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        &larr; Non-MVC
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4 flex-grow-1">
        <?php foreach (['success', 'danger', 'warning', 'info'] as $alertType): ?>
            <?php if (Session::hasFlash($alertType)): ?>
                <div class="alert alert-<?= $alertType ?> alert-dismissible fade show shadow-sm rounded-3" role="alert">
                    <?= Session::getFlash($alertType) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
