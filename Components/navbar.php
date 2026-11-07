<?php
require_once __DIR__ . '/button.php';

if (!isset($current_page)) {
    $current_page = '';
}

$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(.*?)/(Pages|api|Components)#', $script_name, $matches)) {
    $base_url = $matches[1];
} else {
    $base_url = rtrim(dirname($script_name), '/\\');
    if ($base_url === '/' || $base_url === '\\') {
        $base_url = '';
    }
}

$nav_links = [
    ['name' => 'Beranda', 'href' => $base_url . '/Pages/index.php', 'key' => 'beranda'],
    ['name' => 'Tentang Kami', 'href' => $base_url . '/Pages/TentangKami/index.php', 'key' => 'tentang-kami'],
    ['name' => 'Pelayanan', 'href' => $base_url . '/Pages/Pelayanan/index.php', 'key' => 'pelayanan'],
    ['name' => 'Pelatihan', 'href' => $base_url . '/Pages/Pelatihan/index.php', 'key' => 'pelatihan'],
    ['name' => 'Portofolio', 'href' => $base_url . '/Pages/Portofolio/index.php', 'key' => 'portofolio'],
    ['name' => 'Tim', 'href' => $base_url . '/Pages/Tim/index.php', 'key' => 'tim'],
];
?>

<style>
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1100;
    transition: background-color 0.4s ease, backdrop-filter 0.4s ease, box-shadow 0.4s ease;
}

.navbar.scrolled {
    background-color: rgba(30, 58, 95, 0.55);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
}

.navbar-container {
    max-width: var(--container-max-width);
    margin: 0 auto;
    padding: 0 var(--container-padding-x);
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-sizing: border-box;
}

.navbar-brand {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    z-index: 1100;
    position: relative;
    flex-shrink: 0;
}

.navbar-brand img {
    height: 40px;
    width: auto;
    transition: opacity 0.3s ease;
}

.navbar-brand img:hover {
    opacity: 0.85;
}

.navbar-toggle {
    display: none;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    width: 44px;
    height: 44px;
    z-index: 1200;
    position: relative;
    color: #fff;
    box-sizing: border-box;
    border-radius: var(--radius-input);
    transition: background-color 0.2s ease;
}

.navbar-toggle:hover {
    background-color: rgba(255, 255, 255, 0.08);
}

.hamburger-box {
    width: 20px;
    height: 14px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
}

.hamburger-line {
    display: block;
    width: 20px;
    height: 2px;
    background-color: currentColor;
    border-radius: 2px;
    position: absolute;
    left: 0;
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                opacity 0.25s ease,
                top 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.hamburger-line:nth-child(1) { top: 0; }
.hamburger-line:nth-child(2) { top: 6px; }
.hamburger-line:nth-child(3) { top: 12px; }

.navbar-toggle.active .hamburger-line:nth-child(1) {
    top: 6px;
    transform: rotate(45deg);
}

.navbar-toggle.active .hamburger-line:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}

.navbar-toggle.active .hamburger-line:nth-child(3) {
    top: 6px;
    transform: rotate(-45deg);
}

.navbar-menu-wrapper {
    display: flex;
    align-items: center;
    gap: 32px;
}

.navbar-menu {
    display: flex;
    align-items: center;
    gap: 28px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    position: relative;
}

.nav-link {
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    color: #fff;
    padding: 8px 0;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: color 0.2s ease;
    cursor: pointer;
    background: none;
    border: none;
    font-family: 'Inter', sans-serif;
    white-space: nowrap;
}

.nav-link:hover,
.nav-link.active {
    color: var(--brand-teal);
    font-weight: 600;
}

.nav-link .chevron {
    width: 16px;
    height: 16px;
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.nav-item.open .nav-link .chevron {
    transform: rotate(180deg);
}

.dropdown-panel {
    position: absolute;
    left: 0;
    top: calc(100% + 16px);
    min-width: 200px;
    background-color: var(--bg-white);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-card);
    padding: 8px 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s ease;
    z-index: 200;
}

.nav-item.open .dropdown-panel {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-link {
    display: block;
    padding: 10px 16px;
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    text-decoration: none;
    transition: background-color 0.15s ease, color 0.15s ease;
    cursor: pointer;
}

.dropdown-link:hover,
.dropdown-link.active {
    background-color: var(--bg-soft);
    color: var(--brand-primary);
}

.dropdown-link.active {
    font-weight: 600;
}

.navbar-cta {
    flex-shrink: 0;
}

.mobile-overlay {
    display: flex;
    position: fixed;
    inset: 0;
    background-color: rgba(30, 58, 95, 0.97);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    z-index: 1050;
    flex-direction: column;
    padding: 90px 32px 40px;
    box-sizing: border-box;
    overflow-y: auto;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.35s ease,
                visibility 0.35s ease;
}

.mobile-overlay.open {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transition: opacity 0.35s ease,
                visibility 0s ease;
}

.mobile-overlay.closing {
    opacity: 0;
    visibility: visible;
    pointer-events: none;
    transition: opacity 0.38s cubic-bezier(0.16, 1, 0.3, 1) 0.45s,
                visibility 0.38s ease 0.45s;
}

@keyframes fadeUpIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeUpOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-20px);
    }
}

.mobile-overlay .mobile-nav-item,
.mobile-overlay .mobile-divider,
.mobile-overlay .mobile-cta {
    opacity: 0;
}

.mobile-overlay.open .mobile-nav-item,
.mobile-overlay.open .mobile-divider,
.mobile-overlay.open .mobile-cta {
    animation: fadeUpIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.mobile-overlay.open .mobile-nav-item:nth-child(1) { animation-delay: 0.06s; }
.mobile-overlay.open .mobile-nav-item:nth-child(2) { animation-delay: 0.11s; }
.mobile-overlay.open .mobile-nav-item:nth-child(3) { animation-delay: 0.16s; }
.mobile-overlay.open .mobile-nav-item:nth-child(4) { animation-delay: 0.21s; }
.mobile-overlay.open .mobile-nav-item:nth-child(5) { animation-delay: 0.26s; }
.mobile-overlay.open .mobile-nav-item:nth-child(6) { animation-delay: 0.31s; }
.mobile-overlay.open .mobile-divider          { animation-delay: 0.36s; }
.mobile-overlay.open .mobile-cta              { animation-delay: 0.41s; }

.mobile-overlay.closing .mobile-nav-item,
.mobile-overlay.closing .mobile-divider,
.mobile-overlay.closing .mobile-cta {
    animation: fadeUpOut 0.28s cubic-bezier(0.22, 1, 0.36, 1) both;
}

.mobile-overlay.closing .mobile-cta              { animation-delay: 0s; }
.mobile-overlay.closing .mobile-divider          { animation-delay: 0.04s; }
.mobile-overlay.closing .mobile-nav-item:nth-child(6) { animation-delay: 0.08s; }
.mobile-overlay.closing .mobile-nav-item:nth-child(5) { animation-delay: 0.12s; }
.mobile-overlay.closing .mobile-nav-item:nth-child(4) { animation-delay: 0.16s; }
.mobile-overlay.closing .mobile-nav-item:nth-child(3) { animation-delay: 0.20s; }
.mobile-overlay.closing .mobile-nav-item:nth-child(2) { animation-delay: 0.24s; }
.mobile-overlay.closing .mobile-nav-item:nth-child(1) { animation-delay: 0.28s; }

.mobile-nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
    width: 100%;
}

.mobile-nav-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 14px 0;
    font-size: 20px;
    font-weight: 500;
    color: #fff;
    text-decoration: none;
    background: none;
    border: none;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    transition: color 0.2s ease;
}

.mobile-nav-link:hover,
.mobile-nav-link.active {
    color: var(--brand-teal);
}

.mobile-nav-link .chevron {
    width: 20px;
    height: 20px;
    opacity: 0.6;
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.mobile-nav-item.open .mobile-nav-link .chevron {
    transform: rotate(180deg);
}

.mobile-dropdown {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    display: flex;
    flex-direction: column;
}

.mobile-nav-item.open .mobile-dropdown {
    max-height: 400px;
}

.mobile-dropdown-link {
    display: block;
    padding: 10px 0 10px 20px;
    font-size: 17px;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.65);
    text-decoration: none;
    transition: color 0.2s ease;
    cursor: pointer;
}

.mobile-dropdown-link:hover,
.mobile-dropdown-link.active {
    color: #fff;
}

.mobile-divider {
    height: 1px;
    background-color: rgba(255, 255, 255, 0.1);
    margin: 20px 0;
}

.mobile-cta {
    margin-top: 8px;
}

@media (max-width: 900px) {
    .navbar-container {
        padding: 0 var(--space-24);
    }

    .navbar-toggle {
        display: block;
    }

    .navbar-menu-wrapper {
        display: none;
    }
}

@media (prefers-reduced-motion: reduce) {
    .navbar,
    .nav-link,
    .dropdown-panel,
    .navbar-cta,
    .mobile-overlay,
    .mobile-nav-link,
    .mobile-nav-link .chevron,
    .mobile-dropdown,
    .mobile-nav-item,
    .mobile-divider,
    .mobile-cta {
        transition: none;
        animation: none;
    }
}
</style>

<?php
$chevron_svg = '<svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
?>

<header class="navbar" id="mainNavbar" role="banner">
    <div class="navbar-container">
        <a href="<?= $base_url ?>/Pages/index.php" class="navbar-brand" aria-label="Nova JTI - Halaman Utama">
            <img src="<?= $base_url ?>/Assets/images/logo.png" alt="Nova JTI" width="120" height="40">
        </a>

        <button
            type="button"
            class="navbar-toggle"
            id="navToggle"
            aria-label="Menu navigasi"
            aria-expanded="false"
            aria-controls="mobileOverlay"
        >
            <span class="hamburger-box">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </span>
        </button>

        <div class="navbar-menu-wrapper" role="navigation" aria-label="Menu utama">
            <ul class="navbar-menu">
                <?php foreach ($nav_links as $link): ?>
                <li class="nav-item">
                    <a
                        href="<?= htmlspecialchars($link['href']) ?>"
                        class="nav-link<?= ($current_page === $link['key']) ? ' active' : '' ?>"
                        <?= ($current_page === $link['key']) ? 'aria-current="page"' : '' ?>
                    >
                        <?= htmlspecialchars($link['name']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>

            <?= render_button([
                'href'    => $base_url . '/Pages/HubungiKami/index.php',
                'text'    => 'Hubungi Kami',
                'variant' => 'teal',
                'size'    => 'sm',
                'class'   => 'navbar-cta'
            ]) ?>
        </div>
    </div>
</header>

<div class="mobile-overlay" id="mobileOverlay" role="dialog" aria-modal="true" aria-label="Menu navigasi mobile">
    <ul class="mobile-nav-list">
        <?php foreach ($nav_links as $link): ?>
        <li class="mobile-nav-item">
            <a
                href="<?= htmlspecialchars($link['href']) ?>"
                class="mobile-nav-link<?= ($current_page === $link['key']) ? ' active' : '' ?>"
                <?= ($current_page === $link['key']) ? 'aria-current="page"' : '' ?>
            >
                <?= htmlspecialchars($link['name']) ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>

    <div class="mobile-divider"></div>

    <?= render_button([
        'href'    => $base_url . '/Pages/HubungiKami/index.php',
        'text'    => 'Hubungi Kami',
        'variant' => 'teal',
        'size'    => 'md',
        'class'   => 'mobile-cta btn-block'
    ]) ?>
</div>

<script>
(function () {
    const navbar = document.getElementById('mainNavbar');
    const toggle = document.getElementById('navToggle');
    const overlay = document.getElementById('mobileOverlay');
    let mobileOpen = false;
    let closeTimer = null;

    function setScrolled() {
        navbar.classList.toggle('scrolled', window.scrollY >= 80);
    }

    function openMobile() {
        if (mobileOpen) return;
        mobileOpen = true;
        clearTimeout(closeTimer);
        overlay.classList.remove('closing');
        overlay.querySelectorAll('.mobile-nav-item, .mobile-divider, .mobile-cta').forEach(function (el) {
            el.style.animation = 'none';
            el.offsetHeight;
            el.style.animation = '';
        });
        overlay.classList.add('open');
        toggle.classList.add('active');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'Tutup menu navigasi');
        document.body.style.overflow = 'hidden';
    }

    function closeMobile() {
        if (!mobileOpen) return;
        mobileOpen = false;
        clearTimeout(closeTimer);
        overlay.classList.remove('open');
        overlay.querySelectorAll('.mobile-nav-item, .mobile-divider, .mobile-cta').forEach(function (el) {
            el.style.animation = 'none';
            el.offsetHeight;
            el.style.animation = '';
        });
        overlay.classList.add('closing');
        toggle.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Buka menu navigasi');
        document.body.style.overflow = '';

        closeTimer = setTimeout(function () {
            overlay.classList.remove('closing');
        }, 880);
    }

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        mobileOpen ? closeMobile() : openMobile();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeMobile();
            closeAllDropdowns();
        }
    });

    overlay.querySelectorAll('.mobile-nav-link, .mobile-dropdown-link, .mobile-cta').forEach(function (link) {
        link.addEventListener('click', function () {
            closeMobile();
        });
    });

    function closeAllDropdowns() {
        document.querySelectorAll('.nav-item.open').forEach(function (item) {
            item.classList.remove('open');
        });
    }

    document.querySelectorAll('.nav-item').forEach(function (item) {
        const btn = item.querySelector('.nav-link[data-dropdown]');
        if (!btn) return;

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const isOpen = item.classList.contains('open');
            closeAllDropdowns();
            if (!isOpen) item.classList.add('open');
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.nav-item')) {
            closeAllDropdowns();
        }
    });

    const resizeObserver = new ResizeObserver(function (entries) {
        for (const entry of entries) {
            if (entry.contentRect.width > 900 && mobileOpen) {
                closeMobile();
            }
        }
    });
    resizeObserver.observe(document.body);

    window.addEventListener('scroll', setScrolled, { passive: true });
    setScrolled();
})();
</script>
