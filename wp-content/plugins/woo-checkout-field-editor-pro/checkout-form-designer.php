<?php
/**
 * Plugin Name: Woo Checkout Field Editor Pro
 * Description: Customize WooCommerce checkout fields(Add, Edit, Delete and re-arrange fields).
 * Author:      ThemeHiGH
 * Version:     1.1.9
 * Author URI:  https://www.themehigh.com
 * Plugin URI:  https://www.themehigh.com
 * Text Domain: thwcfd
 * Domain Path: /languages
 */
 
if(!defined( 'ABSPATH' )) exit;

if (!function_exists('is_woocommerce_active')){
	function is_woocommerce_active(){
	    $active_plugins = (array) get_option('active_plugins', array());
	    if(is_multisite()){
		   $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
	    }
	    return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
	}
}

if(is_woocommerce_active()) {
	load_plugin_textdomain( 'thwcfd', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	/**
	 * woocommerce_init_checkout_field_editor function.
	 */
	function thwcfd_init_checkout_field_editor_lite() {
		global $supress_field_modification;
		$supress_field_modification = false;

		if(!class_exists('WC_Checkout_Field_Editor')){
			require_once('classes/class-wc-checkout-field-editor.php');
		}

		if (!class_exists('WC_Checkout_Field_Editor_Export_Handler')){
			require_once('classes/class-wc-checkout-field-editor-export-handler.php');
		}
		new WC_Checkout_Field_Editor_Export_Handler();

		$GLOBALS['WC_Checkout_Field_Editor'] = new WC_Checkout_Field_Editor();
	}
	add_action('init', 'thwcfd_init_checkout_field_editor_lite');
	
	function thwcfd_is_locale_field( $field_name ){
		if(!empty($field_name) && in_array($field_name, array(
			'billing_address_1', 'billing_address_2', 'billing_state', 'billing_postcode', 'billing_city',
			'shipping_address_1', 'shipping_address_2', 'shipping_state', 'shipping_postcode', 'shipping_city',
		))){
			return true;
		}
		return false;
	}
	 
	function thwcfd_woocommerce_version_check( $version = '3.0' ) {
	  	if(function_exists( 'is_woocommerce_active' ) && is_woocommerce_active() ) {
			global $woocommerce;
			if( version_compare( $woocommerce->version, $version, ">=" ) ) {
		  		return true;
			}
	  	}
	  	return false;
	}
	
	/**
	 * Hide Additional Fields title if no fields available.
	 *
	 * @param mixed $old
	 */
	function thwcfd_enable_order_notes_field() {
		global $supress_field_modification;

		if($supress_field_modification){
			return $fields;
		}

		$additional_fields = get_option('wc_fields_additional');
		if(is_array($additional_fields)){
			$enabled = 0;
			foreach($additional_fields as $field){
				if($field['enabled']){
					$enabled++;
				}
			}
			return $enabled > 0 ? true : false;
		}
		return true;
	}
	add_filter('woocommerce_enable_order_notes_field', 'thwcfd_enable_order_notes_field', 1000);
		
	function thwcfd_woo_default_address_fields( $original ) {
		$sname = 'billing';
		$address_fields = get_option('wc_fields_'.$sname);
		
		if(is_array($address_fields) && !empty($address_fields) && !empty($original)){	
			foreach($original as $name => $ofield) {
				$new_field = isset($address_fields[$sname.'_'.$name]) ? $address_fields[$sname.'_'.$name] : false;
				$override_required = apply_filters( 'thwcfd_address_field_override_required', false );
				
				if($new_field && !( isset($new_field['enabled']) && $new_field['enabled'] == false )){
					$original[$name]['required'] = isset($new_field['required']) ? $new_field['required'] : 0;
				}
			}
		}
		
		return $original;
	}	
	//add_filter('woocommerce_default_address_fields' , 'thwcfd_woo_default_address_fields' );
	
	function thwcfd_prepare_country_locale($fields) {
		if(is_array($fields)){
			foreach($fields as $key => $props){
				$override_ph = apply_filters( 'thwcfd_address_field_override_placeholder', true );
				$override_label = apply_filters( 'thwcfd_address_field_override_label', true );
				$override_required = apply_filters( 'thwcfd_address_field_override_required', false );
				
				if($override_ph && isset($props['placeholder'])){
					unset($fields[$key]['placeholder']);
				}
				if($override_label && isset($props['label'])){
					unset($fields[$key]['label']);
				}
				if($override_required && isset($props['required'])){
					unset($fields[$key]['required']);
				}
				
				if(isset($props['priority'])){
					unset($fields[$key]['priority']);
				}
			}
		}
		return $fields;
	} 
	add_filter('woocommerce_get_country_locale_default', 'thwcfd_prepare_country_locale');
	add_filter('woocommerce_get_country_locale_base', 'thwcfd_prepare_country_locale');
	
	function thwcfd_woo_get_country_locale($locale) {
		if(is_array($locale)){
			foreach($locale as $country => $fields){
				$locale[$country] = thwcfd_prepare_country_locale($fields);
			}
		}
		return $locale;
	}
	add_filter('woocommerce_get_country_locale', 'thwcfd_woo_get_country_locale');
			
	/**
	 * wc_checkout_fields_modify_billing_fields function.
	 *
	 * @param mixed $old
	 */
	function thwcfd_billing_fields_lite($old){
		global $supress_field_modification;

		if($supress_field_modification){
			return $old;
		}

		return thwcfd_prepare_checkout_fields_lite(get_option('wc_fields_billing'), $old);
	}
	add_filter('woocommerce_billing_fields', 'thwcfd_billing_fields_lite', 1000);

	/**
	 * wc_checkout_fields_modify_shipping_fields function.
	 *
	 * @param mixed $old
	 */
	function thwcfd_shipping_fields_lite($old){
		global $supress_field_modification;

		if ($supress_field_modification){
			return $old;
		}

		return thwcfd_prepare_checkout_fields_lite(get_option('wc_fields_shipping'), $old);
	}
	add_filter('woocommerce_shipping_fields', 'thwcfd_shipping_fields_lite', 1000);

	/**
	 * wc_checkout_fields_modify_shipping_fields function.
	 *
	 * @param mixed $old
	 */
	function thwcfd_checkout_fields_lite( $fields ) {
		global $supress_field_modification;

		if($supress_field_modification){
			return $fields;
		}

		if($additional_fields = get_option('wc_fields_additional')){
			if( isset($fields['order']) && is_array($fields['order']) ){
				$fields['order'] = $additional_fields + $fields['order'];
			}

			// check if order_comments is enabled/disabled
			if(isset($additional_fields) && !$additional_fields['order_comments']['enabled']){
				unset($fields['order']['order_comments']);
			}
		}
				
		if(isset($fields['order']) && is_array($fields['order'])){
			$fields['order'] = thwcfd_prepare_checkout_fields_lite($fields['order'], false);
		}
		
		return $fields;
	}
	add_filter('woocommerce_checkout_fields', 'thwcfd_checkout_fields_lite', 1000);

	/**
	 * checkout_fields_modify_fields function.
	 *
	 * @param mixed $data
	 * @param mixed $old
	 */
	 function thwcfd_prepare_checkout_fields_lite($fields, $original_fields) {
		if(is_array($fields) && !empty($fields)) {
			foreach($fields as $name => $field) {
				if(isset($field['enabled']) && $field['enabled'] == false ) {
					unset($fields[$name]);
				}else{
					$new_field = false;
					
					if($original_fields && isset($original_fields[$name])){
						$new_field = $original_fields[$name];
						
						$new_field['label'] = isset($field['label']) ? $field['label'] : '';
						$new_field['placeholder'] = isset($field['placeholder']) ? $field['placeholder'] : '';
						
						$new_field['class'] = isset($field['class']) && is_array($field['class']) ? $field['class'] : array();
						$new_field['label_class'] = isset($field['label_class']) && is_array($field['label_class']) ? $field['label_class'] : array();
						$new_field['validate'] = isset($field['validate']) && is_array($field['validate']) ? $field['validate'] : array();
						
						if(!thwcfd_is_locale_field($name)){
							$new_field['required'] = isset($field['required']) ? $field['required'] : 0;
						}
						$new_field['clear'] = isset($field['clear']) ? $field['clear'] : 0;
					}else{
						$new_field = $field;
					}
					
					$new_field['order'] = isset($field['order']) && is_numeric($field['order']) ? $field['order'] : 0;
					if(isset($new_field['order']) && is_numeric($new_field['order'])){
						$new_field['priority'] = $new_field['order'];
					}
					
					if(isset($new_field['label'])){
						$new_field['label'] = __($new_field['label'], 'woocommerce');
					}
					if(isset($new_field['placeholder'])){
						$new_field['placeholder'] = __($new_field['placeholder'], 'woocommerce');
					}
					
					$fields[$name] = $new_field;
				}
			}								
			return $fields;
		}else {
			return $original_fields;
		}
	}
	
	/*****************************************
	 ----- Display Field Values - START ------
	 *****************************************/
	
	/**
	 * Display custom fields in emails
	 *
	 * @param array $keys
	 * @return array
	 */
	function thwcfd_display_custom_fields_in_emails_lite($keys){
		$custom_keys = array();
		$fields = array_merge(WC_Checkout_Field_Editor::get_fields('billing'), WC_Checkout_Field_Editor::get_fields('shipping'), 
		WC_Checkout_Field_Editor::get_fields('additional'));

		// Loop through all custom fields to see if it should be added
		foreach( $fields as $name => $options ) {
			if(isset($options['show_in_email']) && $options['show_in_email']){
				$custom_keys[ esc_attr( $options['label'] ) ] = esc_attr( $name );
			}
		}

		return array_merge( $keys, $custom_keys );
	}	
	add_filter('woocommerce_email_order_meta_keys', 'thwcfd_display_custom_fields_in_emails_lite', 10, 1);
	
	/**
	 * Display custom checkout fields on view order pages
	 *
	 * @param  object $order
	 */
	function thwcfd_order_details_after_customer_details_lite($order){
		if(thwcfd_woocommerce_version_check()){
			$order_id = $order->get_id();	
		}else{
			$order_id = $order->id;
		}
		
		$fields = array();		
		if(!wc_ship_to_billing_address_only() && $order->needs_shipping_address()){
			$fields = array_merge(WC_Checkout_Field_Editor::get_fields('billing'), WC_Checkout_Field_Editor::get_fields('shipping'), 
			WC_Checkout_Field_Editor::get_fields('additional'));
		}else{
			$fields = array_merge(WC_Checkout_Field_Editor::get_fields('billing'), WC_Checkout_Field_Editor::get_fields('additional'));
		}
		
		// Loop through all custom fields to see if it should be added
		foreach($fields as $name => $options){
			$enabled = (isset($options['enabled']) && $options['enabled'] == false) ? false : true;
			$is_custom_field = (isset($options['custom']) && $options['custom'] == true) ? true : false;
		
			if(isset($options['show_in_order']) && $options['show_in_order'] && $enabled && $is_custom_field){
				$value = get_post_meta($order_id, $name, true);
				
				if(!empty($value)){
					$label = isset($options['label']) && !empty($options['label']) ? __( $options['label'], 'woocommerce' ) : $name;
					echo '<tr><th>'. esc_attr($label) .':</th><td>'. wptexturize($value) .'</td></tr>';
				}
			}
		}
	}
	add_action('woocommerce_order_details_after_customer_details', 'thwcfd_order_details_after_customer_details_lite', 20, 1);
	
	/*****************************************
	 ----- Display Field Values - END --------
	 *****************************************/
	 		
	/*function thwcfd_prepare_checkout_fields_lite( $data, $old_fields ) {
		global $WC_Checkout_Field_Editor;

		if( empty( $data ) ) {
			return $old_fields;
			
		}else {
			$fields = $data;			
			foreach( $fields as $name => $values ) {
				// enabled
				if ( $values['enabled'] == false ) {
					unset( $fields[ $name ] );
				}

				// Replace locale field properties so they are unchanged
				if ( in_array( $name, array(
					'billing_country', 'billing_state', 'billing_city', 'billing_postcode',
					'shipping_country', 'shipping_state', 'shipping_city', 'shipping_postcode',
					'order_comments'
				) ) ) {
					if ( isset( $fields[ $name ] ) ) {
						$fields[ $name ]          = $old_fields[ $name ];
						$fields[ $name ]['label'] = ! empty( $data[ $name ]['label'] ) ? $data[ $name ]['label'] : $old_fields[ $name ]['label'];

						if ( ! empty( $data[ $name ]['placeholder'] ) ) {
							$fields[ $name ]['placeholder'] = $data[ $name ]['placeholder'];

						} elseif ( ! empty( $old_fields[ $name ]['placeholder'] ) ) {
							$fields[ $name ]['placeholder'] = $old_fields[ $name ]['placeholder'];

						} else {
							$fields[ $name ]['placeholder'] = '';
						}

						$fields[ $name ]['class'] = $data[ $name ]['class'];
						$fields[ $name ]['clear'] = $data[ $name ]['clear'];
					}
				}
				
				if(isset($fields[$name])){
					if(isset($fields[$name]['label'])){
						$fields[ $name ]['label'] = __($fields[ $name ]['label'], 'woocommerce');
					}
					if(isset($fields[$name]['placeholder'])){
						$fields[ $name ]['placeholder'] = __($fields[ $name ]['placeholder'], 'woocommerce');
					}
					if(isset($fields[$name]['order'])){
						$fields[ $name ]['priority'] = is_numeric($fields[$name]['order']) ? $fields[$name]['order'] : '';
					}
				}
			}								
			return $fields;
		}
	}*/

	/**
	 * wc_checkout_fields_validation function.
	 *
	 * @param mixed $posted
	 */
	/*function thwcfd_checkout_fields_validation_lite($posted){
		foreach(WC()->checkout->checkout_fields as $fieldset_key => $fieldset){

			// Skip shipping if its not needed
			if($fieldset_key === 'shipping' && (wc_ship_to_billing_address_only() || !empty($posted['shiptobilling']) || 
			(!WC()->cart->needs_shipping() && get_option('woocommerce_require_shipping_address') === 'no'))){
				continue;
			}

			foreach($fieldset as $key => $field){
				if(!empty($field['validate']) && is_array($field['validate']) && !empty($posted[$key])){
					foreach($field['validate'] as $rule){
						switch($rule) {
							case 'number' :
								if(!is_numeric($posted[$key])){
									if(defined('WC_VERSION') && version_compare(WC_VERSION, '2.3.0', '>=')){
										wc_add_notice('<strong>'. $field['label'] .'</strong> '. sprintf(__('(%s) is not a valid number.', 'woocommerce'), $posted[$key]), 'error');
									} else {
										WC()->add_error('<strong>'. $field['label'] .'</strong> '. sprintf(__('(%s) is not a valid number.', 'woocommerce'), $posted[$key]));
									}
								}
								break;
							case 'email' :
								if(!is_email($posted[$key])){
									if(defined('WC_VERSION') && version_compare(WC_VERSION, '2.3.0', '<')){
										WC()->add_error('<strong>'. $field['label'] .'</strong> '. sprintf(__('(%s) is not a valid email address.', 'woocommerce'), $posted[$key]));
									}
								}
								break;
						}
					}
				}
			}
		}
	}*/
	//add_action('woocommerce_after_checkout_validation', 'thwcfd_checkout_fields_validation_lite');
	
}
