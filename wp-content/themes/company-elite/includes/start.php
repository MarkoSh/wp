<?php
/**
 * Load required files.
 *
 * @package Company_Elite
 */

// Load template functions.
require_once trailingslashit( get_template_directory() ) . 'includes/template-functions.php';

// Load helpers.
require_once trailingslashit( get_template_directory() ) . 'includes/helpers.php';

// Load theme core functions.
require_once trailingslashit( get_template_directory() ) . 'includes/core.php';

// Load extras.
require_once trailingslashit( get_template_directory() ) . 'includes/extras.php';

// Load theme hooks.
require_once trailingslashit( get_template_directory() ) . 'includes/theme-hooks.php';

// Load module.
require_once trailingslashit( get_template_directory() ) . 'includes/module/structure.php';
require_once trailingslashit( get_template_directory() ) . 'includes/module/slider.php';

// Load metabox.
require_once trailingslashit( get_template_directory() ) . 'includes/module/metabox.php';

// Include theme widgets.
require_once trailingslashit( get_template_directory() ) . 'includes/widgets.php';

// Custom template tags for this theme.
require_once trailingslashit( get_template_directory() ) . 'includes/template-tags.php';

// Customizer options.
require_once trailingslashit( get_template_directory() ) . 'includes/customizer.php';

// Load WooCommerce support.
if ( class_exists( 'WooCommerce' ) ) {
	require_once trailingslashit( get_template_directory() ) . 'includes/support/woocommerce.php';
}
