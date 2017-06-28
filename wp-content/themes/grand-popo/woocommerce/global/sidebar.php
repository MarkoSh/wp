<?php
/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
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
 * @version     1.6.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $grand_popo_options;
$shop_sidebar_toggle = grand_popo_get_proper_value($grand_popo_options, 'opt-enable-toggle-sidebar', 1);

if($shop_sidebar_toggle == 1){
    $toggle_class="toggle";
}
else{
    $toggle_class="";
}
?>

<div id="secondary" class="shop-sidebar col xl-1-4 lg-1-4 md-1-1 sm-1-1" role="complementary">

    <span id="top-menu-close"><i class="ti-close"></i></span>
    <div id="shop-sidebar" class="<?php echo esc_attr($toggle_class); ?>">
<?php
if (!dynamic_sidebar('shop-sidebar')) {
    the_widget('WC_Widget_Product_Search');
} 
?>
    </div>
</div>

