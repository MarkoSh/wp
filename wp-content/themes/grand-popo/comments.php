<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Grand-Popo
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title single-section-title">
                    <?php
                        $comments_number = get_comments_number();
                        if ( '1' === $comments_number ) {
                                printf( _x( 'Comment (1)', 'comments title', 'grand-popo' ) );
                        } else {
                                printf(
                                        /* translators: %s: number of comments*/
                                        _nx(
                                                'Comment (%s)',
                                                'Comments (%s)',
                                                $comments_number,
                                                'comments title',
                                                'grand-popo'
                                        ),
                                        number_format_i18n( $comments_number )
                                );
                        }
                    ?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'grand-popo' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'grand-popo' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'grand-popo' ) ); ?></div>

			</div>
		</nav>
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
                        wp_list_comments('callback=grand_popo_comments');
			?>
		</ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'grand-popo' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'grand-popo' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'grand-popo' ) ); ?></div>

			</div>
		</nav>
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'grand-popo' ); ?></p>
	<?php
	endif;

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
        
	$fields =  array(
	    'author' => '<p class="comment-form-author col xl-1-3 lg-1-3 md-1-3 sm-1-1"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder=" '. esc_html__( 'Name', 'grand-popo' ) .'&nbsp;* " /></p>',
	    'email'  => '<p class="comment-form-email col xl-1-3 lg-1-3 md-1-3 sm-1-1"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder=" '. esc_html__( 'Email', 'grand-popo' ) .'&nbsp;* " /></p>',
	    'url'    => '<p class="comment-form-url col xl-1-3 lg-1-3 md-1-3 sm-1-1"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder=" '. esc_html__( 'Your Website', 'grand-popo' ) .' "/></p>'

	);

	$comments_args = array(
            'class_form' => 'comment-form o-wrap xl-gutter-24 lg-gutter-24 md-gutter-24 sm-gutter-0',
            'title_reply' =>  esc_html__('Leave a comment', 'grand-popo'),
	    'fields' =>  $fields,
	    'comment_field' => '<p class="comment-form-comment col xl-1-1 lg-1-1 md-1-1 sm-1-1"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder=" '. esc_html__( 'Your comment', 'grand-popo' ) .'&nbsp;*" ></textarea></p>',
	    'comment_notes_after' => '',
	    'label_submit' => esc_html__('Submit now', 'grand-popo')
	);
	 
	comment_form($comments_args);

	?>

</div><!-- #comments -->