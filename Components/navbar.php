<?php
if (!isset($current_page)) {
    $current_page = 'tentang-kami';
}
?>

<style>
.navbar {
    width: 100%;
    background-color: var(--bg-white);
    border-bottom: 1px solid var(--border-default);
    position: sticky;
    top: 0;
    z-index: 1000;
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
    gap: var(--space-8);
    text-decoration: none;
    font-size: 22px;
    font-weight: 700;
    color: var(--brand-red);
    user-select: none;
}

.brand-badge {
    background-color: var(--brand-red);
    color: var(--bg-white);
    font-size: 14px;
    font-weight: 700;
    padding: 6px 10px;
    border-radius: var(--radius-pill);
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.brand-text {
    color: var(--brand-red);
    font-weight: 700;
    letter-spacing: -0.5px;
}

.brand-sub {
    font-size: 8px;
    color: var(--text-secondary);
    font-weight: 600;
    letter-spacing: 0.5px;
    display: block;
    margin-top: -2px;
}

.navbar-collapse {
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
    display: flex;
    align-items: center;
}

.nav-link {
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    color: var(--text-primary);
    padding: 8px 0;
    position: relative;
    transition: color 0.2s ease;
}

.nav-link:hover {
    color: var(--brand-primary);
}

.nav-link.active {
    color: var(--brand-primary);
    font-weight: 600;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 3px;
    background-color: var(--brand-primary);
    border-radius: var(--radius-pill);
    transition: width 0.2s ease;
}

.nav-link.active::after,
.nav-link:hover::after {
    width: 20px;
}

.navbar-cta {
    background-color: var(--brand-primary);
    color: var(--bg-white);
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    border-radius: var(--radius-pill);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
    transition: opacity 0.2s ease;
}

.navbar-cta:hover {
    opacity: 0.9;
}

.navbar-hamburger {
    display: none;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 8px;
    width: 40px;
    height: 40px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 5px;
    border-radius: var(--radius-input);
}

.navbar-hamburger span {
    display: block;
    width: 22px;
    height: 2px;
    background-color: var(--brand-primary);
    border-radius: 2px;
    transition: transform 0.25s ease, opacity 0.25s ease;
}

.navbar-hamburger.active span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.navbar-hamburger.active span:nth-child(2) {
    opacity: 0;
}

.navbar-hamburger.active span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

@media (max-width: 900px) {
    .navbar-container {
        padding: 0 var(--space-24);
    }

    .navbar-hamburger {
        display: flex;
    }

    .navbar-collapse {
        position: absolute;
        top: 72px;
        left: 0;
        width: 100%;
        background-color: var(--bg-white);
        border-bottom: 1px solid var(--border-default);
        box-shadow: var(--shadow-card);
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
        padding: var(--space-24);
        box-sizing: border-box;
        display: none;
    }

    .navbar-collapse.show {
        display: flex;
    }

    .navbar-menu {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }

    .nav-link {
        padding: 10px 14px;
        border-radius: var(--radius-input);
    }

    .nav-link.active,
    .nav-link:hover {
        background-color: var(--bg-soft);
    }

    .nav-link::after {
        display: none;
    }

    .navbar-action {
        width: 100%;
        padding-top: var(--space-8);
    }

    .navbar-cta {
        width: 100%;
        text-align: center;
        padding: 12px 20px;
    }
}
</style>

<header class="navbar">
    <div class="navbar-container">
        <a href="#" class="navbar-brand">
            <span class="brand-badge">jti</span>
            <div>
                <span class="brand-text">nova</span>
                <span class="brand-sub">TEFA JTI INNOVATION</span>
            </div>
        </a>

        <button type="button" class="navbar-hamburger" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="navbar-collapse" id="navMenu">
            <ul class="navbar-menu">
                <li class="nav-item">
                    <a href="Pages/TentangKami/index.php"
                        class="nav-link <?= ($current_page === 'tentang-kami') ? 'active' : '' ?>">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a href="Pages/Pelayanan/index.php"
                        class="nav-link <?= ($current_page === 'pelayanan') ? 'active' : '' ?>">Pelayanan</a>
                </li>
                <li class="nav-item">
                    <a href="Pages/Pelatihan/index.php"
                        class="nav-link <?= ($current_page === 'pelatihan') ? 'active' : '' ?>">Pelatihan</a>
                </li>
                <li class="nav-item">
                    <a href="Pages/Portofolio/index.php"
                        class="nav-link <?= ($current_page === 'portofolio') ? 'active' : '' ?>">Portofolio</a>
                </li>
                <li class="nav-item">
                    <a href="Pages/Tim/index.php"
                        class="nav-link <?= ($current_page === 'tim') ? 'active' : '' ?>">Tim</a>
                </li>
            </ul>
        </nav>

        <div class="navbar-action">
            <a href="#" class="navbar-cta">Hubungi Kami</a>
        </div>
        </nav>
    </div>
</header>

<script>
(function() {
    const toggle = document.getElementById('navToggle');
    const menu = document.getElementById('navMenu');

    if (toggle && menu) {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = menu.classList.toggle('show');
            toggle.classList.toggle('active', isOpen);
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !toggle.contains(e.target)) {
                menu.classList.remove('show');
                toggle.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
})();
</script>