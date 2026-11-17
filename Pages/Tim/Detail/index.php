<?php
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
$images_dir = __DIR__ . '/../../../Assets/images/';

$gambar_url = function ($nama) use ($images_url, $images_dir) {
    return file_exists($images_dir . $nama) ? $images_url . $nama : $images_url . 'dummy.jpg';
};

$tim_url     = $base_url . '/Pages/Tim/index.php';
$hubungi_url = $base_url . '/Pages/HubungiKami/index.php';

$foto_anggota = [
    1 => 'suki.png',
    2 => 'suki2.png',
    3 => 'suki3.png',
    4 => 'suki4.png',
    5 => 'suki5.png',
    6 => 'tim-6.jpg',
    7 => 'tim-7.jpg',
    8 => 'tim-8.jpg',
];

$anggota_katalog = [
    1 => [
        'id'          => 1,
        'foto'        => $foto_anggota[1],
        'nama'        => 'Dr. Aria Wiguna, M.T.',
        'jabatan'     => 'Instruktur Senior',
        'bidang'      => 'Rekayasa Perangkat Lunak dan Data Science',
        'npwp'        => '12.345.678.9-012.000',
        'nidn'        => '0412038502',
        'email'       => 'aria.wiguna@contohinstansi.com',
        'telepon'     => '0812-3456-7890',
        'pendidikan'  => 'S2 Teknik Informatika, Universitas Teknologi Nusantara',
        'sertifikasi' => 'Certified Python Developer, AWS Certified Solutions Architect',
        'pengalaman'  => '8 Tahun sebagai praktisi industri dan pengajar aktif.',
    ],
];

$anggota_lain = [
    2 => ['Nama Anggota 2, M.M.',    'Project Manager',    'Manajemen Proyek Teknologi Informasi',   'S2 Manajemen Teknologi, Universitas Teknologi Nusantara',   'PMP, Certified Scrum Master',                        '7 Tahun sebagai project manager dan pengajar aktif.'],
    3 => ['Nama Anggota 3, M.Des.',  'UI/UX Designer',     'UI/UX Design dan Desain Interaksi',      'S2 Desain Komunikasi Visual, Universitas Teknologi Nusantara', 'Google UX Design Professional Certificate',         '6 Tahun sebagai desainer produk digital dan pengajar aktif.'],
    4 => ['Nama Anggota 4, M.Kom.',  'Frontend Developer', 'Pengembangan Antarmuka Web',             'S2 Teknik Informatika, Universitas Teknologi Nusantara',    'Meta Front-End Developer Certificate',               '5 Tahun sebagai frontend developer dan pengajar aktif.'],
    5 => ['Nama Anggota 5, M.Kom.',  'Backend Developer',  'Pengembangan Sistem dan Basis Data',     'S2 Sistem Informasi, Universitas Teknologi Nusantara',      'Certified Laravel Developer, MySQL Professional',    '6 Tahun sebagai backend developer dan pengajar aktif.'],
    6 => ['Nama Anggota 6, M.T.',    'Mobile Developer',   'Pengembangan Aplikasi Mobile',           'S2 Teknik Informatika, Universitas Teknologi Nusantara',    'Associate Android Developer, Flutter Certified',     '5 Tahun sebagai mobile developer dan pengajar aktif.'],
    7 => ['Nama Anggota 7, M.T.',    'Network & IoT',      'Jaringan Komputer dan Internet of Things', 'S2 Teknik Komputer, Universitas Teknologi Nusantara',      'CCNA, CompTIA Security+',                            '7 Tahun sebagai network engineer dan pengajar aktif.'],
    8 => ['Nama Anggota 8, M.Sn.',   'Multimedia',         'Produksi Multimedia dan Motion Graphic', 'S2 Desain Media Digital, Universitas Teknologi Nusantara', 'Adobe Certified Professional',                       '6 Tahun sebagai kreator multimedia dan pengajar aktif.'],
];

foreach ($anggota_lain as $no => $baris) {
    $anggota_katalog[$no] = [
        'id'          => $no,
        'foto'        => $foto_anggota[$no],
        'nama'        => $baris[0],
        'jabatan'     => $baris[1],
        'bidang'      => $baris[2],
        'npwp'        => '12.345.678.9-012.00' . $no,
        'nidn'        => '041203850' . $no,
        'email'       => 'anggota' . $no . '@contohinstansi.com',
        'telepon'     => '0812-3456-789' . $no,
        'pendidikan'  => $baris[3],
        'sertifikasi' => $baris[4],
        'pengalaman'  => $baris[5],
    ];
}

$id = (int) ($_GET['id'] ?? 1);
if (!isset($anggota_katalog[$id])) {
    header('Location: ' . $tim_url . '#anggota');
    exit;
}

$orang = $anggota_katalog[$id];
$orang['foto'] = $gambar_url($orang['foto']);

$detail = [
    'Nama Lengkap'           => $orang['nama'],
    'Jabatan'                => $orang['jabatan'],
    'Bidang Keahlian'        => $orang['bidang'],
    'NPWP'                   => $orang['npwp'],
    'Nomor Induk / NIDN'     => $orang['nidn'],
    'Email'                  => $orang['email'],
    'Nomor Telepon'          => $orang['telepon'],
    'Pendidikan Terakhir'    => $orang['pendidikan'],
    'Riwayat Sertifikasi'    => $orang['sertifikasi'],
    'Pengalaman Profesional' => $orang['pengalaman'],
];

$carousel_gambar = [
    $images_url . 'dummy.jpg',
    $images_url . 'ajasendiri.jpg',
];

$carousel_slides = [];
foreach ($carousel_gambar as $no => $gambar) {
    $carousel_slides[] = [
        'id'          => $no + 1,
        'image'       => $gambar,
        'title'       => $orang['nama'],
        'description' => $orang['jabatan'] . ' · ' . $orang['bidang'],
        'buttons'     => [
            ['text' => 'Hubungi Kami', 'link' => $hubungi_url, 'variant' => 'primary'],
            ['text' => 'Kembali ke Tim', 'link' => $tim_url,   'variant' => 'outline-white'],
        ],
    ];
}

include_once __DIR__ . '/../../../Components/button.php';

$auto_slide_interval = 7000;
$carousel_id = 'carousel_' . substr(md5(uniqid((string)mt_rand(), true)), 0, 8);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jtinova - Anggota Tim</title>

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">

    <?php require_once __DIR__ . '/../../../Components/card.php'; ?>

    <style>
    @keyframes zoomRight {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .carousel-wrapper {
        position: relative;
        width: 100%;
        height: 480px;
        overflow: hidden;
        background-color: #000000;
    }

    @media (min-width: 768px) {
        .carousel-wrapper {
            height: 520px;
        }
    }

    @media (min-width: 1200px) {
        .carousel-wrapper {
            height: 560px;
        }
    }

    .carousel-slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        z-index: 1;
        pointer-events: none;
        transition: opacity 1s ease-in-out, visibility 1s ease-in-out;
    }

    .carousel-slide.active {
        opacity: 1;
        visibility: visible;
        z-index: 2;
        pointer-events: auto;
    }

    .carousel-bg-wrap {
        position: absolute;
        inset: 0;
        overflow: hidden;
    }

    .carousel-bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0.8;
        will-change: transform;
    }

    .carousel-slide.active .carousel-bg {
        animation: zoomRight 30s ease-out infinite;
        transform-origin: right center;
    }

    .carousel-overlay {
        position: absolute;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .carousel-content-wrap {
        position: relative;
        z-index: 3;
        height: 100%;
        display: flex;
        align-items: center;
        max-width: var(--container-max-width, 1200px);
        margin: 0 auto;
        padding: 0 var(--container-padding-x, 120px);
        box-sizing: border-box;
        width: 100%;
    }

    .carousel-text-box {
        max-width: 780px;
        width: 100%;
        color: var(--bg-white, #ffffff);
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.7s ease 0.2s, transform 0.7s ease 0.2s;
        min-height: 270px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .carousel-slide.active .carousel-text-box {
        opacity: 1;
        transform: translateY(0);
    }

    .carousel-title {
        font-size: clamp(26px, 4.2vw, 44px);
        font-weight: 700;
        line-height: 1.3;
        margin: 0 0 var(--space-16, 16px) 0;
        color: var(--bg-white, #ffffff);
        white-space: pre-line;
        letter-spacing: -0.5px;
        min-height: calc(2 * 1.3em);
        box-sizing: border-box;
        padding-bottom: 2px;
    }

    .carousel-desc {
        font-size: clamp(14px, 1.6vw, 17px);
        line-height: 1.6;
        margin: 0;
        color: rgba(255, 255, 255, 0.9);
        max-width: 660px;
        min-height: calc(2 * 1.6em);
        box-sizing: border-box;
    }

    .carousel-desc--empty {
        visibility: hidden;
        user-select: none;
        pointer-events: none;
    }

    .carousel-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-16, 16px);
        align-items: center;
        margin-top: 32px;
    }

    .carousel-hero-btn,
    .carousel-buttons .blob-btn {
        width: 230px !important;
        flex: 0 0 230px !important;
        height: 52px !important;
        min-height: 52px !important;
        padding: 0 16px !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        line-height: 1.4 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        box-sizing: border-box !important;
        white-space: nowrap !important;
        border-radius: var(--radius-pill, 999px) !important;
    }

    .carousel-hero-btn .blob-btn__text,
    .carousel-buttons .blob-btn .blob-btn__text {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        text-align: center;
        line-height: 1.4;
        overflow: visible;
        padding-bottom: 2px;
    }

    .carousel-dots {
        position: absolute;
        bottom: var(--space-24, 24px);
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .carousel-dot {
        width: 10px;
        height: 10px;
        border-radius: var(--radius-pill, 999px);
        background-color: rgba(255, 255, 255, 0.45);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .carousel-dot:hover {
        background-color: var(--bg-white, #ffffff);
    }

    .carousel-dot.active {
        width: 32px;
        background-color: var(--brand-teal, #8DBCC2);
    }

    @media (max-width: 1280px) {
        .carousel-content-wrap {
            padding-left: 64px;
            padding-right: 64px;
        }
    }

    @media (max-width: 1024px) {
        .carousel-content-wrap {
            padding-left: 40px;
            padding-right: 40px;
        }
    }

    @media (max-width: 768px) {
        .carousel-content-wrap {
            padding: 72px 24px 48px;
        }

        .carousel-text-box {
            min-height: auto;
        }

        .carousel-title {
            min-height: auto;
            margin-bottom: var(--space-12, 12px);
        }

        .carousel-desc {
            min-height: auto;
            font-size: 14.5px;
            line-height: 1.5;
        }

        .carousel-buttons {
            margin-top: 24px;
            gap: var(--space-12, 12px);
        }

        .carousel-hero-btn,
        .carousel-buttons .blob-btn {
            width: 210px !important;
            flex: 0 0 210px !important;
            height: 50px !important;
            min-height: 50px !important;
            font-size: 14.5px !important;
        }
    }

    @media (max-width: 640px) {
        .carousel-wrapper {
            height: 540px;
        }

        .carousel-buttons {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            gap: 12px;
            margin-top: 20px;
        }

        .carousel-hero-btn,
        .carousel-buttons .blob-btn {
            width: 100% !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            height: 48px !important;
            min-height: 48px !important;
            padding: 0 16px !important;
            font-size: 15px !important;
        }
    }

    @media (max-width: 480px) {
        .carousel-content-wrap {
            padding: 72px 16px 48px;
        }
    }

    @media (max-width: 380px) {
        .carousel-wrapper {
            height: 580px;
        }
    }
    </style>

    <style>
    .at-hero {
        background-color: var(--bg-soft);
        padding-top: calc(var(--space-48) + var(--space-8));
        padding-bottom: calc(var(--space-48) + var(--space-8));
    }

    .at-hero__back {
        display: inline-flex;
        color: var(--text-primary);
        border-radius: 50%;
    }

    .at-hero__back svg {
        width: 44px;
        height: 44px;
        fill: none;
        stroke: currentColor;
    }

    .at-hero__back:focus-visible {
        outline: 2px solid var(--brand-teal);
        outline-offset: 3px;
    }

    .at-hero__crumb {
        margin: calc(var(--space-24) + var(--space-16)) 0 calc(var(--space-24) + var(--space-8));
        color: var(--text-secondary);
    }

    .at-hero__crumb a {
        color: inherit;
        text-decoration: none;
    }

    .at-hero__crumb a:hover {
        text-decoration: underline;
    }

    .at-hero__title {
        margin: 0 0 calc(var(--space-24) + var(--space-8));
        color: var(--brand-primary);
    }

    .at-hero__desc {
        margin: 0;
        color: var(--text-secondary);
    }

    .at-profile {
        padding-top: calc(var(--space-24) + var(--space-8));
        padding-bottom: calc(var(--space-48) + var(--space-16));
    }

    .at-profile__grid {
        display: grid;
        grid-template-columns: 360px 1fr;
        align-items: center;
        gap: 60px;
    }

    .at-profile__photo {
        width: 360px;
        height: 485px;
        object-fit: cover;
        display: block;
        border-radius: var(--radius-card);
        background-color: var(--bg-gray);
    }

    .at-profile__list {
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 20px;
        font-weight: 400;
        line-height: 37px;
        color: var(--text-primary);
    }

    .at-profile__list strong {
        font-weight: 700;
        color: var(--text-primary);
    }

    .at-back {
        padding-top: 28px;
    }

    .at-back .at-hero__back {
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .at-back .at-hero__back:hover {
        color: var(--brand-primary);
        transform: translateX(-3px);
    }

    @media (max-width: 768px) {
        .at-back {
            padding-top: 20px;
        }

        .at-back .at-hero__back svg {
            width: 40px;
            height: 40px;
        }
    }

    @media (max-width: 480px) {
        .at-back .at-hero__back svg {
            width: 36px;
            height: 36px;
        }
    }

    @media (hover: none) {
        .at-back .at-hero__back:hover {
            transform: none;
        }
    }

    html { -webkit-text-size-adjust: 100%; }
    body { overflow-x: clip; }
    img  { max-width: 100%; }

    .at-profile__grid > * { min-width: 0; }
    .at-profile__list li { overflow-wrap: break-word; }
    .at-hero__title { overflow-wrap: anywhere; }

    @media (max-width: 1280px) {
        .container {
            padding-left: 64px;
            padding-right: 64px;
        }

        .navbar .navbar-container {
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
        .container,
        .at-hero .container,
        .at-profile .container {
            padding-left: 40px;
            padding-right: 40px;
        }

        .navbar .navbar-container {
            padding-left: 40px;
            padding-right: 40px;
        }

        .at-hero {
            padding-top: 48px;
            padding-bottom: 48px;
        }

        .at-profile {
            padding-top: 28px;
            padding-bottom: 56px;
        }

        .at-profile__grid {
            grid-template-columns: minmax(240px, 300px) 1fr;
            gap: 40px;
        }

        .at-profile__photo {
            width: 100%;
            height: auto;
            aspect-ratio: 360 / 485;
        }

        .at-profile__list {
            font-size: 18px;
            line-height: 1.8;
        }
    }

    @media (max-width: 900px) {
        .navbar .navbar-container {
            padding-left: 24px;
            padding-right: 24px;
        }
    }

    @media (max-width: 768px) {
        .container,
        .at-hero .container,
        .at-profile .container {
            padding-left: 24px;
            padding-right: 24px;
        }

        .at-hero {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .at-hero__title {
            font-size: 32px;
        }

        .at-profile {
            padding-top: 24px;
            padding-bottom: 44px;
        }

        .at-profile__grid {
            grid-template-columns: minmax(180px, 220px) 1fr;
            gap: 28px;
        }

        .at-profile__list {
            font-size: 16px;
            line-height: 1.75;
        }
    }

    @media (max-width: 640px) {
        .at-profile__grid {
            grid-template-columns: 1fr;
            gap: 24px;
            align-items: start;
        }

        .at-profile__photo {
            max-width: 360px;
        }

        .at-profile__list {
            font-size: 15px;
            line-height: 1.7;
        }

        .at-profile__list li + li {
            margin-top: 6px;
        }
    }

    @media (max-width: 480px) {
        .container,
        .at-hero .container,
        .at-profile .container {
            padding-left: 16px;
            padding-right: 16px;
        }

        .navbar .navbar-container {
            padding-left: 16px;
            padding-right: 16px;
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

        .at-hero__title {
            font-size: 28px;
        }

        .at-profile__photo {
            max-width: 100%;
        }
    }

    @media (max-width: 380px) {
        .at-profile__list {
            font-size: 14.5px;
        }
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../../../Components/navbar.php'; ?>

    <div class="carousel-wrapper" id="<?= htmlspecialchars($carousel_id) ?>">
        <?php foreach ($carousel_slides as $index => $slide): ?>
            <?php
            $is_active = ($index === 0);
            $buttons = (!empty($slide['buttons']) && is_array($slide['buttons'])) ? $slide['buttons'] : [];
            ?>
            <div class="carousel-slide <?= $is_active ? 'active' : '' ?>" data-index="<?= $index ?>">
                <div class="carousel-bg-wrap">
                    <div class="carousel-bg" style="background-image: url('<?= htmlspecialchars($slide['image']) ?>');"></div>
                    <div class="carousel-overlay"></div>
                </div>

                <div class="carousel-content-wrap">
                    <div class="carousel-text-box">
                        <h2 class="carousel-title"><?= htmlspecialchars($slide['title']) ?></h2>
                        <?php if (!empty($slide['description'])): ?>
                            <p class="carousel-desc"><?= htmlspecialchars($slide['description']) ?></p>
                        <?php else: ?>
                            <p class="carousel-desc carousel-desc--empty" aria-hidden="true">&nbsp;</p>
                        <?php endif; ?>

                        <?php if (!empty($buttons)): ?>
                            <div class="carousel-buttons">
                                <?php foreach ($buttons as $btn): ?>
                                    <?= render_button([
                                        'variant' => $btn['variant'] ?? 'primary',
                                        'text'    => $btn['text'] ?? '',
                                        'href'    => $btn['link'] ?? null,
                                        'size'    => 'md',
                                        'class'   => 'carousel-hero-btn'
                                    ]) ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (count($carousel_slides) > 1): ?>
            <div class="carousel-dots">
                <?php foreach ($carousel_slides as $index => $slide): ?>
                    <button type="button"
                            class="carousel-dot <?= ($index === 0) ? 'active' : '' ?>"
                            data-target="<?= $index ?>"
                            aria-label="Menuju slide <?= $index + 1 ?>">
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
    (function () {
        const root = document.getElementById('<?= $carousel_id ?>');
        if (!root) return;

        const slides = root.querySelectorAll('.carousel-slide');
        const dots = root.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;
        const intervalDuration = <?= (int)$auto_slide_interval ?>;

        if (totalSlides <= 1) return;

        let current = 0;
        let timer = null;
        let isPaused = false;

        function goTo(index) {
            if (index < 0) {
                current = totalSlides - 1;
            } else if (index >= totalSlides) {
                current = 0;
            } else {
                current = index;
            }

            slides.forEach(function (slide, idx) {
                slide.classList.toggle('active', idx === current);
            });

            dots.forEach(function (dot, idx) {
                dot.classList.toggle('active', idx === current);
            });
        }

        function next() { goTo(current + 1); }
        function prev() { goTo(current - 1); }

        function stopTimer() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        function startTimer() {
            stopTimer();
            timer = setInterval(function () {
                if (!isPaused) next();
            }, intervalDuration);
        }

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                goTo(parseInt(dot.getAttribute('data-target'), 10));
                startTimer();
            });
        });

        root.addEventListener('mouseenter', function () { isPaused = true; });
        root.addEventListener('mouseleave', function () { isPaused = false; });

        let touchStartX = 0;

        root.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        root.addEventListener('touchend', function (e) {
            const diff = touchStartX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 40) {
                diff > 0 ? next() : prev();
                startTimer();
            }
        }, { passive: true });

        startTimer();
    })();
    </script>

    <section class="at-back">
        <div class="container">
            <a href="<?= htmlspecialchars($tim_url) ?>#anggota" class="at-hero__back" aria-label="Kembali ke halaman Tim">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12.5 8l-4 4 4 4M8.5 12h7.5"/>
                </svg>
            </a>
        </div>
    </section>

    <section class="at-profile">
        <div class="container at-profile__grid">
            <img class="at-profile__photo"
                 src="<?= htmlspecialchars($orang['foto']) ?>"
                 alt="<?= htmlspecialchars($orang['nama']) ?>">
            <ul class="at-profile__list">
                <?php foreach ($detail as $label => $nilai): ?>
                    <li><strong><?= htmlspecialchars($label) ?>:</strong> <?= htmlspecialchars($nilai) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php require_once __DIR__ . '/../../../Components/footer.php'; ?>

</body>

</html>