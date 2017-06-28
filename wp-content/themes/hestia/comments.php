<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Hestia
 * @since Hestia 1.0
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

					<div id="comments" class="section section-comments">
						<div class="row">
							<div class="col-md-12">
								<div class="media-area">
									<h3 class="title text-center">
									<?php
									$comments_number = get_comments_number();
									if ( 1 === $comments_number ) {
										/* translators: %s: post title */
										printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'hestia' ), get_the_title() );
									} else {
										printf(
											/* translators: 1: number of comments, 2: post title */
											_nx(
												'%1$s thought on &ldquo;%2$s&rdquo;',
												'%1$s thoughts on &ldquo;%2$s&rdquo;',
												$comments_number,
												'comments title',
												'hestia'
											),
											number_format_i18n( $comments_number ),
											get_the_title()
										);
									}
									?>
									</h3>
									<?php
										wp_list_comments( 'type=comment&callback=hestia_comments_list' );
										wp_list_comments( 'type=pings&callback=hestia_comments_list' );
										hestia_comments_pagination();
									?>
								</div>
								<div class="media-body">
								<?php comment_form( hestia_comments_template() ); ?>
								<?php if ( ! comments_open() && get_comments_number() ) : ?>
									<?php if ( is_single() ) : ?>
										<h4 class="no-comments title text-center"><?php esc_html_e( 'Comments are closed.' , 'hestia' ); ?></h4>
									<?php endif; ?>
								<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
