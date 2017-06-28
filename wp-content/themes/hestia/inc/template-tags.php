<?php
/**
 * Custom template tags for Hestia
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_layout' ) ) :
	/**
	 * Return class based on the layout.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.24
	 */
	function hestia_layout() {

		if ( is_page_template( 'page-templates/template-pagebuilder-full-width.php' ) ) {
			return 'main';
		}

		$hestia_general_layout = get_theme_mod( 'hestia_general_layout', 1 );
		if ( isset( $hestia_general_layout ) && $hestia_general_layout != 1 ) {
			$layout = 'main';
		} else {
			$layout = 'main main-raised';
		}
		return $layout;
	}
endif;

if ( ! function_exists( 'hestia_logo' ) ) :
	/**
	 * Display your custom logo if present.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_logo() {
		if ( get_theme_mod( 'custom_logo' ) ) {
			$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' );
			$logo = '<img src="' . esc_url( $logo[0] ) . '">';
		} else {
			if ( is_front_page() ) {
				$logo = '<h1>' . get_bloginfo( 'name' ) . '</h1>';
			} else {
				$logo = '<p>' . get_bloginfo( 'name' ) . '</p>';
			}
		}
		return $logo;
	}
endif;

if ( ! function_exists( 'hestia_category' ) ) :
	/**
	 * Display the first category of the post.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_category() {
		$category = get_the_category();
		if ( $category ) {
			echo '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" title="' .
				 /* translators: %s is Category name */
				 esc_attr( sprintf( __( 'View all posts in %s', 'hestia' ), $category[0]->name ) ) . '" ' . '>' . esc_html( $category[0]->name ) . '</a> ';
		}
	}
endif;

if ( ! function_exists( 'hestia_get_author' ) ) :
	/**
	 * Returns the author meta data outside the loop.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_get_author( $info ) {
		global $post;
		$author_id = $post->post_author;
		$author = get_the_author_meta( $info, $author_id );
		return $author;
	}
endif;

if ( ! function_exists( 'hestia_author_box' ) ) :
	/**
	 * Display author box below the posts.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_author_box() {
		?>
		<div class="card card-profile card-plain">
			<div class="row">
				<div class="col-md-2">
					<div class="card-avatar">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php the_author();  ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?></a>
					</div>
				</div>
				<div class="col-md-10">
					<h4 class="card-title"><?php esc_html( the_author() ); ?></h4>
					<p class="description"><?php esc_html( the_author_meta( 'description' ) ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hestia_featured_header' ) ) :
	/**
	 * Returns the header image if the featured image isn't available.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_featured_header() {
		$thumbnail = get_the_post_thumbnail_url();
		if ( ! $thumbnail ) {
			$thumbnail = get_header_image();
		}
		return esc_url( $thumbnail );
	}
endif;

if ( ! function_exists( 'hestia_wp_link_pages' ) ) :
	/**
	 * Display a custom wp_link_pages for singular view.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_wp_link_pages( $args = '' ) {
		$defaults = array(
			'before' => '<ul class="nav pagination pagination-primary">',
			'after' => '</ul>',
			'link_before' => '',
			'link_after' => '',
			'next_or_number' => 'number',
			'nextpagelink' => esc_html__( 'Next page', 'hestia' ),
			'previouspagelink' => esc_html__( 'Previous page', 'hestia' ),
			'pagelink' => '%',
			'echo' => 1,
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';
		if ( $multipage ) {
			if ( 'number' == $r['next_or_number'] ) {
				$output .= $r['before'];
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $r['pagelink'] );
					$output .= ' ';
					$output .= $r['link_before'];
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
						$output .= _wp_link_page( $i );
					} else {
						$output .= '<span class="page-numbers current">';
					}
					$output .= $j;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
						$output .= '</a>';
					} else {
						$output .= '</span>';
					}
					$output .= $r['link_after'];
				}
				$output .= $r['after'];
			} else {
				if ( $more ) {
					$output .= $r['before'];
					$i = $page - 1;
					if ( $i && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $r['link_before'] . $r['previouspagelink'] . $r['link_after'] . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $r['link_before'] . $r['nextpagelink'] . $r['link_after'] . '</a>';
					}
					$output .= $r['after'];
				}
			}// End if().
		}// End if().

		if ( $r['echo'] ) {
			echo wp_kses( $output, array(
				'div' => array(
					'class' => array(),
					'id' => array(),
				),
				'ul' => array(
					'class' => array(),
				),
				'a' => array(
					'href' => array(),
				),
				'li' => array(),
				'span' => array(
					'class' => array(),
				),
			) );
		}

		return $output;
	}
endif;

if ( ! function_exists( 'hestia_comments_list' ) ) :
	/**
	 * Custom list of comments for the theme.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_comments_list( $comment, $args, $depth ) {
		?>
		<div <?php comment_class( empty( $args['has_children'] ) ? 'media' : 'parent media' ) ?> id="comment-<?php comment_ID() ?>">
			<?php if ( $args['type'] != 'pings' ) : ?>
				<a class="pull-left" href="<?php echo esc_url( get_comment_author_url( $comment ) ); ?> ">
					<div class="comment-author avatar vcard">
						<?php if ( $args['avatar_size'] != 0 ) { echo get_avatar( $comment, 64 ); } ?>
					</div>
				</a>
			<?php endif; ?>
			<div class="media-body">
				<h4 class="media-heading">
					<?php echo get_comment_author_link(); ?>
					<small>
						<?php
						/* translators: %1$s is Date, %2$s is Time */
						printf( esc_html__( '&#183; %1$s at %2$s', 'hestia' ),
							get_comment_date(),
							get_comment_time()
						);
						edit_comment_link( esc_html__( '(Edit)', 'hestia' ), '  ', '' );
						?>
					</small>
				</h4>
				<?php comment_text(); ?>
				<div class="media-footer">
					<?php
					echo get_comment_reply_link(
						array(
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'reply_text' => sprintf( '<i class="fa fa-mail-reply"></i> %s', esc_html__( 'Reply', 'hestia' ) ),
						),
						$comment->comment_ID,
						$comment->comment_post_ID
					); ?>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hestia_comments_template' ) ) :
	/**
	 * Custom list of comments for the theme.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_comments_template() {
		if ( is_user_logged_in() ) {
			$current_user = get_avatar( wp_get_current_user(), 64 );
		} else {
			$current_user = '<img src="' . get_template_directory_uri() . '/assets/img/placeholder.jpg" height="64" width="64"/>';
		}
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$args = array(
			'class_form' => 'form',
			'class_submit' => 'btn btn-primary pull-right',
			'title_reply_before' => '<h3 class="title text-center">',
			'title_reply_after' => '</h3> <span class="pull-left author"> <div class="avatar">' . $current_user . '</div> </span> <div class="media-body">',
			'must_log_in' => '<p class="must-log-in">' .
							 /* translators: %s is Link to login */
							 sprintf( wp_kses( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'hestia' ),  array(
								 'a' => array(
								 'href' => array(),
								 ),
							 ) ), esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) ) . '</p> </div>',
			'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' => '<div class="row"> <div class="col-md-4"> <div class="form-group label-floating is-empty"> <label class="control-label">' . esc_html__( 'Name', 'hestia' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="author" name="author" class="form-control" type="text"' . $aria_req . ' /> <span class="hestia-input"></span> </div> </div>',
				'email' => '<div class="col-md-4"> <div class="form-group label-floating is-empty"> <label class="control-label">' . esc_html__( 'Email', 'hestia' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="email" name="email" class="form-control" type="email"' . $aria_req . ' /> <span class="hestia-input"></span> </div> </div>',
				'url' => '<div class="col-md-4"> <div class="form-group label-floating is-empty"> <label class="control-label">' . esc_html__( 'Website', 'hestia' ) . '</label><input id="url" name="url" class="form-control" type="url"' . $aria_req . ' /> <span class="hestia-input"></span> </div> </div> </div>',
			) ),
			'comment_field' => '<div class="form-group label-floating is-empty"> <label class="control-label">' . esc_html__( 'What\'s on your mind?', 'hestia' ) . '</label><textarea id="comment" name="comment" class="form-control" rows="6" aria-required="true"></textarea><span class="hestia-input"></span> </div> </div>',
		);
		return $args;
	}
endif;

if ( ! function_exists( 'hestia_comments_pagination' ) ) :
	/**
	 * Display a custom number page navigation for comments.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_comments_pagination() {
		$pages = paginate_comments_links( array(
			'echo' => false,
			'type' => 'array',
		) );
		if ( is_array( $pages ) ) {
			echo '<div class="text-center"><ul class="nav pagination pagination-primary">';
			foreach ( $pages as $page ) {
				echo '<li>' . $page . '</li>';
			}
			echo '</ul></div>';
		}
	}
endif;

if ( ! function_exists( 'hestia_related_posts' ) ) :
	/**
	 * Related posts for single view.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_related_posts() {
		global $post;
		$cats = wp_get_object_terms( $post->ID, 'category', array(
			'fields' => 'ids',
		) );
		$args = array(
			'posts_per_page' => 3,
			'cat' => $cats,
			'orderby' => 'date',
			'ignore_sticky_posts' => true,
			'post__not_in' => array( $post->ID ),
		);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) :
			?>
			<div class="section">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2 class="title text-center"><?php esc_html_e( 'Related Posts', 'hestia' ); ?></h2>
							<div class="row">
								<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
									<div class="col-md-4">
										<div class="card card-blog">
											<?php if ( has_post_thumbnail() ) : ?>
												<div class="card-image">
													<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
														<?php the_post_thumbnail( 'hestia-blog' ); ?>
													</a>
												</div>
											<?php endif; ?>
											<div class="content">
												<h6 class="category text-info"><?php hestia_category(); ?></h6>
												<?php the_title( sprintf( '<h4 class="card-title"><a class="blog-item-title-link"  href="%s" title="%s" rel="bookmark">', esc_url( get_permalink() ), the_title_attribute( array(
													'echo' => false,
												) ) ), '</a></h4>' ); ?>
												<p class="card-description"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
											</div>
										</div>
									</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		endif;
	}
endif;

if ( ! function_exists( 'hestia_social_icons' ) ) :
	/**
	 * Social sharing icons for single view.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_social_icons() {
		?>
		<div class="entry-social">
			<a target="_blank" rel="tooltip" data-original-title="<?php esc_attr_e( 'Share on Facebook', 'hestia' ); ?>" class="btn btn-just-icon btn-round btn-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
			<a target="_blank" rel="tooltip" data-original-title="<?php esc_attr_e( 'Share on Twitter', 'hestia' ); ?>" class="btn btn-just-icon btn-round btn-twitter" href="https://twitter.com/home?status=<?php echo wp_strip_all_tags( get_the_title() ); ?> - <?php the_permalink(); ?>"><i class="fa fa-twitter"></i></a>
			<a target="_blank" rel="tooltip" data-original-title="<?php esc_attr_e( 'Share on Google+', 'hestia' ); ?>" class="btn btn-just-icon btn-round btn-google" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google"></i></a>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hestia_get_image_sizes' ) ) :
	/**
	 * Output image sizes for attachment single page.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_get_image_sizes() {

		/* If not viewing an image attachment page, return. */
		if ( ! wp_attachment_is_image( get_the_ID() ) ) {
			return;
		}

		/* Set up an empty array for the links. */
		$links = array();

		/* Get the intermediate image sizes and add the full size to the array. */
		$sizes = get_intermediate_image_sizes();
		$sizes[] = 'full';

		/* Loop through each of the image sizes. */
		foreach ( $sizes as $size ) {

			/* Get the image source, width, height, and whether it's intermediate. */
			$image = wp_get_attachment_image_src( get_the_ID(), $size );

			/* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
			if ( ! empty( $image ) && ( true == $image[3] || 'full' == $size ) ) {
				$links[] = '<a target="_blank" class="image-size-link" href="' . esc_url( $image[0] ) . '">' . $image[1] . ' &times; ' . $image[2] . '</a>';
			}
		}

		/* Join the links in a string and return. */
		return join( ' <span class="sep">|</span> ', $links );
	}
endif;

/**
 * Hestia Contact Old Defaults
 */
function hestia_contact_get_old_content( $theme_mod ) {
	$contact_section_default_old = get_theme_mod( $theme_mod );
	$output                      = '';

	if ( ! empty( $contact_section_default_old ) ) {
		$contact_section_default_old_content = json_decode( $contact_section_default_old );
		if ( ! empty( $contact_section_default_old_content ) ) {
			foreach ( $contact_section_default_old_content as $contact_item ) {
				if ( ! empty( $contact_item ) ) {
					$output .= '<div class="info hestia-info info-horizontal">' . "\n";

					if ( ! empty( $contact_item->icon_value ) ) {
						$output .= '<div class="icon icon-primary"><i class="fa ' . esc_attr( $contact_item->icon_value ) . '"></i></div>' . "\n";
					}

					$output .= '<div class="description">' . "\n";

					if ( ! empty( $contact_item->title ) ) {
						$output .= '<h4 class="info-title">' . wp_kses_post( $contact_item->title ) . '</h4>' . "\n";
					}

					if ( ! empty( $contact_item->text ) ) {
						$output .= '<p>' . wp_kses_post( $contact_item->text ) . '</p>' . "\n";
					}
					$output .= '</div></div>';
				}
			}
		}
	}
	return $output;
}

/**
 * Function to display footer content.
 *
 * @since 1.1.24
 * @access public
 */
function hestia_the_footer_content() {
	$hestia_general_credits = get_theme_mod( 'hestia_general_credits',
		/* translators: %1$s is Theme Name, %2$s is WordPress */
		sprintf( esc_html__( '%1$s | Powered by %2$s', 'hestia' ),
			/* translators: %s is Theme name */
			sprintf( '<a href="https://themeisle.com/themes/hestia/" target="_blank" rel="nofollow">%s</a>',
				esc_html__( 'Hestia', 'hestia' )
			),
			/* translators: %s is WordPress */
			sprintf( '<a href="%1$s" rel="nofollow">%2$s</a>',
				esc_url( __( 'http://wordpress.org', 'hestia' ) ),
				esc_html__( 'WordPress', 'hestia' )
			)
		)
	);

	$footer_has_widgets = is_active_sidebar( 'footer-one-widgets' ) || is_active_sidebar( 'footer-two-widgets' ) || is_active_sidebar( 'footer-three-widgets' ); ?>
	<footer class="footer footer-black footer-big">
		<div class="container">
			<?php
			if ( $footer_has_widgets ) { ?>
				<div class="content">
					<div class="row">
						<div class="col-md-12">
							<?php if ( is_active_sidebar( 'footer-one-widgets' ) ) : ?>
								<div class="col-md-4">
									<?php dynamic_sidebar( 'footer-one-widgets' ); ?>
								</div>
							<?php endif; ?>
							<?php if ( is_active_sidebar( 'footer-two-widgets' ) ) : ?>
								<div class="col-md-4">
									<?php dynamic_sidebar( 'footer-two-widgets' ); ?>
								</div>
							<?php endif; ?>
							<?php if ( is_active_sidebar( 'footer-three-widgets' ) ) : ?>
								<div class="col-md-4">
									<?php dynamic_sidebar( 'footer-three-widgets' ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<hr/>
				<?php
			}
			wp_nav_menu( array(
				'theme_location'    => 'footer',
				'depth'             => 1,
				'container'         => 'ul',
				'menu_class'   => 'footer-menu pull-left',
			) ); ?>
			<?php if ( ! empty( $hestia_general_credits ) || is_customize_preview() ) : ?>
				<div class="copyright pull-right">
					<?php echo wp_kses_post( $hestia_general_credits ); ?>
				</div>
			<?php endif; ?>
		</div>
	</footer>
	<?php
}
add_action( 'hestia_do_footer','hestia_the_footer_content' );

/**
 * Function to display header content.
 *
 * @since 1.1.24
 * @access public
 */
function hestia_the_header_content() {
	$navbar_class = '';

	if ( get_option( 'show_on_front' ) === 'page' && is_front_page() && ! is_page_template() ) {
		$navbar_class = 'navbar-color-on-scroll navbar-transparent';
	}
	?>

	<nav class="navbar navbar-default navbar-fixed-top <?php echo esc_attr( $navbar_class ); ?>">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navigation">
					<span class="sr-only"><?php esc_html_e( 'Toggle Navigation', 'hestia' ); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="title-logo-wrapper">
					<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo hestia_logo(); ?></a>
				</div>
			</div>
			<?php
			wp_nav_menu( array(
				'theme_location'    => 'primary',
				'depth'             => 2,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'main-navigation',
				'menu_class'        => 'nav navbar-nav navbar-right',
				'fallback_cb'       => 'hestia_bootstrap_navwalker::fallback',
				'walker'            => new hestia_bootstrap_navwalker(),
			) );
			?>
		</div>
	</nav>
	<?php
}
add_action( 'hestia_do_header','hestia_the_header_content' );

/**
 * Display sidebar placeholder.
 *
 * @param string $class_to_add Classes to add on container.
 * @access public
 * @since 1.1.24
 */
function hestia_sidebar_placeholder( $class_to_add ) {
	$content = apply_filters( 'hestia_sidebar_placeholder_content', esc_html__( 'This sidebar is active but empty. In order to use this layout, please add widgets in the sidebar', 'hestia' ) ); ?>
	<aside id="secondary" class="col-md-3 blog-sidebar <?php echo esc_attr( $class_to_add ); ?>" role="complementary">
		<div class="hestia-widget-placeholder">
			<?php
			the_widget( 'WP_Widget_Text', 'text=' . $content ); ?>
		</div>
	</aside><!-- .sidebar .widget-area -->
	<?php
}

/**
 * Function to decide which classes to add on content. It depends if sidebar is visible or not.
 *
 * $args format:
 * array(
 *  'full-width' => '.classes_to_add',
 *  'sidebar-right' => '.classes_to_add'',
 *  'sidebar-left' => '.classes_to_add',
 *  'is_shop' => false
 * )
 *
 * @param string $layout Control on page layout.
 * @param string $sidebar_name Sidebar id.
 * @param array  $args Arguments.
 * @return string
 */
function hestia_get_content_classes( $layout, $sidebar_name, $args ) {
	if ( class_exists( 'WooCommerce' ) && ( is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
		return 'col-md-12';
	}
	$class_to_add = ! empty( $args['full-width'] ) ? $args['full-width'] : 'col-md-12';
	$is_shop = ! empty( $args['is_shop'] ) ? $args['is_shop'] : false;
	if ( is_active_sidebar( $sidebar_name ) && ! empty( $layout ) || is_customize_preview() ) {
		switch ( $layout ) {
			case 'sidebar-right':
				$class_to_add = $args['sidebar-right'];
				if ( $is_shop && ! is_product() ) {
					add_filter( 'loop_shop_columns', 'hestia_shop_loop_columns' );
				}
				break;
			case 'sidebar-left':
				$class_to_add = $args['sidebar-left'];
				if ( $is_shop && ! is_product() ) {
					add_filter( 'loop_shop_columns', 'hestia_shop_loop_columns' );
				}
				break;
		}
	}
	return $class_to_add;
}
