<?php
require_once __DIR__ . '/button.php';

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

        // Map CTA variant to button variant for optimal contrast
        $btn_variant = ($variant === 'dark') ? 'white' : 'primary';

        $action_button = render_button([
            'text'    => $btn_text,
            'href'    => $btn_href,
            'variant' => $btn_variant,
            'size'    => 'md',
            'class'   => 'cta-action-btn'
        ]);

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
                        <?= $action_button ?>
                    </div>
                </div>
            </div>
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

    .cta-action .blob-btn {
        width: 100%;
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
