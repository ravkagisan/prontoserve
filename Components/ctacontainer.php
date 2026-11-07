<?php
if (!isset($current_page)) {
    $current_page = 'tentang-kami';
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

if (!function_exists('render_cta')) {
    function render_cta(array $options = []): string
    {
        global $base_url;

        $title       = $options['title']       ?? 'Ingin berkolaborasi dengan kami?';
        $subtitle    = $options['subtitle']    ?? 'Sampaikan kebutuhan Anda dan tim kami akan segera menghubungi.';
        $btn_text    = $options['btn_text']    ?? 'Hubungi Kami';
        $btn_href    = $options['btn_href']    ?? '#';
        $variant     = $options['variant']     ?? 'dark';
        $id_attr     = !empty($options['id']) ? ' id="' . htmlspecialchars($options['id']) . '"' : '';
        $extra_class = $options['class']       ?? '';

        if ($btn_href !== null && strpos($btn_href, 'http') !== 0 && strpos($btn_href, '#') !== 0 && strpos($btn_href, 'javascript:') !== 0 && strpos($btn_href, 'mailto:') !== 0 && strpos($btn_href, 'tel:') !== 0) {
            $clean_path = ltrim($btn_href, '/');
            if (isset($base_url) && $base_url !== '') {
                if (strpos($btn_href, $base_url) !== 0) {
                    $btn_href = rtrim($base_url, '/') . '/' . $clean_path;
                }
            } else {
                $btn_href = '/' . $clean_path;
            }
        }

        ob_start();
        ?>
        <section class="cta-section cta-variant-<?= htmlspecialchars($variant) ?><?= $extra_class ? ' ' . htmlspecialchars($extra_class) : '' ?>"<?= $id_attr ?>>
            <div class="cta-container">
                <div class="cta-inner">
                    <div class="cta-text">
                        <h2 class="cta-title"><?= htmlspecialchars($title) ?></h2>
                        <?php if ($subtitle): ?>
                            <p class="cta-subtitle"><?= htmlspecialchars($subtitle) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="cta-action">
                        <a href="<?= htmlspecialchars($btn_href) ?>" class="cta-blob-btn" aria-label="<?= htmlspecialchars($btn_text) ?>">
                            <span class="cta-blob-btn__text"><?= htmlspecialchars($btn_text) ?></span>
                            <span class="cta-blob-btn__inner">
                                <span class="cta-blob-btn__blobs">
                                    <span class="cta-blob-btn__blob"></span>
                                    <span class="cta-blob-btn__blob"></span>
                                    <span class="cta-blob-btn__blob"></span>
                                    <span class="cta-blob-btn__blob"></span>
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0; position: absolute;" aria-hidden="true">
                <defs>
                    <filter id="cta-goo">
                        <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
                        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></feColorMatrix>
                        <feComposite in2="goo" in="SourceGraphic" result="mix"></feComposite>
                    </filter>
                </defs>
            </svg>
        </section>
        <?php
        return ob_get_clean();
    }
}

if (!defined('PRONTOSERVE_CTA_CSS_LOADED')):
define('PRONTOSERVE_CTA_CSS_LOADED', true);
?>
<style>
.cta-section {
    width: 100%;
    margin: 0;
    padding: var(--space-48) 0;
    box-sizing: border-box;
    display: block;
    position: relative;
    border-bottom: none;
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

/* ── Blob Button Interaction ── */
.cta-blob-btn {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 13px 36px;
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    background: transparent;
    border: none;
    outline: none;
    border-radius: var(--radius-pill);
    box-sizing: border-box;
    transition: color 0.4s ease, transform 0.2s ease, box-shadow 0.3s ease;
    user-select: none;
    white-space: nowrap;
}

.cta-variant-dark .cta-blob-btn {
    color: var(--brand-primary);
}

.cta-variant-dark .cta-blob-btn:hover {
    color: var(--bg-white);
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.3);
}

.cta-variant-dark .cta-blob-btn:active {
    transform: translateY(0);
}

.cta-variant-dark .cta-blob-btn::before {
    content: "";
    position: absolute;
    inset: 0;
    border: 2px solid var(--bg-white);
    border-radius: var(--radius-pill);
    z-index: 1;
    pointer-events: none;
    transition: border-color 0.3s ease;
}

.cta-variant-dark .cta-blob-btn:hover::before {
    border-color: rgba(255, 255, 255, 0.95);
}

.cta-blob-btn__text {
    position: relative;
    z-index: 2;
    display: inline-block;
    letter-spacing: 0.2px;
}

.cta-blob-btn__inner {
    position: absolute;
    inset: 0;
    overflow: hidden;
    border-radius: var(--radius-pill);
    background-color: var(--bg-white);
    z-index: -1;
}

.cta-blob-btn__blobs {
    position: relative;
    display: block;
    height: 100%;
    filter: url('#cta-goo');
}

.cta-blob-btn__blob {
    position: absolute;
    top: 2px;
    width: 25%;
    height: 100%;
    background-color: #162c48;
    border-radius: 100%;
    transform: translate3d(0, 150%, 0) scale(1.7);
    transition: transform 0.45s ease;
}

@supports(filter: url('#cta-goo')) {
    .cta-blob-btn__blob {
        transform: translate3d(0, 150%, 0) scale(1.4);
    }
}

.cta-blob-btn__blob:nth-child(1) {
    left: 0%;
    transition-delay: 0s;
}

.cta-blob-btn__blob:nth-child(2) {
    left: 30%;
    transition-delay: 0.08s;
}

.cta-blob-btn__blob:nth-child(3) {
    left: 60%;
    transition-delay: 0.16s;
}

.cta-blob-btn__blob:nth-child(4) {
    left: 90%;
    transition-delay: 0.24s;
}

.cta-blob-btn:hover .cta-blob-btn__blob {
    transform: translateZ(0) scale(1.7);
}

@supports(filter: url('#cta-goo')) {
    .cta-blob-btn:hover .cta-blob-btn__blob {
        transform: translateZ(0) scale(1.4);
    }
}

/* ── Light Variant ── */
.cta-variant-light .cta-blob-btn {
    color: var(--bg-white);
}

.cta-variant-light .cta-blob-btn:hover {
    color: var(--bg-white);
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(30, 58, 95, 0.2);
}

.cta-variant-light .cta-blob-btn::before {
    content: "";
    position: absolute;
    inset: 0;
    border: 2px solid var(--brand-primary);
    border-radius: var(--radius-pill);
    z-index: 1;
    pointer-events: none;
}

.cta-variant-light .cta-blob-btn__inner {
    background-color: var(--brand-primary);
}

.cta-variant-light .cta-blob-btn__blob {
    background-color: #162c48;
}

/* ── Seamless Connection to Footer ── */
.cta-section + .site-footer {
    margin-top: 0 !important;
}

/* ── Responsive Mobile ── */
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

    .cta-blob-btn {
        width: 100%;
        text-align: center;
        padding: 14px 28px;
    }
}
</style>
<?php endif; ?>

<?php
if (isset($cta_title) || isset($cta_subtitle) || isset($cta_btn_text)) {
    echo render_cta([
        'title'       => $cta_title       ?? 'Ingin berkolaborasi dengan kami?',
        'subtitle'    => $cta_subtitle    ?? '',
        'btn_text'    => $cta_btn_text    ?? 'Hubungi Kami',
        'btn_href'    => $cta_btn_href    ?? '#',
        'variant'     => $cta_variant     ?? 'dark',
        'id'          => $cta_id          ?? null,
        'class'       => $cta_class       ?? '',
    ]);
}
