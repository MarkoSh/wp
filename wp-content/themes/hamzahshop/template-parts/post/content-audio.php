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
<?php
	$content = apply_filters( 'the_content', get_the_content() );
	$audio = false;

	// Only get audio from the content if a playlist isn't present.
	if ( false === strpos( $content, 'wp-playlist-script' ) ) {
		$audio = get_media_embedded_in_content( $content, array( 'audio' ) );
	}

?>
    
<div class="single-blog fix">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
		if ( ! is_single() ) :

			// If not a single post, highlight the audio file.
			if ( ! empty( $audio ) ) :
				foreach ( $audio as $audio_html ) {
					echo '<div class="entry-audio">';
						echo $audio_html;
					echo '</div><!-- .entry-audio -->';
				}
			endif;

		endif;
	?>		
                            
     <div class="postinfo-wrapper">
        <div class="post-date">
            <span class="day"><?php echo get_the_date('d'); ?></span><span class="month"><?php echo get_the_date('M'); ?></span>
        </div>
        <div class="post-info">
           
			<?php
            if ( is_single() ) :
           		 the_title( '<h1 class="entry-title blog-post-title">', '</h1>' );
            else :
           		 the_title( '<h2 class="entry-title blog-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;?>
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