<?php
if (!isset($current_page)) {
    $current_page = 'tentang-kami';
}

$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(.*?)/(Pages|api|Components|error)#', $script_name, $matches)) {
    $base_url = $matches[1];
} else {
    $base_url = rtrim(dirname($script_name), '/\\');
    if ($base_url === '/' || $base_url === '\\') {
        $base_url = '';
    }
}

$footerAlamat  = 'Politeknik Negeri Jember, Jl. Mastrip, Sumbersari, Jember, Jawa Timur';
$footerTelepon = '+62 812-0000-0000';
$footerEmail   = 'info@jtinova.com';

$footerLinks = [
    ['key' => 'beranda',      'label' => 'Beranda',      'href' => '/Pages/index.php'],
    ['key' => 'tentang-kami', 'label' => 'Tentang Kami', 'href' => '/Pages/TentangKami/index.php'],
    ['key' => 'pelayanan',    'label' => 'Pelayanan',    'href' => '/Pages/Pelayanan/index.php'],
    ['key' => 'pelatihan',    'label' => 'Pelatihan',    'href' => '/Pages/Pelatihan/index.php'],
    ['key' => 'portofolio',   'label' => 'Portofolio',   'href' => '/Pages/Portofolio/index.php'],
    ['key' => 'tim',          'label' => 'Tim',          'href' => '/Pages/Tim/index.php'],
    ['key' => 'hubungi-kami', 'label' => 'Hubungi Kami', 'href' => '/Pages/HubungiKami/index.php'],
];
?><footer class="site-footer">
<style>
.site-footer {
    background-color: var(--bg-dark);
    color: var(--bg-gray);
    font-family: 'Inter', sans-serif;
    padding-top: 56px;
    padding-bottom: 56px;
    margin: 0 !important;
    position: relative;
    border: none;
}

.site-footer .footer-container {
    max-width: var(--container-max-width);
    margin: 0 auto;
    padding-left: var(--container-padding-x);
    padding-right: var(--container-padding-x);
    box-sizing: border-box;
}

.site-footer__grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr 1fr;
    gap: 48px;
    align-items: start;
}

/* ── Left: logo + address + socials ── */
.footer-logo-img {
    height: 44px;
    width: auto;
    object-fit: contain;
    display: block;
    margin-bottom: 16px;
    filter: brightness(0) invert(1);
}

.footer-address {
    font-size: 13.5px;
    line-height: 1.65;
    color: rgba(255,255,255,0.55);
    margin: 0 0 20px;
}

.footer-socials {
    display: flex;
    align-items: center;
    gap: 10px;
}

.footer-social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.08);
    color: var(--bg-white);
    transition: background-color 0.2s ease, transform 0.15s ease;
    text-decoration: none;
    flex-shrink: 0;
}

.footer-social-link:hover {
    background-color: rgba(255,255,255,0.2);
    transform: translateY(-2px);
}

.footer-social-link svg {
    width: 16px;
    height: 16px;
    fill: currentColor;
}

/* ── Section title ── */
.footer-section-title {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
    margin: 0 0 18px;
}

/* ── Center: menu ── */
.footer-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.footer-menu a {
    font-size: 14px;
    font-weight: 400;
    color: rgba(255,255,255,0.65);
    text-decoration: none;
    transition: color 0.2s ease;
    display: inline-block;
}

.footer-menu a:hover,
.footer-menu a.is-active {
    color: var(--bg-white);
}

.footer-menu a.is-active {
    font-weight: 600;
}

/* ── Right: contact ── */
.footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 14px;
}

.footer-contact-icon {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    margin-top: 1px;
    color: var(--brand-teal);
}

.footer-contact-icon svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.footer-contact-text {
    font-size: 13.5px;
    line-height: 1.55;
    color: rgba(255,255,255,0.65);
    text-decoration: none;
    transition: color 0.2s ease;
}

a.footer-contact-text:hover {
    color: var(--bg-white);
}

/* ── Bottom: copyright ── */
.footer-bottom {
    margin-top: 48px;
    padding-top: 24px;
    border-top: 1px solid rgba(255,255,255,0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.footer-copyright {
    font-size: 12.5px;
    color: rgba(255,255,255,0.4);
    margin: 0;
}

.footer-bottom-links {
    display: flex;
    gap: 20px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.footer-bottom-links a {
    font-size: 12.5px;
    color: rgba(255,255,255,0.4);
    text-decoration: none;
    transition: color 0.2s ease;
}

.footer-bottom-links a:hover {
    color: var(--bg-white);
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .site-footer .footer-container {
        padding-left: var(--space-24);
        padding-right: var(--space-24);
    }
}

@media (max-width: 768px) {
    .site-footer__grid {
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }

    .footer-col-brand {
        grid-column: 1 / -1;
    }

    .footer-bottom {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}

@media (max-width: 480px) {
    .site-footer__grid {
        grid-template-columns: 1fr;
        gap: 28px;
    }

    .footer-col-brand {
        grid-column: unset;
    }
}
</style>
    <div class="footer-container">
        <div class="site-footer__grid">

            <!-- Kiri: Logo + Alamat + Sosial -->
            <div class="footer-col-brand">
                <img
                    src="<?= $base_url ?>/Assets/images/logo.png"
                    srcset="<?= $base_url ?>/Assets/images/logo@2x.png 2x"
                    alt="JTI NOVA"
                    class="footer-logo-img"
                >
                <p class="footer-address"><?= htmlspecialchars($footerAlamat) ?></p>
                <div class="footer-socials">
                    <a href="#" class="footer-social-link" aria-label="X / Twitter">
                        <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622 5.91-5.622Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"/></svg>
                    </a>
                    <a href="#" class="footer-social-link" aria-label="Facebook">
                        <svg viewBox="0 0 24 24"><path d="M24 12.073C24 5.40365 18.6274 0 12 0S0 5.40365 0 12.073C0 18.1 4.38823 23.0943 10.125 24v-8.437H7.078v-3.49h3.047v-2.66c0-3.025 1.791-4.697 4.533-4.697 1.313 0 2.686.235 2.686.235v2.97h-1.514c-1.491 0-1.956.93-1.956 1.886v2.266h3.328l-.532 3.49h-2.796V24C19.6118 23.0943 24 18.1 24 12.073Z"/></svg>
                    </a>
                    <a href="#" class="footer-social-link" aria-label="Instagram">
                        <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069ZM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0Zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881Z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Tengah: Menu -->
            <div class="footer-col-menu">
                <p class="footer-section-title">Menu</p>
                <ul class="footer-menu">
                    <?php foreach ($footerLinks as $link): ?>
                        <li>
                            <a href="<?= htmlspecialchars($base_url . $link['href']) ?>"
                               <?= ($current_page === $link['key']) ? 'class="is-active" aria-current="page"' : '' ?>>
                                <?= htmlspecialchars($link['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Kanan: Kontak -->
            <div class="footer-col-contact">
                <p class="footer-section-title">Kontak</p>

                <div class="footer-contact-item">
                    <span class="footer-contact-icon">
                        <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </span>
                    <a href="tel:<?= preg_replace('/[^+\d]/', '', $footerTelepon) ?>" class="footer-contact-text">
                        <?= htmlspecialchars($footerTelepon) ?>
                    </a>
                </div>

                <div class="footer-contact-item">
                    <span class="footer-contact-icon">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <a href="mailto:<?= htmlspecialchars($footerEmail) ?>" class="footer-contact-text">
                        <?= htmlspecialchars($footerEmail) ?>
                    </a>
                </div>

                <div class="footer-contact-item">
                    <span class="footer-contact-icon">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <span class="footer-contact-text"><?= htmlspecialchars($footerAlamat) ?></span>
                </div>

            </div>

        </div>

        <!-- Bawah: Copyright -->
        <div class="footer-bottom">
            <p class="footer-copyright">
                &copy; <?= date('Y') ?> JTI NOVA &bull; TEFA Jurusan Teknologi Informasi &bull; Politeknik Negeri Jember.
            </p>
            <ul class="footer-bottom-links">
                <li><a href="<?= htmlspecialchars($base_url) ?>/Pages/HubungiKami/index.php">Bantuan</a></li>
                <li><a href="<?= htmlspecialchars($base_url) ?>/Pages/TentangKami/index.php">Tentang</a></li>
            </ul>
        </div>
    </div>
</footer>
