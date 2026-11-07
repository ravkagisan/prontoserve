<?php
require_once __DIR__ . '/../../Components/button.php';

$current_page = 'hubungi-kami';

$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(.*?)/(Pages|api|Components)#', $script_name, $matches)) {
    $base_url = $matches[1];
} else {
    $base_url = rtrim(dirname($script_name), '/\\');
    if ($base_url === '/' || $base_url === '\\') {
        $base_url = '';
    }
}

$pesan_terkirim = isset($_GET['sent']) && $_GET['sent'] === '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'kirim_pesan') {
    date_default_timezone_set('Asia/Jakarta');
    $hour = (int) date('H');
    $minute = (int) date('i');
    $time_val = $hour + ($minute / 60);

    if ($time_val >= 4.0 && $time_val <= 10.0) {
        $waktu = 'pagi';
    } elseif ($time_val > 10.0 && $time_val <= 15.0) {
        $waktu = 'siang';
    } elseif ($time_val > 15.0 && $time_val <= 18.0) {
        $waktu = 'sore';
    } else {
        $waktu = 'malam';
    }

    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $layanan = trim($_POST['layanan'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    $template = "Halo Admin JTI NOVA, selamat {$waktu}! 😊\n\n"
              . "Saya tertarik dengan layanan JTI NOVA dan ingin bertanya lebih lanjut.\n\n"
              . "Nama: {$nama}\n\n"
              . "Email: {$email}\n\n"
              . "Layanan: {$layanan}\n\n"
              . "Pertanyaan/Kebutuhan: {$pesan}\n\n"
              . "Ditunggu respons dan informasi selanjutnya. Terima kasih! 🙏";

    $wa_number = '6281200000000';
    $wa_url = "https://api.whatsapp.com/send?phone={$wa_number}&text=" . rawurlencode($template);

    header("Location: {$wa_url}");
    exit;
}

$carousel_slides = [
    [
        'id' => 1,
        'image' => $base_url . '/Assets/images/dummy.jpg',
        'title' => "Hubungi JTI NOVA\nSolusi Digital & Kemitraan",
        'description' => "Kami siap membantu mewujudkan transformasi digital, kolaborasi proyek nyata, serta pelatihan teknologi informasi berstandar industri.",
        'buttons' => [
            ['text' => 'Kirim Pesan', 'link' => '#kontak-form', 'variant' => 'primary'],
            ['text' => 'Lihat Portofolio', 'link' => $base_url . '/Pages/Portofolio/index.php', 'variant' => 'outline-white']
        ]
    ]
];

$polije_ti_map_src = "https://maps.google.com/maps?q=-8.1581561,113.7226039+(Gedung%20Jurusan%20Teknologi%20Informasi%20Politeknik%20Negeri%20Jember)&t=&z=17&ie=UTF8&iwloc=B&output=embed";

$layanan_pilihan = [];
$pelayanan_file = __DIR__ . '/../Pelayanan/index.php';
if (file_exists($pelayanan_file)) {
    $pelayanan_content = file_get_contents($pelayanan_file);
    if (preg_match('/\$layanan\s*=\s*\[(.*?)\]\s*;\s*\$alur/s', $pelayanan_content, $matches_layanan)) {
        if (preg_match_all("/'judul'\s*=>\s*'([^']+)'/", $matches_layanan[1], $matches_judul)) {
            $icons_map = [
                'IT Consultant' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
                'IT Solution' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>',
                'Pelatihan' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>',
                'Pendampingan' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'Instruktur' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>',
                'Magang Mahasiswa MBKM' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>'
            ];
            foreach ($matches_judul[1] as $idx => $item_judul) {
                $item_id = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', $item_judul));
                $layanan_pilihan[] = [
                    'id' => $item_id,
                    'label' => $item_judul,
                    'icon' => $icons_map[$item_judul] ?? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>'
                ];
            }
        }
    }
}

if (empty($layanan_pilihan)) {
    $layanan_pilihan = [
        ['id' => 'it_consultant', 'label' => 'IT Consultant', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>'],
        ['id' => 'it_solution', 'label' => 'IT Solution', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>'],
        ['id' => 'pelatihan', 'label' => 'Pelatihan', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>'],
        ['id' => 'pendampingan', 'label' => 'Pendampingan', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'],
        ['id' => 'instruktur', 'label' => 'Instruktur', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>'],
        ['id' => 'magang_mbkm', 'label' => 'Magang Mahasiswa MBKM', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>']
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - JTI NOVA</title>
    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">
    <style>
        .contact-page-section {
            padding: var(--space-80) 0;
            background-color: var(--bg-white);
            min-height: 60vh;
        }

        .contact-layout-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: var(--space-48);
            align-items: start;
        }

        .contact-card {
            background-color: var(--bg-white);
            border-radius: var(--radius-card);
            border: 1px solid var(--border-default);
            box-shadow: 0 4px 20px rgba(30, 58, 95, 0.05);
            padding: 36px;
            box-sizing: border-box;
            position: relative;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 36px;
            right: 36px;
            height: 4px;
            background: linear-gradient(90deg, var(--brand-primary), var(--brand-teal));
            border-radius: 4px 4px 0 0;
        }

        .contact-form-header {
            margin-bottom: var(--space-16);
        }

        .contact-form-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--brand-primary);
            margin: 0 0 4px;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.3px;
        }

        .contact-form-subtitle {
            font-size: 13.5px;
            color: var(--text-secondary);
            margin: 0;
            font-family: 'Inter', sans-serif;
            line-height: 1.45;
        }

        .form-row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 8px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 10px;
        }

        .form-label {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-label-hint {
            font-size: 11.5px;
            color: var(--text-secondary);
            font-weight: 400;
        }

        .form-input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input-icon {
            position: absolute;
            left: 14px;
            color: var(--brand-slate);
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-input-icon svg {
            width: 16px;
            height: 16px;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 10px 14px 10px 38px;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
            color: var(--text-primary);
            background-color: var(--bg-white);
            border: 1px solid var(--border-default);
            border-radius: var(--radius-input);
            outline: none;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #94a3b8;
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12);
            background-color: var(--bg-white);
        }

        .service-selection-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .service-option-item {
            position: relative;
        }

        .service-option-item input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .service-option-label {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            min-height: 82px;
            padding: 16px 14px;
            border: 1.5px solid var(--border-default);
            border-radius: var(--radius-card);
            background-color: var(--bg-white);
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
            box-sizing: border-box;
        }

        .service-option-icon {
            color: var(--brand-slate);
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
        }

        .service-option-icon svg {
            width: 20px;
            height: 20px;
        }

        .service-option-text {
            font-family: 'Inter', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.35;
        }

        .service-option-item:hover .service-option-label {
            border-color: var(--brand-primary);
            background-color: var(--bg-soft);
        }

        .service-option-item input[type="radio"]:checked + .service-option-label {
            border-color: var(--brand-primary);
            background-color: #f0f5fa;
            box-shadow: 0 0 0 2px var(--brand-primary);
        }

        .service-option-item input[type="radio"]:checked + .service-option-label .service-option-icon {
            color: var(--brand-primary);
        }

        .service-option-item input[type="radio"]:checked + .service-option-label .service-option-text {
            color: var(--brand-primary);
        }

        .form-textarea {
            padding: 12px 14px;
            resize: vertical;
            min-height: 100px;
            line-height: 1.5;
        }

        .form-footer-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-16);
            margin-top: 4px;
        }

        .form-privacy-note {
            font-size: 12px;
            color: var(--text-secondary);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-privacy-note svg {
            width: 14px;
            height: 14px;
            color: #15803d;
            flex-shrink: 0;
        }



        .contact-info-column {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .info-pill-card {
            background-color: var(--bg-white);
            border: 1px solid var(--border-default);
            border-radius: var(--radius-card);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            box-sizing: border-box;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .info-pill-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            border-color: var(--brand-teal);
        }

        .info-icon-bubble {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
            transition: transform 0.2s ease;
        }

        .info-pill-card:hover .info-icon-bubble {
            transform: scale(1.08);
        }

        .info-icon-bubble.icon-wa {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
        }

        .info-icon-bubble.icon-email {
            background-color: #f8fafc;
            color: var(--brand-primary);
            border: 1px solid #e2e8f0;
        }

        .info-icon-bubble.icon-alamat {
            background-color: #f0fdf4;
            color: #15803d;
            border: 1px solid #dcfce7;
        }

        .info-icon-bubble.icon-jam {
            background-color: #f8fafc;
            color: var(--brand-slate);
            border: 1px solid #e2e8f0;
        }

        .info-icon-bubble svg {
            width: 18px;
            height: 18px;
        }

        .info-text-group {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .info-title {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2px;
        }

        .info-desc {
            font-family: 'Inter', sans-serif;
            font-size: 12.5px;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.45;
        }

        .contact-map-wrapper {
            background-color: var(--bg-white);
            border-radius: var(--radius-card);
            border: 1px solid var(--border-default);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .contact-map-card {
            width: 100%;
            height: 220px;
            position: relative;
            background-color: var(--bg-soft);
        }

        .contact-map-card iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
            pointer-events: auto !important;
        }

        .contact-map-footer {
            padding: 10px 16px;
            background-color: var(--bg-white);
            border-top: 1px solid var(--border-default);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .contact-map-caption {
            font-size: 12px;
            font-weight: 600;
            color: var(--brand-primary);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .contact-map-link {
            font-size: 12px;
            color: var(--brand-slate);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .contact-map-link:hover {
            color: var(--brand-primary);
            text-decoration: underline;
        }

        .success-box-wrapper {
            max-width: 640px;
            margin: 0 auto;
        }

        .success-card {
            background-color: var(--bg-white);
            border-radius: var(--radius-card);
            border: 1.5px solid #22c55e;
            box-shadow: var(--shadow-card);
            padding: 56px 40px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }

        .success-icon-badge {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: #15803d;
            color: var(--bg-white);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-24);
            box-shadow: 0 4px 14px rgba(21, 128, 61, 0.25);
        }

        .success-icon-badge svg {
            width: 32px;
            height: 32px;
            stroke-width: 3;
        }

        .success-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 var(--space-16);
            font-family: 'Inter', sans-serif;
        }

        .success-desc {
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-secondary);
            max-width: 460px;
            margin: 0 0 var(--space-24);
            font-family: 'Inter', sans-serif;
        }

        .success-btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            max-width: 240px;
        }



        @media (max-width: 1024px) {
            .contact-layout-grid {
                grid-template-columns: 1fr;
                gap: var(--space-32);
            }

            .service-selection-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .form-row-2col {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .service-selection-grid {
                grid-template-columns: 1fr;
            }

            .contact-card {
                padding: 24px 18px;
            }

            .form-footer-action {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .btn-submit-message {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <?php require_once __DIR__ . '/../../Components/navbar.php'; ?>

    <?php require_once __DIR__ . '/../../Components/carousel.php'; ?>

    <section id="kontak-form" class="contact-page-section">
        <div class="container">

            <div id="successView" class="success-box-wrapper" style="<?= $pesan_terkirim ? '' : 'display: none;' ?>">
                <div class="success-card">
                    <div class="success-icon-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <h2 class="success-title">Pesan Terkirim</h2>
                    <p class="success-desc">
                        Terima kasih telah menghubungi JTI NOVA. Tim kami akan membalas melalui email atau WhatsApp dalam 1×24 jam kerja.
                    </p>
                    <div class="success-btn-group">
                        <?= render_button([
                            'href'    => $base_url . '/Pages/index.php',
                            'text'    => 'Kembali ke Beranda',
                            'variant' => 'primary',
                            'size'    => 'md',
                            'class'   => 'btn-block'
                        ]) ?>
                        <?= render_button([
                            'href'    => $base_url . '/Pages/HubungiKami/index.php',
                            'text'    => 'Kirim Pesan Lagi',
                            'variant' => 'outline',
                            'size'    => 'md',
                            'id'      => 'btnKirimLagi',
                            'class'   => 'btn-block'
                        ]) ?>
                    </div>
                </div>
            </div>

            <div id="formView" class="contact-layout-grid" style="<?= $pesan_terkirim ? 'display: none;' : '' ?>">
                
                <div class="contact-card">
                    <div class="contact-form-header">
                        <h2 class="contact-form-title">Mulai Diskusi Proyek Anda</h2>
                        <p class="contact-form-subtitle">Ceritakan rencana sistem, aplikasi, atau kebutuhan pelatihan digital instansi Anda bersama tim ahli JTI NOVA.</p>
                    </div>

                    <form id="contactForm" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
                        <input type="hidden" name="action" value="kirim_pesan">
                        
                        <div class="form-row-2col">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <div class="form-input-box">
                                    <span class="form-input-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </span>
                                    <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama Anda" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Alamat Email</label>
                                <div class="form-input-box">
                                    <span class="form-input-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    </span>
                                    <input type="email" id="email" name="email" class="form-input" placeholder="nama@instansi.com" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span>Layanan yang Dibutuhkan</span>
                                <span class="form-label-hint">Pilih salah satu</span>
                            </label>
                            <div class="service-selection-grid">
                                <?php foreach ($layanan_pilihan as $idx => $opt): ?>
                                    <div class="service-option-item">
                                        <input type="radio" 
                                               id="srv_<?= $opt['id'] ?>" 
                                               name="layanan" 
                                               value="<?= htmlspecialchars($opt['label']) ?>" 
                                               <?= $idx === 0 ? 'checked' : '' ?> 
                                               required>
                                        <label for="srv_<?= $opt['id'] ?>" class="service-option-label">
                                            <span class="service-option-icon"><?= $opt['icon'] ?></span>
                                            <span class="service-option-text"><?= htmlspecialchars($opt['label']) ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pesan" class="form-label">
                                <span>Detail Kebutuhan atau Pertanyaan</span>
                                <span class="form-label-hint">Singkat & jelas</span>
                            </label>
                            <textarea id="pesan" name="pesan" class="form-textarea" placeholder="Jelaskan gambaran proyek, target waktu, atau ekspektasi hasil yang diinginkan..." required></textarea>
                        </div>

                        <div class="form-footer-action">
                            <div class="form-privacy-note">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                <span>Data Anda aman & dirahasiakan</span>
                            </div>
                            <?= render_button([
                                'type'          => 'submit',
                                'text'          => 'Kirim Pesan',
                                'icon'          => 'send',
                                'icon_position' => 'right',
                                'variant'       => 'primary',
                                'size'          => 'md',
                                'class'         => 'btn-submit-message'
                            ]) ?>
                        </div>
                    </form>
                </div>

                <div class="contact-info-column">
                    
                    <a href="https://wa.me/6281200000000" target="_blank" rel="noopener noreferrer" class="info-pill-card">
                        <div class="info-icon-bubble icon-wa">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </div>
                        <div class="info-text-group">
                            <h3 class="info-title">WhatsApp</h3>
                            <p class="info-desc">+62 812-0000-0000</p>
                        </div>
                    </a>

                    <a href="mailto:info@jtinova.com" class="info-pill-card">
                        <div class="info-icon-bubble icon-email">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div class="info-text-group">
                            <h3 class="info-title">Email Resmi</h3>
                            <p class="info-desc">info@jtinova.com</p>
                        </div>
                    </a>

                    <div class="info-pill-card">
                        <div class="info-icon-bubble icon-alamat">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="3 11 22 2 13 21 11 13 3 11"/>
                            </svg>
                        </div>
                        <div class="info-text-group">
                            <h3 class="info-title">Lokasi Kampus</h3>
                            <p class="info-desc">Gedung Jurusan Teknologi Informasi, Politeknik Negeri Jember, Jl. Mastrip, Jember</p>
                        </div>
                    </div>

                    <div class="info-pill-card">
                        <div class="info-icon-bubble icon-jam">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="7"/>
                                <polyline points="12 9 12 12 13.5 13.5"/>
                                <path d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"/>
                            </svg>
                        </div>
                        <div class="info-text-group">
                            <h3 class="info-title">Jam Operasional</h3>
                            <p class="info-desc">Senin – Jumat, 08.00 – 16.00 WIB</p>
                        </div>
                    </div>

                    <div class="contact-map-wrapper">
                        <div class="contact-map-card">
                            <iframe 
                                src="<?= htmlspecialchars($polije_ti_map_src) ?>" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Peta Interaktif Lokasi Gedung Jurusan TI Politeknik Negeri Jember">
                            </iframe>
                        </div>
                        <div class="contact-map-footer">
                            <span class="contact-map-caption">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Gedung Jurusan TI Polije
                            </span>
                            <a href="https://maps.google.com/?q=-8.1581561,113.7226039" target="_blank" rel="noopener noreferrer" class="contact-map-link">
                                Buka di Maps &rarr;
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <?php require_once __DIR__ . '/../../Components/footer.php'; ?>

    <script>
    (function () {
        var form = document.getElementById('contactForm');
        var formView = document.getElementById('formView');
        var successView = document.getElementById('successView');
        var btnKirimLagi = document.getElementById('btnKirimLagi');

        if (!form) return;

        function getWaktuSapaan() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var timeVal = hours + (minutes / 60);

            if (timeVal >= 4.0 && timeVal <= 10.0) {
                return 'pagi';
            } else if (timeVal > 10.0 && timeVal <= 15.0) {
                return 'siang';
            } else if (timeVal > 15.0 && timeVal <= 18.0) {
                return 'sore';
            } else {
                return 'malam';
            }
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var namaInput = document.getElementById('nama');
            var emailInput = document.getElementById('email');
            var pesanInput = document.getElementById('pesan');
            var selectedLayanan = document.querySelector('input[name="layanan"]:checked');

            var nama = namaInput ? namaInput.value.trim() : '';
            var email = emailInput ? emailInput.value.trim() : '';
            var layanan = selectedLayanan ? selectedLayanan.value.trim() : '-';
            var pesan = pesanInput ? pesanInput.value.trim() : '';

            var waktu = getWaktuSapaan();

            var template = "Halo Admin JTI NOVA, selamat " + waktu + "! 😊\n\n"
                         + "Saya tertarik dengan layanan JTI NOVA dan ingin bertanya lebih lanjut.\n\n"
                         + "Nama: " + nama + "\n\n"
                         + "Email: " + email + "\n\n"
                         + "Layanan: " + layanan + "\n\n"
                         + "Pertanyaan/Kebutuhan: " + pesan + "\n\n"
                         + "Ditunggu respons dan informasi selanjutnya. Terima kasih! 🙏";

            var waNumber = '6281200000000';
            var waUrl = "https://api.whatsapp.com/send?phone=" + waNumber + "&text=" + encodeURIComponent(template);

            // Buka WhatsApp di tab baru
            window.open(waUrl, '_blank');

            // Tampilkan kartu "Pesan Terkirim" pada halaman
            if (formView && successView) {
                formView.style.display = 'none';
                successView.style.display = 'block';
                successView.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        if (btnKirimLagi) {
            btnKirimLagi.addEventListener('click', function (e) {
                e.preventDefault();
                form.reset();
                if (formView && successView) {
                    successView.style.display = 'none';
                    formView.style.display = 'grid';
                    formView.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }
    })();
    </script>
</body>
</html>
