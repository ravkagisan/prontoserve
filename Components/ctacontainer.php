<?php
/**
 * CTA Container Component — ctacontainer.php
 * ============================================
 * A reusable Call-To-Action banner strip.
 *
 * Usage (include-based):
 * ----------------------
 *   $cta_title      = 'Ingin berkolaborasi dengan JTI NOVA?';
 *   $cta_subtitle   = 'Sampaikan kebutuhan Anda dan tim kami akan segera menghubungi.';
 *   $cta_btn_text   = 'Hubungi Kami';
 *   $cta_btn_href   = '/contact';
 *   $cta_btn_variant = 'outline-white';   // optional, default: outline-white
 *   $cta_variant    = 'dark';             // 'dark' (default) | 'light' | 'teal'
 *   $cta_id         = 'cta-home';        // optional HTML id
 *   require_once 'Components/ctacontainer.php';
 *
 * Function-based:
 * ---------------
 *   echo render_cta([
 *       'title'       => 'Ingin berkolaborasi dengan JTI NOVA?',
 *       'subtitle'    => 'Sampaikan kebutuhan Anda dan tim kami akan segera menghubungi.',
 *       'btn_text'    => 'Hubungi Kami',
 *       'btn_href'    => '/contact',
 *       'btn_variant' => 'outline-white',
 *       'variant'     => 'dark',
 *       'id'          => 'cta-home',
 *   ]);
 */

// ── Dependencies ─────────────────────────────────────────────────────────────
if (!function_exists('render_button')) {
    require_once __DIR__ . '/button.php';
}

// ── Base URL (for link normalization, mirrors other components) ───────────────
if (!isset($base_url)) {
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    if (preg_match('#^(.*?)/(Pages|api|Components)#', $script_name, $matches)) {
        $base_url = $matches[1];
    } else {
        $base_url = rtrim(dirname($script_name), '/\\');
        if ($base_url === '/' || $base_url === '\\') {
            $base_url = '';
        }
    }
}

// ── render_cta() ─────────────────────────────────────────────────────────────
if (!function_exists('render_cta')) {
    function render_cta(array $options = []): string
    {
        $title       = $options['title']       ?? 'Ingin berkolaborasi dengan kami?';
        $subtitle    = $options['subtitle']    ?? 'Sampaikan kebutuhan Anda dan tim kami akan segera menghubungi.';
        $btn_text    = $options['btn_text']    ?? 'Hubungi Kami';
        $btn_href    = $options['btn_href']    ?? '#';
        $btn_variant = $options['btn_variant'] ?? 'outline-white';
        $btn_size    = $options['btn_size']    ?? 'md';
        $btn_icon    = $options['btn_icon']    ?? null;
        $variant     = $options['variant']     ?? 'dark';   // dark | light | teal
        $id_attr     = $options['id']          ? ' id="' . htmlspecialchars($options['id']) . '"' : '';
        $extra_class = $options['class']       ?? '';

        $button_html = render_button([
            'variant'  => $btn_variant,
            'text'     => $btn_text,
            'href'     => $btn_href,
            'size'     => $btn_size,
            'icon'     => $btn_icon,
            'class'    => 'cta-btn',
        ]);

        return '
<section class="cta-section cta-variant-' . htmlspecialchars($variant) . ($extra_class ? ' ' . htmlspecialchars($extra_class) : '') . '"' . $id_attr . '>
    <div class="container cta-inner">
        <div class="cta-text">
            <p class="cta-title">' . htmlspecialchars($title) . '</p>
            ' . ($subtitle ? '<p class="cta-subtitle">' . htmlspecialchars($subtitle) . '</p>' : '') . '
        </div>
        <div class="cta-action">
            ' . $button_html . '
        </div>
    </div>
</section>';
    }
}

// ── Inline CSS (loaded once) ──────────────────────────────────────────────────
if (!defined('PRONTOSERVE_CTA_CSS_LOADED')):
define('PRONTOSERVE_CTA_CSS_LOADED', true);
?>
<style>
/* ── CTA Section ── */
.cta-section {
    width: 100%;
    padding: 28px 0;
    box-sizing: border-box;
}

/* Variant: dark (default — deep navy, matches reference) */
.cta-variant-dark {
    background-color: var(--brand-primary);
}

/* Variant: light (soft off-white background) */
.cta-variant-light {
    background-color: var(--bg-soft);
}

/* Variant: teal */
.cta-variant-teal {
    background-color: var(--brand-teal);
}

/* ── Inner layout: text left, button right ── */
.cta-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-24);
    flex-wrap: nowrap;
}

/* ── Text block ── */
.cta-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1 1 auto;
    min-width: 0;
}

.cta-title {
    font-family: 'Inter', sans-serif;
    font-size: 17px;
    font-weight: 700;
    line-height: 1.4;
    margin: 0;
    white-space: normal;
}

.cta-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: 13.5px;
    font-weight: 400;
    line-height: 1.5;
    margin: 0;
    opacity: 0.82;
}

/* Dark variant text colours */
.cta-variant-dark .cta-title,
.cta-variant-dark .cta-subtitle {
    color: var(--bg-white);
}

/* Light variant text colours */
.cta-variant-light .cta-title {
    color: var(--brand-primary);
}
.cta-variant-light .cta-subtitle {
    color: var(--text-secondary);
}

/* Teal variant text colours */
.cta-variant-teal .cta-title,
.cta-variant-teal .cta-subtitle {
    color: var(--brand-primary);
}

/* ── Button wrapper ── */
.cta-action {
    flex-shrink: 0;
}

/* Light variant: override btn outline-white to outline-primary */
.cta-variant-light .cta-btn.btn-outline-white,
.cta-variant-teal  .cta-btn.btn-outline-white {
    color: var(--brand-primary);
    border-color: var(--brand-primary);
}

.cta-variant-light .cta-btn.btn-outline-white:hover,
.cta-variant-teal  .cta-btn.btn-outline-white:hover {
    background-color: var(--brand-primary);
    color: var(--bg-white);
}

/* ── Responsive: stack on small screens ── */
@media (max-width: 640px) {
    .cta-inner {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-16);
    }

    .cta-title {
        font-size: 15px;
    }

    .cta-subtitle {
        font-size: 13px;
    }
}
</style>
<?php endif; ?>

<?php
// ── Include-based usage (when variables are set directly) ─────────────────────
if (isset($cta_title) || isset($cta_subtitle) || isset($cta_btn_text)) {
    echo render_cta([
        'title'       => $cta_title       ?? 'Ingin berkolaborasi dengan kami?',
        'subtitle'    => $cta_subtitle    ?? '',
        'btn_text'    => $cta_btn_text    ?? 'Hubungi Kami',
        'btn_href'    => $cta_btn_href    ?? '#',
        'btn_variant' => $cta_btn_variant ?? 'outline-white',
        'btn_size'    => $cta_btn_size    ?? 'md',
        'btn_icon'    => $cta_btn_icon    ?? null,
        'variant'     => $cta_variant     ?? 'dark',
        'id'          => $cta_id          ?? null,
        'class'       => $cta_class       ?? '',
    ]);
}
