(function () {
    var currentScript = document.currentScript;

    var currentPage = window.current_page || 'tentang-kami';

    function computeBaseUrl() {
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

    function escapeHtml(value) {
        return String(value === null || value === undefined ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function isExternalOrSpecial(url) {
        return url.indexOf('http') === 0 ||
            url.indexOf('#') === 0 ||
            url.indexOf('javascript:') === 0 ||
            url.indexOf('mailto:') === 0 ||
            url.indexOf('tel:') === 0;
    }

    function normalizePath(path) {
        var cleanPath = path.replace(/^\/+/, '');
        if (baseUrl !== '') {
            if (path.indexOf(baseUrl) !== 0) {
                return baseUrl.replace(/\/+$/, '') + '/' + cleanPath;
            }
            return path;
        }
        return '/' + cleanPath;
    }

    var icons = {
        'search': '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        'arrow-right': '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',
        'arrow-left': '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>',
        'plus': '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',
        'check': '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>',
        'phone': '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        'send': '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>'
    };

    function pick(value, fallback) {
        return value === undefined || value === null ? fallback : value;
    }

    function renderButton(options) {
        options = options || {};

        var variant = pick(options.variant, 'primary');
        var text = pick(options.text, '');
        var href = pick(options.href, null);
        var type = pick(options.type, 'button');
        var icon = pick(options.icon, null);
        var iconPosition = pick(options.icon_position, 'left');
        var size = pick(options.size, 'md');
        var extraClass = pick(options.class, '');
        var id = pick(options.id, null);
        var attributes = pick(options.attributes, '');
        var disabled = !!options.disabled;

        if (href !== null && !isExternalOrSpecial(href)) {
            href = normalizePath(href);
        }

        var renderedIcon = '';
        if (icon) {
            renderedIcon = icons[icon] !== undefined ? icons[icon] : icon;
        }

        if (variant === 'search') {
            var placeholder = pick(options.placeholder, 'Cari proyek portofolio...');
            var btnText = pick(options.button_text, text || 'Cari');
            var name = pick(options.name, 'q');
            var value = pick(options.value, '');
            var action = pick(options.action, null);
            var formMethod = pick(options.method, 'GET');

            if (action !== null && action.indexOf('http') !== 0 && action.indexOf('#') !== 0) {
                action = normalizePath(action);
            }

            var searchBtn = renderButton({
                type: 'submit',
                text: btnText,
                variant: 'primary',
                size: 'sm',
                class: 'btn-search-action'
            });

            var inputGroup =
                '<div class="search-input-group ' + escapeHtml(extraClass) + '" ' + (id ? 'id="' + escapeHtml(id) + '"' : '') + '>' +
                '<span class="search-input-icon">' + icons.search + '</span>' +
                '<input type="text" ' +
                'name="' + escapeHtml(name) + '" ' +
                'value="' + escapeHtml(value) + '" ' +
                'placeholder="' + escapeHtml(placeholder) + '" ' +
                'class="search-input-field" ' + attributes + '>' +
                searchBtn +
                '</div>';

            if (action !== null) {
                return '<form action="' + escapeHtml(action) + '" method="' + escapeHtml(formMethod) + '" class="search-form-wrapper">' + inputGroup + '</form>';
            }
            return inputGroup;
        }

        var classes = ['btn', 'blob-btn', 'blob-btn-' + variant, 'btn-size-' + size];
        if (extraClass) {
            classes.push(extraClass);
        }
        if (disabled) {
            classes.push('btn-disabled');
        }
        var classAttr = classes.filter(Boolean).join(' ');

        var innerContent = '';
        if (renderedIcon && iconPosition === 'left') {
            innerContent += renderedIcon + ' ';
        }
        if (text !== '') {
            innerContent += '<span class="btn-text">' + escapeHtml(text) + '</span>';
        }
        if (renderedIcon && iconPosition === 'right') {
            innerContent += ' ' + renderedIcon;
        }

        var idAttr = id ? 'id="' + escapeHtml(id) + '"' : '';

        var blobStructure =
            '<span class="blob-btn__text">' + innerContent + '</span>' +
            '<span class="blob-btn__inner" aria-hidden="true">' +
            '<span class="blob-btn__blobs">' +
            '<span class="blob-btn__blob"></span>' +
            '<span class="blob-btn__blob"></span>' +
            '<span class="blob-btn__blob"></span>' +
            '<span class="blob-btn__blob"></span>' +
            '</span>' +
            '</span>';

        if (href !== null && !disabled) {
            return '<a href="' + escapeHtml(href) + '" class="' + escapeHtml(classAttr) + '" ' + idAttr + ' ' + attributes + '>' + blobStructure + '</a>';
        }

        var disabledAttr = disabled ? 'disabled' : '';
        return '<button type="' + escapeHtml(type) + '" class="' + escapeHtml(classAttr) + '" ' + idAttr + ' ' + disabledAttr + ' ' + attributes + '>' + blobStructure + '</button>';
    }

    var buttonCss = `
.blob-btn {
    --btn-border-w: 2px;
    z-index: 1;
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    line-height: 1.2;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    background-color: transparent;
    outline: none;
    border: none;
    border-radius: var(--radius-pill);
    box-sizing: border-box;
    white-space: nowrap;
    user-select: none;
    vertical-align: middle;
    transition: color 0.4s ease, transform 0.2s ease, box-shadow 0.3s ease;
}

.blob-btn:active:not(.btn-disabled):not(:disabled) {
    transform: translateY(1px);
}

.blob-btn:focus-visible {
    outline: 2px solid var(--brand-primary);
    outline-offset: 3px;
}

.blob-btn:before {
    content: "";
    z-index: 1;
    position: absolute;
    inset: 0;
    border: var(--btn-border-w) solid currentColor;
    border-radius: var(--radius-pill);
    pointer-events: none;
    transition: border-color 0.3s ease;
}

.blob-btn__inner {
    z-index: -1;
    overflow: hidden;
    position: absolute;
    inset: 0;
    border-radius: var(--radius-pill);
    pointer-events: none;
}

.blob-btn__blobs {
    position: relative;
    display: block;
    height: 100%;
    filter: url('#btn-goo');
}

.blob-btn__blob {
    position: absolute;
    top: var(--btn-border-w);
    width: 25%;
    height: 100%;
    border-radius: 100%;
    transform: translate3d(0, 150%, 0) scale(1.7);
    transition: transform 0.45s ease;
}

@supports(filter: url('#btn-goo')) {
    .blob-btn__blob {
        transform: translate3d(0, 150%, 0) scale(1.4);
    }
}

.blob-btn__blob:nth-child(1) { left: 0%;   transition-delay: 0s; }
.blob-btn__blob:nth-child(2) { left: 30%;  transition-delay: 0.08s; }
.blob-btn__blob:nth-child(3) { left: 60%;  transition-delay: 0.16s; }
.blob-btn__blob:nth-child(4) { left: 90%;  transition-delay: 0.24s; }

.blob-btn:hover:not(.btn-disabled):not(:disabled) .blob-btn__blob {
    transform: translateZ(0) scale(1.7);
}

@supports(filter: url('#btn-goo')) {
    .blob-btn:hover:not(.btn-disabled):not(:disabled) .blob-btn__blob {
        transform: translateZ(0) scale(1.4);
    }
}

.blob-btn__text {
    position: relative;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-8);
    pointer-events: none;
}

.btn-icon {
    width: 17px;
    height: 17px;
    stroke-width: var(--icon-stroke);
    stroke-linecap: round;
    stroke-linejoin: round;
    display: inline-block;
    flex-shrink: 0;
}

.btn-size-sm {
    padding: 10px 24px;
    font-size: 14px;
}
.btn-size-sm .btn-icon {
    width: 16px;
    height: 16px;
}

.btn-size-md {
    padding: 14px 32px;
    font-size: 15.5px;
}
.btn-size-md .btn-icon {
    width: 18px;
    height: 18px;
}

.btn-size-lg {
    padding: 17px 40px;
    font-size: 17px;
}
.btn-size-lg .btn-icon {
    width: 20px;
    height: 20px;
}

.btn-block {
    width: 100% !important;
    display: flex !important;
}

.blob-btn-primary {
    color: var(--brand-primary);
}
.blob-btn-primary:before {
    border-color: var(--brand-primary);
}
.blob-btn-primary .blob-btn__inner {
    background-color: var(--bg-white);
}
.blob-btn-primary .blob-btn__blob {
    background-color: var(--brand-primary);
}
.blob-btn-primary:hover:not(.btn-disabled):not(:disabled) {
    color: var(--bg-white);
    box-shadow: 0 6px 18px rgba(30, 58, 95, 0.22);
}

.blob-btn-primary-solid {
    color: var(--bg-white);
}
.blob-btn-primary-solid:before {
    border-color: var(--brand-primary);
}
.blob-btn-primary-solid .blob-btn__inner {
    background-color: var(--brand-primary);
}
.blob-btn-primary-solid .blob-btn__blob {
    background-color: #162c48;
}
.blob-btn-primary-solid:hover:not(.btn-disabled):not(:disabled) {
    color: var(--bg-white);
    box-shadow: 0 8px 22px rgba(22, 44, 72, 0.32);
}

.blob-btn-outline {
    color: var(--brand-primary);
}
.blob-btn-outline:before {
    border-color: var(--brand-primary);
}
.blob-btn-outline .blob-btn__inner {
    background-color: var(--bg-white);
}
.blob-btn-outline .blob-btn__blob {
    background-color: var(--brand-primary);
}
.blob-btn-outline:hover:not(.btn-disabled):not(:disabled) {
    color: var(--bg-white);
    box-shadow: 0 6px 16px rgba(30, 58, 95, 0.2);
}

.blob-btn-outline-white,
.blob-btn-secondary {
    color: var(--bg-white);
}
.blob-btn-outline-white:before,
.blob-btn-secondary:before {
    border-color: rgba(255, 255, 255, 0.9);
}
.blob-btn-outline-white .blob-btn__inner,
.blob-btn-secondary .blob-btn__inner {
    background-color: transparent;
}
.blob-btn-outline-white .blob-btn__blob,
.blob-btn-secondary .blob-btn__blob {
    background-color: var(--bg-white);
}
.blob-btn-outline-white:hover:not(.btn-disabled):not(:disabled),
.blob-btn-secondary:hover:not(.btn-disabled):not(:disabled) {
    color: var(--brand-primary);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.blob-btn-white {
    color: var(--brand-primary);
}
.blob-btn-white:before {
    border-color: var(--bg-white);
}
.blob-btn-white .blob-btn__inner {
    background-color: var(--bg-white);
}
.blob-btn-white .blob-btn__blob {
    background-color: #162c48;
}
.blob-btn-white:hover:not(.btn-disabled):not(:disabled) {
    color: var(--bg-white);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.blob-btn-teal {
    color: var(--brand-primary);
}
.blob-btn-teal:before {
    border-color: var(--brand-teal);
}
.blob-btn-teal .blob-btn__inner {
    background-color: var(--brand-teal);
}
.blob-btn-teal .blob-btn__blob {
    background-color: var(--brand-primary);
}
.blob-btn-teal:hover:not(.btn-disabled):not(:disabled) {
    color: var(--bg-white);
    box-shadow: 0 6px 16px rgba(141, 188, 194, 0.4);
}

.blob-btn-ghost {
    color: var(--brand-primary);
}
.blob-btn-ghost:before {
    border-color: transparent;
}
.blob-btn-ghost .blob-btn__inner {
    background-color: transparent;
}
.blob-btn-ghost .blob-btn__blob {
    background-color: var(--bg-soft);
}
.blob-btn-ghost:hover:not(.btn-disabled):not(:disabled) {
    color: var(--brand-primary);
}

.blob-btn-danger {
    color: var(--brand-red);
}
.blob-btn-danger:before {
    border-color: var(--brand-red);
}
.blob-btn-danger .blob-btn__inner {
    background-color: var(--bg-white);
}
.blob-btn-danger .blob-btn__blob {
    background-color: var(--brand-red);
}
.blob-btn-danger:hover:not(.btn-disabled):not(:disabled) {
    color: var(--bg-white);
}

.btn-disabled,
.blob-btn:disabled {
    opacity: 0.55;
    cursor: not-allowed !important;
    pointer-events: none !important;
}

.btn-badge {
    display: inline-flex;
    align-items: center;
    background-color: var(--brand-slate);
    color: var(--bg-white);
    border: none;
    border-radius: var(--radius-badge);
    padding: 5px 12px;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.2;
}

.search-form-wrapper {
    display: inline-block;
    width: 100%;
    max-width: 420px;
    margin: 0;
}

.search-input-group {
    display: inline-flex;
    align-items: center;
    background-color: var(--bg-white);
    border: 1.5px solid var(--border-default);
    border-radius: var(--radius-pill);
    padding: 3px 4px 3px 14px;
    box-sizing: border-box;
    width: 100%;
    max-width: 420px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.search-input-group:focus-within {
    border-color: var(--brand-primary);
    box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12);
}

.search-input-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    margin-right: var(--space-8);
    flex-shrink: 0;
}

.search-input-icon svg {
    width: 16px;
    height: 16px;
    stroke-width: var(--icon-stroke);
}

.search-input-field {
    border: none;
    outline: none;
    background: transparent;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: var(--text-primary);
    width: 100%;
    padding: 6px 0;
    box-sizing: border-box;
}

.search-input-field::placeholder {
    color: var(--text-secondary);
}

.btn-search-action {
    flex-shrink: 0;
    padding: 7px 18px !important;
    font-size: 13px !important;
}

@media (prefers-reduced-motion: reduce) {
    .blob-btn,
    .blob-btn__blob {
        transition: none !important;
        transform: none !important;
    }
}
`;

    var gooSvg =
        '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0; position: absolute; pointer-events: none;" aria-hidden="true">' +
        '<defs>' +
        '<filter id="btn-goo">' +
        '<feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>' +
        '<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></feColorMatrix>' +
        '<feComposite in2="goo" in="SourceGraphic" result="mix"></feComposite>' +
        '</filter>' +
        '<filter id="goo">' +
        '<feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>' +
        '<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></feColorMatrix>' +
        '<feComposite in2="goo" in="SourceGraphic" result="mix"></feComposite>' +
        '</filter>' +
        '</defs>' +
        '</svg>';

    function loadAssets() {
        if (window.PRONTOSERVE_BUTTON_CSS_LOADED) {
            return;
        }
        window.PRONTOSERVE_BUTTON_CSS_LOADED = true;

        var style = document.createElement('style');
        style.textContent = buttonCss;
        document.head.appendChild(style);

        var holder = document.createElement('div');
        holder.innerHTML = gooSvg;
        var svg = holder.firstChild;

        if (document.body) {
            document.body.insertBefore(svg, document.body.firstChild);
        } else {
            document.addEventListener('DOMContentLoaded', function () {
                document.body.insertBefore(svg, document.body.firstChild);
            });
        }
    }

    loadAssets();

    function renderFromGlobals() {
        var keys = ['btn_variant', 'btn_text', 'btn_href', 'btn_icon'];
        var hasAny = keys.some(function (key) {
            return window[key] !== undefined;
        });

        if (!hasAny) {
            return;
        }

        var html = renderButton({
            variant: pick(window.btn_variant, 'primary'),
            text: pick(window.btn_text, ''),
            href: pick(window.btn_href, null),
            type: pick(window.btn_type, 'button'),
            icon: pick(window.btn_icon, null),
            icon_position: pick(window.btn_icon_position, 'left'),
            size: pick(window.btn_size, 'md'),
            class: pick(window.btn_class, ''),
            id: pick(window.btn_id, null),
            attributes: pick(window.btn_attributes, ''),
            disabled: pick(window.btn_disabled, false),
            placeholder: pick(window.btn_placeholder, 'Cari proyek portofolio...'),
            button_text: pick(window.btn_button_text, 'Cari'),
            name: pick(window.btn_name, 'q'),
            value: pick(window.btn_value, ''),
            action: pick(window.btn_action, null)
        });

        if (currentScript && currentScript.parentNode) {
            currentScript.insertAdjacentHTML('beforebegin', html);
        }
    }

    renderFromGlobals();

    window.renderButton = renderButton;
    window.render_button = renderButton;
    window.baseUrl = baseUrl;
    window.current_page = currentPage;
})();