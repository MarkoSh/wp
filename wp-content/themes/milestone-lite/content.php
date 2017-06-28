<?php
/**
 * @package Milestone Lite
 */
?>
 <div class="siteblog_listing">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
         <?php if (has_post_thumbnail() ){ ?>
			<div class="post-thumb">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			</div>
		<?php }  ?> 
        
        <header class="entry-header">           
            <h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            <?php if ( 'post' == get_post_type() ) : ?>
                <div class="postmeta">
                    <div class="post-date"><?php the_date(); ?></div><!-- post-date -->
                    <div class="post-comment"> <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></div>                                  
                </div><!-- postmeta -->
            <?php endif; ?>
        </header><!-- .entry-header -->
          
        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
           	<?php the_excerpt(); ?>
            <a class="ReadMore" href="<?php the_permalink(); ?>"><?php _e('Read More &raquo;','milestone-lite'); ?></a>
        </div><!-- .entry-summary -->
        <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'milestone-lite' ) ); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'milestone-lite' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->
        <?php endif; ?>
        <div class="clear"></div>
    </article><!-- #post-## -->
</div><!-- site-bloglist-repeat -->