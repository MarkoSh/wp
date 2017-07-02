<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WCPBC_Country_Selector class.
 *
 * @class 		WCPBC_Country_Selector
 * @version		1.5.12
 * @author 		oscargare
 */
class WCPBC_Country_Selector {
	
	/**
	 * Hook actions and shortcodes
	 */
	public static function init(){						
	
		add_shortcode( 'wcpbc_country_selector', array( __CLASS__ , 'shortcode_country_selector' ) );
		
		add_action( 'wcpbc_manual_country_selector', array( __CLASS__ , 'output_country_selector' ) );
	}
	
	/**
	 * Return installed countries
	 * @return array
	 */
	private static function get_countries(){
		
		$all_countries = WC()->countries->get_countries();		
		$base_country = wc_get_base_location();			

		$countries[ $base_country['country'] ] = $all_countries[$base_country['country']];

		foreach ( WCPBC()->get_regions() as $region ) {
			
			foreach ( $region['countries'] as $country ) {

				if ( ! array_key_exists( $country, $countries ) ) {
					$countries[ $country ] = $all_countries[$country];					
				}
			}			
		}

		wcpbc_maybe_asort_locale( $countries );
		
		$other_country = key( array_diff_key($all_countries, $countries ) );
		
		$countries[$other_country] = apply_filters( 'wcpbc_other_countries_text', __( 'Other countries' ) );
		
		return $countries;
	}
	
	/**
	 * Return manual country select form
	 */
	public static function shortcode_country_selector(){	
		
		$countries = self::get_countries();
		$selected_country = wcpbc_get_woocommerce_country();

		if ( ! array_key_exists( $selected_country, $countries ) ) {
			//find other countries
			foreach ($countries as $key => $value) {
				if ($value == apply_filters( 'wcpbc_other_countries_text', __( 'Other countries' ) ) ) {
					$selected_country = $key;
				}
			}
		}

		ob_start();
		
		echo '<div class="wc-price-based-country">';
		wc_get_template('country-selector.php', array( 'countries' => $countries, 'selected_country' => $selected_country ), 'woocommerce-product-price-based-on-countries/',  WCPBC()->plugin_path()  . '/templates/' );
		echo '</div>';
		
		return ob_get_clean();
	}
	
	/**
	 * Output manual country select form
	 */
	public static function output_country_selector(){
		echo self::shortcode_country_selector();
	}
}

WCPBC_Country_Selector::init();