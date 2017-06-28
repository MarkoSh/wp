<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Company_Elite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content-wrapper">
	<?php if ( has_post_thumbnail() ) : ?>
		<?php
		$args = array(
			'class' => 'company-elite-post-thumb aligncenter',
		);
		the_post_thumbnail( 'large', $args );
		?>
	<?php endif; ?>

	<div class="entry-content">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php company_elite_posted_on(); ?>
			</div>
			<?php endif; ?>
		</header><!-- .entry-header -->
		<?php $archive_layout = company_elite_get_option( 'archive_layout' ); ?>

		<?php if ( 'full' === $archive_layout ) : ?>
			<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'company-elite' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'company-elite' ),
				'after'  => '</div>',
			) );
			?>
		<?php else : ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
			<footer class="entry-footer">
		<?php company_elite_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	</div> <!-- .entry-content-wrapper -->
	</div><!-- .entry-content -->


</article><!-- #post-## -->
