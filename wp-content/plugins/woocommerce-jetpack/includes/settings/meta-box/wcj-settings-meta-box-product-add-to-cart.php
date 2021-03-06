<?php
/**
 * Booster for WooCommerce - Settings Meta Box - Product Add To Cart
 *
 * @version 2.8.0
 * @since   2.8.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$options = array();
if ( 'per_product' === get_option( 'wcj_add_to_cart_on_visit_enabled', 'no' ) ) {
	$options = array_merge( $options, array(
		array(
			'name'       => 'wcj_add_to_cart_on_visit_enabled',
			'default'    => 'no',
			'type'       => 'select',
			'options'    => array(
				'yes' => __( 'Yes', 'woocommerce-jetpack' ),
				'no'  => __( 'No', 'woocommerce-jetpack' ),
			),
			'title'      => __( 'Add to Cart on Visit', 'woocommerce-jetpack' ),
		),
	) );
}
if ( 'yes' === get_option( 'wcj_add_to_cart_button_per_product_enabled', 'no' ) ) {
	$options = array_merge( $options, array(
		array(
			'name'       => 'wcj_add_to_cart_button_disable',
			'default'    => 'no',
			'type'       => 'select',
			'options'    => array(
				'yes' => __( 'Yes', 'woocommerce-jetpack' ),
				'no'  => __( 'No', 'woocommerce-jetpack' ),
			),
			'title'      => __( 'Disable Add to Cart Button (Single Product Page)', 'woocommerce-jetpack' ),
		),
		array(
			'name'       => 'wcj_add_to_cart_button_loop_disable',
			'default'    => 'no',
			'type'       => 'select',
			'options'    => array(
				'yes' => __( 'Yes', 'woocommerce-jetpack' ),
				'no'  => __( 'No', 'woocommerce-jetpack' ),
			),
			'title'      => __( 'Disable Add to Cart Button (Category/Archives)', 'woocommerce-jetpack' ),
		),
	) );
}
if ( 'yes' === get_option( 'wcj_add_to_cart_button_custom_loop_url_per_product_enabled', 'no' ) ) {
	$options = array_merge( $options, array(
		array(
			'name'       => 'wcj_add_to_cart_button_loop_custom_url',
			'default'    => '',
			'type'       => 'text',
			'title'      => __( 'Custom Add to Cart Button URL (Category/Archives)', 'woocommerce-jetpack' ),
		),
	) );
}
if ( 'yes' === get_option( 'wcj_add_to_cart_button_ajax_per_product_enabled', 'no' ) ) {
	$options = array_merge( $options, array(
		array(
			'name'       => 'wcj_add_to_cart_button_ajax_disable',
			'default'    => 'as_shop_default',
			'type'       => 'select',
			'options'    => array(
				'as_shop_default' => __( 'As shop default (no changes)', 'woocommerce-jetpack' ),
				'yes'             => __( 'Disable', 'woocommerce-jetpack' ),
				'no'              => __( 'Enable', 'woocommerce-jetpack' ),
			),
			'title'      => __( 'Disable Add to Cart Button AJAX', 'woocommerce-jetpack' ),
		),
	) );
}
return $options;
