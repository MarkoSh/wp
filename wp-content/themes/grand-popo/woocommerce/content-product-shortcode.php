<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $classes, $rating,$grand_popo_products_counter,$row_number,$products,$columns,$columns_medium;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
?>

    <div <?php post_class($classes); ?>>
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>

        <div class="product-thumbnail-wrap">
                
            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('woocommerce_before_shop_loop_item_title');
            ?>

            <?php
            /**
             * woocommerce_after_shop_loop_item hook.
             *
             * @hooked woocommerce_template_loop_product_link_close - 5
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action('woocommerce_after_shop_loop_item');
            ?>

        </div>
    </a>
        <div class="flex-caption grand_popo-product-caption">
            
            <?php
            /**
             * woocommerce_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_product_title - 10
             */
            do_action('woocommerce_shop_loop_item_title');
            ?>
            
            <?php
              do_action( 'woocommerce_after_shop_loop_item_title' );
            
            ?>
        </div>
    

</div>

