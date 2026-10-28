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

if (!function_exists('render_button')) {
    function render_button($options = []) {
        global $base_url;

        $variant = $options['variant'] ?? 'primary';
        $text = $options['text'] ?? '';
        $href = $options['href'] ?? null;
        $type = $options['type'] ?? 'button';
        $icon = $options['icon'] ?? null;
        $icon_position = $options['icon_position'] ?? 'left';
        $size = $options['size'] ?? 'md';
        $extra_class = $options['class'] ?? '';
        $id = $options['id'] ?? null;
        $attributes = $options['attributes'] ?? '';
        $disabled = !empty($options['disabled']);

        if ($href !== null && strpos($href, 'http') !== 0 && strpos($href, '#') !== 0 && strpos($href, 'javascript:') !== 0 && strpos($href, 'mailto:') !== 0 && strpos($href, 'tel:') !== 0) {
            $clean_path = ltrim($href, '/');
            if (isset($base_url) && $base_url !== '') {
                if (strpos($href, $base_url) !== 0) {
                    $href = rtrim($base_url, '/') . '/' . $clean_path;
                }
            } else {
                $href = '/' . $clean_path;
            }
        }

        $icons = [
            'search' => '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
            'arrow-right' => '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',
            'arrow-left' => '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>',
            'plus' => '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',
            'check' => '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>',
            'phone' => '<svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>'
        ];

        $rendered_icon = '';
        if ($icon) {
            $rendered_icon = $icons[$icon] ?? $icon;
        }

        if ($variant === 'search') {
            $placeholder = $options['placeholder'] ?? 'Cari proyek portofolio...';
            $btn_text = $options['button_text'] ?? ($text ?: 'Cari');
            $name = $options['name'] ?? 'q';
            $value = $options['value'] ?? '';
            $action = $options['action'] ?? null;
            $form_method = $options['method'] ?? 'GET';

            if ($action !== null && strpos($action, 'http') !== 0 && strpos($action, '#') !== 0) {
                $clean_action = ltrim($action, '/');
                if (isset($base_url) && $base_url !== '') {
                    if (strpos($action, $base_url) !== 0) {
                        $action = rtrim($base_url, '/') . '/' . $clean_action;
                    }
                } else {
                    $action = '/' . $clean_action;
                }
            }

            $input_group = '
            <div class="search-input-group ' . htmlspecialchars($extra_class) . '" ' . ($id ? 'id="' . htmlspecialchars($id) . '"' : '') . '>
                <span class="search-input-icon">' . $icons['search'] . '</span>
                <input type="text" 
                       name="' . htmlspecialchars($name) . '" 
                       value="' . htmlspecialchars($value) . '" 
                       placeholder="' . htmlspecialchars($placeholder) . '" 
                       class="search-input-field" ' . $attributes . '>
                <button type="submit" class="btn btn-primary btn-search-action">
                    ' . htmlspecialchars($btn_text) . '
                </button>
            </div>';

            if ($action !== null) {
                return '<form action="' . htmlspecialchars($action) . '" method="' . htmlspecialchars($form_method) . '" class="search-form-wrapper">' . $input_group . '</form>';
            }
            return $input_group;
        }

        $classes = ['btn', 'btn-' . $variant, 'btn-size-' . $size];
        if ($extra_class) {
            $classes[] = $extra_class;
        }
        if ($disabled) {
            $classes[] = 'btn-disabled';
        }
        $class_attr = implode(' ', array_filter($classes));

        $inner_content = '';
        if ($rendered_icon && $icon_position === 'left') {
            $inner_content .= $rendered_icon;
        }
        if ($text !== '') {
            $inner_content .= '<span class="btn-text">' . htmlspecialchars($text) . '</span>';
        }
        if ($rendered_icon && $icon_position === 'right') {
            $inner_content .= $rendered_icon;
        }

        $id_attr = $id ? 'id="' . htmlspecialchars($id) . '"' : '';

        if ($href !== null && !$disabled) {
            return '<a href="' . htmlspecialchars($href) . '" class="' . htmlspecialchars($class_attr) . '" ' . $id_attr . ' ' . $attributes . '>' . $inner_content . '</a>';
        }

        $disabled_attr = $disabled ? 'disabled' : '';
        return '<button type="' . htmlspecialchars($type) . '" class="' . htmlspecialchars($class_attr) . '" ' . $id_attr . ' ' . $disabled_attr . ' ' . $attributes . '>' . $inner_content . '</button>';
    }
}

if (!defined('PRONTOSERVE_BUTTON_CSS_LOADED')):
define('PRONTOSERVE_BUTTON_CSS_LOADED', true);
?>
<style>
.btn {
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-8);
    text-decoration: none;
    cursor: pointer;
    border: 1px solid transparent;
    border-radius: var(--radius-pill);
    transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
    white-space: nowrap;
    box-sizing: border-box;
    user-select: none;
}

.btn:active:not(.btn-disabled) {
    transform: translateY(1px);
}

.btn-size-sm {
    padding: 6px 14px;
    font-size: 12px;
}

.btn-size-md {
    padding: 10px 24px;
    font-size: 14px;
}

.btn-size-lg {
    padding: 14px 32px;
    font-size: 16px;
}

.btn-icon {
    width: 16px;
    height: 16px;
    stroke-width: var(--icon-stroke);
    stroke-linecap: round;
    stroke-linejoin: round;
    display: inline-block;
    flex-shrink: 0;
}

.btn-size-sm .btn-icon {
    width: 14px;
    height: 14px;
}

.btn-size-lg .btn-icon {
    width: 20px;
    height: 20px;
}

.btn-primary {
    background-color: var(--brand-primary);
    color: var(--bg-white);
    border-color: var(--brand-primary);
}

.btn-primary:hover:not(.btn-disabled) {
    background-color: #162c48;
    border-color: #162c48;
    color: var(--bg-white);
    box-shadow: 0 4px 12px rgba(30, 58, 95, 0.22);
}

.btn-outline {
    background-color: var(--bg-white);
    color: var(--brand-primary);
    border: 1.5px solid var(--brand-primary);
}

.btn-outline:hover:not(.btn-disabled) {
    background-color: var(--brand-primary);
    color: var(--bg-white);
    box-shadow: 0 4px 12px rgba(30, 58, 95, 0.18);
}

.btn-chip {
    background-color: var(--bg-white);
    color: var(--text-primary);
    border: 1px solid var(--border-default);
    font-weight: 500;
    padding: 8px 18px;
    font-size: 13px;
}

.btn-chip:hover:not(.btn-disabled) {
    background-color: var(--bg-soft);
    border-color: var(--brand-slate);
    color: var(--brand-primary);
}

.btn-chip-active {
    background-color: var(--brand-primary);
    color: var(--bg-white);
    border: 1px solid var(--brand-primary);
    font-weight: 600;
    padding: 8px 18px;
    font-size: 13px;
}

.btn-chip-active:hover:not(.btn-disabled) {
    background-color: #162c48;
    border-color: #162c48;
    color: var(--bg-white);
}

.btn-badge {
    background-color: var(--brand-slate);
    color: var(--bg-white);
    border: none;
    border-radius: var(--radius-badge);
    padding: 7px 14px;
    font-size: 13px;
    font-weight: 600;
}

.btn-badge:hover:not(.btn-disabled) {
    background-color: #4f677e;
    color: var(--bg-white);
}

.btn-secondary {
    background-color: var(--brand-slate);
    color: var(--bg-white);
    border-color: var(--brand-slate);
}

.btn-secondary:hover:not(.btn-disabled) {
    background-color: #4f677e;
    border-color: #4f677e;
    color: var(--bg-white);
}

.btn-teal {
    background-color: var(--brand-teal);
    color: var(--brand-primary);
    border-color: var(--brand-teal);
}

.btn-teal:hover:not(.btn-disabled) {
    background-color: #79aab0;
    border-color: #79aab0;
}

.btn-danger {
    background-color: var(--brand-red);
    color: var(--bg-white);
    border-color: var(--brand-red);
}

.btn-danger:hover:not(.btn-disabled) {
    background-color: #c41e22;
    border-color: #c41e22;
}

.btn-ghost {
    background-color: transparent;
    color: var(--brand-primary);
    border-color: transparent;
}

.btn-ghost:hover:not(.btn-disabled) {
    background-color: var(--bg-soft);
    color: var(--brand-primary);
}

.btn-disabled,
.btn:disabled {
    opacity: 0.55;
    cursor: not-allowed;
    pointer-events: none;
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
    border: 1px solid var(--border-default);
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
    padding: 8px 20px;
    font-size: 13px;
    flex-shrink: 0;
}
</style>
<?php endif; ?>

<?php
if (isset($btn_variant) || isset($btn_text) || isset($btn_href) || isset($btn_icon)) {
    echo render_button([
        'variant' => $btn_variant ?? 'primary',
        'text' => $btn_text ?? '',
        'href' => $btn_href ?? null,
        'type' => $btn_type ?? 'button',
        'icon' => $btn_icon ?? null,
        'icon_position' => $btn_icon_position ?? 'left',
        'size' => $btn_size ?? 'md',
        'class' => $btn_class ?? '',
        'id' => $btn_id ?? null,
        'attributes' => $btn_attributes ?? '',
        'disabled' => $btn_disabled ?? false,
        'placeholder' => $btn_placeholder ?? 'Cari proyek portofolio...',
        'button_text' => $btn_button_text ?? 'Cari',
        'name' => $btn_name ?? 'q',
        'value' => $btn_value ?? '',
        'action' => $btn_action ?? null
    ]);
}
?>
