<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HamzahShop
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php if ( has_post_thumbnail() ) :?>
  <div class="post-thumbnail">
    <?php the_post_thumbnail('full');?>
  </div>
  <?php endif;?>
  <div class="entry-content">
    <?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hamzahshop' ),
				'after'  => '</div>',
			) );
		?>
  </div>
  <!-- .entry-content -->
  
  <?php if ( get_edit_post_link() ) : ?>
  <footer class="entry-footer">
		<?php
        edit_post_link(
            sprintf(
                /* translators: %s: Name of current post */
                esc_html__( 'Edit %s', 'hamzahshop' ),
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>
  </footer>
  <!-- .entry-footer -->
  <?php endif; ?>
</article>
<!-- #post-## --> 
