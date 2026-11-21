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

    function truthy(value) {
        return !(value === undefined || value === null || value === false || value === 0 || value === '' || value === '0');
    }

    var currentPage = window.current_page || 'tentang-kami';

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

    function normalizeHref(href) {
        if (href === null) {
            return href;
        }
        if (href.indexOf('http') === 0 || href.indexOf('#') === 0 || href.indexOf('javascript:') === 0 || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) {
            return href;
        }
        var cleanPath = href.replace(/^\/+/, '');
        if (baseUrl !== '') {
            if (href.indexOf(baseUrl) !== 0) {
                return baseUrl.replace(/\/+$/, '') + '/' + cleanPath;
            }
            return href;
        }
        return '/' + cleanPath;
    }

    function renderBtn(options) {
        if (typeof window.renderButton === 'function') {
            return window.renderButton(options);
        }
        return '';
    }

    function renderCta(options) {
        options = options || {};

        var title = pick(options.title, 'Ingin berkolaborasi dengan kami?');
        var subtitle = pick(options.subtitle, 'Sampaikan kebutuhan Anda dan tim kami akan segera menghubungi.');
        var btnText = pick(options.btn_text, 'Hubungi Kami');
        var btnHref = pick(options.btn_href, '#');
        var variant = pick(options.variant, 'dark');
        var idAttr = truthy(options.id) ? ' id="' + escapeHtml(options.id) + '"' : '';
        var extraClass = pick(options.class, '');

        btnHref = normalizeHref(btnHref);

        var btnVariant = variant === 'dark' ? 'white' : 'primary';

        var actionButton = renderBtn({
            text: btnText,
            href: btnHref,
            variant: btnVariant,
            size: 'md',
            class: 'cta-action-btn'
        });

        var subtitleHtml = truthy(subtitle)
            ? '<p class="cta-subtitle">' + escapeHtml(subtitle) + '</p>'
            : '';

        return '<section class="cta-section cta-variant-' + escapeHtml(variant) + (extraClass ? ' ' + escapeHtml(extraClass) : '') + '"' + idAttr + '>' +
            '<div class="cta-container"><div class="cta-inner">' +
            '<div class="cta-text"><h2 class="cta-title">' + escapeHtml(title) + '</h2>' + subtitleHtml + '</div>' +
            '<div class="cta-action">' + actionButton + '</div>' +
            '</div></div></section>';
    }

    var ctaCss = `
.cta-section {
    width: 100%;
    margin: 0 !important;
    padding: var(--space-48) 0;
    box-sizing: border-box;
    display: block;
    position: relative;
    border: none !important;
}

.cta-variant-dark {
    background-color: var(--brand-primary);
    color: var(--bg-white);
}

.cta-variant-light {
    background-color: var(--bg-soft);
    color: var(--brand-primary);
}

.cta-variant-teal {
    background-color: var(--brand-teal);
    color: var(--brand-primary);
}

.cta-container {
    max-width: var(--container-max-width);
    margin: 0 auto;
    padding-left: var(--container-padding-x);
    padding-right: var(--container-padding-x);
    box-sizing: border-box;
}

.cta-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-48);
}

.cta-text {
    flex: 1 1 auto;
    min-width: 0;
}

.cta-title {
    font-family: 'Inter', sans-serif;
    font-size: 26px;
    font-weight: 700;
    line-height: 1.3;
    margin: 0 0 var(--space-8);
    letter-spacing: -0.3px;
    color: inherit;
}

.cta-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.6;
    margin: 0;
    opacity: 0.88;
    color: inherit;
    max-width: 700px;
}

.cta-action {
    flex-shrink: 0;
    display: flex;
    align-items: center;
}

.cta-section + .site-footer,
.cta-section ~ .site-footer {
    margin-top: 0 !important;
}

@media (max-width: 1024px) {
    .cta-container {
        padding-left: var(--space-24);
        padding-right: var(--space-24);
    }

    .cta-title {
        font-size: 23px;
    }

    .cta-inner {
        gap: var(--space-32);
    }
}

@media (max-width: 768px) {
    .cta-section {
        padding: var(--space-48) 0;
    }

    .cta-inner {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-24);
    }

    .cta-title {
        font-size: 21px;
    }

    .cta-subtitle {
        font-size: 14px;
        line-height: 1.5;
    }

    .cta-action {
        width: 100%;
    }

    .cta-action .blob-btn {
        width: 100%;
    }
}
`;

    function loadStyle() {
        if (window.PRONTOSERVE_CTA_CSS_LOADED) {
            return;
        }
        window.PRONTOSERVE_CTA_CSS_LOADED = true;
        var style = document.createElement('style');
        style.textContent = ctaCss;
        document.head.appendChild(style);
    }

    loadStyle();

    function mountCta(target, options, position) {
        target.insertAdjacentHTML(position || 'beforeend', renderCta(options));
    }

    function renderFromGlobals() {
        var keys = ['cta_title', 'cta_subtitle', 'cta_btn_text'];
        var hasAny = keys.some(function (key) {
            return window[key] !== undefined;
        });

        if (!hasAny || !currentScript || !currentScript.parentNode) {
            return;
        }

        var html = renderCta({
            title: pick(window.cta_title, 'Ingin berkolaborasi dengan kami?'),
            subtitle: pick(window.cta_subtitle, ''),
            btn_text: pick(window.cta_btn_text, 'Hubungi Kami'),
            btn_href: pick(window.cta_btn_href, '#'),
            variant: pick(window.cta_variant, 'dark'),
            id: pick(window.cta_id, null),
            class: pick(window.cta_class, '')
        });

        currentScript.insertAdjacentHTML('beforebegin', html);
    }

    renderFromGlobals();

    window.renderCta = renderCta;
    window.render_cta = renderCta;
    window.mountCta = mountCta;
    window.current_page = currentPage;
})();