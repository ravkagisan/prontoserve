<?php
$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(.*?)/(Pages|api|Components|error)#', $script_name, $matches)) {
    $base_url = $matches[1];
} else {
    $base_url = rtrim(dirname($script_name), '/\\');
    if ($base_url === '/' || $base_url === '\\') {
        $base_url = '';
    }
}

$current_page = 'error';

$errors = [
    400 => [
        'code'     => 400,
        'badge'    => 'STATUS 400 • BAD REQUEST',
        'title'    => 'Permintaan Tidak Valid',
        'subtitle' => 'Server tidak dapat memproses permintaan yang dikirimkan.',
        'desc'     => 'Format data atau parameter yang dikirim oleh peramban Anda tidak sesuai atau mengalami kerusakan. Silakan periksa kembali tautan yang Anda tuju.',
        'icon'     => '<path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
    ],
    401 => [
        'code'     => 401,
        'badge'    => 'STATUS 401 • UNAUTHORIZED',
        'title'    => 'Autentikasi Diperlukan',
        'subtitle' => 'Akses ke halaman ini membutuhkan verifikasi kredensial.',
        'desc'     => 'Anda belum melakukan otentikasi atau sesi Anda telah kedaluwarsa. Silakan masuk terlebih dahulu untuk melanjutkan akses ke layanan JTI NOVA.',
        'icon'     => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>'
    ],
    403 => [
        'code'     => 403,
        'badge'    => 'STATUS 403 • FORBIDDEN',
        'title'    => 'Akses Terbatas',
        'subtitle' => 'Anda tidak memiliki hak akses untuk membuka halaman ini.',
        'desc'     => 'Halaman atau direktori ini dibatasi khusus bagi pihak yang memiliki wewenang. Jika Anda memerlukan izin akses, silakan hubungi tim administrator JTI NOVA.',
        'icon'     => '<circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>'
    ],
    404 => [
        'code'     => 404,
        'badge'    => 'STATUS 404 • NOT FOUND',
        'title'    => 'Halaman Tidak Ditemukan',
        'subtitle' => 'Alamat yang Anda tuju tidak tersedia di server JTI NOVA.',
        'desc'     => 'Halaman mungkin telah dipindahkan, diganti tautannya, atau alamat URL yang Anda masukkan mengalami salah pengetikan. Silakan kembali ke beranda atau telusuri layanan kami.',
        'icon'     => '<circle cx="12" cy="12" r="10"/><path d="M16 16s-1.5-2-4-2-4 2-4 2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>'
    ],
    500 => [
        'code'     => 500,
        'badge'    => 'STATUS 500 • INTERNAL SERVER ERROR',
        'title'    => 'Kesalahan Server Internal',
        'subtitle' => 'Terjadi kendala teknis tak terduga pada sistem kami.',
        'desc'     => 'Sistem kami mengalami kesalahan internal saat memproses halaman ini. Tim teknis JTI NOVA segera menangani kendala ini agar layanan kembali normal.',
        'icon'     => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>'
    ],
    503 => [
        'code'     => 503,
        'badge'    => 'STATUS 503 • SERVICE UNAVAILABLE',
        'title'    => 'Layanan Sedang Dipelihara',
        'subtitle' => 'Server sedang dalam proses peningkatan sistem.',
        'desc'     => 'Kami sedang melakukan pemeliharaan berkala untuk meningkatkan keandalan dan keamanan sistem JTI NOVA. Mohon tunggu beberapa saat dan muat ulang halaman.',
        'icon'     => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>'
    ]
];

$code = 404;
if (isset($_GET['code'])) {
    $req_code = (int)$_GET['code'];
    if (array_key_exists($req_code, $errors)) {
        $code = $req_code;
    }
} elseif (isset($_SERVER['REDIRECT_STATUS'])) {
    $redirect_code = (int)$_SERVER['REDIRECT_STATUS'];
    if (array_key_exists($redirect_code, $errors)) {
        $code = $redirect_code;
    }
}

if (!headers_sent()) {
    http_response_code($code);
}

$error_data = $errors[$code];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (int)$error_data['code'] ?> - <?= htmlspecialchars($error_data['title']) ?> | JTI NOVA</title>
    <link rel="stylesheet" href="<?= htmlspecialchars($base_url) ?>/Style/style.css">
    <?php require_once __DIR__ . '/../Components/button.php'; ?>
<style>
.navbar-bg-dark {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 72px;
    background-color: #111827;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.navbar:not(.scrolled) {
    background-color: #111827;
}
.error-main {
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle at 50% 20%, rgba(141, 188, 194, 0.12) 0%, transparent 60%),
                radial-gradient(circle at 80% 80%, rgba(30, 58, 95, 0.05) 0%, transparent 50%),
                var(--bg-white);
    padding: 130px 0 80px;
    position: relative;
    overflow: hidden;
}

.error-card {
    background: var(--bg-white);
    border: 1px solid var(--border-default);
    border-radius: 24px;
    padding: clamp(36px, 5vw, 64px) clamp(24px, 4vw, 56px);
    box-shadow: 0 16px 48px rgba(30, 58, 95, 0.08);
    text-align: center;
    max-width: 760px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

.error-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--bg-soft);
    color: var(--brand-primary);
    border: 1px solid rgba(141, 188, 194, 0.45);
    border-radius: var(--radius-pill);
    padding: 6px 18px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.error-badge svg {
    width: 15px;
    height: 15px;
    stroke: var(--brand-teal);
    stroke-width: 2.2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.error-digits {
    font-size: clamp(84px, 15vw, 150px);
    font-weight: 800;
    line-height: 0.95;
    letter-spacing: -3px;
    color: var(--brand-primary);
    margin: 10px 0 20px;
    position: relative;
    display: inline-block;
    background: linear-gradient(135deg, var(--brand-primary) 0%, #162c48 50%, var(--brand-teal) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 4px 16px rgba(30, 58, 95, 0.15));
}

.error-title {
    font-size: clamp(24px, 3.2vw, 34px);
    font-weight: 700;
    color: var(--brand-primary);
    line-height: 1.25;
    margin: 0 0 12px;
}

.error-subtitle {
    font-size: clamp(15.5px, 1.8vw, 17px);
    font-weight: 600;
    color: var(--brand-slate);
    line-height: 1.5;
    margin: 0 0 16px;
}

.error-desc {
    font-size: 14.5px;
    color: var(--text-secondary);
    line-height: 1.65;
    max-width: 580px;
    margin: 0 auto 36px;
}

.error-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

.error-quicklinks {
    border-top: 1px solid var(--border-default);
    padding-top: 28px;
    margin-top: 10px;
}

.error-quicklinks__title {
    font-size: 12.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-secondary);
    margin-bottom: 14px;
}

.error-quicklinks__list {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.error-nav-pill {
    display: inline-flex;
    align-items: center;
    padding: 7px 16px;
    font-size: 13px;
    font-weight: 600;
    color: var(--brand-primary);
    background: var(--bg-soft);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-pill);
    text-decoration: none;
    transition: all 0.2s ease;
}

.error-nav-pill:hover {
    background: var(--brand-primary);
    color: var(--bg-white);
    border-color: var(--brand-primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 58, 95, 0.15);
}

.error-nav-pill:focus-visible {
    outline: 2px solid var(--brand-primary);
    outline-offset: 2px;
}

.error-bg-circle {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    z-index: 1;
}

.error-bg-circle--1 {
    width: 480px;
    height: 480px;
    border: 1px dashed rgba(141, 188, 194, 0.35);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: errorRotate 50s linear infinite;
}

.error-bg-circle--2 {
    width: 680px;
    height: 680px;
    border: 1px solid rgba(30, 58, 95, 0.08);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@keyframes errorRotate {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

@media (max-width: 640px) {
    .error-main {
        padding: 100px 0 60px;
    }
    .error-card {
        padding: 32px 20px;
        border-radius: 18px;
    }
    .error-actions {
        flex-direction: column;
        width: 100%;
    }
    .error-actions .btn {
        width: 100% !important;
    }
}

@media (prefers-reduced-motion: reduce) {
    .error-bg-circle--1 {
        animation: none;
    }
    .error-nav-pill {
        transition: none;
        transform: none !important;
    }
}
</style>
</head>
<body>

<div class="navbar-bg-dark" aria-hidden="true"></div>
<?php require_once __DIR__ . '/../Components/navbar.php'; ?>

<main class="error-main" id="main-content">
    <div class="error-bg-circle error-bg-circle--1" aria-hidden="true"></div>
    <div class="error-bg-circle error-bg-circle--2" aria-hidden="true"></div>

    <div class="container">
        <div class="error-card">
            <div class="error-badge">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <?= $error_data['icon'] ?>
                </svg>
                <span><?= htmlspecialchars($error_data['badge']) ?></span>
            </div>

            <div class="error-digits-wrap" aria-hidden="true">
                <span class="error-digits"><?= (int)$error_data['code'] ?></span>
            </div>

            <h1 class="error-title"><?= htmlspecialchars($error_data['title']) ?></h1>
            <p class="error-subtitle"><?= htmlspecialchars($error_data['subtitle']) ?></p>
            <p class="error-desc"><?= htmlspecialchars($error_data['desc']) ?></p>

            <div class="error-actions">
                <?= render_button([
                    'text'    => 'Kembali ke Beranda',
                    'href'    => $base_url . '/Pages/index.php',
                    'variant' => 'primary',
                    'size'    => 'lg',
                    'icon'    => 'arrow-left'
                ]) ?>
                <?= render_button([
                    'text'    => 'Hubungi Kami',
                    'href'    => $base_url . '/Pages/HubungiKami/index.php',
                    'variant' => 'outline',
                    'size'    => 'lg',
                    'icon'    => 'phone'
                ]) ?>
            </div>

            <div class="error-quicklinks">
                <p class="error-quicklinks__title">Halaman yang Sering Dikunjungi</p>
                <div class="error-quicklinks__list" role="navigation" aria-label="Tautan navigasi cepat">
                    <a href="<?= htmlspecialchars($base_url) ?>/Pages/index.php" class="error-nav-pill">Beranda</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/Pages/Pelayanan/index.php" class="error-nav-pill">Pelayanan</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/Pages/Pelatihan/index.php" class="error-nav-pill">Pelatihan</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/Pages/Portofolio/index.php" class="error-nav-pill">Portofolio</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/Pages/TentangKami/index.php" class="error-nav-pill">Tentang Kami</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../Components/footer.php'; ?>

</body>
</html>
