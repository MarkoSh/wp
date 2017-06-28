<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

global $product;
?>
<?php

if($icon)
    $grand_popo_icon=$icon;
else
    $grand_popo_icon="<i class='fa fa-heart'></i>";

?>
<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-placement="top" data-original-title="<?php echo esc_attr($label) ?>" data-product-id="<?php echo esc_attr($product_id) ?>" data-product-type="<?php echo esc_attr($product_type)?>" class="<?php echo esc_attr($link_classes) ?>" >
    <?php echo $grand_popo_icon; ?>
</a>
<img src="<?php echo esc_url( YITH_WCWL_URL . 'assets/images/wpspin_light.gif' ) ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />