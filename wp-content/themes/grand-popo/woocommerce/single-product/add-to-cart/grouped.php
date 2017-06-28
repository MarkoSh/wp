<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
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
 * @version     3.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $post;

$parent_product_post = $post;

$grouped_products_ids= array_map(create_function('$o', 'return $o->get_id();'), $grouped_products);
$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'post__in'            => $grouped_products_ids,
	'post__not_in'        => array( $product->get_id() ),
	'meta_query'          => WC()->query->get_meta_query()
);

$grouped_products_arr = new WP_Query( $args );

do_action( 'woocommerce_before_add_to_cart_form' ); 
if ( $grouped_products_arr->have_posts() ) : ?>

<form class="cart" method="post" enctype='multipart/form-data'>
    <table cellspacing="0" class="group_table">
        <tbody>
            <?php
            $quantites_required = false;
            while ( $grouped_products_arr->have_posts() ) : $grouped_products_arr->the_post();
                $grouped_product=  new WC_Product(get_the_ID());
                $post_object = get_post($grouped_product->get_id());
                $quantites_required = $quantites_required || ( $grouped_product->is_purchasable() && !$grouped_product->has_options() );
                ?>
                <tr id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <td>
                        <?php if (!$grouped_product->is_purchasable() || $grouped_product->has_options()) : ?>
                            <?php woocommerce_template_loop_add_to_cart(); ?>

                        <?php elseif ($grouped_product->is_sold_individually()) : ?>
                            <input type="checkbox" name="<?php echo esc_attr('quantity[' . $grouped_product->get_id() . ']'); ?>" value="1" class="wc-grouped-product-add-to-cart-checkbox" />

                        <?php else : ?>
                            <?php
                            /**
                             * @since 3.0.0.
                             */
                            do_action('woocommerce_before_add_to_cart_quantity');
                            woocommerce_quantity_input(array(
                                'input_name' => 'quantity[' . $grouped_product->get_id() . ']',
                                'input_value' => isset($_POST['quantity'][$grouped_product->get_id()]) ? wc_stock_amount($_POST['quantity'][$grouped_product->get_id()]) : 0,
                                'min_value' => apply_filters('woocommerce_quantity_input_min', 0, $grouped_product),
                                'max_value' => apply_filters('woocommerce_quantity_input_max', $grouped_product->get_max_purchase_quantity(), $grouped_product),
                            ));
                            /**
                             * @since 3.0.0.
                             */
                            do_action('woocommerce_after_add_to_cart_quantity');
                            ?>
                        <?php endif; ?>
                    </td>
                    <td class="label">
                        <label for="product-<?php echo $grouped_product->get_id(); ?>">
                            <?php echo $grouped_product->is_visible() ? '<a href="' . esc_url(apply_filters('woocommerce_grouped_product_list_link', get_permalink(), $grouped_product->get_id())) . '">' . get_the_title() . '</a>' : get_the_title(); ?>
                        </label>
                    </td>
                    <?php do_action('woocommerce_grouped_product_list_before_price', $grouped_product); ?>
                    <td class="price">
                        <?php
                        echo $grouped_product->get_price_html();
                        echo wc_get_stock_html($grouped_product);
                        ?>
                    </td>
                </tr>
                <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </tbody>
    </table>

    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />

    <?php if ($quantites_required) : ?>

        <?php do_action('woocommerce_before_add_to_cart_button'); ?>
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
            <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
            <?php
            }
        ?>
        
        <?php do_action('woocommerce_after_add_to_cart_button'); ?>

    <?php endif; ?>
</form>

<?php 
do_action( 'woocommerce_after_add_to_cart_form' ); 
endif;

?>
