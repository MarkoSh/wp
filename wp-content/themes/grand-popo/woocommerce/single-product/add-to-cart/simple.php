<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

?>

<?php
	echo wc_get_stock_html( $product );
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

        <form class="cart" method="post" enctype='multipart/form-data'>
        <?php
        /**
         * @since 2.1.0.
         */
        do_action('woocommerce_before_add_to_cart_button');
        /**
         * @since 3.0.0.
         */
        do_action('woocommerce_before_add_to_cart_quantity');
        woocommerce_quantity_input(array(
            'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
            'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
            'input_value' => isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : $product->get_min_purchase_quantity(),
        ));
        /**
         * @since 3.0.0.
         */
        do_action('woocommerce_after_add_to_cart_quantity');
        ?>
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
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt grand_popo-preorder"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
            <?php
            }
            else{
                ?>
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
            <?php
                }
        ?>
        

        <?php
        /**
         * @since 2.1.0.
         */
        do_action('woocommerce_after_add_to_cart_button');
        ?>
    </form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
