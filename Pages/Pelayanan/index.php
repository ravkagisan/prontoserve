<?php
$current_page = 'pelayanan';

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

$hubungi_url   = $base_url . '/Pages/HubungiKami/index.php';
$detail_url    = $base_url . '/Pages/Pelayanan/Detail/index.php';

$kontak_layanan = '+62 812-0000-0000';

$layanan = [
    [
        'judul'     => 'IT Consultant',
        'deskripsi' => 'Konsultasi kebutuhan, perancangan, dan strategi transformasi digital.',
        'gambar'    => 'layanan-it-consultant.jpg',
        'href'      => $detail_url,
    ],
    [
        'judul'     => 'IT Solution',
        'deskripsi' => 'Pengembangan website, aplikasi mobile, dan sistem informasi.',
        'gambar'    => 'layanan-it-solution.jpg',
        'href'      => $detail_url,
    ],
    [
        'judul'     => 'Pelatihan',
        'deskripsi' => 'Pelatihan teknologi informasi dengan kurikulum berbasis industri.',
        'gambar'    => 'layanan-pelatihan.jpg',
        'href'      => $detail_url,
    ],
    [
        'judul'     => 'Pendampingan',
        'deskripsi' => 'Pendampingan pengembangan produk digital dan UMKM.',
        'gambar'    => 'layanan-pendampingan.jpg',
        'href'      => $detail_url,
    ],
    [
        'judul'     => 'Instruktur',
        'deskripsi' => 'Penyediaan instruktur profesional untuk program pelatihan.',
        'gambar'    => 'layanan-instruktur.jpg',
        'href'      => $detail_url . '#instruktur',
    ],
    [
        'judul'     => 'Magang Mahasiswa MBKM',
        'deskripsi' => 'Program magang MBKM pada proyek nyata teaching factory.',
        'gambar'    => 'layanan-magang-mbkm.jpg',
        'href'      => $detail_url,
    ],
];

$alur = [
    ['judul' => 'Konsultasi',            'teks' => 'Sampaikan kebutuhan dan tujuan Anda kepada tim kami.'],
    ['judul' => 'Proposal & Penawaran',  'teks' => 'Kami menyusun solusi, estimasi waktu, dan biaya.'],
    ['judul' => 'Pengerjaan',            'teks' => 'Tim dan mahasiswa mengerjakan sesuai kesepakatan.'],
    ['judul' => 'Serah Terima',          'teks' => 'Produk diserahkan beserta dokumentasi dan dukungan.'],
];

$kontak = [
    ['ikon' => '&#x260E;&#xFE0F;', 'judul' => 'WhatsApp',    'nilai' => $kontak_layanan],
    ['ikon' => '&#x2709;&#xFE0F;', 'judul' => 'Email',       'nilai' => 'info@jtinova.com'],
    ['ikon' => '&#x231A;',         'judul' => 'Jam Layanan', 'nilai' => 'Senin–Jumat, 08.00–16.00 WIB'],
];

$carousel_slides = [
    [
        'id'          => 1,
        'image'       => $images_url . 'dummy.jpg',
        'title'       => "Layanan IT Terpadu\nUntuk Industri, Instansi, dan UMKM",
        'description' => 'Konsultasi, pengembangan solusi digital, pelatihan, dan pendampingan berbasis proyek nyata bersama tim JTI NOVA.',
        'buttons'     => [
            ['text' => 'Hubungi Kami',    'link' => $hubungi_url,   'variant' => 'primary'],
            ['text' => 'Lihat Pelatihan', 'link' => $detail_url, 'variant' => 'outline-white'],
        ],
    ],
    [
        'id'          => 2,
        'image'       => $images_url . 'ajasendiri.jpg',
        'title'       => "Pendampingan Produk Digital\nDari Ide Hingga Serah Terima",
        'description' => 'Tim profesional dan mahasiswa bekerja sama menghadirkan solusi yang sesuai dengan kebutuhan Anda.',
        'buttons'     => [
            ['text' => 'Mulai Konsultasi', 'link' => $hubungi_url, 'variant' => 'primary'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jtinova - Pelayanan</title>

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">

    <?php require_once __DIR__ . '/../../Components/card.php'; ?>

    <style>
    .pl-hero {
        background-color: var(--bg-soft);
        padding-top: calc(var(--space-48) + var(--space-8));
        padding-bottom: calc(var(--space-48) + var(--space-8));
    }

    .pl-hero__crumb {
        margin: 0 0 calc(var(--space-24) + var(--space-8));
        color: var(--text-secondary);
    }

    .pl-hero__crumb a {
        color: inherit;
        text-decoration: none;
    }

    .pl-hero__crumb a:hover {
        text-decoration: underline;
    }

    .pl-hero__title {
        margin: 0 0 calc(var(--space-24) + var(--space-8));
        color: var(--brand-primary);
    }

    .pl-hero__desc {
        margin: 0;
        color: var(--text-secondary);
    }

    .pl-section {
        padding-top: calc(var(--space-48) + var(--space-16));
        padding-bottom: calc(var(--space-48) + var(--space-16));
    }

    .pl-section--soft {
        background-color: var(--bg-soft);
    }

    .pl-section--tight {
        padding-top: var(--space-48);
        padding-bottom: var(--space-48);
    }

    .pl-head {
        text-align: center;
        margin-bottom: calc(var(--space-24) + var(--space-8));
    }

    .pl-head__title {
        margin: 0 0 var(--space-8);
        color: var(--brand-primary);
    }

    .pl-head__sub {
        margin: 0;
        color: var(--text-secondary);
    }

    .service-grid,
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--space-24);
    }

    .service-grid .card-inner {
        padding: 20px;
    }

    .service-grid .card-img-inset-wrap {
        height: 140px;
    }

    .service-grid .card-desc {
        font-size: 14px;
        line-height: 17px;
        margin-bottom: 12px;
    }

    .service-grid .card-contact-info {
        font-size: 13px;
        font-weight: 400;
        color: var(--brand-primary);
        margin-bottom: 12px;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--space-24);
    }

    .step {
        padding: 20px;
    }

    .step__no {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin-bottom: var(--space-8);
        border-radius: 50%;
        background-color: var(--brand-primary);
        color: var(--bg-white);
        font-size: 14px;
        font-weight: 700;
    }

    .step__title {
        margin: 0 0 var(--space-8);
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .step__text {
        margin: 0;
        font-size: 13px;
        line-height: 16px;
        color: var(--text-secondary);
    }

    .info-card {
        padding: 20px;
        border: 1px solid var(--border-default);
    }

    .info-card__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin-bottom: var(--space-8);
        border-radius: 50%;
        background-color: var(--bg-soft);
        font-size: 16px;
    }

    .info-card__title {
        margin: 0 0 var(--space-8);
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .info-card__text {
        margin: 0;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .cta {
        background-color: var(--brand-primary);
        color: var(--bg-white);
        padding-top: calc(var(--space-48) + var(--space-8));
        padding-bottom: calc(var(--space-48) + var(--space-8));
    }

    .cta__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: var(--space-24);
    }

    .cta__title {
        margin: 0 0 4px;
        color: var(--bg-white);
    }

    .cta__text {
        margin: 0;
        color: var(--bg-soft);
    }



    @media (max-width: 1024px) {
        .pl-hero .container,
        .pl-section .container,
        .cta .container {
            padding-left: var(--space-24);
            padding-right: var(--space-24);
        }

        .service-grid,
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .steps-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .pl-hero__title {
            font-size: 32px;
        }

        .pl-head__title,
        .cta__title {
            font-size: 24px;
        }

        .cta__inner {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 560px) {
        .service-grid,
        .info-grid,
        .steps-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../../Components/navbar.php'; ?>

    <?php require_once __DIR__ . '/../../Components/carousel.php'; ?>

    <section class="pl-section" id="layanan">
        <div class="container">
            <div class="service-grid">
                <?php foreach ($layanan as $item): ?>
                    <?= render_card([
                        'variant'     => 'service',
                        'title'       => $item['judul'],
                        'description' => $item['deskripsi'],
                        'image'       => $gambar_url($item['gambar']),
                        'extra_info'  => 'Kontak: ' . $kontak_layanan,
                        'href'        => $item['href'],
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="pl-section pl-section--soft" id="alur">
        <div class="container">
            <div class="pl-head">
                <h2 class="heading-2 pl-head__title">Alur Order Layanan</h2>
                <p class="pl-head__sub">Empat langkah mudah untuk memulai kerja sama</p>
            </div>
            <div class="steps-grid">
                <?php foreach ($alur as $no => $langkah): ?>
                    <article class="card step">
                        <span class="step__no"><?= $no + 1 ?></span>
                        <h3 class="step__title"><?= htmlspecialchars($langkah['judul']) ?></h3>
                        <p class="step__text"><?= htmlspecialchars($langkah['teks']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="pl-section pl-section--tight" id="kontak">
        <div class="container">
            <div class="pl-head">
                <h2 class="heading-2 pl-head__title">Butuh Informasi Layanan?</h2>
                <p class="pl-head__sub">Hubungi kontak berikut untuk setiap layanan</p>
            </div>
            <div class="info-grid">
                <?php foreach ($kontak as $info): ?>
                    <article class="card info-card">
                        <span class="info-card__icon" aria-hidden="true"><?= $info['ikon'] ?></span>
                        <h3 class="info-card__title"><?= htmlspecialchars($info['judul']) ?></h3>
                        <p class="info-card__text"><?= htmlspecialchars($info['nilai']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    $cta_title     = 'Siap memulai proyek Anda?';
    $cta_subtitle  = 'Konsultasikan kebutuhan Anda bersama tim JTI NOVA.';
    $cta_btn_text  = 'Hubungi Kami';
    $cta_btn_href  = $hubungi_url;
    $cta_variant   = 'dark';
    require_once __DIR__ . '/../../Components/ctacontainer.php';
    ?>

    <?php require_once __DIR__ . '/../../Components/footer.php'; ?>

</body>

</html>