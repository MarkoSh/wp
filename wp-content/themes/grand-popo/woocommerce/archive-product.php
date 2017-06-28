<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $grand_popo_options;
$shop_layout = grand_popo_get_proper_value($grand_popo_options, 'shop-layout-template',"left-sidebar");

get_header('shop');

if ($shop_layout == "right-sidebar") {
    $shop_class = $shop_layout;
} else {
    $shop_class = "";
}

if($shop_layout != "no-sidebar"){
    $shop_sidebar_class = "col xl-3-4 lg-3-4 md-1-1 sm-1-1 ";

}else{
    $shop_sidebar_class = "col xl-1-1 lg-1-1 md-1-1 sm-1-1";
}

$shop_sidebar_wrapper="fix-shop-sidebar-wrapper";

if (is_active_sidebar('top-shop-sidebar')) {
    ?>
    <div class="top-shop-wrap">

        <div class="site-wrap">

            <div class="o-wrap">

                <div id="top-shop-sidebar" class="sidebar col xl-1-1 lg-1-1 md-1-1 sm-1-1 " role="complementary">
                    <?php dynamic_sidebar('top-shop-sidebar'); ?>
                </div>    

            </div>
        </div>

    </div>
    <?php
    $sidebar_pad="no-pad";
}else{
     $sidebar_pad="";
}


?>
<div id="shop-view-menu-mask"></div>
<div class="grand_popo-loop-wrap <?php echo esc_attr($shop_layout); ?>  <?php echo esc_attr($shop_sidebar_wrapper); ?>  <?php echo esc_attr($sidebar_pad); ?>"> 
    <div id="shop-view-menu-mask-2"></div>
    
    <div class="site-wrap o-wrap  ">
    <?php
        grand_popo_get_shop_tools($shop_layout);
    

if ($shop_layout == "left-sidebar")
    do_action('woocommerce_sidebar');

?>
    
    <div class="site-wrap grand_popo-loop  <?php echo esc_attr($shop_sidebar_class); ?>">
        <div id="top-menu-mask"></div>
        
<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content');
?>

        <?php
        /**
         * woocommerce_archive_description hook.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        //do_action( 'woocommerce_archive_description' );
        ?>

        <?php if (have_posts()) : 
            
            ?>
            <?php  woocommerce_product_loop_start(); ?>

            <?php woocommerce_product_subcategories(); ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php wc_get_template_part('content', 'product'); ?>

            <?php endwhile; // end of the loop.  ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
            /**
             * woocommerce_after_shop_loop hook.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
            ?>

        <?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

            <?php wc_get_template('loop/no-products-found.php'); ?>

        <?php endif; ?>

        <?php
        /**
         * woocommerce_after_main_content hook.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action('woocommerce_after_main_content');
        ?>

        
    </div>
        <?php
        if ($shop_layout == "right-sidebar")
            do_action('woocommerce_sidebar');
        ?> 
</div>


<?php get_footer('shop'); ?>
