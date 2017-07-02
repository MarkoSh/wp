<?php
/**
 * Booster for WooCommerce - Settings - Admin Tools
 *
 * @version 2.8.0
 * @since   2.8.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Handle deprecated option types
$options = array(
	'wcj_product_listings_exclude_cats_on_shop',
	'wcj_product_listings_exclude_cats_on_archives',
);
foreach ( $options as $option ) {
	$value = get_option( $option, '' );
	if ( ! is_array( $value ) ) {
		$value = explode( ',', str_replace( ' ', '', $value ) );
		update_option( $option, $value );
	}
}

// Prepare categories
$product_cats = array();
$product_categories = get_terms( 'product_cat', 'orderby=name&hide_empty=0' );
foreach ( $product_categories as $product_category ) {
	$product_cats[ $product_category->term_id ] = $product_category->name;
}

// Prepare products
$products = wcj_get_products();

// Settings
return array(
	array(
		'title'    => __( 'Shop Page Display Options', 'woocommerce-jetpack' ),
		'type'     => 'title',
		'desc'     => sprintf(
			__( 'You can control what is shown on the product archive in <a href="%s">WooCommerce > Settings > Products > Display > Shop page display</a>.', 'woocommerce-jetpack' ),
			admin_url( 'admin.php?page=wc-settings&tab=products&section=display' )
		),
		'id'       => 'wcj_product_listings_shop_page_options',
	),
	array(
		'title'    => __( 'Categories Count', 'woocommerce-jetpack' ),
		'desc'     => __( 'Hide categories count on shop page', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_hide_cats_count_on_shop',
		'default'  => 'no',
		'type'     => 'checkbox',
	),
	array(
		'title'    => __( 'Exclude Categories', 'woocommerce-jetpack' ),
		'desc_tip' => __(' Excludes one or more categories from the shop page. Leave blank to disable.', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_exclude_cats_on_shop',
		'default'  => '',
		'type'     => 'multiselect',
		'class'    => 'chosen_select',
		'css'      => 'width: 450px;',
		'options'  => $product_cats,
	),
	array(
		'title'    => __( 'Hide Empty', 'woocommerce-jetpack' ),
		'desc'     => __( 'Hide empty categories on shop page', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_hide_empty_cats_on_shop',
		'default'  => 'yes',
		'type'     => 'checkbox',
	),
	array(
		'title'    => __( 'Show Products', 'woocommerce-jetpack' ),
		'desc'     => __( 'Show products if no categories are displayed on shop page', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_show_products_if_no_cats_on_shop',
		'default'  => 'yes',
		'type'     => 'checkbox',
	),
	array(
		'type'     => 'sectionend',
		'id'       => 'wcj_product_listings_shop_page_options',
	),
	array(
		'title'    => __( 'Category Display Options', 'woocommerce-jetpack' ),
		'type'     => 'title',
		'desc'     => sprintf(
			__( 'You can control what is shown on category archives in <a href="%s">WooCommerce > Settings > Products > Display > Default category display</a>.', 'woocommerce-jetpack' ),
			admin_url( 'admin.php?page=wc-settings&tab=products&section=display' )
		),
		'id'       => 'wcj_product_listings_archive_pages_options',
	),
	array(
		'title'    => __( 'Subcategories Count', 'woocommerce-jetpack' ),
		'desc'     => __( 'Hide subcategories count on category pages', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_hide_cats_count_on_archive',
		'default'  => 'no',
		'type'     => 'checkbox',
		'custom_attributes' => apply_filters( 'booster_get_message', '', 'disabled' ),
		'desc_tip' => apply_filters( 'booster_get_message', '', 'desc' ),
	),
	array(
		'title'    => __( 'Exclude Subcategories', 'woocommerce-jetpack' ),
		'desc_tip' => __(' Excludes one or more categories from the category (archive) pages. Leave blank to disable.', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_exclude_cats_on_archives',
		'default'  => '',
		'type'     => 'multiselect',
		'class'    => 'chosen_select',
		'css'      => 'width: 450px;',
		'options'  => $product_cats,
	),
	array(
		'title'    => __( 'Hide Empty', 'woocommerce-jetpack' ),
		'desc'     => __( 'Hide empty subcategories on category pages', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_hide_empty_cats_on_archives',
		'default'  => 'yes',
		'type'     => 'checkbox',
	),
	array(
		'title'    => __( 'Show Products', 'woocommerce-jetpack' ),
		'desc'     => __( 'Show products if no categories are displayed on category page', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_show_products_if_no_cats_on_archives',
		'default'  => 'yes',
		'type'     => 'checkbox',
	),
	array(
		'type'     => 'sectionend',
		'id'       => 'wcj_product_listings_archive_pages_options',
	),
	array(
		'title'    => __( 'TAX Display Prices in the Shop', 'woocommerce-jetpack' ),
		'type'     => 'title',
		'desc'     => __( 'If you want to display part of your products including TAX and another part excluding TAX, you can set it here.', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_display_taxes_options',
	),
	array(
		'title'    => __( 'Products - Including TAX', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_display_taxes_products_incl_tax',
		'desc_tip' => __( 'Select products to display including TAX.', 'woocommerce-jetpack' ),
		'default'  => '',
		'type'     => 'multiselect',
		'class'    => 'chosen_select',
		'css'      => 'width: 450px;',
		'options'  => $products,
	),
	array(
		'title'    => __( 'Products - Excluding TAX', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_display_taxes_products_excl_tax',
		'desc_tip' => __( 'Select products to display excluding TAX.', 'woocommerce-jetpack' ),
		'default'  => '',
		'type'     => 'multiselect',
		'class'    => 'chosen_select',
		'css'      => 'width: 450px;',
		'options'  => $products,
	),
	array(
		'title'    => __( 'Product Categories - Including TAX', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_display_taxes_product_cats_incl_tax',
		'desc_tip' => __( 'Select product categories to display including TAX.', 'woocommerce-jetpack' ),
		'default'  => '',
		'type'     => 'multiselect',
		'class'    => 'chosen_select',
		'css'      => 'width: 450px;',
		'options'  => $product_cats,
	),
	array(
		'title'    => __( 'Product Categories - Excluding TAX', 'woocommerce-jetpack' ),
		'id'       => 'wcj_product_listings_display_taxes_product_cats_excl_tax',
		'desc_tip' => __( 'Select product categories to display excluding TAX.', 'woocommerce-jetpack' ),
		'default'  => '',
		'type'     => 'multiselect',
		'class'    => 'chosen_select',
		'css'      => 'width: 450px;',
		'options'  => $product_cats,
	),
	array(
		'type'     => 'sectionend',
		'id'       => 'wcj_product_listings_display_taxes_options',
	),
);
