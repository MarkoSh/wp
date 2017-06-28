<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Company_Elite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content-wrapper">
	<?php
	  /**
	   * Hook - company_elite_single_image.
	   *
	   * @hooked company_elite_add_image_in_single_display - 10
	   */
	  do_action( 'company_elite_single_image' );
	?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'company-elite' ),
				'after'  => '</div>',
			) );
		?>
			<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'company-elite' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
	</div><!-- .entry-content -->


	</div> <!-- .entry-content-wrapper -->
</article><!-- #post-## -->

