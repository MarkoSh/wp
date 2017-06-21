<?php
/**
 * PHP vX.x Handlers.
 *
 * @since 160503 Reorganizing structure.
 *
 * @copyright WebSharks, Inc. <http://websharks-inc.com>
 * @license GNU General Public License, version 3
 */

/**
 * Back compat. function (rarely used).
 */
function wp_php_rv_custom_notice()
{
    wp_php_rv_notice(___wp_php_rv_notice_brand_name());
}

/**
 * Creates a WP Dashboard notice regarding PHP requirements.
 *
 * @param string $brand_name Name of the calling theme/plugin.
 */
function wp_php_rv_notice($brand_name = '')
{
    global $wp_php_rv;
    global $___wp_php_rv;
    global $wp_version;

    if (isset($wp_php_rv)) {
        ___wp_php_rv_initialize();
    }
    # Only in the admin area.

    if (!is_admin()) {
        return; // Not applicable.
    }
    # Establish the brand name.

    if (!($brand_name = (string) $brand_name)) {
        $brand_name = ___wp_php_rv_notice_brand_name();
    } // If brand name detection fails too, use generic.
    $brand_name = $brand_name ? $brand_name : __('This Software', 'wp-php-rv');

    # Current requirements/dependencies.

    $required_os             = $___wp_php_rv['os'];
    $php_min_version         = $___wp_php_rv['min'];
    $php_max_version         = $___wp_php_rv['max'];
    $php_minimum_bits        = $___wp_php_rv['bits'];
    $php_required_functions  = $___wp_php_rv['functions'];
    $php_required_extensions = $___wp_php_rv['extensions'];
    $wp_min_version          = $___wp_php_rv['wp']['min'];
    $wp_max_version          = $___wp_php_rv['wp']['max'];

    # Determine reason for dependency failure.

    if (!($issue = ___wp_php_rv_issue())) {
        return; // Nothing to do here.
    } // If there is no issue we can stop here.
    extract($issue); // `reason`, `php_missing_functions`, `php_missing_extensions`.

    # Fill-in additional variables needed down below.

    $action          = 'all_admin_notices';
    $action_priority = 10; // Default priority.

    $php_version = strpos(PHP_VERSION, '+') !== false
        ? strstr(PHP_VERSION, '+', true) : PHP_VERSION;
        // e.g., minus `+donate.sury.org~trusty+1`, etc.

    # Defined pre-styled icons needed below for markup generation.

    $arrow = '<span class="dashicons dashicons-editor-break" style="-webkit-transform:scale(-1, 1); transform:scale(-1, 1);"></span>';
    $icon  = '<span class="dashicons dashicons-admin-tools" style="display:inline-block; width:64px; height:64px; font-size:64px; float:left; margin:-5px 10px 0 -2px;"></span>';

    # This allows hooks to alter any variable by reference.

    foreach (array_keys(get_defined_vars()) as $___var_key) {
        $___refs[$___var_key] = &$$___var_key;
    } // Hooks can alter any variable by reference.

    do_action('wp_php_rv_notice_refs_before_markup', $___refs);
    unset($___refs, $___var_key); // Housekeeping.

    # Generate markup for the PHP dependency notice.

    switch ($reason) { // Based on reason.

        case 'os-incompatible': // OS incomaptible.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('Incompatible Operating System', 'wp-php-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires a %2$s operating system.', 'wp-php-rv'), esc_html($brand_name), esc_html(___wp_php_rv_os_name($required_os))).'<br />';
            $markup     .= sprintf(__('You\'re currently running %1$s, which is not supported by %2$s at this time.', 'wp-php-rv'), esc_html(PHP_OS), esc_html($brand_name)).'<br />';
            $markup     .= $arrow.' '.__('A compatible OS is necessary. <strong>Please contact your hosting company for assistance</strong>.', 'wp-php-rv').'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, change the OS or remove %1$s from WordPress.</em>', 'wp-php-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'php-needs-upgrade': // Upgrade to latest version of PHP.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('PHP Upgrade Required', 'wp-php-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires PHP v%2$s (or higher).', 'wp-php-rv'), esc_html($brand_name), esc_html($php_min_version)).'<br />';
            $markup     .= sprintf(__('You\'re currently running the older PHP v%1$s, which is not supported by %2$s.', 'wp-php-rv'), esc_html($php_version), esc_html($brand_name)).'<br />';
            $markup     .= $arrow.' '.__('An update is necessary. <strong>Please contact your hosting company for assistance</strong>.', 'wp-php-rv').'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, upgrade PHP or remove %1$s from WordPress.</em>', 'wp-php-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'php-needs-downgrade': // Downgrade to older version of PHP.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('PHP Downgrade Required', 'wp-php-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires an older version of PHP.', 'wp-php-rv'), esc_html($brand_name)).'<br />';
            $markup     .= sprintf(__('This software is compatible up to PHP v%1$s, but you\'re running the newer PHP v%2$s.', 'wp-php-rv'), esc_html($php_max_version), esc_html($php_version)).'<br />';
            $markup     .= $arrow.' '.__('A downgrade is necessary. <strong>Please contact your hosting company for assistance</strong>.', 'wp-php-rv').'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, downgrade PHP or remove %1$s from WordPress.</em>', 'wp-php-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'php-missing-bits': // Upgrade to a more powerful architecture.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('System Upgrade Required', 'wp-php-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires PHP on a %2$s-bit+ architecture.', 'wp-php-rv'), esc_html($brand_name), esc_html($php_minimum_bits)).'<br />';
            $markup     .= sprintf(__('You\'re running an older %1$s-bit architecture, which is not supported by %2$s.', 'wp-php-rv'), esc_html(PHP_INT_SIZE * 8), esc_html($brand_name)).'<br />';
            $markup     .= $arrow.' '.__('An update is necessary. <strong>Please contact your hosting company for assistance</strong>.', 'wp-php-rv').'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, upgrade your system or remove %1$s from WordPress.</em>', 'wp-php-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'php-missing-functions': // PHP is missing required functions.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('PHP Function(s) Missing', 'wp-php-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It depends on PHP function(s): %2$s.', 'wp-php-rv'), esc_html($brand_name), '<code>'.implode('</code>, <code>', array_map('esc_html', $php_missing_functions)).'</code>').'<br />';
            $markup     .= $arrow.' '.__('An action is necessary. <strong>Please contact your hosting company for assistance</strong>.', 'wp-php-rv').'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, enable missing function(s) or remove %1$s from WordPress.</em>', 'wp-php-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'php-missing-extensions': // PHP is missing required extensions.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('PHP Extension(s) Missing', 'wp-php-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It depends on PHP extension(s): %2$s.', 'wp-php-rv'), esc_html($brand_name), '<code>'.implode('</code>, <code>', array_map('esc_html', $php_missing_extensions)).'</code>').'<br />';
            $markup     .= $arrow.' '.__('An action is necessary. <strong>Please contact your hosting company for assistance</strong>.', 'wp-php-rv').'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, enable missing extension(s) or remove %1$s from WordPress.</em>', 'wp-php-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'wp-needs-upgrade': // Upgrade to latest version of WP.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('WP Upgrade Required', 'wp-php-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires WP v%2$s (or higher).', 'wp-php-rv'), esc_html($brand_name), esc_html($wp_min_version)).'<br />';
            $markup     .= sprintf(__('You\'re currently running the older WP v%1$s, which is not supported by %2$s.', 'wp-php-rv'), esc_html($wp_version), esc_html($brand_name)).'<br />';
            $markup     .= $arrow.' '.sprintf(__('An upgrade is necessary. <strong>Please <a href="%1$s">click here to upgrade now</a></strong>.', 'wp-php-rv'), esc_url(network_admin_url('/update-core.php'))).'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, upgrade WordPress or deactivate %1$s.</em>', 'wp-php-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'wp-needs-downgrade': // Downgrade to older version of WP.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('WP Downgrade Required', 'wp-php-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires an older version of WP.', 'wp-php-rv'), esc_html($brand_name)).'<br />';
            $markup     .= sprintf(__('This software is compatible up to WP v%1$s, but you\'re running the newer WP v%2$s.', 'wp-php-rv'), esc_html($wp_max_version), esc_html($wp_version)).'<br />';
            $markup     .= $arrow.' '.sprintf(__('A downgrade is necessary. <strong>Please see: <a href="%1$s">WordPress.org release archive</a></strong>.', 'wp-php-rv'), esc_url('https://wordpress.org/download/release-archive/')).'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, downgrade WordPress or deactivate %1$s.</em>', 'wp-php-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        default: // Default case handler; i.e., anything else.
            return; // Nothing to do here.
    }
    # This allows hooks to alter any variable by reference.

    foreach (array_keys(get_defined_vars()) as $___var_key) {
        $___refs[$___var_key] = &$$___var_key;
    } // Hooks can alter any variable by reference.

    do_action('wp_php_rv_notice_refs', $___refs);
    unset($___refs, $___var_key); // Housekeeping.

    # Attach an action to display the notice now.

    add_action($action, create_function(
        '',
        'global $pagenow;'.// Needed below.

        'if (!current_user_can(\'activate_plugins\')) return;'.

        'if (in_array($pagenow, array(\'update-core.php\'), true)) return;'.
        'if (in_array($pagenow, array(\'plugins.php\', \'themes.php\', \'update.php\'), true)'.
        '    && !empty($_REQUEST[\'___action_via\']) && $_REQUEST[\'___action_via\'] === \'wp-php-rv\') return;'.
        // Not during a core update, and not during a plugin install/activate/update.

        'if (!apply_filters(\'wp_php_rv_notice_display\', true, get_defined_vars())) return;'.

        'echo \''.// Wrap `$markup` inside a WordPress warning.
            '<div class="notice notice-warning" style="min-height:7.5em;">'.
                str_replace("'", "\\'", $markup).
            '</div>'.
        '\';'
    ), $action_priority); // Priority of the action hook can be filtered above.
}

/**
 * Last-ditch effort to find a brand name.
 *
 * @return string Name of the calling theme/plugin.
 */
function ___wp_php_rv_notice_brand_name()
{
    if (!($debug_backtrace = @debug_backtrace())) {
        return ''; // Not possible.
    }
    if (empty($debug_backtrace[1]['file'])) {
        return ''; // Not possible.
    }
    $calling_plugin_theme_dir = ''; // Initialize.
    $_calling_dir             = dirname($debug_backtrace[1]['file']);

    for ($_i = 0; $_i < 10; ++$_i) {
        if (in_array(basename(dirname($_calling_dir)), array('plugins', 'themes'), true)
            && basename(dirname(dirname($_calling_dir))) === 'wp-content') {
            $calling_plugin_theme_dir = $_calling_dir;
            break; // We can stop here.
        } else {
            $_calling_dir = dirname($_calling_dir);
        }
    } // unset($_i, $_calling_dir); // Housekeeping.

    if (empty($calling_plugin_theme_dir)) {
        return ''; // Not possible.
    }
    $brand_name = strtolower(basename($calling_plugin_theme_dir));
    $brand_name = preg_replace('/[_\-]+(?:lite|pro)$/u', '', $brand_name);
    $brand_name = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $brand_name);
    $brand_name = ucwords(trim($brand_name));

    return $brand_name;
}
