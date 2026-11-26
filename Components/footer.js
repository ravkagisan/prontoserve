(function () {
    var currentScript = document.currentScript;

    function pick(value, fallback) {
        return value === undefined || value === null ? fallback : value;
    }

    function escapeHtml(value) {
        return String(value === null || value === undefined ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function computeBaseUrl() {
        if (window.base_url !== undefined && window.base_url !== null) {
            return window.base_url;
        }
        var scriptName = (window.location.pathname || '').replace(/\\/g, '/');
        var matches = scriptName.match(/^(.*?)\/(Pages|api|Components|error)/);
        var base;
        if (matches) {
            base = matches[1];
        } else {
            var idx = scriptName.lastIndexOf('/');
            base = idx > 0 ? scriptName.substring(0, idx) : '';
            base = base.replace(/[\/\\]+$/, '');
            if (base === '/' || base === '\\') {
                base = '';
            }
        }
        return base;
    }

    var baseUrl = computeBaseUrl();

    if (!window.current_page) {
        window.current_page = 'tentang-kami';
    }

    var defaultAlamat = 'Politeknik Negeri Jember, Jl. Mastrip, Sumbersari, Jember, Jawa Timur';
    var defaultTelepon = '+62 812-0000-0000';
    var defaultEmail = 'info@jtinova.com';

    var defaultLinks = [
        { key: 'beranda', label: 'Beranda', href: '/Pages/index.html' },
        { key: 'tentang-kami', label: 'Tentang Kami', href: '/Pages/TentangKami/index.html' },
        { key: 'pelayanan', label: 'Pelayanan', href: '/Pages/Pelayanan/index.html' },
        { key: 'pelatihan', label: 'Pelatihan', href: '/Pages/Pelatihan/index.html' },
        { key: 'portofolio', label: 'Portofolio', href: '/Pages/Portofolio/index.html' },
        { key: 'tim', label: 'Tim', href: '/Pages/Tim/index.html' },
        { key: 'hubungi-kami', label: 'Hubungi Kami', href: '/Pages/HubungiKami/index.html' }
    ];

    var defaultSocials = [
        { key: 'instagram', label: 'Instagram', href: 'https://www.instagram.com/jtinova?bqrl=MXAzNHJvNTczMjM5Zg==' },
        { key: 'tiktok', label: 'TikTok', href: 'https://www.tiktok.com/@jtinova?_r=1&_t=ZS-9BhW9Zg1kKC' },
        { key: 'youtube', label: 'Youtube', href: 'https://youtube.com/@jtinova9005?si=HhervVVazUkhoZT_' }
    ];

    var socialYoutube = '<svg viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.376.55A3.016 3.016 0 0 0 .502 6.186C0 8.071 0 12 0 12s0 3.929.502 5.814a3.016 3.016 0 0 0 2.122 2.136C4.495 20.5 12 20.5 12 20.5s7.505 0 9.376-.55a3.016 3.016 0 0 0 2.122-2.136C24 15.929 24 12 24 12s0-3.929-.502-5.814ZM9.545 15.568V8.432L15.818 12l-6.273 3.568Z"/></svg>';
    var socialTiktok = '<svg viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>';
    var socialInstagram = '<svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069ZM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0Zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881Z"/></svg>';

    var iconPhone = '<svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>';
    var iconMail = '<svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>';
    var iconPin = '<svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>';

    function renderFooter(options) {
        options = options || {};

        var alamat = pick(options.alamat, pick(window.footerAlamat, defaultAlamat));
        var telepon = pick(options.telepon, pick(window.footerTelepon, defaultTelepon));
        var email = pick(options.email, pick(window.footerEmail, defaultEmail));
        var links = pick(options.links, pick(window.footerLinks, defaultLinks));
        var currentPage = pick(options.current_page, window.current_page);
        var base = pick(options.base_url, baseUrl);

        var menuHtml = links.map(function (link) {
            var activeAttr = currentPage === link.key ? 'class="is-active" aria-current="page"' : '';
            return '<li><a href="' + escapeHtml(base + link.href) + '" ' + activeAttr + '>' + escapeHtml(link.label) + '</a></li>';
        }).join('');

        var phoneHref = String(telepon).replace(/[^+\d]/g, '');

        var socials = pick(options.socials, pick(window.footerSocials, defaultSocials));
        var socialIcons = { instagram: socialInstagram, tiktok: socialTiktok, youtube: socialYoutube };

        var socialsHtml = socials.map(function (item) {
            var icon = pick(item.icon, socialIcons[item.key] || '');
            var href = pick(item.href, '#');
            return '<a href="' + escapeHtml(href) + '" class="footer-social-link" aria-label="' + escapeHtml(pick(item.label, item.key)) + '" target="_blank" rel="noopener noreferrer">' + icon + '</a>';
        }).join('');

        return '' +
            '<footer class="site-footer">' +
            '<div class="footer-container">' +
            '<div class="site-footer__grid">' +
            '<div class="footer-col-brand">' +
            '<img src="' + escapeHtml(base) + '/Assets/images/logo.png" srcset="' + escapeHtml(base) + '/Assets/images/logo2.png 2x" alt="JTI NOVA" class="footer-logo-img">' +
            '<p class="footer-address">' + escapeHtml(alamat) + '</p>' +
            '<div class="footer-socials">' + socialsHtml + '</div>' +
            '</div>' +
            '<div class="footer-col-menu">' +
            '<p class="footer-section-title">Menu</p>' +
            '<ul class="footer-menu">' + menuHtml + '</ul>' +
            '</div>' +
            '<div class="footer-col-contact">' +
            '<p class="footer-section-title">Kontak</p>' +
            '<div class="footer-contact-item">' +
            '<span class="footer-contact-icon">' + iconPhone + '</span>' +
            '<a href="tel:' + escapeHtml(phoneHref) + '" class="footer-contact-text">' + escapeHtml(telepon) + '</a>' +
            '</div>' +
            '<div class="footer-contact-item">' +
            '<span class="footer-contact-icon">' + iconMail + '</span>' +
            '<a href="mailto:' + escapeHtml(email) + '" class="footer-contact-text">' + escapeHtml(email) + '</a>' +
            '</div>' +
            '<div class="footer-contact-item">' +
            '<span class="footer-contact-icon">' + iconPin + '</span>' +
            '<span class="footer-contact-text">' + escapeHtml(alamat) + '</span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="footer-bottom">' +
            '<p class="footer-copyright">&copy; ' + new Date().getFullYear() + ' JTI NOVA &bull; TEFA Jurusan Teknologi Informasi &bull; Politeknik Negeri Jember.</p>' +
            '<ul class="footer-bottom-links">' +
            '<li><a href="' + escapeHtml(base) + '/Pages/HubungiKami/index.html">Bantuan</a></li>' +
            '<li><a href="' + escapeHtml(base) + '/Pages/TentangKami/index.html">Tentang</a></li>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '</footer>';
    }

    var footerCss = `
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

.footer-section-title {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
    margin: 0 0 18px;
}

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
`;

    function loadStyle() {
        if (window.PRONTOSERVE_FOOTER_CSS_LOADED) {
            return;
        }
        window.PRONTOSERVE_FOOTER_CSS_LOADED = true;
        var style = document.createElement('style');
        style.textContent = footerCss;
        document.head.appendChild(style);
    }

    loadStyle();

    function mountFooter(target, options, position) {
        target.insertAdjacentHTML(position || 'beforeend', renderFooter(options));
    }

    window.renderFooter = renderFooter;
    window.mountFooter = mountFooter;

    if (window.footer_autorender !== false && currentScript && currentScript.parentNode) {
        mountFooter(currentScript, {}, 'beforebegin');
    }
})();