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

$anggota_katalog = [
    1 => [
        'id'          => 1,
        'foto'        => 'tim-1.jpg',
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
        'foto'        => 'tim-' . $no . '.jpg',
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

$carousel_slides = [
    [
        'id'          => 1,
        'image'       => $orang['foto'],
        'title'       => $orang['nama'],
        'description' => $orang['jabatan'] . ' · ' . $orang['bidang'],
        'buttons'     => [
            ['text' => 'Hubungi Kami', 'link' => $hubungi_url, 'variant' => 'primary'],
            ['text' => 'Kembali ke Tim', 'link' => $tim_url,   'variant' => 'outline-white'],
        ],
    ],
];
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

    @media (max-width: 1024px) {
        .at-hero .container,
        .at-profile .container {
            padding-left: var(--space-24);
            padding-right: var(--space-24);
        }

        .at-profile__grid {
            grid-template-columns: 1fr;
            gap: var(--space-24);
        }

        .at-profile__photo {
            width: 100%;
            max-width: 360px;
            height: auto;
            aspect-ratio: 360 / 485;
        }
    }

    @media (max-width: 768px) {
        .at-hero__title {
            font-size: 32px;
        }

        .at-profile__list {
            font-size: 16px;
            line-height: 1.8;
        }
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../../../Components/navbar.php'; ?>

    <?php require_once __DIR__ . '/../../../Components/carousel.php'; ?>

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