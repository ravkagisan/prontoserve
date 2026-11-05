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

$images_url = $base_url . '/Assets/images/';
$images_dir = __DIR__ . '/../../Assets/images/';

$gambar_url = function ($nama) use ($images_url, $images_dir) {
    return file_exists($images_dir . $nama) ? $images_url . $nama : null;
};

$katalog = [
    [
        'id'        => 1,
        'judul'     => 'Pemrograman Web Fullstack',
        'badge'     => 'Sertifikasi',
        'deskripsi' => 'Dasar HTML, CSS, JavaScript, hingga pengembangan aplikasi web utuh.',
        'tanggal'   => '15 Nov 2026',
        'mode'      => 'Tatap muka / hybrid',
        'kuota'     => 30,
        'instruktur' => 'Instruktur 1',
        'gambar'    => 'pelatihan-web.jpg',
        'silabus'   => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Dasar HTML & CSS',   'ringkasan' => 'Struktur halaman, styling, dan layout responsif'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'JavaScript Dasar',   'ringkasan' => 'Variabel, fungsi, DOM, dan event'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Backend & Database', 'ringkasan' => 'PHP, REST API, dan pengelolaan database'],
            ['pertemuan' => 'Proyek Akhir', 'materi' => 'Proyek Akhir',      'ringkasan' => 'Integrasi, penyajian, dan presentasi'],
        ],
    ],
    [
        'id'        => 2,
        'judul'     => 'UI/UX Design dengan Figma',
        'badge'     => 'Sertifikasi',
        'deskripsi' => 'Riset pengguna, wireframe, hingga prototipe interaktif siap pakai.',
        'tanggal'   => '29 Nov 2026',
        'mode'      => 'Tatap muka / hybrid',
        'kuota'     => 25,
        'instruktur' => 'Instruktur 2',
        'gambar'    => 'pelatihan-uiux.jpg',
        'silabus'   => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Dasar UI/UX',       'ringkasan' => 'Prinsip desain dan alur kerja desainer'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Riset & Wireframe',  'ringkasan' => 'User persona, user flow, dan wireframe'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Desain Visual',      'ringkasan' => 'Komponen, warna, tipografi, dan design system'],
            ['pertemuan' => 'Proyek Akhir', 'materi' => 'Prototipe',         'ringkasan' => 'Prototipe interaktif dan uji kegunaan'],
        ],
    ],
    [
        'id'        => 3,
        'judul'     => 'Dasar Jaringan Komputer',
        'badge'     => 'Pre-Master',
        'deskripsi' => 'Konfigurasi jaringan, keamanan, hingga troubleshooting dasar.',
        'tanggal'   => '6 Des 2026',
        'mode'      => 'Tatap muka',
        'kuota'     => 35,
        'instruktur' => 'Instruktur 3',
        'gambar'    => 'pelatihan-jaringan.jpg',
        'silabus'   => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Konsep Jaringan',   'ringkasan' => 'Model OSI, TCP/IP, dan topologi'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Pengalamatan IP',   'ringkasan' => 'IPv4, subnetting, dan routing dasar'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Keamanan Jaringan', 'ringkasan' => 'Firewall, autentikasi, dan praktik aman'],
            ['pertemuan' => 'Proyek Akhir', 'materi' => 'Simulasi Jaringan', 'ringkasan' => 'Merancang dan mengonfigurasi jaringan kantor'],
        ],
    ],
    [
        'id'        => 4,
        'judul'     => 'Pemrograman Mobile',
        'badge'     => 'Sertifikasi',
        'deskripsi' => 'Membangun aplikasi mobile berbasis Android dan lintas platform.',
        'tanggal'   => '13 Des 2026',
        'mode'      => 'Tatap muka / hybrid',
        'kuota'     => 30,
        'instruktur' => 'Instruktur 1',
        'gambar'    => 'pelatihan-mobile.jpg',
        'silabus'   => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Dasar Mobile',      'ringkasan' => 'Lingkungan kerja dan komponen antarmuka'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Navigasi & State',  'ringkasan' => 'Perpindahan layar dan pengelolaan state'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Data & API',        'ringkasan' => 'Penyimpanan lokal dan konsumsi REST API'],
            ['pertemuan' => 'Proyek Akhir', 'materi' => 'Aplikasi Lengkap', 'ringkasan' => 'Menyusun dan mempresentasikan aplikasi'],
        ],
    ],
    [
        'id'        => 5,
        'judul'     => 'Data & Analitik',
        'badge'     => 'Pre-Master',
        'deskripsi' => 'Pengolahan data, visualisasi, dan pengambilan keputusan berbasis data.',
        'tanggal'   => '20 Des 2026',
        'mode'      => 'Hybrid',
        'kuota'     => 30,
        'instruktur' => 'Instruktur 4',
        'gambar'    => 'pelatihan-data.jpg',
        'silabus'   => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Pengantar Data',   'ringkasan' => 'Jenis data dan alur analisis'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Pembersihan Data', 'ringkasan' => 'Menangani data kosong, duplikat, dan outlier'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Visualisasi',      'ringkasan' => 'Grafik dan dashboard yang informatif'],
            ['pertemuan' => 'Proyek Akhir', 'materi' => 'Studi Kasus',     'ringkasan' => 'Analisis data nyata dan presentasi temuan'],
        ],
    ],
    [
        'id'        => 6,
        'judul'     => 'Coding for Kids',
        'badge'     => 'Anak',
        'deskripsi' => 'Mengenalkan logika pemrograman dengan cara seru dan menyenangkan.',
        'tanggal'   => '3 Jan 2027',
        'mode'      => 'Tatap muka',
        'kuota'     => 20,
        'instruktur' => 'Instruktur 2',
        'gambar'    => 'pelatihan-kids.jpg',
        'silabus'   => [
            ['pertemuan' => 'Pertemuan 1', 'materi' => 'Mengenal Logika', 'ringkasan' => 'Urutan perintah dan pola sederhana'],
            ['pertemuan' => 'Pertemuan 2', 'materi' => 'Animasi',         'ringkasan' => 'Membuat tokoh dan gerakan'],
            ['pertemuan' => 'Pertemuan 3', 'materi' => 'Permainan',       'ringkasan' => 'Membuat game sederhana'],
            ['pertemuan' => 'Proyek Akhir', 'materi' => 'Pameran Karya',  'ringkasan' => 'Menampilkan karya kepada orang tua'],
        ],
    ],
];

$instruktur = [
    ['nama' => 'Nama Instruktur 1', 'peran' => 'Web Development',     'foto' => 'instruktur-1.jpg'],
    ['nama' => 'Nama Instruktur 2', 'peran' => 'UI/UX Design',        'foto' => 'instruktur-2.jpg'],
    ['nama' => 'Nama Instruktur 3', 'peran' => 'Jaringan & Keamanan', 'foto' => 'instruktur-3.jpg'],
    ['nama' => 'Nama Instruktur 4', 'peran' => 'Data & Analitik',     'foto' => 'instruktur-4.jpg'],
];

$jadwal = array_slice($katalog, 0, 3);

$silabus_awal = $katalog[0];

$silabus_js = [];
foreach ($katalog as $kursus) {
    $silabus_js[$kursus['id']] = [
        'judul' => $kursus['judul'],
        'baris' => $kursus['silabus'],
    ];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jtinova - Pelatihan</title>

    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">

    <?php require_once __DIR__ . '/../../Components/card.php'; ?>

    <style>
    @media (prefers-reduced-motion: no-preference) {
        html {
            scroll-behavior: smooth;
        }
    }

    [id] {
        scroll-margin-top: 96px;
    }

    .page-hero {
        background-color: var(--bg-soft);
        padding-top: var(--space-24);
        padding-bottom: var(--space-48);
    }

    .page-hero__crumb {
        margin: 0 0 var(--space-24);
        color: var(--text-secondary);
    }

    .page-hero__title {
        margin: 0 0 var(--space-16);
        color: var(--brand-primary);
    }

    .page-hero__desc {
        margin: 0;
        font-size: 14px;
        color: var(--text-secondary);
    }

    .section {
        padding-top: var(--space-48);
        padding-bottom: var(--space-48);
    }

    .section--soft {
        background-color: var(--bg-soft);
    }

    .section__head {
        text-align: center;
        margin-bottom: var(--space-24);
    }

    .section__title {
        margin: 0;
        color: var(--brand-primary);
        font-size: 24px;
    }

    .section__subtitle {
        margin: var(--space-8) 0 0;
        font-size: 12px;
        color: var(--text-secondary);
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--space-24);
    }

    .syllabus {
        display: flex;
        flex-direction: column;
        gap: var(--space-8);
        max-width: 880px;
        margin: 0 auto;
    }

    .syllabus__row {
        display: grid;
        grid-template-columns: 120px 180px 1fr;
        align-items: center;
        gap: var(--space-16);
        padding: var(--space-16) var(--space-24);
        border: 1px solid var(--border-default);
        border-radius: var(--radius-input);
        background-color: var(--bg-white);
        font-size: 12px;
    }

    .syllabus__no {
        color: var(--text-secondary);
    }

    .syllabus__topic {
        margin: 0;
        font-weight: 700;
        color: var(--text-primary);
    }

    .syllabus__sum {
        margin: 0;
        color: var(--text-secondary);
    }

    .schedule {
        overflow-x: auto;
        border: 1px solid var(--border-default);
        border-radius: var(--radius-input);
    }

    .schedule table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .schedule th {
        padding: var(--space-16) var(--space-24);
        background-color: var(--brand-primary);
        color: var(--bg-white);
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }

    .schedule td {
        padding: var(--space-16) var(--space-24);
        border-top: 1px solid var(--border-default);
        color: var(--text-primary);
    }

    .instr-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--space-24);
    }

    @media (max-width: 1024px) {
        .page-hero .container,
        .section .container {
            padding-left: var(--space-24);
            padding-right: var(--space-24);
        }

        .catalog-grid,
        .instr-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-hero__title {
            font-size: 32px;
        }

        .syllabus__row {
            grid-template-columns: 1fr;
            gap: 4px;
        }
    }

    @media (max-width: 560px) {
        .catalog-grid,
        .instr-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../../Components/navbar.php'; ?>

    <?php require_once __DIR__ . '/../../Components/carousel.php'; ?>

    <section class="section" id="katalog">
        <div class="container">
            <div class="section__head">
                <h2 class="heading-2 section__title">Katalog Pelatihan</h2>
                <p class="section__subtitle">Pilih program sesuai kebutuhan Anda</p>
            </div>
            <div class="catalog-grid">
                <?php foreach ($katalog as $kursus): ?>
                    <?= render_card([
                        'variant'       => 'training',
                        'title'         => $kursus['judul'],
                        'description'   => $kursus['deskripsi'],
                        'category'      => $kursus['badge'],
                        'image'         => $gambar_url($kursus['gambar']),
                        'extra_info'    => ['Jadwal: ' . $kursus['tanggal'], 'Mode: ' . $kursus['mode']],
                        'attributes'    => 'data-id="' . (int) $kursus['id'] . '"',
                        'button_config' => [
                            'variant' => 'primary',
                            'text'    => 'Lihat Silabus',
                            'href'    => '#silabus',
                        ],
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section section--soft" id="silabus">
        <div class="container">
            <div class="section__head">
                <h2 class="heading-2 section__title" id="silabus-judul">Silabus: <?= htmlspecialchars($silabus_awal['judul']) ?></h2>
                <p class="section__subtitle">Contoh ringkasan materi per pertemuan</p>
            </div>
            <div class="syllabus" id="silabus-daftar">
                <?php foreach ($silabus_awal['silabus'] as $baris): ?>
                    <div class="syllabus__row">
                        <span class="syllabus__no"><?= htmlspecialchars($baris['pertemuan']) ?></span>
                        <p class="syllabus__topic"><?= htmlspecialchars($baris['materi']) ?></p>
                        <p class="syllabus__sum"><?= htmlspecialchars($baris['ringkasan']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section" id="jadwal">
        <div class="container">
            <div class="section__head">
                <h2 class="heading-2 section__title">Jadwal Pelatihan</h2>
                <p class="section__subtitle">Konfirmasi dibuka hingga satu minggu sebelum kelas dimulai</p>
            </div>
            <div class="schedule">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelatihan</th>
                            <th>Instruktur</th>
                            <th>Kuota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['tanggal']) ?></td>
                                <td><?= htmlspecialchars($item['judul']) ?></td>
                                <td><?= htmlspecialchars($item['instruktur']) ?></td>
                                <td><?= (int) $item['kuota'] ?></td>
                                <td>
                                    <?= render_button([
                                        'variant' => 'primary',
                                        'text'    => 'Daftar',
                                        'href'    => $base_url . '/Pages/HubungiKami/index.php',
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="section section--soft" id="instruktur">
        <div class="container">
            <div class="section__head">
                <h2 class="heading-2 section__title">Profil Instruktur</h2>
                <p class="section__subtitle">Dibimbing oleh dosen dan praktisi berpengalaman</p>
            </div>
            <div class="instr-grid">
                <?php foreach ($instruktur as $orang): ?>
                    <?= render_card([
                        'variant'  => 'team',
                        'title'    => $orang['nama'],
                        'subtitle' => $orang['peran'],
                        'image'    => $gambar_url($orang['foto']),
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../../Components/footer.php'; ?>

    <script>
    (function () {
        var data = <?= json_encode($silabus_js, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;
        var judul = document.getElementById('silabus-judul');
        var daftar = document.getElementById('silabus-daftar');
        var kartu = document.querySelectorAll('.catalog-grid [data-id]');

        function buatBaris(item) {
            var baris = document.createElement('div');
            baris.className = 'syllabus__row';

            var no = document.createElement('span');
            no.className = 'syllabus__no';
            no.textContent = item.pertemuan;

            var topik = document.createElement('p');
            topik.className = 'syllabus__topic';
            topik.textContent = item.materi;

            var ringkasan = document.createElement('p');
            ringkasan.className = 'syllabus__sum';
            ringkasan.textContent = item.ringkasan;

            baris.appendChild(no);
            baris.appendChild(topik);
            baris.appendChild(ringkasan);
            return baris;
        }

        kartu.forEach(function (el) {
            var tautan = el.querySelector('a[href="#silabus"]');
            if (!tautan) {
                return;
            }
            tautan.addEventListener('click', function (e) {
                var kursus = data[el.getAttribute('data-id')];
                if (!kursus) {
                    return;
                }
                e.preventDefault();

                judul.textContent = 'Silabus: ' + kursus.judul;
                daftar.textContent = '';
                kursus.baris.forEach(function (item) {
                    daftar.appendChild(buatBaris(item));
                });

                document.getElementById('silabus').scrollIntoView({ behavior: 'smooth', block: 'start' });
                history.replaceState(null, '', '#silabus');
            });
        });
    })();
    </script>

</body>

</html>