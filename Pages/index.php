<?php
$current_page = 'tentang-kami';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Navbar - prontoserve</title>

    <link rel="stylesheet" href="../Style/style.css">

    <style>
    .hero-section {
        padding-top: var(--space-80);
        padding-bottom: var(--space-80);
        text-align: center;
        background-color: var(--bg-soft);
        border-radius: var(--radius-card);
        margin-top: var(--space-24);
        margin-bottom: var(--space-48);
    }

    .hero-title {
        color: var(--brand-primary);
        margin-bottom: var(--space-16);
    }

    .hero-desc {
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto var(--space-24);
    }

    .info-card {
        padding: var(--space-24);
        margin-bottom: var(--space-24);
    }

    @media (max-width: 900px) {
        .container {
            padding-left: var(--space-24);
            padding-right: var(--space-24);
        }
    }
    </style>
</head>

<body>

    <?php include_once __DIR__ . '/../Components/navbar.php'; ?>

    <main class="container">
        <section class="hero-section">
            <h1 class="hero-title">Demo Navbar prontoserve</h1>
            <p class="hero-desc body-text">
                Navbar di atas telah disesuaikan dengan desain referensi. Desain mengambil variabel dari
                <code>style.css</code> dan secara otomatis berubah menjadi <strong>hamburger menu</strong> saat ukuran
                layar diperkecil ke mode mobile/tablet.
            </p>
            <a href="#" class="btn navbar-cta" style="display: inline-flex;">Coba Responsive (Resize Browser)</a>
        </section>

        <div class="card info-card">
            <h3 class="heading-3" style="color: var(--brand-primary); margin-top: 0;">Status Implementasi</h3>
            <p class="body-text" style="color: var(--text-secondary); margin-bottom: 0;">
                &bull; <strong>style.css:</strong> Tetap murni sebagai base design token / master style.<br>
                &bull; <strong>navbar.php:</strong> Komponen mandiri yang siap dipanggil di halaman mana pun dengan
                fungsionalitas hamburger aktif.<br>
                &bull; <strong>Style Halaman:</strong> Ditambahkan di dalam tag <code>&lt;style&gt;</code> di index.php
                sesuai instruksi.
            </p>
        </div>
    </main>

</body>

</html>