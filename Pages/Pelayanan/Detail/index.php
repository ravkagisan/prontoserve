<?php
require_once __DIR__ . '/../../../Components/button.php';

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
$images_dir = __DIR__ . '/../../../Assets/images/';

$gambar_url = function ($nama) use ($images_url, $images_dir) {
    return file_exists($images_dir . $nama) ? $images_url . $nama : $images_url . 'dummy.jpg';
};

$isi_p1 = 'Lorem ipsum dolor sit amet. Qui excepturi dolor ut consequatur cupiditate et ratione rerum aut dolorem sapiente sit mollitia asperiores id quis rerum. Sed odio asperiores non galisum sunt est doloribus adipisci id fuga omnis ea mollitia ullam ea animi officia ut tempore possimus. Ut error nihil eos reprehenderit voluptas aut laudantium perspiciatis vel iure consectetur et enim atque 33 sint rerum! Aut similique iste aut neque dolor non omnis libero sit nihil similique et doloremque molestias sit rerum autem ut voluptatem deleniti. Ab expedita magnam ut repellat deserunt qui sunt voluptatum sed voluptas omnis ea eaque nostrum. Ut voluptate nihil est aliquam sint rem tempora mollitia non dolore tempora hic dicta eligendi sed dolorem alias eos nostrum corporis. Sed fuga expedita ut ullam nulla sed beatae numquam ea nihil nesciunt et illo reiciendis vel fuga rerum aut internos fuga? Est quam illo et harum repudiandae eum nobis odio eum reiciendis galisum.';

$isi_p2 = 'Ut aliquid commodi et illo omnis ea perspiciatis praesentium eum fugiat dolor nam laboriosam maiores sit voluptatem voluptates! Qui deleniti nulla et eaque veniam qui pariatur eaque hic nobis quaerat aut accusantium deleniti in sunt nihil sit asperiores laboriosam. In saepe porro et soluta quam eum totam inventore ut esse quisquam. Aut quisquam dolores eum assumenda voluptas non Quis architecto eum voluptatem eligendi aut voluptatem dolor sed eveniet consequatur? Sit dolorem consequatur id alias accusamus non tempora molestiae? Aut dolores odio non quas debitis ut dolore esse sit aliquam dolores et nisi saepe et sapiente odit. Ea galisum temporibus non nisi natus qui vitae quod in aliquid nisi. Et molestiae suscipit est optio facilis in aperiam reiciendis et quos officia id libero adipisci et incidunt ipsam. Qui perspiciatis accusantium sit fuga voluptatem qui incidunt voluptatibus ad corporis quia qui temporibus fugiat aut quam quia. Aut animi temporibus quo veniam nulla sit molestiae voluptas. Non tempora dolores ea accusamus exercitationem eum dolorem aperiam id omnis illum ut earum magni sit quis galisum hic officia reiciendis. Qui dolor possimus est laborum ipsa ex error quia cum ipsum dolorem et quam sint et eius consequatur. Eum adipisci sunt qui veniam dolor quo galisum labore ea nemo minus ab odio vero! Id voluptatum itaque ea saepe laboriosam est exercitationem iusto.';

$layanan_katalog = [
    1 => [
        'id'       => 1,
        'title'    => 'IT Consultant',
        'crumb'    => 'ITconsultant',
        'image'    => 'layanan-it-consultant.jpg',
        'overview' => 'Konsultasi kebutuhan, perancangan, dan strategi transformasi digital.',
    ],
    2 => [
        'id'       => 2,
        'title'    => 'IT Solution',
        'crumb'    => 'ITsolution',
        'image'    => 'layanan-it-solution.jpg',
        'overview' => 'Pengembangan website, aplikasi mobile, dan sistem informasi.',
    ],
    3 => [
        'id'       => 3,
        'title'    => 'Pelatihan',
        'crumb'    => 'Pelatihan',
        'image'    => 'layanan-pelatihan.jpg',
        'overview' => 'Pelatihan teknologi informasi dengan kurikulum berbasis industri.',
    ],
    4 => [
        'id'       => 4,
        'title'    => 'Pendampingan',
        'crumb'    => 'Pendampingan',
        'image'    => 'layanan-pendampingan.jpg',
        'overview' => 'Pendampingan pengembangan produk digital dan UMKM.',
    ],
    5 => [
        'id'       => 5,
        'title'    => 'Instruktur',
        'crumb'    => 'Instruktur',
        'image'    => 'layanan-instruktur.jpg',
        'overview' => 'Penyediaan instruktur profesional untuk program pelatihan.',
    ],
    6 => [
        'id'       => 6,
        'title'    => 'Magang Mahasiswa MBKM',
        'crumb'    => 'MagangMBKM',
        'image'    => 'layanan-magang-mbkm.jpg',
        'overview' => 'Program magang MBKM pada proyek nyata teaching factory.',
    ],
];

$id = (int) ($_GET['id'] ?? 1);
$layanan = $layanan_katalog[$id] ?? $layanan_katalog[1];
$layanan['image'] = $gambar_url($layanan['image']);
$layanan['p1'] = $isi_p1;
$layanan['p2'] = $isi_p2;

$pelayanan_url = $base_url . '/Pages/Pelayanan/index.php';
$hubungi_url   = $base_url . '/Pages/HubungiKami/index.php';

$carousel_slides = [
    [
        'id'          => 1,
        'image'       => $layanan['image'],
        'title'       => $layanan['title'],
        'description' => $layanan['overview'],
        'buttons'     => [
            ['text' => 'Hubungi Kami',          'link' => $hubungi_url,   'variant' => 'primary'],
            ['text' => 'Kembali ke Pelayanan',  'link' => $pelayanan_url, 'variant' => 'outline-white'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($layanan['title']) ?> - Detail Pelayanan JTI NOVA</title>

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">

    <?php require_once __DIR__ . '/../../../Components/card.php'; ?>

    <style>
        .detail-page-section {
            padding: var(--space-48) 0 var(--space-80);
            background-color: var(--bg-white);
        }
        .dt-hero__back {
            display: inline-flex;
            color: var(--text-primary);
            border-radius: 50%;
            margin-bottom: var(--space-24);
        }
        .dt-hero__back svg {
            width: 44px;
            height: 44px;
            fill: none;
            stroke: currentColor;
        }
        .dt-hero__back:focus-visible {
            outline: 2px solid var(--brand-teal);
            outline-offset: 3px;
        }
        .detail-hero-banner {
            width: 100%;
            height: 380px;
            border-radius: var(--radius-card);
            overflow: hidden;
            background-color: var(--brand-primary);
            margin-bottom: var(--space-48);
            position: relative;
            box-shadow: var(--shadow-card);
        }
        .detail-hero-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .detail-layout-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 48px;
            align-items: start;
        }
        .detail-main-content {
            display: flex;
            flex-direction: column;
        }
        .detail-main-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 var(--space-24);
            font-family: 'Inter', sans-serif;
            line-height: 1.25;
        }
        .detail-paragraph {
            font-size: 14.5px;
            line-height: 1.75;
            color: var(--text-secondary);
            margin: 0 0 var(--space-24);
            font-family: 'Inter', sans-serif;
            text-align: justify;
        }
        .detail-sidebar-card {
            background-color: var(--bg-white);
            border-radius: var(--radius-card);
            border: 1px solid var(--border-default);
            box-shadow: var(--shadow-card);
            padding: 32px 28px;
            position: sticky;
            top: 96px;
        }
        .sidebar-card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--brand-primary);
            margin: 0 0 var(--space-16);
            font-family: 'Inter', sans-serif;
        }
        .sidebar-card-desc {
            font-size: 13.5px;
            line-height: 1.5;
            color: var(--text-secondary);
            margin: 0 0 var(--space-16);
            font-family: 'Inter', sans-serif;
        }
        .sidebar-contact-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: var(--space-24);
            font-size: 13.5px;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
        }
        .sidebar-contact-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .sidebar-contact-label {
            color: var(--text-secondary);
        }
        .sidebar-contact-value {
            font-weight: 600;
            color: var(--text-primary);
        }
        .sidebar-card-hours {
            font-size: 12px;
            color: var(--text-secondary);
            margin: 0 0 var(--space-24);
            font-family: 'Inter', sans-serif;
        }
        .sidebar-btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        @media (max-width: 900px) {
            .detail-layout-grid {
                grid-template-columns: 1fr;
                gap: var(--space-32);
            }
            .detail-sidebar-card {
                position: static;
            }
            .detail-hero-banner {
                height: 260px;
            }
            .detail-main-title {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../../../Components/navbar.php'; ?>

    <?php require_once __DIR__ . '/../../../Components/carousel.php'; ?>

    <section class="detail-page-section">
        <div class="container">
            <a class="dt-hero__back" href="<?= htmlspecialchars($pelayanan_url) ?>" aria-label="Kembali ke Pelayanan">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M16 12H8M12 8l-4 4 4 4"/>
                </svg>
            </a>

            <div class="detail-hero-banner">
                <img src="<?= htmlspecialchars($layanan['image']) ?>" alt="<?= htmlspecialchars($layanan['title']) ?>">
            </div>

            <div class="detail-layout-grid">
                <main class="detail-main-content">
                    <h1 class="detail-main-title"><?= htmlspecialchars($layanan['title']) ?></h1>
                    <p class="detail-paragraph"><?= htmlspecialchars($layanan['p1']) ?></p>
                    <p class="detail-paragraph"><?= htmlspecialchars($layanan['p2']) ?></p>
                </main>

                <aside class="detail-sidebar-card">
                    <h3 class="sidebar-card-title">Hubungi Kami</h3>
                    <p class="sidebar-card-desc">Tertarik dengan layanan ini? Hubungi tim JTI NOVA.</p>
                    
                    <div class="sidebar-contact-info">
                        <div class="sidebar-contact-item">
                            <span class="sidebar-contact-label">WhatsApp:</span>
                            <span class="sidebar-contact-value">+62 812-0000-0000</span>
                        </div>
                        <div class="sidebar-contact-item">
                            <span class="sidebar-contact-label">Email:</span>
                            <span class="sidebar-contact-value">info@jtinova.com</span>
                        </div>
                    </div>

                    <p class="sidebar-card-hours">Jam layanan: Senin–Jumat, 08.00–16.00 WIB</p>

                    <div class="sidebar-btn-group">
                        <?= render_button([
                            'href'    => $hubungi_url,
                            'text'    => 'Hubungi Kami',
                            'variant' => 'primary',
                            'size'    => 'md',
                            'class'   => 'btn-block'
                        ]) ?>
                        <?= render_button([
                            'href'    => $pelayanan_url,
                            'text'    => 'Kembali ke Pelayanan',
                            'variant' => 'outline',
                            'size'    => 'md',
                            'class'   => 'btn-block'
                        ]) ?>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../../../Components/footer.php'; ?>

</body>

</html>