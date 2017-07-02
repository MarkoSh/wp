<?php
/*
Plugin Name:    WooCommerce Wholesale Prices
Plugin URI:     https://wholesalesuiteplugin.com
Description:    WooCommerce Extension to Provide Wholesale Prices Functionality
Author:         Rymera Web Co
Version:        1.4.5
Author URI:     http://rymera.com.au/
Text Domain:    woocommerce-wholesale-prices
*/

// This file is the main plugin boot loader

/**
 * Register Global Deactivation Hook.
 * Codebase that must be run on plugin deactivation whether or not dependencies are present.
 * Necessary to prevent activation code from being executed more than once.
 *
 * @since 1.2.9
 * @since 1.3.0 Add multi-site support.
 *
 * @param boolean $network_wide Flag that determines if the plugin is activated in a multi-site environment.
 */
function wwp_global_plugin_deactivate( $network_wide ) {

    global $wpdb;

    // check if it is a multisite network
    if ( is_multisite() ) {

        // check if the plugin has been activated on the network or on a single site
        if ( $network_wide ) {

            // get ids of all sites
            $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

            foreach ( $blog_ids as $blog_id ) {

                switch_to_blog( $blog_id );
                delete_option( 'wwp_option_activation_code_triggered' );
                delete_option( 'wwp_option_installed_version' );

            }

            restore_current_blog();

        } else {

            // activated on a single site, in a multi-site
            delete_option( 'wwp_option_activation_code_triggered' );
            delete_option( 'wwp_option_installed_version' );

        }

    } else {

        // activated on a single site
        delete_option( 'wwp_option_activation_code_triggered' );
        delete_option( 'wwp_option_installed_version' );

    }

}

register_deactivation_hook( __FILE__ , 'wwp_global_plugin_deactivate' );

require_once ( 'woocommerce-wholesale-prices.options.php' );
require_once ( 'includes/class-wwp-helper-functions.php' );

/**
 * Check if WooCommerce is active
 */
if ( WWP_Helper_Functions::is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

    if ( WWP_Helper_Functions::is_plugin_active( 'woocommerce-wholesale-prices-premium/woocommerce-wholesale-prices-premium.bootstrap.php' ) ) {

        $wwpp_plugin_data = WWP_Helper_Functions::get_plugin_data( 'woocommerce-wholesale-prices-premium/woocommerce-wholesale-prices-premium.bootstrap.php' );

        if ( version_compare( $wwpp_plugin_data[ 'Version' ] , '1.14.0' , '<' ) ) {

            /**
            * Add important notice to update to WWPP 1.14.0
            *
            * @since 1.4.1
            */
            function wwp_missing_plugin_dependency_notice() { ?>

                <div class="error">
                    <h3><?php _e( 'Important Notice:' , 'woocommerce-wholesale-prices' ); ?></h3>
                    <p><?php _e( 'We have detected an outdated version of WooCommerce Wholesale Prices Premium. You require at least version 1.14.0 for this version of WooCommerce Wholesale Prices ( 1.4.0 ). Please update now.' , 'woocommerce-wholesale-prices' ); ?></p>
                </div>

                <?php

            }

            add_action( 'admin_notices' , 'wwp_missing_plugin_dependency_notice' );

        }

    }


    // Initialize main plugin class
    require_once ( 'woocommerce-wholesale-prices.plugin.php' );
    $wc_wholesale_prices = WooCommerceWholeSalePrices::instance();
    $GLOBALS[ 'wc_wholesale_prices' ] = $wc_wholesale_prices;




    /*
    |---------------------------------------------------------------------------------------------------------------
    | Code For Integrating Into Woocommerce Price
    |---------------------------------------------------------------------------------------------------------------
    */

    // Apply wholesale price to archive and single product pages
    add_filter( 'woocommerce_get_price_html' , array( $wc_wholesale_prices , 'wholesalePriceHTMLFilter' ) , 10 , 2 );

    // Apply wholesale price whenever "get_html_price" function gets called inside a variation product
    // Variation product is the actual variation of a variable product
    // Variable product is the parent product which contains variations
    add_filter( 'woocommerce_get_variation_price_html' , array( $wc_wholesale_prices , 'wholesaleSingleVariationPriceHTMLFilter' ) , 10 , 2 );

    // Apply wholesale price upon adding product to cart
    add_action( 'woocommerce_before_calculate_totals' , array( $wc_wholesale_prices , 'applyProductWholesalePrice' ) , 10 , 1 );

    // Apply wholesale price on WC Cart Widget.
    add_filter( 'woocommerce_cart_item_price' , array( $wc_wholesale_prices , 'applyProductWholesalePriceOnDefaultWCCartWidget' ) , 10 , 3 );

    // Add notice to WC Widget if the user (wholesale user) fails to avail the wholesale price requirements. Only applies to wholesale users.
    add_action( 'woocommerce_before_mini_cart' , array( $wc_wholesale_prices , 'beforeWCWidget' ) );



    /*
    |---------------------------------------------------------------------------------------------------------------
    | Execute WWPP
    |---------------------------------------------------------------------------------------------------------------
    */

    $wc_wholesale_prices->run();

} else {

    /**
     * Provide admin notice when plugin dependency is missing.
     *
     * @since 1.2.9
     */
    function wwp_missing_plugin_dependency_notice() {

        $plugin_base_path    = 'woocommerce/woocommerce.php';
        $plugin_install_text = '<a href="' . wp_nonce_url( 'update.php?action=install-plugin&plugin=woocommerce', 'install-plugin_woocommerce' ) . '">' . __( 'Click here to install from WordPress.org repo &rarr;' , 'woocommerce-wholesale-prices' ) . '</a>';

        if ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . plugin_basename( $plugin_base_path ) ) )
            $plugin_install_text = '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin_base_path . '&amp;plugin_status=all&amp;s', 'activate-plugin_' . $plugin_base_path ) . '" title="' . __( 'Activate this plugin' , 'woocommerce-wholesale-prices' ) . '" class="edit">' . __( 'Click here to activate &rarr;' , 'woocommerce-wholesale-prices' ) . '</a>'; ?>

        <div class="error">
            <p>
                <?php _e( '<b>WooCommerce Wholesale Prices</b> plugin missing dependency.<br/><br/>Please ensure you have the <a href="http://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> plugin installed and activated.<br/>' , 'woocommerce-wholesale-prices' ); ?>
                <?php echo $plugin_install_text; ?>
            </p>
        </div>

        <?php

    }

    add_action( 'admin_notices' , 'wwp_missing_plugin_dependency_notice' );

}
