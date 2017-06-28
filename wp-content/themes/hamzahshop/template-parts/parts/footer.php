<?php
/**
 * Displays Footer
 *
 */

?>

<?php if (  is_active_sidebar( 'footer-top' ) ) { ?>
<!--Service Area Start-->
<div class="service-area">
    <div class="container">
        <div class="service-padding">
            <div class="row">
                 <?php dynamic_sidebar( 'footer-top' ); ?>
            </div>
        </div>    
    </div>
</div>
<?php }?>

<!--End of Service Area-->

<?php if (  is_active_sidebar( 'footer' ) ) { ?>
<!--Footer Widget Area Start-->
<div class="footer-widget-area">
    <div class="container">
        <div class="footer-widget-padding"> 
            <div class="row">
           	 <?php dynamic_sidebar( 'footer' ); ?>
            </div>
        </div>     
    </div>
</div>
<!--End of Footer Widget Area-->
<?php }?>

 <!--Footer Area Start-->
<footer class="footer">
    <div class="container">
        <div class="footer-padding">   
            <div class="row">
                <div class="col-md-12">
                 
                        <?php $options = get_theme_mod( 'hamzahshop_theme_options' ); ?>
                        <p class="author"><?php /* translators: straing */ echo esc_html( $options['footer']['copyright'] );?>   <a href="<?php /* translators:straing */ echo esc_url( esc_html__( 'https://wordpress.org/', 'hamzahshop' ) ); ?>"><?php /* translators:straing */  printf( esc_html__( 'Proudly powered by %s', 'hamzahshop' ), 'WordPress' ); ?></a>
         
        <?php /* translators: straing */
        printf( esc_html__( 'Theme: %1$s by %2$s.', 'hamzahshop' ), 'hamzahshop', '<a href="' . esc_url( __( 'https://edatastyle.com', 'hamzahshop' ) ) . '" target="_blank">' . esc_html__( 'eDataStyle', 'hamzahshop' ) . '</a>' ); ?></p>
                  
                </div>
               
            </div>
        </div>    
    </div>
</footer>
<!--End of Footer Area-->