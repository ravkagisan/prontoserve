(function () {
    var projectLogos = [
        { name: "Dikantin Polije", img: "Assets/images/Foto-Project/foto1.png" },
        { name: "Dexagon", img: "Assets/images/Foto-Project/foto2.png" },
        { name: "Kopi Polije", img: "Assets/images/Foto-Project/foto3.png" },
        { name: "CDC Polije", img: "Assets/images/Foto-Project/foto4.png" },
        { name: "Snavdav 2024", img: "Assets/images/Foto-Project/foto5.png" }
    ];

    var mitraLogos = [
        { name: "SD Al Furqan Jember", img: "Assets/images/Foto-Mitra/foto1.png" },
        { name: "Yayasan Nurul Chotib", img: "Assets/images/Foto-Mitra/foto2.png" },
        { name: "Esolusindo", img: "Assets/images/Foto-Mitra/foto3.png" }
    ];

    var defaultSpacing = {
        sectionPadding: "clamp(24px, 3vw, 40px) 0",
        titleMarginBottom: "clamp(18px, 2.2vw, 28px)",
        gap: "clamp(36px, 5vw, 80px)",
        itemHeight: "clamp(46px, 5vw, 72px)",
        maxImgWidth: "clamp(110px, 12vw, 160px)",
        titleSize: "clamp(19px, 2vw, 25px)",
        pixelsPerSecond: 55,
        tabletGap: "56px",
        tabletItemHeight: "60px",
        tabletMaxImgWidth: "135px",
        tabletTitleSize: "22px",
        mobileGap: "36px",
        mobileItemHeight: "46px",
        mobileMaxImgWidth: "110px",
        mobileTitleSize: "19px"
    };

    function injectMarqueeStyles() {
        var styleId = "jti-marquee-style";
        if (document.getElementById(styleId)) return;

        var css =
            ".logo-marquee-section {" +
                "width: 100%;" +
                "padding: var(--marquee-section-padding, clamp(24px, 3vw, 40px) 0);" +
                "text-align: center;" +
                "overflow: hidden;" +
                "background: transparent;" +
                "box-sizing: border-box;" +
            "}" +
            ".logo-marquee__title {" +
                "font-size: var(--marquee-title-size, clamp(19px, 2vw, 25px));" +
                "font-weight: 700;" +
                "color: var(--brand-primary);" +
                "margin: 0 0 var(--marquee-title-mb, clamp(18px, 2.2vw, 28px));" +
                "padding: 0 16px;" +
                "line-height: 1.25;" +
            "}" +
            ".logo-marquee__wrapper {" +
                "position: relative;" +
                "width: 100%;" +
                "overflow: hidden;" +
                "display: flex;" +
                "-webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);" +
                "mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);" +
            "}" +
            ".logo-marquee__track," +
            ".logo-marquee__wrapper:hover .logo-marquee__track," +
            ".logo-marquee__wrapper:active .logo-marquee__track," +
            ".logo-marquee__item:hover ~ .logo-marquee__track {" +
                "animation-play-state: running !important;" +
            "}" +
            ".logo-marquee__track {" +
                "display: flex;" +
                "align-items: center;" +
                "width: max-content;" +
                "gap: var(--marquee-gap, 72px);" +
                "animation: marqueeScrollLeft var(--marquee-speed, 20s) linear infinite;" +
                "animation-play-state: running !important;" +
                "will-change: transform;" +
                "-webkit-backface-visibility: hidden;" +
                "backface-visibility: hidden;" +
            "}" +
            ".logo-marquee__track--reverse {" +
                "animation: marqueeScrollRight var(--marquee-speed, 20s) linear infinite;" +
                "animation-play-state: running !important;" +
            "}" +
            ".logo-marquee__item {" +
                "flex-shrink: 0;" +
                "display: flex;" +
                "align-items: center;" +
                "justify-content: center;" +
                "height: var(--marquee-item-height, 70px);" +
                "cursor: pointer;" +
                "user-select: none;" +
                "-webkit-tap-highlight-color: transparent;" +
            "}" +
            ".logo-marquee__img {" +
                "max-height: 100%;" +
                "max-width: var(--marquee-img-max-width, 155px);" +
                "width: auto;" +
                "height: auto;" +
                "object-fit: contain;" +
                "filter: grayscale(100%);" +
                "opacity: 0.55;" +
                "transition: filter 0.25s ease, opacity 0.25s ease, transform 0.25s ease;" +
            "}" +
            ".logo-marquee__item:hover .logo-marquee__img," +
            ".logo-marquee__item:active .logo-marquee__img," +
            ".logo-marquee__img:hover," +
            ".logo-marquee__img:active {" +
                "filter: grayscale(0%);" +
                "opacity: 1;" +
                "transform: scale(1.06);" +
            "}" +
            "@keyframes marqueeScrollLeft {" +
                "0% { transform: translate3d(0, 0, 0); }" +
                "100% { transform: translate3d(-50%, 0, 0); }" +
            "}" +
            "@keyframes marqueeScrollRight {" +
                "0% { transform: translate3d(-50%, 0, 0); }" +
                "100% { transform: translate3d(0, 0, 0); }" +
            "}" +
            "@media (max-width: 1440px) {" +
                ".logo-marquee__track {" +
                    "gap: var(--marquee-gap, 64px);" +
                "}" +
            "}" +
            "@media (max-width: 1024px) {" +
                ".logo-marquee__wrapper {" +
                    "-webkit-mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);" +
                    "mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);" +
                "}" +
                ".logo-marquee__track {" +
                    "gap: var(--marquee-tablet-gap, 56px);" +
                "}" +
                ".logo-marquee__item {" +
                    "height: var(--marquee-tablet-item-height, 60px);" +
                "}" +
                ".logo-marquee__img {" +
                    "max-width: var(--marquee-tablet-img-max-width, 135px);" +
                "}" +
                ".logo-marquee__title {" +
                    "font-size: var(--marquee-tablet-title-size, 22px);" +
                "}" +
            "}" +
            "@media (max-width: 768px) {" +
                ".logo-marquee__wrapper {" +
                    "-webkit-mask-image: linear-gradient(to right, transparent, black 4%, black 96%, transparent);" +
                    "mask-image: linear-gradient(to right, transparent, black 4%, black 96%, transparent);" +
                "}" +
                ".logo-marquee__track {" +
                    "gap: var(--marquee-mobile-gap, 36px);" +
                "}" +
                ".logo-marquee__item {" +
                    "height: var(--marquee-mobile-item-height, 46px);" +
                "}" +
                ".logo-marquee__img {" +
                    "max-width: var(--marquee-mobile-img-max-width, 110px);" +
                "}" +
                ".logo-marquee__title {" +
                    "font-size: var(--marquee-mobile-title-size, 19px);" +
                "}" +
            "}";

        var styleEl = document.createElement("style");
        styleEl.id = styleId;
        styleEl.textContent = css;
        document.head.appendChild(styleEl);
    }

    function getBaseUrl() {
        if (typeof window.base_url === "string" && window.base_url !== "") {
            return window.base_url.replace(/\/+$/, "");
        }
        return "..";
    }

    function buildImgUrl(imgPath) {
        if (!imgPath) return "";
        if (/^(https?:\/\/|\/|\.\.\/)/.test(imgPath)) {
            return imgPath;
        }
        return getBaseUrl() + "/" + imgPath.replace(/^\/+/, "");
    }

    function syncTrackSpeed(container, track, pixelsPerSecond) {
        if (!container || !track) return;
        var halfTrackWidth = track.scrollWidth / 2;
        if (halfTrackWidth > 0 && pixelsPerSecond > 0) {
            var duration = (halfTrackWidth / pixelsPerSecond).toFixed(2) + "s";
            container.style.setProperty("--marquee-speed", duration);
        }
    }

    function mountMarquee(containerId, titleText, items, options) {
        injectMarqueeStyles();

        var opts = options || {};
        var container = document.getElementById(containerId);
        if (!container) return;

        var pps = Number(container.dataset.pixelsPerSecond || opts.pixelsPerSecond || defaultSpacing.pixelsPerSecond);

        var cfg = {
            sectionPadding: container.dataset.sectionPadding || opts.sectionPadding || defaultSpacing.sectionPadding,
            titleMarginBottom: container.dataset.titleMarginBottom || opts.titleMarginBottom || defaultSpacing.titleMarginBottom,
            gap: container.dataset.gap || opts.gap || defaultSpacing.gap,
            itemHeight: container.dataset.itemHeight || opts.itemHeight || defaultSpacing.itemHeight,
            maxImgWidth: container.dataset.maxImgWidth || opts.maxImgWidth || defaultSpacing.maxImgWidth,
            titleSize: container.dataset.titleSize || opts.titleSize || defaultSpacing.titleSize,
            tabletGap: container.dataset.tabletGap || opts.tabletGap || defaultSpacing.tabletGap,
            tabletItemHeight: container.dataset.tabletItemHeight || opts.tabletItemHeight || defaultSpacing.tabletItemHeight,
            tabletMaxImgWidth: container.dataset.tabletMaxImgWidth || opts.tabletMaxImgWidth || defaultSpacing.tabletMaxImgWidth,
            tabletTitleSize: container.dataset.tabletTitleSize || opts.tabletTitleSize || defaultSpacing.tabletTitleSize,
            mobileGap: container.dataset.mobileGap || opts.mobileGap || defaultSpacing.mobileGap,
            mobileItemHeight: container.dataset.mobileItemHeight || opts.mobileItemHeight || defaultSpacing.mobileItemHeight,
            mobileMaxImgWidth: container.dataset.mobileMaxImgWidth || opts.mobileMaxImgWidth || defaultSpacing.mobileMaxImgWidth,
            mobileTitleSize: container.dataset.mobileTitleSize || opts.mobileTitleSize || defaultSpacing.mobileTitleSize,
            reverse: Boolean(opts.reverse)
        };

        container.style.setProperty("--marquee-section-padding", cfg.sectionPadding);
        container.style.setProperty("--marquee-title-mb", cfg.titleMarginBottom);
        container.style.setProperty("--marquee-gap", cfg.gap);
        container.style.setProperty("--marquee-item-height", cfg.itemHeight);
        container.style.setProperty("--marquee-img-max-width", cfg.maxImgWidth);
        container.style.setProperty("--marquee-title-size", cfg.titleSize);
        container.style.setProperty("--marquee-tablet-gap", cfg.tabletGap);
        container.style.setProperty("--marquee-tablet-item-height", cfg.tabletItemHeight);
        container.style.setProperty("--marquee-tablet-img-max-width", cfg.tabletMaxImgWidth);
        container.style.setProperty("--marquee-tablet-title-size", cfg.tabletTitleSize);
        container.style.setProperty("--marquee-mobile-gap", cfg.mobileGap);
        container.style.setProperty("--marquee-mobile-item-height", cfg.mobileItemHeight);
        container.style.setProperty("--marquee-mobile-img-max-width", cfg.mobileMaxImgWidth);
        container.style.setProperty("--marquee-mobile-title-size", cfg.mobileTitleSize);

        var trackId = containerId + "Track";
        var reverseClass = cfg.reverse ? " logo-marquee__track--reverse" : "";

        container.innerHTML =
            '<section class="logo-marquee-section">' +
                '<h2 class="logo-marquee__title">' + titleText + '</h2>' +
                '<div class="logo-marquee__wrapper">' +
                    '<div class="logo-marquee__track' + reverseClass + '" id="' + trackId + '"></div>' +
                '</div>' +
            '</section>';

        var marqueeTrack = document.getElementById(trackId);
        if (marqueeTrack) {
            var repeatCount = items.length <= 3 ? 6 : 4;
            var marqueeHtml = "";
            for (var loop = 0; loop < repeatCount; loop++) {
                for (var t = 0; t < items.length; t++) {
                    var item = items[t];
                    marqueeHtml +=
                        '<div class="logo-marquee__item"' + (loop > 0 ? ' aria-hidden="true"' : '') + '>' +
                            '<img src="' + buildImgUrl(item.img) + '" alt="' + item.name + '" class="logo-marquee__img">' +
                        '</div>';
                }
            }
            marqueeTrack.innerHTML = marqueeHtml;

            var recalc = function () {
                syncTrackSpeed(container, marqueeTrack, pps);
            };

            var imgs = marqueeTrack.querySelectorAll("img");
            for (var i = 0; i < imgs.length; i++) {
                if (!imgs[i].complete) {
                    imgs[i].addEventListener("load", recalc);
                }
            }
            recalc();
            window.addEventListener("resize", recalc);
        }
    }

    function initAllMarquees() {
        injectMarqueeStyles();

        mountMarquee("projectMarqueeContainer", "Project Kami", projectLogos, {
            reverse: false,
            pixelsPerSecond: 55,
            sectionPadding: "clamp(24px, 3vw, 36px) 0 12px",
            titleMarginBottom: "clamp(18px, 2.2vw, 26px)",
            gap: "76px"
        });

        mountMarquee("mitraMarqueeContainer", "Mitra Kami", mitraLogos, {
            reverse: false,
            pixelsPerSecond: 55,
            sectionPadding: "clamp(24px, 3vw, 36px) 0 16px",
            titleMarginBottom: "clamp(18px, 2.2vw, 26px)",
            gap: "76px"
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initAllMarquees);
    } else {
        initAllMarquees();
    }

    window.JtiMarquee = {
        mount: mountMarquee,
        refresh: initAllMarquees,
        projectLogos: projectLogos,
        mitraLogos: mitraLogos,
        defaultSpacing: defaultSpacing
    };
})();