<?php
include_once __DIR__ . '/button.php';

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

$asset_base = '';
if (file_exists('Assets/images/dummy.jpg')) {
    $asset_base = 'Assets/images/';
} elseif (file_exists('../Assets/images/dummy.jpg')) {
    $asset_base = '../Assets/images/';
} elseif (file_exists('../../Assets/images/dummy.jpg')) {
    $asset_base = '../../Assets/images/';
} else {
    $asset_base = (isset($base_url) && $base_url !== '' ? rtrim($base_url, '/') . '/' : '/') . 'Assets/images/';
}

$default_placeholder_image = $asset_base . 'dummy.jpg';

if (!function_exists('render_card')) {
    function render_card($options = []) {
        global $base_url, $default_placeholder_image, $asset_base;

        $variant       = $options['variant'] ?? 'service';
        $title         = $options['title'] ?? '';
        $subtitle      = $options['subtitle'] ?? '';
        $description   = $options['description'] ?? '';
        $category      = $options['category'] ?? '';
        $extra_info    = $options['extra_info'] ?? null;
        $button_config = $options['button_config'] ?? null;
        $social_links  = $options['social_links'] ?? null;
        $href          = $options['href'] ?? null;
        $extra_class   = $options['class'] ?? '';
        $id            = $options['id'] ?? null;
        $attributes    = $options['attributes'] ?? '';
        $gradient      = $options['gradient'] ?? null;
        $icon          = $options['icon'] ?? null;

        $image = !empty($options['image']) ? $options['image'] : $default_placeholder_image;
        if (!filter_var($image, FILTER_VALIDATE_URL) && !file_exists($image)) {
            if (file_exists($asset_base . ltrim($image, '/'))) {
                $image = $asset_base . ltrim($image, '/');
            }
        }

        $id_attr = $id ? 'id="' . htmlspecialchars($id) . '"' : '';

        // Kartu "team" bisa diklik penuh jika punya href
        $is_clickable = $href && in_array($variant, ['team'], true);
        $card_classes = 'card custom-card card-' . htmlspecialchars($variant)
            . ($is_clickable ? ' custom-card-clickable' : '')
            . ($extra_class ? ' ' . htmlspecialchars($extra_class) : '');

        ob_start();
        ?>
        <?php if ($variant === 'team' && $href): ?>
            <a href="<?= htmlspecialchars($href) ?>" class="<?= $card_classes ?>" <?= $id_attr ?> <?= $attributes ?>>
                <div class="card-inner card-inner-team">
                    <div class="card-img-portrait-wrap">
                        <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>" class="card-img">
                    </div>
                    <div class="card-body card-body-center">
                        <h3 class="card-title"><?= htmlspecialchars($title) ?></h3>
                        <p class="card-subtitle"><?= htmlspecialchars($subtitle ?: $description) ?></p>
                        <div class="card-social-dots">
                            <?php if (!empty($social_links) && is_array($social_links)): ?>
                                <?php foreach ($social_links as $item): ?>
                                    <span class="social-dot" aria-hidden="true">
                                        <?= !empty($item['icon']) ? $item['icon'] : '' ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="social-dot"></span>
                                <span class="social-dot"></span>
                                <span class="social-dot"></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </a>

        <?php else: ?>
            <div class="<?= $card_classes ?>" <?= $id_attr ?> <?= $attributes ?>>
                <?php if ($variant === 'project'): ?>
                    <div class="card-img-top-wrap" <?= $gradient ? 'style="background: ' . htmlspecialchars($gradient) . ';"' : '' ?>>
                        <?php if ($icon): ?>
                            <div class="card-img-placeholder-icon">
                                <?= $icon ?>
                            </div>
                        <?php else: ?>
                            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>" class="card-img-top">
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if ($category): ?>
                            <div class="card-badge-wrap">
                                <span class="btn btn-badge"><?= htmlspecialchars($category) ?></span>
                            </div>
                        <?php endif; ?>
                        <h3 class="card-title">
                            <?php if ($href): ?>
                                <a href="<?= htmlspecialchars($href) ?>" class="card-title-link"><?= htmlspecialchars($title) ?></a>
                            <?php else: ?>
                                <?= htmlspecialchars($title) ?>
                            <?php endif; ?>
                        </h3>
                        <?php if ($description): ?>
                            <p class="card-desc"><?= htmlspecialchars($description) ?></p>
                        <?php endif; ?>
                        <div class="card-action">
                            <?php
                            $btn_params = is_array($button_config) ? $button_config : [
                                'variant' => 'primary',
                                'text'    => 'Lihat Detail',
                                'href'    => $href ?? '#',
                                'size'    => 'sm'
                            ];
                            if (!isset($btn_params['size'])) {
                                $btn_params['size'] = 'sm';
                            }
                            if (!isset($btn_params['variant'])) {
                                $btn_params['variant'] = 'primary';
                            }
                            echo render_button($btn_params);
                            ?>
                        </div>
                    </div>

                <?php elseif ($variant === 'training'): ?>
                    <div class="card-inner">
                        <div class="card-img-inset-wrap card-img-training">
                            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>" class="card-img">
                        </div>
                        <div class="card-body">
                            <?php if ($category): ?>
                                <div class="card-badge-wrap">
                                    <span class="btn btn-badge"><?= htmlspecialchars($category) ?></span>
                                </div>
                            <?php endif; ?>
                            <h3 class="card-title">
                                <?php if ($href): ?>
                                    <a href="<?= htmlspecialchars($href) ?>" class="card-title-link"><?= htmlspecialchars($title) ?></a>
                                <?php else: ?>
                                    <?= htmlspecialchars($title) ?>
                                <?php endif; ?>
                            </h3>
                            <?php if ($description): ?>
                                <p class="card-desc"><?= htmlspecialchars($description) ?></p>
                            <?php endif; ?>
                            <?php if ($extra_info): ?>
                                <div class="card-extra-info">
                                    <span class="card-extra-icon">📅</span>
                                    <span><?= htmlspecialchars(is_array($extra_info) ? implode(' · ', $extra_info) : $extra_info) ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="card-action">
                                <?php
                                $btn_params = is_array($button_config) ? $button_config : [
                                    'variant' => 'primary',
                                    'text'    => 'Lihat Silabus',
                                    'href'    => $href ?? 'Pages/HubungiKami/index.php',
                                    'size'    => 'sm'
                                ];
                                if (!isset($btn_params['size'])) {
                                    $btn_params['size'] = 'sm';
                                }
                                if (!isset($btn_params['variant'])) {
                                    $btn_params['variant'] = 'primary';
                                }
                                echo render_button($btn_params);
                                ?>
                            </div>
                        </div>
                    </div>

                <?php elseif ($variant === 'team'): ?>
                    <div class="card-inner card-inner-team">
                        <div class="card-img-portrait-wrap">
                            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>" class="card-img">
                        </div>
                        <div class="card-body card-body-center">
                            <h3 class="card-title"><?= htmlspecialchars($title) ?></h3>
                            <p class="card-subtitle"><?= htmlspecialchars($subtitle ?: $description) ?></p>
                            <div class="card-social-dots">
                                <?php if (!empty($social_links) && is_array($social_links)): ?>
                                    <?php foreach ($social_links as $item): ?>
                                        <a href="<?= htmlspecialchars($item['url'] ?? '#') ?>" class="social-dot" aria-label="Social Link">
                                            <?= !empty($item['icon']) ? $item['icon'] : '' ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="social-dot"></span>
                                    <span class="social-dot"></span>
                                    <span class="social-dot"></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="card-inner">
                        <div class="card-img-inset-wrap card-img-service">
                            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>" class="card-img">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">
                                <?php if ($href): ?>
                                    <a href="<?= htmlspecialchars($href) ?>" class="card-title-link"><?= htmlspecialchars($title) ?></a>
                                <?php else: ?>
                                    <?= htmlspecialchars($title) ?>
                                <?php endif; ?>
                            </h3>
                            <?php if ($description): ?>
                                <p class="card-desc"><?= htmlspecialchars($description) ?></p>
                            <?php endif; ?>
                            <?php if ($extra_info): ?>
                                <div class="card-extra-info card-contact-info">
                                    <span><?= htmlspecialchars(is_array($extra_info) ? implode(' · ', $extra_info) : $extra_info) ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="card-action">
                                <?php
                                $btn_params = is_array($button_config) ? $button_config : [
                                    'variant' => 'primary',
                                    'text'    => 'Pelajari Selengkapnya',
                                    'href'    => $href ?? '#',
                                    'size'    => 'sm'
                                ];
                                if (!isset($btn_params['size'])) {
                                    $btn_params['size'] = 'sm';
                                }
                                if (!isset($btn_params['variant'])) {
                                    $btn_params['variant'] = 'primary';
                                }
                                echo render_button($btn_params);
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
        return ob_get_clean();
    }
}

if (!defined('PRONTOSERVE_CARD_CSS_LOADED')):
define('PRONTOSERVE_CARD_CSS_LOADED', true);
?>
<style>
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
</style>
<?php endif; ?>

<?php
if (isset($card_variant) || isset($card_title) || isset($variant) || isset($title)) {
    echo render_card([
        'variant' => $card_variant ?? ($variant ?? 'service'),
        'title' => $card_title ?? ($title ?? ''),
        'subtitle' => $card_subtitle ?? ($subtitle ?? ''),
        'description' => $card_description ?? ($description ?? ''),
        'image' => $card_image ?? ($image ?? null),
        'category' => $card_category ?? ($category ?? ''),
        'extra_info' => $card_extra_info ?? ($extra_info ?? null),
        'button_config' => $card_button_config ?? ($button_config ?? null),
        'social_links' => $card_social_links ?? ($social_links ?? null),
        'href' => $card_href ?? ($href ?? null),
        'class' => $card_class ?? ($class ?? ''),
        'id' => $card_id ?? ($id ?? null),
        'attributes' => $card_attributes ?? ($attributes ?? '')
    ]);
}
?>
