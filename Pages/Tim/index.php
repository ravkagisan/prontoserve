<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$current_page = 'tim';

$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(.*?)/(Pages|api|Components)#', $script_name, $matches)) {
    $base_url = $matches[1];
} else {
    $base_url = rtrim(dirname($script_name), '/\\');
    if ($base_url === '/' || $base_url === '\\') {
        $base_url = '';
    }
}

$images_url = $base_url . '/Assets/images/';
$images_dir = __DIR__ . '/../../Assets/images/';

$gambar_url = function ($nama) use ($images_url, $images_dir) {
    return file_exists($images_dir . $nama) ? $images_url . $nama : null;
};

$hubungi_url = $base_url . '/Pages/HubungiKami/index.php';
$tim_detail_url = $base_url . '/Pages/Tim/Detail/index.php';

$anggota = [
    ['nama' => 'Nama Anggota 1', 'peran' => 'Ketua Tim',          'foto' => 'suki.png'],
    ['nama' => 'Nama Anggota 2', 'peran' => 'Project Manager',    'foto' => 'suki2.png'],
    ['nama' => 'Nama Anggota 3', 'peran' => 'UI/UX Designer',     'foto' => 'suki3.png'],
    ['nama' => 'Nama Anggota 4', 'peran' => 'Frontend Developer', 'foto' => 'suki4.png'],
    ['nama' => 'Nama Anggota 5', 'peran' => 'Backend Developer',  'foto' => 'suki5.png'],
    ['nama' => 'Nama Anggota 6', 'peran' => 'Mobile Developer',   'foto' => 'tim-6.jpg'],
    ['nama' => 'Nama Anggota 7', 'peran' => 'Network & IoT',      'foto' => 'tim-7.jpg'],
    ['nama' => 'Nama Anggota 8', 'peran' => 'Multimedia',         'foto' => 'tim-8.jpg'],
];

$budaya = [
    [
        'judul' => 'Kolaboratif',
        'teks'  => 'Mahasiswa, dosen, dan industri bekerja dalam satu tim.',
        'ikon'  => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3"/>',
    ],
    [
        'judul' => 'Profesional',
        'teks'  => 'Standar kerja mengikuti praktik industri.',
        'ikon'  => '<path d="M4 7h16M4 12h16M4 17h16"/>',
    ],
    [
        'judul' => 'Bertumbuh',
        'teks'  => 'Setiap proyek menjadi sarana belajar.',
        'ikon'  => '<path d="M5 13l4 4L19 7"/>',
    ],
];

$pelayanan_url = $base_url . '/Pages/Pelayanan/index.php';
$pelatihan_url = $base_url . '/Pages/Pelatihan/index.php';
$portofolio_url = $base_url . '/Pages/Portofolio/index.php';

$carousel_slides = [
    [
        'id'          => 1,
        'image'       => $images_url . 'dummy.jpg',
        'title'       => "Inovasi Teknologi Terdepan\nBersama TEFA JTI Innovation",
        'description' => 'Menghadirkan riset terapan dan transformasi digital melalui pengembangan perangkat lunak, sistem cerdas, dan solusi industri terpercaya.',
        'buttons'     => [
            ['text' => 'Jelajahi Pelayanan', 'link' => $pelayanan_url, 'variant' => 'primary'],
            ['text' => 'Hubungi Kami',       'link' => $hubungi_url,   'variant' => 'outline-white'],
        ],
    ],
    [
        'id'          => 2,
        'image'       => $images_url . 'ajasendiri.jpg',
        'title'       => "Program Pelatihan Digital\nBerstandar Industri Terkini",
        'description' => 'Tingkatkan keahlian teknis dan kompetensi profesional mahasiswa serta talenta digital melalui kurikulum praktis dan sertifikasi industri.',
        'buttons'     => [
            ['text' => 'Lihat Pelatihan',  'link' => $pelatihan_url,  'variant' => 'primary'],
            ['text' => 'Lihat Portofolio', 'link' => $portofolio_url, 'variant' => 'outline-white'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jtinova - Tim</title>

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">

    <?php require_once __DIR__ . '/../../Components/card.php'; ?>

    <style>
    .tm-hero {
        background-color: var(--bg-soft);
        padding-top: calc(var(--space-48) + var(--space-8));
        padding-bottom: calc(var(--space-48) + var(--space-8));
    }

    .tm-hero__crumb {
        margin: 0 0 calc(var(--space-24) + var(--space-8));
        color: var(--text-secondary);
    }

    .tm-hero__crumb a {
        color: inherit;
        text-decoration: none;
    }

    .tm-hero__crumb a:hover {
        text-decoration: underline;
    }

    .tm-hero__title {
        margin: 0 0 calc(var(--space-24) + var(--space-8));
        color: var(--brand-primary);
    }

    .tm-hero__desc {
        margin: 0;
        font-size: 14px;
        color: var(--text-secondary);
    }

    .tm-section {
        padding-top: calc(var(--space-48) + var(--space-16));
        padding-bottom: calc(var(--space-48) + var(--space-16));
    }

    .tm-section--soft {
        background-color: var(--bg-soft);
    }

    .tm-head {
        text-align: center;
        margin-bottom: calc(var(--space-24) + var(--space-16));
    }

    .tm-head__title {
        margin: 0;
        color: var(--brand-primary);
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--space-24);
    }

    .team-grid .card-img-portrait-wrap {
        aspect-ratio: 4 / 3;
    }

    .culture-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--space-24);
    }

    .culture {
        padding: 20px;
    }

    .culture__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        margin-bottom: var(--space-8);
        border-radius: 50%;
        background-color: var(--bg-soft);
        color: var(--brand-primary);
    }

    .culture__icon svg {
        width: var(--icon-size-min);
        height: var(--icon-size-min);
        fill: none;
        stroke: currentColor;
    }

    .culture__title {
        margin: 0 0 var(--space-8);
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .culture__text {
        margin: 0;
        font-size: 13px;
        line-height: 16px;
        color: var(--text-secondary);
    }

    .tm-cta {
        background-color: var(--brand-primary);
        color: var(--bg-white);
        padding-top: calc(var(--space-48) + var(--space-8));
        padding-bottom: calc(var(--space-48) + var(--space-8));
    }

    .tm-cta__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: var(--space-24);
    }

    .tm-cta__title {
        margin: 0 0 4px;
        font-size: 28px;
        color: var(--bg-white);
    }

    .tm-cta__text {
        margin: 0;
        font-size: 14px;
        color: var(--bg-soft);
    }

    html { -webkit-text-size-adjust: 100%; }
    body { overflow-x: clip; }
    img  { max-width: 100%; }

    .team-grid > *,
    .culture-grid > *,
    .tm-cta__inner > * { min-width: 0; }

    .tm-hero__title,
    .tm-head__title,
    .culture__title,
    .tm-cta__title { overflow-wrap: anywhere; }

    .culture__text,
    .tm-cta__text,
    .tm-hero__desc { overflow-wrap: break-word; }

    @media (max-width: 1280px) {
        .container {
            padding-left: 64px;
            padding-right: 64px;
        }
    }

    @media (max-width: 1024px) {
        .container,
        .tm-hero .container,
        .tm-section .container,
        .tm-cta .container {
            padding-left: 40px;
            padding-right: 40px;
        }

        .tm-hero {
            padding-top: 48px;
            padding-bottom: 48px;
        }

        .tm-section {
            padding-top: 56px;
            padding-bottom: 56px;
        }

        .tm-cta {
            padding-top: 48px;
            padding-bottom: 48px;
        }

        .team-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .culture-grid {
            gap: 16px;
        }

        .tm-cta__inner {
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .container,
        .tm-hero .container,
        .tm-section .container,
        .tm-cta .container {
            padding-left: 24px;
            padding-right: 24px;
        }

        .tm-hero {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .tm-hero__title {
            font-size: 32px;
        }

        .tm-section {
            padding-top: 44px;
            padding-bottom: 44px;
        }

        .tm-head {
            margin-bottom: 28px;
        }

        .tm-head__title {
            font-size: 24px;
        }

        .team-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .culture-grid {
            grid-template-columns: 1fr;
        }

        .culture {
            padding: 18px;
        }

        .tm-cta {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .tm-cta__title {
            font-size: 22px;
        }

        .tm-cta__inner {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .container,
        .tm-hero .container,
        .tm-section .container,
        .tm-cta .container {
            padding-left: 16px;
            padding-right: 16px;
        }

        .tm-hero__title {
            font-size: 28px;
        }

        .tm-section {
            padding-top: 36px;
            padding-bottom: 36px;
        }

        .tm-head__title {
            font-size: 22px;
        }

        .team-grid {
            gap: 12px;
        }

        .tm-cta__title {
            font-size: 20px;
        }
    }

    @media (max-width: 340px) {
        .team-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 1280px) {
        .navbar .navbar-container {
            padding-left: 64px;
            padding-right: 64px;
        }

        body .carousel-wrapper .carousel-content-wrap {
            padding-left: 64px;
            padding-right: 64px;
        }
    }

    @media (min-width: 901px) and (max-width: 1100px) {
        .navbar .navbar-menu-wrapper {
            gap: 16px;
        }

        .navbar .navbar-menu {
            gap: 16px;
        }

        .navbar .nav-link {
            font-size: 14px;
        }
    }

    @media (max-width: 1024px) {
        .navbar .navbar-container {
            padding-left: 40px;
            padding-right: 40px;
        }

        body .carousel-wrapper .carousel-content-wrap {
            padding-left: 40px;
            padding-right: 40px;
        }
    }

    @media (max-width: 900px) {
        .navbar .navbar-container {
            padding-left: 24px;
            padding-right: 24px;
        }
    }

    @media (max-width: 768px) {
        body .carousel-wrapper .carousel-content-wrap {
            padding: 72px 24px 48px;
        }

        .team-grid .card-inner-team {
            padding: 14px;
        }
    }

    @media (max-width: 640px) {
        body .carousel-wrapper {
            height: 540px;
        }
    }

    @media (max-width: 480px) {
        .navbar .navbar-container {
            padding-left: 16px;
            padding-right: 16px;
        }

        body .carousel-wrapper .carousel-content-wrap {
            padding: 72px 16px 48px;
        }

        body .mobile-overlay {
            padding: 84px 24px 32px;
        }

        .mobile-overlay .mobile-nav-link {
            font-size: 18px;
            padding: 12px 0;
        }

        .mobile-overlay .mobile-dropdown-link {
            font-size: 16px;
        }

        .team-grid .card-inner-team {
            padding: 12px;
        }

        .team-grid .card-img-portrait-wrap {
            margin-bottom: 12px;
        }

        .team-grid .card-title {
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .team-grid .card-subtitle {
            font-size: 12px;
            margin-bottom: 12px;
        }
    }

    @media (max-width: 380px) {
        body .carousel-wrapper {
            height: 580px;
        }
    }

    @media (hover: none) {
        .custom-card:hover {
            transform: none;
        }

        .custom-card:hover .card-img {
            transform: none;
        }
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../../Components/navbar.php'; ?>

    <?php require_once __DIR__ . '/../../Components/carousel.php'; ?>

    <section class="tm-section" id="anggota">
        <div class="container">
            <div class="tm-head">
                <h2 class="heading-2 tm-head__title">Anggota Tim</h2>
            </div>
            <div class="team-grid">
                <?php foreach ($anggota as $index => $orang): ?>
                    <?php $id_anggota = $index + 1;?>
                    <?= render_card([
                        'variant'  => 'team',
                        'title'    => $orang['nama'],
                        'subtitle' => $orang['peran'],
                        'image'    => $gambar_url($orang['foto']),
                        'href'     => $tim_detail_url . '?id=' . $id_anggota, ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="tm-section tm-section--soft" id="budaya">
        <div class="container">
            <div class="tm-head">
                <h2 class="heading-2 tm-head__title">Budaya Kerja Kami</h2>
            </div>
            <div class="culture-grid">
                <?php foreach ($budaya as $nilai): ?>
                    <article class="card culture">
                        <span class="culture__icon">
                            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><?= $nilai['ikon'] ?></svg>
                        </span>
                        <h3 class="culture__title"><?= htmlspecialchars($nilai['judul']) ?></h3>
                        <p class="culture__text"><?= htmlspecialchars($nilai['teks']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    $cta_title     = 'Ingin bergabung atau magang bersama kami?';
    $cta_subtitle  = 'Program Magang Mahasiswa MBKM terbuka untuk mahasiswa berminat.';
    $cta_btn_text  = 'Hubungi Kami';
    $cta_btn_href  = $hubungi_url;
    $cta_variant   = 'dark';
    require_once __DIR__ . '/../../Components/ctacontainer.php';
    require_once __DIR__ . '/../../Components/footer.php';
    ?>

</body>

</html>