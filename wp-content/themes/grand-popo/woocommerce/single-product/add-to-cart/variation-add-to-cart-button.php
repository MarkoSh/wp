<?php
/**
 * Single variation cart button
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php 
            do_action( 'woocommerce_before_add_to_cart_quantity' );
            woocommerce_quantity_input( array(
                'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity(),
            ) );
            /**
		 * @since 3.0.0.
		 */
		do_action( 'woocommerce_after_add_to_cart_quantity' );
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
            <button type="submit" class="single_add_to_cart_button button alt grand_popo-preorder"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
            <?php
            }
            else{
                ?>
            <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
            <?php
            }
        ?>
        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
