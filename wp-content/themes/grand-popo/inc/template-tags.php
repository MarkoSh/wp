<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Grand-Popo
 */

if ( ! function_exists( 'grand_popo_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function grand_popo_posted_on() {
	$posted_on = sprintf(
		esc_html_x( ' %s', 'post date', 'grand-popo' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . get_the_date() . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'grand_popo_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function grand_popo_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'grand-popo' ) );
		if ( $categories_list && grand_popo_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'grand-popo' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'grand-popo' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'grand-popo' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'grand-popo' ), esc_html__( '1 Comment', 'grand-popo' ), esc_html__( '% Comments', 'grand-popo' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'grand-popo' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function grand_popo_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'grand_popo_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'grand_popo_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so grand_popo_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so grand_popo_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in grand_popo_categorized_blog.
 */
function grand_popo_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'grand_popo_categories' );
}
add_action( 'edit_category', 'grand_popo_category_transient_flusher' );
add_action( 'save_post',     'grand_popo_category_transient_flusher' );
