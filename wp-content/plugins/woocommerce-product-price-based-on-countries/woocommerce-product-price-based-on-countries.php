<?php

/*
 Plugin Name: WooCommerce Price Based on Country (Basic)
 Plugin URI: https://wordpress.org/plugins/woocommerce-product-price-based-on-countries/
 Description: Product Pricing and Currency based on Shopper’s Country for WooCommerce.
 Author: Oscar Gare
 Version: 1.6.13
 Author URI: https://www.linkedin.com/in/oscargare
 Text Domain: wc-price-based-country
 Domain Path: /languages
 License: GPLv2 
*/

 /*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Product_Price_Based_Country' ) ) :

/**
 * Main WC Product Price Based Country Class
 *
 * @class WC_Product_Price_Based_Country
 * @version	1.6.13
 */
class WC_Product_Price_Based_Country {

	/**
	 * @var string
	 */
	public $version = '1.6.13';

	/**
	 * @var The single instance of the class		 
	 */
	protected static $_instance = null;

	/**
	 * @var $regions
	 */
	protected $regions = null;
	
	/**
	 * @var $customer
	 */
	public $customer = null;
	
	/**
	 * Main WC_Product_Price_Based_Country Instance
	 *
	 * Ensures only one instance of WooCommerce is loaded or can be loaded.
	 *	 
	 * @static
	 * @see WCPBC()
	 * @return Product Price Based Country - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * WC_Product_Price_Based_Country Constructor.
	 */
	public function __construct() {						
		$this->includes();	
		$this->init_hooks();		
	}		
	
	/**
	 * Include required files used in admin and on the frontend.
	 */
	private function includes() {							
		include_once( 'includes/wcpbc-functions.php' );				
		include_once( 'includes/class-wcpbc-integrations.php' );

		if ( $this->is_request( 'admin') ) {
			include_once( 'includes/class-wcpbc-install.php' );
			include_once( 'includes/admin/class-wcpbc-admin.php' );												
			
		} elseif( $this->is_request( 'frontend') ) {
			include_once( 'includes/class-wcpbc-frontend.php' );			
			include_once( 'includes/class-wcpbc-frontend-pricing.php' );
			include_once( 'includes/class-wcpbc-customer.php' );						
			include_once( 'includes/class-wcpbc-country-selector.php' );	
		}
	}
	
	/**
	 * Hook actions
	 */
	private function init_hooks() {

		register_activation_hook( __FILE__, array( 'WCPBC_Install', 'install' ) );
		
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'widgets_init', array($this, 'register_widgets') );		

		if ( $this->is_request( 'frontend') ) {			

			add_action( 'woocommerce_init', array( $this , 'frontend_init') , 100 );				
		}		

		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'plugin_action_links' ) );
	}
	
	/**
	 * What type of request is this?
	 *
	 * @param string $type frontend or admin	 
	 * @return bool
	 */
	private function is_request( $type ) {
		
		$is_ajax = defined('DOING_AJAX') && DOING_AJAX;				

		switch ( $type ) {
			case 'bot':
				$user_agent = strtolower( ( isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '' ) );
				return preg_match( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent );				

			case 'admin' :
				$is_ajax_admin = $is_ajax && isset( $_POST['action'] ) && in_array( $_POST['action'], array(  'woocommerce_add_variation', 'woocommerce_load_variations', 'woocommerce_save_variations', 'woocommerce_bulk_edit_variations', 'inline-save' ) );
				return $is_ajax_admin || ( is_admin() && ! $is_ajax );							

			case 'frontend' :
				$is_heartbeat = $is_ajax && isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], array( 'heartbeat', 'get-comments', 'wp-remove-post-lock', 'wp-compression-test', 'wcs_update_one_time_shipping', 'wcs_product_has_trial_or_is_synced', 'woocommerce_add_attribute', 'woocommerce_save_attributes', 'woocommerce_link_all_variations', 'oembed-cache' ) );
				return ! $is_heartbeat && ! defined( 'DOING_CRON' ) && ! ( $this->is_request('admin') ) && ! ( $this->is_request('bot') );
		}

	}

	/**
	 * Register Widgets
	 *
	 * @since 1.6.3
	 */
	 public function load_textdomain(){	 	
	 	load_plugin_textdomain( 'wc-price-based-country', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
	 }

	/**
	 * Register Widgets
	 *
	 * @since 1.5.0
	 */
	 public function register_widgets(){		 
		if ( class_exists( 'WC_Widget' ) ) {
			include_once( 'includes/class-wcpbc-widget-country-selector.php' );	
			register_widget( 'WCPBC_Widget_Country_Selector' );
		}	
	 }

	/**
	 * Show action links on the plugin screen.
	 *
	 * @since 	1.6.11
	 * @param	mixed $links Plugin Action links
	 * @return	array
	 */
	public function plugin_action_links( $links ) {

		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=price-based-country' ) . '" aria-label="' . esc_attr__( 'View Price Based on Country settings', 'wc-price-based-country' ) . '">' . esc_html__( 'Settings', 'wc-price-based-country' ) . '</a>'
		);

		if ( ! wcpbc_is_pro() ) {
			$action_links['get-pro'] = '<a target="_blank" style="color:#46b450;" href="https://www.pricebasedcountry.com/pricing/?utm_source=action-link&utm_medium=banner&utm_campaign=Get_Pro" aria-label="' . esc_attr__( 'Get Price Based on Country Pro', 'wc-price-based-country' ) . '">' . esc_html__( 'Get Pro', 'wc-price-based-country' ) . '</a>';
		}

		return array_merge( $action_links, $links );
	}

	/**
	 * Init front-end
	 */
	 public function frontend_init(){	 
	 	
	 	if ( ! wcpbc_is_woocommerce_frontend() ) {
	 		// Do only if woocommerce frontend have been loaded
	 		return;	 		
	 	}

	 	if ( apply_filters( 'wc_price_based_country_stop_princing', false ) )  {
	 		// Allow developers to stop base on country pricing
	 		return;	 		
	 	}

	 	do_action( 'wc_price_based_country_before_frontend_init' );

		$this->customer = new WCPBC_Customer();		

		if ( $this->customer->zone_id ) {

			WCPBC_Frontend_Pricing::init( 
				$this->customer->zone_id, 
				$this->customer->currency, 
				$this->customer->exchange_rate 
			);
		}
		
		do_action('wc_price_based_country_frontend_init');
	 }
	 
	/**
	 * Get regions
	 *
	 * @return array
	 */
	public function get_regions(){
		if ( is_null( $this->regions ) ) {
			$this->regions = get_option( 'wc_price_based_country_regions', array() );			
		}		
		return $this->regions;
	}
	
	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {		
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	
	public function plugin_path(){
		return plugin_dir_path( __FILE__ );
	}		

}

endif; // ! class_exists( 'WC_Product_Price_Based_Country' )

/**
 * Returns the main instance of WC_Product_Price_Based_Country to prevent the need to use globals.
 *
 * @since  1.3.0
 * @return WC_Product_Price_Based_Country
 */
function WCPBC() {
	return WC_Product_Price_Based_Country::instance();
}

/**
 * WC Detection
 *
 * @since  1.5.4
 * @return boolean
 */
if ( ! function_exists( 'is_woocommerce_active' ) ) {
	function is_woocommerce_active() {
		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}
		
		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ;
	}
}


/**
 * WooCommerce inactive notice. 
 *
 * @since  1.5.4
 */
function wcpbc_woocommerce_inactive_notice() {
	if ( current_user_can( 'activate_plugins' ) ) {
		echo '<div id="message" class="error"><p>';
		printf( __( '%1$sWooCommerce Price Based Country is inactive%2$s. %3$sWooCommerce plugin %4$s must be active for Price Based Country to work. Please %5$sinstall and activate WooCommerce &raquo;%6$s', 'wc-price-based-country' ), '<strong>', '</strong>', '<a href="http://wordpress.org/extend/plugins/woocommerce/">', '</a>', '<a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">', '</a>' );
		echo '</p></div>';
	}
}	

/*
 * Initialize
 */
if ( is_woocommerce_active() ) {
	$wc_product_price_based_country = WCPBC();
} else {
	add_action( 'admin_notices', 'wcpbc_woocommerce_inactive_notice' );
}

?>
