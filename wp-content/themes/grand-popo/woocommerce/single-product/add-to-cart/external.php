<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<p class="cart">
    <?php
            $product_id= get_the_ID();

            $product = wc_get_product($product_id);
            if ($product->get_type() == "variation") 
                $product_parent_id=wp_get_post_parent_id( $product_id);
            else
                $product_parent_id=$product_id;

            $products_metas =get_post_meta($product_parent_id,'shipping-date-start',true);
            if(isset($products_metas[$product_id]) && !empty($products_metas[$product_id]) && $products_metas[$product_id]>date('Y-m-d')){
            ?>
            	<a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt grand_popo-preorder"><?php echo esc_html__("Pre Order","grand-popo" ); ?></a>

            <?php
            }
            else{
                ?>
            	<a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></a>
            <?php
            }
        ?>
</p>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
