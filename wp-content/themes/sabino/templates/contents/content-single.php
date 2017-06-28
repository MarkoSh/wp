<?php
/**
 * @package Sabino
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( get_theme_mod( 'sabino-blog-single-featured-img' ) ) : ?>
	
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-content-img">
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
		<?php endif; ?>
		
	<?php endif; ?>
	
	<header class="entry-header">
		<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>

		<div class="entry-meta">
			<?php sabino_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'sabino' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php sabino_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->
