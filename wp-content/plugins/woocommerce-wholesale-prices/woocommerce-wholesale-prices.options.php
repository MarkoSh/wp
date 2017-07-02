<?php
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// This is where you set various options affecting the plugin

// Path Constants ======================================================================================================
define( 'WWP_PLUGIN_BASE_PATH' ,    basename( dirname( __FILE__ ) ) . '/' );
define( 'WWP_PLUGIN_PATH',          plugin_dir_path( __FILE__ ) );
define( 'WWP_PLUGIN_URL',           plugins_url() . '/woocommerce-wholesale-prices/' );
define( 'WWP_CSS_PATH',             WWP_PLUGIN_PATH . 'css/' );
define( 'WWP_CSS_URL',              WWP_PLUGIN_URL . 'css/' );
define( 'WWP_IMAGES_PATH',          WWP_PLUGIN_PATH . 'images/' );
define( 'WWP_IMAGES_URL',           WWP_PLUGIN_URL . 'images/' );
define( 'WWP_INCLUDES_PATH',        WWP_PLUGIN_PATH . 'includes/' );
define( 'WWP_INCLUDES_URL',         WWP_PLUGIN_URL . 'includes/' );
define( 'WWP_JS_PATH',              WWP_PLUGIN_PATH . 'js/' );
define( 'WWP_JS_URL',               WWP_PLUGIN_URL . 'js/' );
define( 'WWP_LANGUAGES_PATH' ,      WWP_PLUGIN_PATH . 'languages/' );
define( 'WWP_LANGUAGES_URL' ,       WWP_PLUGIN_URL . 'languages/' );
define( 'WWP_LOGS_PATH',            WWP_PLUGIN_PATH . 'logs/' );
define( 'WWP_LOGS_URL',             WWP_PLUGIN_URL . 'logs/' );

// Options =============================================================================================================
define( 'WWP_OPTIONS_REGISTERED_CUSTOM_ROLES' , 'wwp_options_registered_custom_roles' );