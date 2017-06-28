<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Milestone Lite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="sitewrapper" <?php if( get_theme_mod( 'box_layout' ) ) { echo 'class="boxlayout"'; } ?>>



<div class="header <?php if( get_theme_mod( 'stickyheader' ) ) { ?>no-sticky<?php } ?> <?php if( !is_front_page() && !is_home() ){ ?>headerinner<?php } ?>">
<?php $hidesocial = get_theme_mod('disabled_social', '1'); ?>
	 				 <?php if($hidesocial == ''){ ?>
<div class="header-top">
  <div class="container">
         <div class="social-icons">                   
                   <?php $fb_link = get_theme_mod('fb_link');
		 				if( !empty($fb_link) ){ ?>
            			<a title="facebook" class="fa fa-facebook" target="_blank" href="<?php echo esc_url($fb_link); ?>"></a>
           		   <?php } ?>
                
                   <?php $twitt_link = get_theme_mod('twitt_link');
					if( !empty($twitt_link) ){ ?>
					<a title="twitter" class="fa fa-twitter" target="_blank" href="<?php echo esc_url($twitt_link); ?>"></a>
          		  <?php } ?>
            
    			  <?php $gplus_link = get_theme_mod('gplus_link');
					if( !empty($gplus_link) ){ ?>
					<a title="google-plus" class="fa fa-google-plus" target="_blank" href="<?php echo esc_url($gplus_link); ?>"></a>
           		  <?php }?>
            
           		  <?php $linked_link = get_theme_mod('linked_link');
					if( !empty($linked_link) ){ ?>
					<a title="linkedin" class="fa fa-linkedin" target="_blank" href="<?php echo esc_url($linked_link); ?>"></a>
          		  <?php } ?>                  
         </div><!--end .social-icons-->   
  </div>
 </div><!--end header-top-->
<?php } ?> 
        <div class="container">
            <div class="logo">
            			<?php milestone_lite_the_custom_logo(); ?>
                        <h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
                        <span><?php bloginfo('description'); ?></span>
            </div><!-- logo -->
            <?php if ( ! dynamic_sidebar( 'header-1' ) ) : ?>
            <?php endif; // end sidebar widget area ?>	
            <div class="clear"></div>
            
        </div><!-- container -->
        
<div class="mainmenu">
 <div class="container">
    <div class="toggle">
        <a class="toggleMenu" href="#"><?php _e('Menu','milestone-lite'); ?></a>
    </div><!-- toggle --> 
    <div class="headermenu">                   
   	  <?php wp_nav_menu( array('theme_location' => 'primary') ); ?>   
    </div><!--.headermenu --> 
    
  </div><!-- .container-->
 </div><!-- .mainmenu-->
 
 
</div><!--.header -->

<?php 
if ( is_front_page() && !is_home() ) {
$hideslide = get_theme_mod('disabled_slides', '1');
if($hideslide == '') {
	for($i=7; $i<=9; $i++) {
	  if( get_theme_mod('slide-page'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('slide-page'.$i,true));
	  }
	}
?>                
                
<?php if(!empty($slider_Arr)){ ?>
    <div id="slider" class="nivoSlider">
        <?php 
        $i=1;
        $slidequery = new WP_query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
        while( $slidequery->have_posts() ) : $slidequery->the_post();
        $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>
        <?php if(!empty($image)){ ?>
        <img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo $i; ?>" />
        <?php }else{ ?>
        <img src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/slides/slider-default.jpg" title="#slidecaption<?php echo $i; ?>" />
        <?php } ?>
        <?php $i++; endwhile; ?>
    </div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo $j; ?>" class="nivo-html-caption">
        <div class="slide_info">
            <h2><?php the_title(); ?></h2>
            <p><?php echo esc_html( wp_trim_words( get_the_content(), 20, '' ) );  ?></p>
            <?php
		 $slider_readmore = get_theme_mod('slider_readmore');
		 if( !empty($slider_readmore) ){ ?>
          <a class="slide_more" href="<?php the_permalink(); ?>"><?php echo esc_attr($slider_readmore); ?></a>
	  	 <?php } ?>                   
        </div>
    </div>      
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>   
    
     </div><!--end .slider area-->    
<div class="clear"></div>        
<?php } ?>
<?php } } ?>
       
        
<?php if ( is_front_page() && ! is_home() ) { ?>   
	<?php
        $hidepageboxes = get_theme_mod('disabled_pgboxes', '1');
        if( $hidepageboxes == ''){
    ?>  
    <section id="sectiopn-1">
            	<div class="container">
                    <div class="pageboxwrap">                               
                        <?php for($p=1; $p<5; $p++) { ?>       
                        <?php if( get_theme_mod('pagebox-area'.$p,false)) { ?>          
                            <?php $queryvar = new WP_query('page_id='.absint(get_theme_mod('pagebox-area'.$p,true)) ); ?>				
                                    <?php while( $queryvar->have_posts() ) : $queryvar->the_post(); ?> 
                                    <div class="page-four-column <?php if($p % 4 == 0) { echo "last_column"; } ?>">                                    
                                      <?php if(has_post_thumbnail() ) { ?>
                                        <div class="page-thumbbox"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a></div>
                                      <?php } ?>
                                     <div class="page-content">
                                     <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>                                    
                                     <p><?php echo wp_trim_words( get_the_content(), 20, '...' ); ?></p>
                                    <a class="ReadMore" href="<?php the_permalink(); ?>">                                      
                                     <?php _e('Read More','milestone-lite'); ?>
                                    </a> 
                                     </div>                                   
                                    </div>
                                    <?php endwhile;
                                   		 wp_reset_postdata(); ?>                                    
                       				<?php } } ?>                                 
                    <div class="clear"></div>  
               </div><!-- pageboxwrap-->            
            </div><!-- container -->
       </section>          	      
<?php } ?>
<?php } ?>