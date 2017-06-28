<?php
/**
 * Displays Header
 *
 */

?>
<div class="header-main hamzahshop-custom-header">
<div class="container">
<div class="header-content">
        <div class="row" >
          <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="logo"> 
            <?php
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                      the_custom_logo();
            }else{
            ?>
            
                <?php if ( is_front_page() && is_home() ) : ?>
                    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php endif; ?>
                <?php $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                     <p class="site-description"><?php echo esc_attr($description); ?></p>
                <?php endif; ?>
                
             <?php }?>   
        
            
             </div>
          </div>
         
         <?php do_action('hamzahshop_custom_product_search');?>
         <?php do_action('hamzahshop_custom_min_cart');?>
         
        </div>


</div>    
</div>
</div>