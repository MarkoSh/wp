<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package mise
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php $firstLetterReverseColor = mise_options('_reverse_color', '1'); ?>
	<header class="entry-header <?php echo '' != get_the_post_thumbnail() ? 'withImage' : 'noImage' ?> <?php echo $firstLetterReverseColor ? 'reverse' : 'noReverse' ?>">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php mise_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'mise' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span class="page-links-number">',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'mise' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php mise_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
