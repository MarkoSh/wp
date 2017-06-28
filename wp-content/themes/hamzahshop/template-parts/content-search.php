<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HamzahShop
 */
$showPost = get_theme_mod('hamzahshop_theme_options_postshow', 'excerpt');
?>
<div class="single-blog fix">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
                            
     <div class="postinfo-wrapper search">
    
        <div class="post-info">
        	<?php 
			the_title( '<h2 class="entry-title blog-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
           
            <?php if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <?php hamzahshop_posted_on();?>
            </div>
            <?php endif;?>
            
            
            <div class="entry-summary">
                <?php
					if( $showPost == 'excerpt'):
						the_excerpt();
					else:
						the_content();
					endif;
				 ?>
            </div>
          
             <a href="<?php echo esc_url( get_permalink()); ?>" class="read-button"><?php esc_html_e('Continue Reading', 'hamzahshop'); ?> <i class="fa fa-fw fa-angle-double-right"></i></a>
        </div>
    </div>
    
    
                           

</article><!-- #post-## -->
</div>