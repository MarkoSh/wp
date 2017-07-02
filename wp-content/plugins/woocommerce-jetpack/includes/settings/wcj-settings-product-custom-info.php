<?php
/**
 * Booster for WooCommerce - Settings - Product Info
 *
 * @version 2.8.0
 * @since   2.8.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$products = wcj_get_products();
$settings = array();
$single_or_archive_array = array( 'single', 'archive' );
foreach ( $single_or_archive_array as $single_or_archive ) {
	$single_or_archive_desc = ( 'single' === $single_or_archive ) ? __( 'Single', 'woocommerce-jetpack' ) : __( 'Archive', 'woocommerce-jetpack' );
	$settings = array_merge( $settings, array(
		array(
			'title'    => __( 'Product Custom Info Blocks', 'woocommerce-jetpack' ) . ' - ' . $single_or_archive_desc,
			'type'     => 'title',
			'id'       => 'wcj_product_custom_info_options_' . $single_or_archive,
		),
		array(
			'title'    => __( 'Total Blocks', 'woocommerce-jetpack' ),
			'id'       => 'wcj_product_custom_info_total_number_' . $single_or_archive,
			'default'  => 1,
			'type'     => 'custom_number',
			'desc'     => apply_filters( 'booster_get_message', '', 'desc' ),
			'custom_attributes' => apply_filters( 'booster_get_message', '', 'readonly' ),
		),
		array(
			'type'     => 'sectionend',
			'id'       => 'wcj_product_custom_info_options_' . $single_or_archive,
		),
	) );
	for ( $i = 1; $i <= apply_filters( 'booster_get_option', 1, get_option( 'wcj_product_custom_info_total_number_' . $single_or_archive, 1 ) ); $i++ ) {
		$settings = array_merge( $settings, array(
			array(
				'title'    => __( 'Info Block', 'woocommerce-jetpack' ) . ' #' . $i . ' - ' . $single_or_archive_desc,
				'type'     => 'title',
				'id'       => 'wcj_product_custom_info_options_' . $single_or_archive . '_' . $i,
			),
			array(
				'title'    => __( 'Content', 'woocommerce-jetpack' ),
				'id'       => 'wcj_product_custom_info_content_' . $single_or_archive . '_' . $i,
				'default'  => '[wcj_product_total_sales before="Total sales: " after=" pcs."]',
				'type'     => 'custom_textarea',
				'desc_tip' => __( 'You can use shortcodes here.', 'woocommerce-jetpack' ),
				'css'      => 'width:60%;min-width:300px;height:100px;',
			),
			array(
				'title'    => __( 'Position', 'woocommerce-jetpack' ),
				'id'       => 'wcj_product_custom_info_hook_' . $single_or_archive . '_' . $i,
				'default'  => ( 'single' === $single_or_archive ) ? 'woocommerce_after_single_product_summary' : 'woocommerce_after_shop_loop_item_title',
				'type'     => 'select',
				'options'  => ( 'single' === $single_or_archive ) ?
					array(
						'woocommerce_before_single_product'         => __( 'Before single product', 'woocommerce-jetpack' ),
						'woocommerce_before_single_product_summary' => __( 'Before single product summary', 'woocommerce-jetpack' ),
						'woocommerce_single_product_summary'        => __( 'Inside single product summary', 'woocommerce-jetpack' ),
						'woocommerce_after_single_product_summary'  => __( 'After single product summary', 'woocommerce-jetpack' ),
						'woocommerce_after_single_product'          => __( 'After single product', 'woocommerce-jetpack' ),
						'woocommerce_before_add_to_cart_form'       => __( 'Before add to cart form', 'woocommerce-jetpack' ),
						'woocommerce_before_add_to_cart_button'     => __( 'Before add to cart button', 'woocommerce-jetpack' ),
						'woocommerce_after_add_to_cart_button'      => __( 'After add to cart button', 'woocommerce-jetpack' ),
						'woocommerce_after_add_to_cart_form'        => __( 'After add to cart form', 'woocommerce-jetpack' ),
					) :
					array(
						'woocommerce_before_shop_loop_item'       => __( 'Before product', 'woocommerce-jetpack' ),
						'woocommerce_before_shop_loop_item_title' => __( 'Before product title', 'woocommerce-jetpack' ),
						'woocommerce_shop_loop_item_title'        => __( 'Inside product title', 'woocommerce-jetpack' ),
						'woocommerce_after_shop_loop_item_title'  => __( 'After product title', 'woocommerce-jetpack' ),
						'woocommerce_after_shop_loop_item'        => __( 'After product', 'woocommerce-jetpack' ),
					),
				'css'      => 'width:250px;',
			),
			array(
				'title'    => __( 'Position Order (i.e. Priority)', 'woocommerce-jetpack' ),
				'id'       => 'wcj_product_custom_info_priority_' . $single_or_archive . '_' . $i,
				'default'  => 10,
				'type'     => 'number',
				'css'      => 'width:250px;',
			),
			array(
				'title'    => __( 'Products to Include', 'woocommerce-jetpack' ),
				'desc_tip' => __( 'Leave blank to disable the option.', 'woocommerce-jetpack' ),
				'id'       => 'wcj_product_custom_info_products_to_include_' . $single_or_archive . '_' . $i,
				'default'  => '',
				'type'     => 'multiselect',
				'class'    => 'chosen_select',
				'css'      => 'width: 450px;',
				'options'  => $products,
			),
			array(
				'title'    => __( 'Products to Exclude', 'woocommerce-jetpack' ),
				'desc_tip' => __( 'Leave blank to disable the option.', 'woocommerce-jetpack' ),
				'id'       => 'wcj_product_custom_info_products_to_exclude_' . $single_or_archive . '_' . $i,
				'default'  => '',
				'type'     => 'multiselect',
				'class'    => 'chosen_select',
				'css'      => 'width: 450px;',
				'options'  => $products,
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'wcj_product_custom_info_options_' . $single_or_archive . '_' . $i,
			),
		) );
	}
}
return $settings;
