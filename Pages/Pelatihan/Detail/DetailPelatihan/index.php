<?php
$current_page = 'pelatihan';

$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(.*?)/(Pages|api|Components)#', $script_name, $matches)) {
    $base_url = $matches[1];
} else {
    $base_url = rtrim(dirname($script_name), '/\\');
    if ($base_url === '/' || $base_url === '\\') {
        $base_url = '';
    }
}

$pelatihan_url = $base_url . '/Pages/Pelatihan';

$katalog = [
    [
        'id'      => 1,
        'singkat' => 'Pemrograman Full Stack',
        'judul'   => 'Pemrograman Web Fullstack',
        'tanggal' => '10 Nov 2026',
        'mentor'  => 'Nama Instruktur',
        'silabus' => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Dasar HTML & CSS',   'ringkasan' => 'Struktur halaman, tipografi, dan layout responsif'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'JavaScript Dasar',   'ringkasan' => 'Variabel, fungsi, DOM, dan event'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Backend & Database', 'ringkasan' => 'REST API, autentikasi, dan basis data'],
            ['pertemuan' => 'Pertemuan 4', 'materi' => 'Proyek Akhir',       'ringkasan' => 'Integrasi, pengujian, dan presentasi'],
        ],
    ],
    [
        'id'      => 2,
        'singkat' => 'UI/UX Design',
        'judul'   => 'UI/UX Design dengan Figma',
        'tanggal' => '24 Nov 2026',
        'mentor'  => 'Nama Instruktur',
        'silabus' => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Dasar UI/UX',      'ringkasan' => 'Prinsip desain dan alur kerja desainer'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Riset & Wireframe', 'ringkasan' => 'User persona, user flow, dan wireframe'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Desain Visual',     'ringkasan' => 'Komponen, warna, tipografi, dan design system'],
            ['pertemuan' => 'Pertemuan 4', 'materi' => 'Proyek Akhir',      'ringkasan' => 'Prototipe interaktif dan uji kegunaan'],
        ],
    ],
    [
        'id'      => 3,
        'singkat' => 'Dasar Jaringan Komputer',
        'judul'   => 'Dasar Jaringan Komputer',
        'tanggal' => '6 Des 2026',
        'mentor'  => 'Nama Instruktur',
        'silabus' => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Konsep Jaringan',   'ringkasan' => 'Model OSI, TCP/IP, dan topologi'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Pengalamatan IP',   'ringkasan' => 'IPv4, subnetting, dan routing dasar'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Keamanan Jaringan', 'ringkasan' => 'Firewall, autentikasi, dan praktik aman'],
            ['pertemuan' => 'Pertemuan 4', 'materi' => 'Proyek Akhir',      'ringkasan' => 'Merancang dan mengonfigurasi jaringan kantor'],
        ],
    ],
    [
        'id'      => 4,
        'singkat' => 'Pemrograman Mobile',
        'judul'   => 'Pemrograman Mobile',
        'tanggal' => '13 Des 2026',
        'mentor'  => 'Nama Instruktur',
        'silabus' => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Dasar Mobile',     'ringkasan' => 'Lingkungan kerja dan komponen antarmuka'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Navigasi & State', 'ringkasan' => 'Perpindahan layar dan pengelolaan state'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Data & API',       'ringkasan' => 'Penyimpanan lokal dan konsumsi REST API'],
            ['pertemuan' => 'Pertemuan 4', 'materi' => 'Proyek Akhir',     'ringkasan' => 'Menyusun dan mempresentasikan aplikasi'],
        ],
    ],
    [
        'id'      => 5,
        'singkat' => 'Data & Analitik',
        'judul'   => 'Data & Analitik',
        'tanggal' => '20 Des 2026',
        'mentor'  => 'Nama Instruktur',
        'silabus' => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Pengantar Data',   'ringkasan' => 'Jenis data dan alur analisis'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Pembersihan Data', 'ringkasan' => 'Menangani data kosong, duplikat, dan outlier'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Visualisasi',      'ringkasan' => 'Grafik dan dashboard yang informatif'],
            ['pertemuan' => 'Pertemuan 4', 'materi' => 'Proyek Akhir',     'ringkasan' => 'Analisis data nyata dan presentasi temuan'],
        ],
    ],
    [
        'id'      => 6,
        'singkat' => 'Coding for Kids',
        'judul'   => 'Coding for Kids',
        'tanggal' => '3 Jan 2027',
        'mentor'  => 'Nama Instruktur',
        'silabus' => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Mengenal Logika', 'ringkasan' => 'Urutan perintah dan pola sederhana'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Animasi',         'ringkasan' => 'Membuat tokoh dan gerakan'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Permainan',       'ringkasan' => 'Membuat game sederhana'],
            ['pertemuan' => 'Pertemuan 4', 'materi' => 'Pameran Karya',   'ringkasan' => 'Menampilkan karya kepada orang tua'],
        ],
    ],
];

$id = (int) ($_GET['id'] ?? 1);
$kursus = null;
foreach ($katalog as $item) {
    if ((int) $item['id'] === $id) {
        $kursus = $item;
        break;
    }
}

if ($kursus === null) {
    header('Location: ' . $pelatihan_url . '/index.php#katalog');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jtinova - <?= htmlspecialchars($kursus['judul']) ?></title>

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">

    <?php require_once __DIR__ . '/../../../../Components/card.php'; ?>

    <style>
    .detail {
        background-color: var(--bg-soft);
    }

    .detail__top {
        padding-top: calc(var(--space-48) + var(--space-8));
    }

    .detail__back {
        display: inline-flex;
        color: var(--text-primary);
        border-radius: 50%;
    }

    .detail__back svg {
        width: 44px;
        height: 44px;
        fill: none;
        stroke: currentColor;
    }

    .detail__back:focus-visible {
        outline: 2px solid var(--brand-teal);
        outline-offset: 3px;
    }

    .detail__crumb {
        margin: var(--space-48) 0 var(--space-24);
        color: var(--text-secondary);
    }

    .detail__crumb a {
        color: inherit;
        text-decoration: none;
    }

    .detail__crumb a:hover {
        text-decoration: underline;
    }

    .detail__title {
        margin: 0 0 var(--space-48);
        color: var(--brand-primary);
    }

    .detail__desc {
        margin: 0;
        color: var(--text-secondary);
    }

    .syllabus {
        padding-top: calc(var(--space-80) + var(--space-24) + var(--space-16));
        padding-bottom: calc(var(--space-80) + var(--space-48) + var(--space-16));
    }

    .syllabus__head {
        text-align: center;
        margin-bottom: var(--space-24);
    }

    .syllabus__title {
        margin: 0 0 var(--space-8);
        color: var(--brand-primary);
    }

    .syllabus__meta {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .syllabus__list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .syllabus__row {
        display: flex;
        align-items: center;
        gap: var(--space-24);
        min-height: 50px;
        padding: 0 var(--space-24);
        border-radius: var(--radius-input);
        background-color: var(--bg-white);
    }

    .syllabus__no {
        flex: 0 0 120px;
        font-size: 14px;
        font-weight: 600;
        color: var(--brand-slate);
    }

    .syllabus__topic {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .syllabus__sum {
        margin: 0;
        font-size: 14px;
        color: var(--text-secondary);
    }

    .detail-end {
        height: var(--space-80);
    }

    @media (max-width: 1024px) {
        .detail .container {
            padding-left: var(--space-24);
            padding-right: var(--space-24);
        }
    }

    @media (max-width: 768px) {
        .detail__title {
            font-size: 32px;
        }

        .syllabus {
            padding-top: var(--space-48);
            padding-bottom: var(--space-48);
        }

        .syllabus__title {
            font-size: 24px;
        }

        .syllabus__meta {
            font-size: 16px;
        }

        .syllabus__row {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            padding: var(--space-16) var(--space-24);
        }

        .syllabus__no {
            flex-basis: auto;
        }
    }
    </style>
</head>

<body>

    <?php include_once __DIR__ . '/../../../../Components/navbar.php'; ?>

    <?php require_once __DIR__ . '/../../../../Components/carousel.php'; ?>

    <main>
        <div class="detail">
            <div class="container detail__top">
                <a class="detail__back" href="<?= htmlspecialchars($pelatihan_url) ?>/index.php#katalog" aria-label="Kembali ke Pelatihan">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M16 12H8M12 8l-4 4 4 4"/>
                    </svg>
                </a>
                <p class="caption detail__crumb">
                    <a href="<?= htmlspecialchars($pelatihan_url) ?>/index.php">Pelatihan</a> / <?= htmlspecialchars($kursus['singkat']) ?>
                </p>
                <h1 class="heading-1 detail__title">Katalog Pelatihan</h1>
                <p class="detail__desc">Pelatihan dan sertifikasi IT terpadu untuk berbagai kebutuhan, mulai dari pengembangan perangkat lunak, desain UI/UX, jaringan, hingga data analitik.</p>
            </div>

            <section class="container syllabus">
                <div class="syllabus__head">
                    <h2 class="heading-2 syllabus__title">Silabus: <?= htmlspecialchars($kursus['judul']) ?></h2>
                    <p class="syllabus__meta">
                        <span aria-hidden="true">&#x1F4C6;</span>
                        Jadwal: <?= htmlspecialchars($kursus['tanggal']) ?> &middot; Mentor: <?= htmlspecialchars($kursus['mentor']) ?>
                    </p>
                </div>
                <div class="syllabus__list">
                    <?php foreach ($kursus['silabus'] as $baris): ?>
                        <div class="syllabus__row">
                            <span class="syllabus__no"><?= htmlspecialchars($baris['pertemuan']) ?></span>
                            <p class="syllabus__topic"><?= htmlspecialchars($baris['materi']) ?></p>
                            <p class="syllabus__sum"><?= htmlspecialchars($baris['ringkasan']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
        <div class="detail-end"></div>
    </main>

    <?php include_once __DIR__ . '/../../../../Components/footer.php'; ?>

</body>

</html>