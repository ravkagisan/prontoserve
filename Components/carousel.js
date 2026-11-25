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

    function isEmpty(value) {
        if (value === undefined || value === null || value === false || value === 0 || value === '' || value === '0') {
            return true;
        }
        if (Array.isArray(value) && value.length === 0) {
            return true;
        }
        return false;
    }

    function randomId() {
        var chars = 'abcdef0123456789';
        var out = '';
        for (var i = 0; i < 8; i++) {
            out += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return 'carousel_' + out;
    }

    function detectAssetBase() {
        if (window.asset_base !== undefined && window.asset_base !== null) {
            return window.asset_base;
        }
        var path = (window.location.pathname || '').replace(/\\/g, '/');
        var match = path.match(/\/Pages\/(.*)$/);
        if (match) {
            var parts = match[1].split('/');
            var depth = parts.length;
            var prefix = '';
            for (var i = 0; i < depth; i++) {
                prefix += '../';
            }
            return prefix + 'Assets/images/';
        }
        return 'Assets/images/';
    }

    function isUrlLike(value) {
        return /^(https?:)?\/\//i.test(value) || value.indexOf('data:') === 0 || value.indexOf('/') === 0;
    }

    function buttonRenderer(options) {
        if (typeof window.renderButton === 'function') {
            return window.renderButton(options);
        }
        return '';
    }

    var carouselCss = `
  @keyframes zoomRight {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
  }

  .carousel-wrapper {
    position: relative;
    width: 100%;
    height: 480px;
    overflow: hidden;
    background-color: #000000;
  }

  @media (min-width: 768px) {
    .carousel-wrapper {
      height: 520px;
    }
  }

  @media (min-width: 1200px) {
    .carousel-wrapper {
      height: 560px;
    }
  }

  .carousel-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    z-index: 1;
    pointer-events: none;
    transition: opacity 1s ease-in-out, visibility 1s ease-in-out;
  }

  .carousel-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 2;
    pointer-events: auto;
  }

  .carousel-bg-wrap {
    position: absolute;
    inset: 0;
    overflow: hidden;
  }

  .carousel-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.8;
    will-change: transform;
  }

  .carousel-slide.active .carousel-bg {
    animation: zoomRight 30s ease-out infinite;
    transform-origin: right center;
  }

  .carousel-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .carousel-content-wrap {
    position: relative;
    z-index: 3;
    height: 100%;
    display: flex;
    align-items: center;
    max-width: var(--container-max-width, 1200px);
    margin: 0 auto;
    padding: 0 var(--container-padding-x, 120px);
    box-sizing: border-box;
    width: 100%;
  }

  @media (max-width: 900px) {
    .carousel-content-wrap {
      padding: 0 var(--space-24, 24px);
    }
  }

  @media (max-width: 480px) {
    .carousel-content-wrap {
      padding: 0 var(--space-16, 16px);
    }
  }

  .carousel-text-box {
    max-width: 780px;
    width: 100%;
    color: var(--bg-white, #ffffff);
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.25s ease, transform 0.25s ease;
    min-height: 270px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
  }

  .carousel-slide.active .carousel-text-box {
    opacity: 1;
    transform: translateY(0);
  }

  .carousel-title {
    font-size: clamp(26px, 4.2vw, 44px);
    font-weight: 700;
    line-height: 1.3;
    margin: 0 0 var(--space-16, 16px) 0;
    color: var(--bg-white, #ffffff);
    white-space: pre-line;
    letter-spacing: -0.5px;
    min-height: calc(2 * 1.3em);
    box-sizing: border-box;
    padding-bottom: 2px;
  }

  .carousel-desc {
    font-size: clamp(14px, 1.6vw, 17px);
    line-height: 1.6;
    margin: 0;
    color: rgba(255, 255, 255, 0.9);
    max-width: 660px;
    min-height: calc(2 * 1.6em);
    box-sizing: border-box;
  }

  .carousel-desc--empty {
    visibility: hidden;
    user-select: none;
    pointer-events: none;
  }

  .carousel-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-16, 16px);
    align-items: center;
    margin-top: 32px;
  }

  .carousel-hero-btn,
  .carousel-buttons .blob-btn {
    width: 230px !important;
    flex: 0 0 230px !important;
    height: 52px !important;
    min-height: 52px !important;
    padding: 0 16px !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    line-height: 1.4 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
    box-sizing: border-box !important;
    white-space: nowrap !important;
    border-radius: var(--radius-pill, 999px) !important;
  }

  .carousel-hero-btn .blob-btn__text,
  .carousel-buttons .blob-btn .blob-btn__text {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    text-align: center;
    line-height: 1.4;
    overflow: visible;
    padding-bottom: 2px;
  }

  @media (max-width: 768px) {
    .carousel-text-box {
      min-height: auto;
    }
    .carousel-title {
      min-height: auto;
      margin-bottom: var(--space-12, 12px);
    }
    .carousel-desc {
      min-height: auto;
      font-size: 14.5px;
      line-height: 1.5;
    }
    .carousel-buttons {
      margin-top: 24px;
      gap: var(--space-12, 12px);
    }
    .carousel-hero-btn,
    .carousel-buttons .blob-btn {
      width: 210px !important;
      flex: 0 0 210px !important;
      height: 50px !important;
      min-height: 50px !important;
      font-size: 14.5px !important;
    }
  }

  .carousel-dots {
    position: absolute;
    bottom: var(--space-24, 24px);
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .carousel-dot {
    width: 10px;
    height: 10px;
    border-radius: var(--radius-pill, 999px);
    background-color: rgba(255, 255, 255, 0.45);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .carousel-dot:hover {
    background-color: var(--bg-white, #ffffff);
  }

  .carousel-dot.active {
    width: 32px;
    background-color: var(--brand-teal, #8DBCC2);
  }

  .cards-carousel-section {
    width: 100%;
    max-width: var(--container-max-width, 1200px);
    margin: 0 auto;
    padding: var(--space-48, 48px) var(--container-padding-x, 120px);
    box-sizing: border-box;
    position: relative;
  }

  @media (max-width: 900px) {
    .cards-carousel-section {
      padding: var(--space-24, 24px);
    }
  }

  .cards-carousel-header {
    margin-bottom: var(--space-24, 24px);
  }

  .cards-carousel-h1 {
    font-size: clamp(24px, 3.5vw, 36px);
    font-weight: 700;
    color: var(--brand-primary, #1E3A5F);
    margin: 0 0 var(--space-8, 8px) 0;
  }

  .cards-carousel-h2 {
    font-size: 16px;
    color: var(--text-secondary, #6B7280);
    margin: 0;
  }

  .cards-carousel-wrap {
    position: relative;
  }

  .cards-scroll-container {
    display: flex;
    gap: var(--space-24, 24px);
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    padding-bottom: var(--space-16, 16px);
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .cards-scroll-container::-webkit-scrollbar {
    display: none;
  }

  .card-item-link {
    text-decoration: none;
    color: inherit;
    flex: 0 0 380px;
    max-width: 85vw;
    scroll-snap-align: start;
  }

  .carousel-card-box {
    display: flex;
    height: 150px;
    background-color: var(--bg-white, #ffffff);
    border-radius: var(--radius-card, 16px);
    border: 1px solid var(--border-default, #D1D5E0);
    overflow: hidden;
    box-shadow: var(--shadow-card, 0 4px 16px rgba(0, 0, 0, 0.08));
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  .carousel-card-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
  }

  .carousel-card-img-wrap {
    width: 40%;
    position: relative;
    overflow: hidden;
    background-color: var(--bg-soft, #EBF1F5);
  }

  .carousel-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .carousel-card-box:hover .carousel-card-img {
    transform: scale(1.06);
  }

  .carousel-card-body {
    width: 60%;
    padding: var(--space-16, 16px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-sizing: border-box;
  }

  .carousel-card-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary, #1F2937);
    margin: 0 0 var(--space-8, 8px) 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .carousel-card-desc {
    font-size: 13px;
    color: var(--text-secondary, #6B7280);
    margin: 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* ===== Mobile: hero carousel ringkas (HARUS paling akhir) ===== */
  @media (max-width: 640px) {
    .carousel-wrapper {
      display: grid;
      height: auto;
      min-height: 300px;
    }

    .carousel-slide {
      position: relative;
      inset: auto;
      grid-area: 1 / 1;
      height: auto;
      min-height: 300px;
    }

    .carousel-content-wrap {
      height: auto;
      min-height: 300px;
      align-items: center;
      padding: 68px var(--space-16, 16px) 44px;
    }

    .carousel-text-box {
      min-height: 0;
      max-width: 100%;
    }

    .carousel-title {
      font-size: clamp(19px, 5.6vw, 22px);
      line-height: 1.3;
      min-height: 0;
      margin-bottom: 8px;
      letter-spacing: -0.2px;
    }

    .carousel-desc {
      font-size: 12.5px;
      line-height: 1.5;
      min-height: 0;
      max-width: 100%;
    }

    .carousel-buttons {
      flex-direction: row;
      flex-wrap: wrap;
      align-items: center;
      width: auto;
      gap: 8px;
      margin-top: 14px;
    }

    .carousel-hero-btn,
    .carousel-buttons .blob-btn {
      width: auto !important;
      flex: 0 0 auto !important;
      min-width: 0 !important;
      height: 38px !important;
      min-height: 38px !important;
      padding: 0 18px !important;
      font-size: 12.5px !important;
    }

    .carousel-dots {
      bottom: 12px;
      gap: 6px;
    }

    .carousel-dot {
      width: 8px;
      height: 8px;
    }

    .carousel-dot.active {
      width: 22px;
    }
  }
`;

    function loadStyle() {
        if (window.PRONTOSERVE_CAROUSEL_CSS_LOADED) {
            return;
        }
        window.PRONTOSERVE_CAROUSEL_CSS_LOADED = true;
        var style = document.createElement('style');
        style.textContent = carouselCss;
        document.head.appendChild(style);
    }

    function defaultSlides(assetBase) {
        return [
            {
            id: 1,
            image: assetBase + 'Foto-Carousel/foto1.png',
            title: 'Podcast\nJTI NOVA',
            description: 'Behind The Scene Podcast JTI NOVA',
            buttons: [
                { text: 'Jelajahi Layanan', link: 'Pages/Pelayanan/index.html', variant: 'primary' },
                { text: 'Hubungi Kami', link: 'Pages/HubungiKami/index.html', variant: 'outline-white' }
            ]
        },
        {
            id: 2,
            image: assetBase + 'Foto-Carousel/foto2.png',
            title: 'Simulasi\nS-LEARN',
            description: 'Pengujian Website S-LEARN.',
            buttons: [
                { text: 'Daftar Pelatihan', link: 'Pages/Pelatihan/index.html', variant: 'primary' },
                { text: 'Lihat Silabus', link: 'Pages/Pelatihan/index.html', variant: 'outline-white' }
            ]
        }
        ];
    }

    function defaultCards(assetBase) {
        return [
            {
                id: 1,
                title: 'Sistem Informasi Manajemen Terintegrasi',
                desc: 'Platform digital enterprise untuk otomatisasi operasional dan pelaporan terpadu.',
                img: assetBase + 'dummy.jpg',
                link: 'Pages/Portofolio/index.php'
            },
            {
                id: 2,
                title: 'Aplikasi Pembelajaran Interaktif EduTech',
                desc: 'Media pembelajaran digital dengan fitur interaktif untuk meningkatkan kualitas edukasi.',
                img: assetBase + 'ajasendiri.jpg',
                link: 'Pages/Portofolio/index.php'
            },
            {
                id: 3,
                title: 'Implementasi IoT Smart Monitoring',
                desc: 'Sensor jaringan cerdas dan dashboard analitik data real-time berbasis cloud.',
                img: assetBase + 'dummy.jpg',
                link: 'Pages/Portofolio/index.php'
            }
        ];
    }

    function buildCardsCarousel(config, carouselId, assetBase) {
        var h1 = pick(config.cards_h1, 'Portofolio Terpilih');
        var h2 = pick(config.cards_h2, 'Jelajahi inovasi dan produk yang telah kami kembangkan bersama mitra industri.');
        var cards = pick(config.cards_data, defaultCards(assetBase));

        var cardsHtml = cards.map(function (card) {
            return '' +
                '<a href="' + escapeHtml(pick(card.link, '#')) + '" class="card-item-link">' +
                '<div class="carousel-card-box">' +
                '<div class="carousel-card-img-wrap">' +
                '<img src="' + escapeHtml(card.img) + '" alt="' + escapeHtml(card.title) + '" class="carousel-card-img">' +
                '</div>' +
                '<div class="carousel-card-body">' +
                '<h3 class="carousel-card-title">' + escapeHtml(card.title) + '</h3>' +
                '<p class="carousel-card-desc">' + escapeHtml(card.desc) + '</p>' +
                '</div>' +
                '</div>' +
                '</a>';
        }).join('');

        return '' +
            '<section class="cards-carousel-section" id="' + escapeHtml(carouselId) + '">' +
            '<div class="cards-carousel-header">' +
            '<h2 class="cards-carousel-h1">' + escapeHtml(h1) + '</h2>' +
            '<p class="cards-carousel-h2">' + escapeHtml(h2) + '</p>' +
            '</div>' +
            '<div class="cards-carousel-wrap">' +
            '<div class="cards-scroll-container">' + cardsHtml + '</div>' +
            '</div>' +
            '</section>';
    }

    function buildHeroCarousel(config, carouselId, assetBase) {
        var slides = config.carousel_slides;
        if (!Array.isArray(slides) || slides.length === 0) {
            slides = defaultSlides(assetBase);
        }

        slides = slides.map(function (slide) {
            var copy = {};
            for (var key in slide) {
                if (Object.prototype.hasOwnProperty.call(slide, key)) {
                    copy[key] = slide[key];
                }
            }
            if (!isEmpty(copy.image) && !isUrlLike(copy.image) && copy.image.indexOf('Assets/') !== 0 && copy.image.indexOf('../') !== 0) {
    copy.image = assetBase + copy.image.replace(/^\/+/, '');
}
            return copy;
        });

        var slidesHtml = slides.map(function (slide, index) {
            var isActive = index === 0;
            var buttons = [];

            if (!isEmpty(slide.buttons) && Array.isArray(slide.buttons)) {
                buttons = slide.buttons;
            } else if (!isEmpty(slide.ctaText) && !isEmpty(slide.ctaLink)) {
                buttons = [{ text: slide.ctaText, link: slide.ctaLink, variant: 'outline-white' }];
            }

            var descHtml = !isEmpty(slide.description)
                ? '<p class="carousel-desc">' + escapeHtml(slide.description) + '</p>'
                : '<p class="carousel-desc carousel-desc--empty" aria-hidden="true">&nbsp;</p>';

            var buttonsHtml = '';
            if (buttons.length > 0) {
                buttonsHtml = '<div class="carousel-buttons">' + buttons.map(function (btn) {
                    var variant = pick(btn.variant, 'primary');
                    if (variant === 'secondary' || variant === 'outline') {
                        variant = 'outline-white';
                    }
                    var href = pick(btn.link, pick(btn.href, null));
                    return buttonRenderer({
                        variant: variant,
                        text: pick(btn.text, ''),
                        href: href,
                        size: pick(btn.size, 'md'),
                        icon: pick(btn.icon, null),
                        icon_position: pick(btn.icon_position, 'right'),
                        class: ('carousel-hero-btn ' + pick(btn.class, '')).trim()
                    });
                }).join('') + '</div>';
            }

            return '' +
                '<div class="carousel-slide ' + (isActive ? 'active' : '') + '" data-index="' + index + '">' +
                '<div class="carousel-bg-wrap">' +
                '<div class="carousel-bg" style="background-image: url(\'' + escapeHtml(slide.image) + '\');"></div>' +
                '<div class="carousel-overlay"></div>' +
                '</div>' +
                '<div class="carousel-content-wrap">' +
                '<div class="carousel-text-box">' +
                '<h2 class="carousel-title">' + escapeHtml(slide.title) + '</h2>' +
                descHtml +
                buttonsHtml +
                '</div>' +
                '</div>' +
                '</div>';
        }).join('');

        var dotsHtml = '';
        if (slides.length > 1) {
            dotsHtml = '<div class="carousel-dots">' + slides.map(function (slide, index) {
                return '<button type="button" class="carousel-dot ' + (index === 0 ? 'active' : '') + '" data-target="' + index + '" aria-label="Menuju slide ' + (index + 1) + '"></button>';
            }).join('') + '</div>';
        }

        return '<div class="carousel-wrapper" id="' + escapeHtml(carouselId) + '">' + slidesHtml + dotsHtml + '</div>';
    }

    function initSlider(carouselId, intervalDuration) {
        var root = document.getElementById(carouselId);
        if (!root) return;

        var slides = root.querySelectorAll('.carousel-slide');
        var dots = root.querySelectorAll('.carousel-dot');
        var totalSlides = slides.length;

        if (totalSlides <= 1) return;

        var current = 0;
        var timer = null;
        var isPaused = false;

        function goTo(index) {
            if (index < 0) {
                current = totalSlides - 1;
            } else if (index >= totalSlides) {
                current = 0;
            } else {
                current = index;
            }

            slides.forEach(function (slide, idx) {
                slide.classList.toggle('active', idx === current);
            });

            dots.forEach(function (dot, idx) {
                dot.classList.toggle('active', idx === current);
            });
        }

        function next() {
            goTo(current + 1);
        }

        function prev() {
            goTo(current - 1);
        }

        function stopTimer() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        function startTimer() {
            stopTimer();
            timer = setInterval(function () {
                if (!isPaused) {
                    next();
                }
            }, intervalDuration);
        }

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                var target = parseInt(dot.getAttribute('data-target'), 10);
                goTo(target);
                startTimer();
            });
        });

        root.addEventListener('mouseenter', function () {
            isPaused = true;
        });

        root.addEventListener('mouseleave', function () {
            isPaused = false;
        });

        var touchStartX = 0;
        var touchEndX = 0;

        root.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        root.addEventListener('touchend', function (e) {
            touchEndX = e.changedTouches[0].screenX;
            var diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 40) {
                if (diff > 0) {
                    next();
                } else {
                    prev();
                }
                startTimer();
            }
        }, { passive: true });

        startTimer();
    }

    function renderCarousel(config) {
        config = config || {};
        loadStyle();

        var type = pick(config.carousel_type, 'hero');
        var carouselId = randomId();
        var interval = parseInt(pick(config.auto_slide_interval, 7000), 10) || 0;
        var assetBase = detectAssetBase();

        var html = type === 'cards'
            ? buildCardsCarousel(config, carouselId, assetBase)
            : buildHeroCarousel(config, carouselId, assetBase);

        return { html: html, id: carouselId, type: type, interval: interval };
    }

    function mountCarousel(target, config, position) {
        var result = renderCarousel(config);
        target.insertAdjacentHTML(position || 'beforeend', result.html);
        if (result.type !== 'cards') {
            initSlider(result.id, result.interval);
        }
        return result.id;
    }

    window.renderCarousel = renderCarousel;
    window.mountCarousel = mountCarousel;

    function autoMount() {
        if (!currentScript || !currentScript.parentNode) {
            return;
        }
        mountCarousel(currentScript, {
            carousel_type: window.carousel_type,
            carousel_slides: window.carousel_slides,
            auto_slide_interval: window.auto_slide_interval,
            cards_h1: window.cards_h1,
            cards_h2: window.cards_h2,
            cards_data: window.cards_data
        }, 'beforebegin');
    }

    if (window.carousel_autorender !== false) {
        autoMount();
    }
})();