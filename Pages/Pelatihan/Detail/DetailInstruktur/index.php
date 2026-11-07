<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$images_url = $base_url . '/Assets/images/';
$images_dir = __DIR__ . '/../../../../Assets/images/';

$gambar_url = function ($nama) use ($images_url, $images_dir) {
    return file_exists($images_dir . $nama) ? $images_url . $nama : $images_url . 'dummy.jpg';
};

$pelatihan_url = $base_url . '/Pages/Pelatihan/index.php';
$hubungi_url   = $base_url . '/Pages/HubungiKami/index.php';

$instruktur_katalog = [
    1 => [
        'id'          => 1,
        'foto'        => 'instruktur-1.jpg',
        'nama'        => 'Nama Instruktur 1',
        'peran'       => 'Web Development',
        'jabatan'     => 'Instruktur Web Development',
        'bidang'      => 'Pemrograman Web Fullstack, HTML/CSS, JavaScript & PHP',
        'npwp'        => '12.345.678.9-011.000',
        'nidn'        => '0412038501',
        'email'       => 'instruktur1@jtinova.com',
        'telepon'     => '+62 812-3456-7891',
        'pendidikan'  => 'S2 Teknik Informatika, Universitas Teknologi Nusantara',
        'sertifikasi' => 'Certified Web Developer, AWS Certified Cloud Practitioner',
        'pengalaman'  => '8 Tahun sebagai praktisi industri web dan pengajar aktif di TEFA JTI.',
    ],
    2 => [
        'id'          => 2,
        'foto'        => 'instruktur-2.jpg',
        'nama'        => 'Nama Instruktur 2',
        'peran'       => 'UI/UX Design',
        'jabatan'     => 'Instruktur UI/UX Design',
        'bidang'      => 'UI/UX Design, Figma, User Research & Design System',
        'npwp'        => '12.345.678.9-012.000',
        'nidn'        => '0412038502',
        'email'       => 'instruktur2@jtinova.com',
        'telepon'     => '+62 812-3456-7892',
        'pendidikan'  => 'S2 Desain Komunikasi Visual, Universitas Teknologi Nusantara',
        'sertifikasi' => 'Google UX Design Professional Certificate, Adobe Certified Expert',
        'pengalaman'  => '6 Tahun sebagai product designer dan mentor workshop desain.',
    ],
    3 => [
        'id'          => 3,
        'foto'        => 'instruktur-3.jpg',
        'nama'        => 'Nama Instruktur 3',
        'peran'       => 'Jaringan & Keamanan',
        'jabatan'     => 'Instruktur Jaringan & Keamanan',
        'bidang'      => 'Infrastruktur Jaringan, Administrasi Server & Keamanan Siber',
        'npwp'        => '12.345.678.9-013.000',
        'nidn'        => '0412038503',
        'email'       => 'instruktur3@jtinova.com',
        'telepon'     => '+62 812-3456-7893',
        'pendidikan'  => 'S2 Teknik Komputer, Universitas Teknologi Nusantara',
        'sertifikasi' => 'Cisco CCNA, CompTIA Security+, Mikrotik Certified Network Associate',
        'pengalaman'  => '7 Tahun sebagai network engineer dan instruktur laboratorium jaringan.',
    ],
    4 => [
        'id'          => 4,
        'foto'        => 'instruktur-4.jpg',
        'nama'        => 'Nama Instruktur 4',
        'peran'       => 'Data & Analitik',
        'jabatan'     => 'Instruktur Data & Analitik',
        'bidang'      => 'Analisis Data, Python, Visualisasi Data & Business Intelligence',
        'npwp'        => '12.345.678.9-014.000',
        'nidn'        => '0412038504',
        'email'       => 'instruktur4@jtinova.com',
        'telepon'     => '+62 812-3456-7894',
        'pendidikan'  => 'S2 Sains Komputasi & Statistik, Universitas Teknologi Nusantara',
        'sertifikasi' => 'Certified Data Analyst, Microsoft Power BI Certified',
        'pengalaman'  => '6 Tahun sebagai data specialist dan pengajar bootcamp data.',
    ],
];

$id = (int) ($_GET['id'] ?? 1);
if (!isset($instruktur_katalog[$id])) {
    $id = 1;
}

$orang = $instruktur_katalog[$id];
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

$carousel_slides = [
    [
        'id'          => 1,
        'image'       => $orang['foto'],
        'title'       => $orang['nama'],
        'description' => $orang['jabatan'] . ' · ' . $orang['bidang'],
        'buttons'     => [
            ['text' => 'Hubungi Kami',       'link' => $hubungi_url,                  'variant' => 'primary'],
            ['text' => 'Kembali ke Pelatihan', 'link' => $pelatihan_url . '#instruktur', 'variant' => 'outline-white'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Instruktur - <?= htmlspecialchars($orang['nama']) ?> - JTI NOVA</title>

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">

    <?php require_once __DIR__ . '/../../../../Components/card.php'; ?>

    <style>
    .at-hero {
        background-color: var(--bg-soft);
        padding-top: calc(var(--space-48) + var(--space-8));
        padding-bottom: calc(var(--space-48) + var(--space-8));
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
        padding-top: calc(var(--space-48) + var(--space-8));
        padding-bottom: calc(var(--space-48) + var(--space-24));
        background-color: var(--bg-white);
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
        box-shadow: var(--shadow-card);
    }

    .at-profile__list {
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 18px;
        font-weight: 400;
        line-height: 36px;
        color: var(--text-primary);
    }

    .at-profile__list strong {
        font-weight: 700;
        color: var(--brand-primary);
    }

    @media (max-width: 1024px) {
        .at-profile .container {
            padding-left: var(--space-24);
            padding-right: var(--space-24);
        }

        .at-profile__grid {
            grid-template-columns: 1fr;
            gap: var(--space-32);
        }

        .at-profile__photo {
            width: 100%;
            max-width: 360px;
            height: auto;
            aspect-ratio: 360 / 485;
            margin: 0 auto;
        }
    }

    @media (max-width: 768px) {
        .at-profile__list {
            font-size: 15px;
            line-height: 1.8;
        }
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../../../../Components/navbar.php'; ?>

    <?php require_once __DIR__ . '/../../../../Components/carousel.php'; ?>

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

    <?php require_once __DIR__ . '/../../../../Components/footer.php'; ?>

</body>

</html>
