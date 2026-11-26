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
        if (value === undefined || value === null || value === false || value === 0 || value === '' || value === '0') {
            return false;
        }
        if (Array.isArray(value) && value.length === 0) {
            return false;
        }
        return true;
    }

    function computeBaseUrl() {
        if (window.base_url !== undefined && window.base_url !== null) {
            return window.base_url;
        }
        var scriptName = (window.location.pathname || '').replace(/\\/g, '/');
        var matches = scriptName.match(/^(.*?)\/(Pages|api|Components)/);
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

    function detectAssetBase() {
        if (window.asset_base !== undefined && window.asset_base !== null) {
            return window.asset_base;
        }
        var path = (window.location.pathname || '').replace(/\\/g, '/');
        var match = path.match(/\/Pages\/(.*)$/);
        if (match) {
            var depth = match[1].split('/').length;
            var prefix = '';
            for (var i = 0; i < depth; i++) {
                prefix += '../';
            }
            return prefix + 'Assets/images/';
        }
        return (baseUrl !== '' ? baseUrl.replace(/\/+$/, '') + '/' : '/') + 'Assets/images/';
    }

    var assetBase = detectAssetBase();
    var defaultPlaceholderImage = assetBase + 'dummy.jpg';

    function isUrl(value) {
        return /^[a-z][a-z0-9+.\-]*:\/\//i.test(value);
    }

    function resolveImage(image) {
        var result = truthy(image) ? image : defaultPlaceholderImage;
        if (!isUrl(result) && result.indexOf('data:') !== 0 && result.indexOf('/') === -1) {
            result = assetBase + result.replace(/^\/+/, '');
        }
        return result;
    }

    function joinInfo(info) {
        return Array.isArray(info) ? info.join(' · ') : info;
    }

    function renderBtn(options) {
        if (typeof window.renderButton === 'function') {
            return window.renderButton(options);
        }
        return '';
    }

    function buildButton(buttonConfig, defaults) {
        var params;
        if (buttonConfig !== null && typeof buttonConfig === 'object') {
            params = {};
            for (var key in buttonConfig) {
                if (Object.prototype.hasOwnProperty.call(buttonConfig, key)) {
                    params[key] = buttonConfig[key];
                }
            }
        } else {
            params = defaults;
        }
        if (params.size === undefined || params.size === null) {
            params.size = 'sm';
        }
        if (params.variant === undefined || params.variant === null) {
            params.variant = 'primary';
        }
        return renderBtn(params);
    }

    function titleHtml(title, href) {
        if (href) {
            return '<a href="' + escapeHtml(href) + '" class="card-title-link">' + escapeHtml(title) + '</a>';
        }
        return escapeHtml(title);
    }

    function badgeHtml(category) {
        if (!truthy(category)) {
            return '';
        }
        return '<div class="card-badge-wrap"><span class="btn btn-badge">' + escapeHtml(category) + '</span></div>';
    }

    function descHtml(description) {
        if (!truthy(description)) {
            return '';
        }
        return '<p class="card-desc">' + escapeHtml(description) + '</p>';
    }

    function renderCard(options) {
        options = options || {};

        var variant = pick(options.variant, 'service');
        var title = pick(options.title, '');
        var subtitle = pick(options.subtitle, '');
        var description = pick(options.description, '');
        var category = pick(options.category, '');
        var extraInfo = pick(options.extra_info, null);
        var buttonConfig = pick(options.button_config, null);
        var socialLinks = pick(options.social_links, null);
        var href = pick(options.href, null);
        var extraClass = pick(options.class, '');
        var id = pick(options.id, null);
        var attributes = pick(options.attributes, '');
        var gradient = pick(options.gradient, null);
        var icon = pick(options.icon, null);

        var image = resolveImage(options.image);

        var idAttr = id ? 'id="' + escapeHtml(id) + '"' : '';

        var isClickable = !!href && variant === 'team';
        var cardClasses = 'card custom-card card-' + escapeHtml(variant) +
            (isClickable ? ' custom-card-clickable' : '') +
            (extraClass ? ' ' + escapeHtml(extraClass) : '');

        var hasSocial = truthy(socialLinks) && Array.isArray(socialLinks);
        var subtitleText = truthy(subtitle) ? subtitle : description;
        var imgTag = '<img src="' + escapeHtml(image) + '" alt="' + escapeHtml(title) + '" class="card-img">';

        if (variant === 'team' && href) {
            var spanDots;
            if (hasSocial) {
                spanDots = socialLinks.map(function (item) {
                    return '<span class="social-dot" aria-hidden="true">' + (truthy(item.icon) ? item.icon : '') + '</span>';
                }).join('');
            } else {
                spanDots = '<span class="social-dot"></span><span class="social-dot"></span><span class="social-dot"></span>';
            }

            return '' +
                '<a href="' + escapeHtml(href) + '" class="' + cardClasses + '" ' + idAttr + ' ' + attributes + '>' +
                '<div class="card-inner card-inner-team">' +
                '<div class="card-img-portrait-wrap">' + imgTag + '</div>' +
                '<div class="card-body card-body-center">' +
                '<h3 class="card-title">' + escapeHtml(title) + '</h3>' +
                '<p class="card-subtitle">' + escapeHtml(subtitleText) + '</p>' +
                '<div class="card-social-dots">' + spanDots + '</div>' +
                '</div>' +
                '</div>' +
                '</a>';
        }

        var inner = '';

        if (variant === 'project') {
            var topStyle = gradient ? 'style="background: ' + escapeHtml(gradient) + ';"' : '';
            var topContent = icon
                ? '<div class="card-img-placeholder-icon">' + icon + '</div>'
                : '<img src="' + escapeHtml(image) + '" alt="' + escapeHtml(title) + '" class="card-img-top">';

            var projectBtn = buildButton(buttonConfig, {
                variant: 'primary',
                text: 'Lihat Detail',
                href: pick(href, '#'),
                size: 'sm'
            });

            inner = '' +
                '<div class="card-img-top-wrap" ' + topStyle + '>' + topContent + '</div>' +
                '<div class="card-body">' +
                badgeHtml(category) +
                '<h3 class="card-title">' + titleHtml(title, href) + '</h3>' +
                descHtml(description) +
                '<div class="card-action">' + projectBtn + '</div>' +
                '</div>';
        } else if (variant === 'training') {
            var trainingBtn = buildButton(buttonConfig, {
                variant: 'primary',
                text: 'Lihat Silabus',
                href: pick(href, 'Pages/HubungiKami/index.php'),
                size: 'sm'
            });

            var trainingExtra = truthy(extraInfo)
                ? '<div class="card-extra-info"><span class="card-extra-icon">📅</span><span>' + escapeHtml(joinInfo(extraInfo)) + '</span></div>'
                : '';

            inner = '' +
                '<div class="card-inner">' +
                '<div class="card-img-inset-wrap card-img-training">' + imgTag + '</div>' +
                '<div class="card-body">' +
                badgeHtml(category) +
                '<h3 class="card-title">' + titleHtml(title, href) + '</h3>' +
                descHtml(description) +
                trainingExtra +
                '<div class="card-action">' + trainingBtn + '</div>' +
                '</div>' +
                '</div>';
        } else if (variant === 'team') {
            var linkDots;
            if (hasSocial) {
                linkDots = socialLinks.map(function (item) {
                    return '<a href="' + escapeHtml(pick(item.url, '#')) + '" class="social-dot" aria-label="Social Link">' + (truthy(item.icon) ? item.icon : '') + '</a>';
                }).join('');
            } else {
                linkDots = '<span class="social-dot"></span><span class="social-dot"></span><span class="social-dot"></span>';
            }

            inner = '' +
                '<div class="card-inner card-inner-team">' +
                '<div class="card-img-portrait-wrap">' + imgTag + '</div>' +
                '<div class="card-body card-body-center">' +
                '<h3 class="card-title">' + escapeHtml(title) + '</h3>' +
                '<p class="card-subtitle">' + escapeHtml(subtitleText) + '</p>' +
                '<div class="card-social-dots">' + linkDots + '</div>' +
                '</div>' +
                '</div>';
        } else {
            var serviceBtn = buildButton(buttonConfig, {
                variant: 'primary',
                text: 'Pelajari Selengkapnya',
                href: pick(href, '#'),
                size: 'sm'
            });

            var serviceExtra = truthy(extraInfo)
                ? '<div class="card-extra-info card-contact-info"><span>' + escapeHtml(joinInfo(extraInfo)) + '</span></div>'
                : '';

            inner = '' +
                '<div class="card-inner">' +
                '<div class="card-img-inset-wrap card-img-service">' + imgTag + '</div>' +
                '<div class="card-body">' +
                '<h3 class="card-title">' + titleHtml(title, href) + '</h3>' +
                descHtml(description) +
                serviceExtra +
                '<div class="card-action">' + serviceBtn + '</div>' +
                '</div>' +
                '</div>';
        }

        return '<div class="' + cardClasses + '" ' + idAttr + ' ' + attributes + '>' + inner + '</div>';
    }

    var cardCss = `
.custom-card {
    background-color: var(--bg-white);
    border-radius: var(--radius-card);
    border: 1px solid var(--border-default);
    box-shadow: var(--shadow-card);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    box-sizing: border-box;
    position: relative;
    width: 100%;
    height: 100%;
}

.custom-card-clickable {
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}

.custom-card-clickable:focus-visible {
    outline: 2px solid var(--brand-primary);
    outline-offset: 3px;
}

.custom-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
    border-color: rgba(95, 122, 148, 0.4);
}

.custom-card-clickable:hover .card-title {
    color: var(--brand-primary);
}

.card-inner {
    padding: var(--space-16);
    display: flex;
    flex-direction: column;
    height: 100%;
    box-sizing: border-box;
}

.card-img-inset-wrap {
    width: 100%;
    height: 165px;
    border-radius: var(--radius-input);
    overflow: hidden;
    background-color: var(--bg-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: var(--space-16);
    flex-shrink: 0;
}

.card-img-training {
    background-color: var(--brand-slate);
}

.card-img-service {
    background-color: var(--bg-soft);
}

.card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}

.custom-card:hover .card-img {
    transform: scale(1.04);
}

.card-img-top-wrap {
    width: 100%;
    height: 185px;
    overflow: hidden;
    background-color: var(--brand-teal);
    position: relative;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-img-placeholder-icon {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.88);
}

.card-img-placeholder-icon svg {
    width: 44px;
    height: 44px;
}

.card-img-top {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}

.custom-card:hover .card-img-top {
    transform: scale(1.04);
}

.card-body {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    box-sizing: border-box;
}

.card-project .card-body {
    padding: var(--space-24);
}

.card-badge-wrap {
    margin-bottom: var(--space-8);
}

.card-badge-wrap .btn-badge {
    pointer-events: none;
    font-size: 12px;
    padding: 4px 10px;
    border-radius: var(--radius-badge);
}

.card-title {
    font-family: 'Inter', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 var(--space-8) 0;
    line-height: 1.35;
    transition: color 0.2s ease;
}

.card-title-link {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
}

.card-title-link:hover {
    color: var(--brand-primary);
}

.card-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: var(--text-secondary);
    margin: 0 0 var(--space-16) 0;
    line-height: 1.4;
}

.card-desc {
    font-family: 'Inter', sans-serif;
    font-size: 13.5px;
    color: var(--text-secondary);
    margin: 0 0 var(--space-16) 0;
    line-height: 1.55;
    flex-grow: 1;
}

.card-extra-info {
    font-family: 'Inter', sans-serif;
    font-size: 12.5px;
    color: var(--text-secondary);
    margin: 0 0 var(--space-16) 0;
    display: flex;
    align-items: center;
    gap: 6px;
    line-height: 1.4;
}

.card-extra-icon {
    font-size: 13px;
    display: inline-flex;
    align-items: center;
}

.card-contact-info {
    font-size: 13px;
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: var(--space-16);
}

.card-action {
    margin-top: auto;
    padding-top: var(--space-16);
}

.card-inner-team {
    padding: var(--space-16);
    text-align: center;
    align-items: center;
}

.card-img-portrait-wrap {
    width: 100%;
    aspect-ratio: 1 / 1.12;
    border-radius: var(--radius-input);
    overflow: hidden;
    background-color: var(--brand-teal);
    margin-bottom: var(--space-16);
    flex-shrink: 0;
}

.card-body-center {
    align-items: center;
    text-align: center;
    width: 100%;
}

.card-team .card-title {
    margin-bottom: 4px;
    font-size: 17px;
}

.card-team .card-subtitle {
    margin-bottom: var(--space-16);
}

.card-social-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-8);
    margin-top: auto;
}

.social-dot {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background-color: var(--brand-slate);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background-color 0.2s ease, transform 0.15s ease;
}

.social-dot:hover {
    background-color: var(--brand-primary);
    transform: scale(1.15);
}
`;

    function loadStyle() {
        if (window.PRONTOSERVE_CARD_CSS_LOADED) {
            return;
        }
        window.PRONTOSERVE_CARD_CSS_LOADED = true;
        var style = document.createElement('style');
        style.textContent = cardCss;
        document.head.appendChild(style);
    }

    loadStyle();

    function mountCard(target, options, position) {
        target.insertAdjacentHTML(position || 'beforeend', renderCard(options));
    }

    function renderFromGlobals() {
        var keys = ['card_variant', 'card_title', 'variant', 'title'];
        var hasAny = keys.some(function (key) {
            return window[key] !== undefined;
        });

        if (!hasAny || !currentScript || !currentScript.parentNode) {
            return;
        }

        var html = renderCard({
            variant: pick(window.card_variant, pick(window.variant, 'service')),
            title: pick(window.card_title, pick(window.title, '')),
            subtitle: pick(window.card_subtitle, pick(window.subtitle, '')),
            description: pick(window.card_description, pick(window.description, '')),
            image: pick(window.card_image, pick(window.image, null)),
            category: pick(window.card_category, pick(window.category, '')),
            extra_info: pick(window.card_extra_info, pick(window.extra_info, null)),
            button_config: pick(window.card_button_config, pick(window.button_config, null)),
            social_links: pick(window.card_social_links, pick(window.social_links, null)),
            href: pick(window.card_href, pick(window.href, null)),
            class: pick(window.card_class, pick(window.class, '')),
            id: pick(window.card_id, pick(window.id, null)),
            attributes: pick(window.card_attributes, pick(window.attributes, ''))
        });

        currentScript.insertAdjacentHTML('beforebegin', html);
    }

    renderFromGlobals();

    window.renderCard = renderCard;
    window.render_card = renderCard;
    window.mountCard = mountCard;
})();