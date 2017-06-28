<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form role="search" method="get" class="woocommerce-product-search search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'grand-popo' ); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'grand-popo' ); ?>" />
	<i class='ti-search search-icon'></i>
        <input type="hidden" name="post_type" value="product" />
</form>
