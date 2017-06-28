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
	<?php
		if ( '' != get_the_post_thumbnail() ) {
			echo '<div class="entry-featuredImg">';
			the_post_thumbnail('mise-little-post');
			echo '<div class="insideImage"><span><a href="' .esc_url(get_permalink()). '">'.esc_html__( 'Read More', 'mise' ).'<i class="spaceLeft fa fa-angle-right" aria-hidden="true"></i></a></span></div></div>';
		}
	?>
	<div class="entry-theContent">
		<header class="entry-header">
			<?php mise_entry_category(); ?>
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php mise_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'mise' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link"><i class="fa fa-wrench spaceRight" aria-hidden="true"></i>',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
