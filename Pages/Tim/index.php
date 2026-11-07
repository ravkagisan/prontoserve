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



    @media (max-width: 1024px) {
        .tm-hero .container,
        .tm-section .container,
        .tm-cta .container {
            padding-left: var(--space-24);
            padding-right: var(--space-24);
        }

        .team-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .tm-hero__title {
            font-size: 32px;
        }

        .tm-head__title {
            font-size: 24px;
        }

        .tm-cta__title {
            font-size: 22px;
        }

        .culture-grid {
            grid-template-columns: 1fr;
        }

        .tm-cta__inner {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .team-grid {
            grid-template-columns: 1fr;
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
                    <?php $id_anggota = $index + 1; // ID dari 1 sampai 8 ?>
                    <?= render_card([
                        'variant'  => 'team',
                        'title'    => $orang['nama'],
                        'subtitle' => $orang['peran'],
                        'image'    => $gambar_url($orang['foto']),
                        'href'     => $tim_detail_url . '?id=' . $id_anggota, // Kartu bisa diklik menuju detail
                    ]) ?>
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