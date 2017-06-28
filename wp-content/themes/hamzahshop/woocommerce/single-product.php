<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<!-- Section: Page Header -->
  <section class="section-page-header">
  <div class="container">
    <div class="row"> 
      
      <!-- Page Title -->
      <div class="col-md-6">
			<h1 class="woocommerce-products-header__title page-title"><?php the_title(); ?></h1>
		
       </div>
       <!-- Page Title -->
      <div class="col-md-6">
     <?php do_action('hamzahshop_key_action_breadcrumb');?>
      </div> 
       

   </div>
  </div>
</section>
<!-- /Section: Page Header -->

<div class="content-area blog-page-area details-page">
    <main id="main" class="site-main" role="main">
    <div class="container">
    <div class="row">
    
   <?php if( get_theme_mod( 'hamzahshop_theme_shop_layout','sidebar') == 'sidebar' ):?> 
        <div class="col-md-9">
    <?php else: ?>
        <div class="col-md-12">
    <?php endif;?> 
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	 </div>
        <?php if( get_theme_mod( 'hamzahshop_theme_shop_layout','sidebar') == 'sidebar' ):?> 
        <div class="col-md-3">
        <?php
        /**
        * woocommerce_sidebar hook.
        *
        * @hooked woocommerce_get_sidebar - 10
        */
        do_action( 'woocommerce_sidebar' );
        ?>
        </div>
   	   <?php endif;?>
        
        
 </div>
    </div>
    </main><!-- #main -->
</div>
<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
