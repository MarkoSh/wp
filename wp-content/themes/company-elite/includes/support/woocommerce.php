<?php
/**
 * Add WooCommerce support.
 *
 * @package Company_Elite
 */

if ( ! function_exists( 'company_elite_add_woocommerce_support' ) ) :

	/**
	 * Register WooCommerce support.
	 *
	 * @since 1.0.1
	 */
	function company_elite_add_woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
	}
endif;

add_action( 'after_setup_theme', 'company_elite_add_woocommerce_support' );

if ( ! function_exists( 'company_elite_start_woocommerce_wrapper' ) ) :

	/**
	 * Start WooCommerce wrapper.
	 *
	 * @since 1.0.1
	 */
	function company_elite_start_woocommerce_wrapper() {
		echo '<div id="primary">';
		echo '<main role="main" class="site-main" id="main">';
	}
endif;

if ( ! function_exists( 'company_elite_end_woocommerce_wrapper_end' ) ) :

	/**
	 * End WooCommerce wrapper.
	 *
	 * @since 1.0.1
	 */
	function company_elite_end_woocommerce_wrapper_end() {
		echo '</main><!-- #main -->';
		echo '</div><!-- #primary -->';
	}
endif;

// Remove title in single product.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// Remove default wrapper.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'company_elite_start_woocommerce_wrapper', 10 );
add_action( 'woocommerce_after_main_content', 'company_elite_end_woocommerce_wrapper_end', 10 );

if ( ! function_exists( 'company_elite_customize_woocommerce_breadcrumb' ) ) :

	/**
	 * Customize WooCommerce breadcrumb.
	 *
	 * @since 1.0.1
	 *
	 * @param array $defaults Breadcrumb defaults array.
	 * @return array Customized breadcrumb defaults array.
	 */
	function company_elite_customize_woocommerce_breadcrumb( $defaults ) {

		$defaults['delimiter']   = '';
		$defaults['before']      = '<li>';
		$defaults['after']       = '</li>';
		$defaults['wrap_before'] = '<div id="breadcrumb" itemprop="breadcrumb"><div class="container"><div class="woo-breadcrumbs breadcrumbs"><ul>';
		$defaults['wrap_after']  = '</ul></div></div></div>';

		return $defaults;

	}
endif;

add_filter( 'woocommerce_breadcrumb_defaults', 'company_elite_customize_woocommerce_breadcrumb' );

if ( ! function_exists( 'company_elite_customize_woocommerce_hooks' ) ) :

	/**
	 * Customize WooCommerce hooks.
	 *
	 * @since 1.0.1
	 */
	function company_elite_customize_woocommerce_hooks() {

		// Breadcrumbs.
		if ( is_woocommerce() || is_product_category() || is_product_tag() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			add_action( 'company_elite_action_breadcrumb', 'woocommerce_breadcrumb', 10 );
			remove_action( 'company_elite_action_breadcrumb', 'company_elite_add_breadcrumb' );
		}

		// Sidebar.
		$global_layout = company_elite_get_option( 'global_layout' );
		$global_layout = apply_filters( 'company_elite_filter_theme_global_layout', $global_layout );

		if ( 'no-sidebar' === $global_layout ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		}

		if ( is_shop() ) {
			remove_action( 'company_elite_action_custom_header_title', 'company_elite_add_title_in_custom_header' );
			add_action( 'company_elite_action_custom_header_title', 'company_elite_customize_shop_title' );
		}
	}
endif;

add_action( 'wp', 'company_elite_customize_woocommerce_hooks' );

if ( ! function_exists( 'company_elite_woocommerce_add_secondary_sidebar' ) ) :

	/**
	 * Add secondary sidebar.
	 *
	 * @since 1.0.1
	 */
	function company_elite_woocommerce_add_secondary_sidebar() {
		$global_layout = company_elite_get_option( 'global_layout' );
		$global_layout = apply_filters( 'company_elite_filter_theme_global_layout', $global_layout );

		if ( 'three-columns' === $global_layout ) {
			get_sidebar( 'secondary' );
		}
	}
endif;

add_action( 'woocommerce_sidebar', 'company_elite_woocommerce_add_secondary_sidebar', 11 );

if ( ! function_exists( 'company_elite_woocommerce_fix_global_layout' ) ) :

	/**
	 * Fix global layout.
	 *
	 * @since 1.0.1
	 *
	 * @param array $layout Layout.
	 * @return array Customized layout.
	 */
	function company_elite_woocommerce_fix_global_layout( $layout ) {

		if ( is_shop() ) {
			$shop_page_id = get_option( 'woocommerce_shop_page_id' );
			if ( $shop_page_id ) {
				$post_options = get_post_meta( $shop_page_id, 'company_elite_settings', true );
				$global_layout = '';

				if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
					$global_layout = $post_options['post_layout'];
				}

				if ( $global_layout ) {
					$layout = esc_attr( $global_layout );
				}

			}

		}

		return $layout;
	}
endif;

add_filter( 'company_elite_filter_theme_global_layout', 'company_elite_woocommerce_fix_global_layout', 15 );

if ( ! function_exists( 'company_elite_woo_hide_page_title' ) ) :

	/**
	 * Custom Woo page title.
	 *
	 * @since 1.0.1
	 * @param string $input Title.
	 * @param string Modified Title.
	 */
	function company_elite_woo_hide_page_title( $input ) {
		return false;
	}
endif;

add_filter( 'woocommerce_show_page_title' , 'company_elite_woo_hide_page_title' );

if ( ! function_exists( 'company_elite_customize_shop_title' ) ) :

	/**
	 * Customize shop page title.
	 *
	 * @since 1.0.1
	 */
	function company_elite_customize_shop_title( $input ) {
		$shop_page_id = get_option( 'woocommerce_shop_page_id' );
		if ( absint( $shop_page_id ) > 0 ) {
			echo '<h1 class="custom-header-title">';
			echo get_the_title( absint( $shop_page_id ) );
			echo '</h1>';
		}
	}
endif;

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'RUB': $currency_symbol = 'руб.'; break;
    }
    return $currency_symbol;
}