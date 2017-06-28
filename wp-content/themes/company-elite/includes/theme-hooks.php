<?php
/**
 * Functions hooked to custom hook.
 *
 * @package Company_Elite
 */

if ( ! function_exists( 'company_elite_skip_to_content' ) ) :

	/**
	 * Add skip to content.
	 *
	 * @since 1.0.0
	 */
	function company_elite_skip_to_content() {
		?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'company-elite' ); ?></a><?php
	}
endif;

add_action( 'company_elite_action_before', 'company_elite_skip_to_content', 15 );

if ( ! function_exists( 'company_elite_site_branding' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */
	function company_elite_site_branding() {
		?>
		<div id="main-header" class="clear">
		<div class="container">
		<div class="site-branding">

			<?php company_elite_the_custom_logo(); ?>

			<?php $show_title = company_elite_get_option( 'show_title' ); ?>
			<?php $show_tagline = company_elite_get_option( 'show_tagline' ); ?>

			<?php if ( true === $show_title || true === $show_tagline ) : ?>
				<div id="site-identity">
					<?php if ( true === $show_title ) : ?>
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( true === $show_tagline ) : ?>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div><!-- #site-identity -->
			<?php endif; ?>

		</div><!-- .site-branding -->
		<div id="main-nav" class="clear-fix">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="wrap-menu-content">
					<?php
					wp_nav_menu(
						array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'fallback_cb'    => 'company_elite_primary_navigation_fallback',
						)
					);
					?>
				</div><!-- .wrap-menu-content -->
			</nav><!-- #site-navigation -->
		</div><!-- #main-nav -->
		</div> <!-- .container -->
		</div> <!-- .main-header -->
	<?php
	}

endif;

add_action( 'company_elite_action_header', 'company_elite_site_branding' );

if ( ! function_exists( 'company_elite_mobile_navigation' ) ) :

	/**
	 * Mobile navigation.
	 *
	 * @since 1.0.0
	 */
	function company_elite_mobile_navigation() {
		?>
		<a id="mobile-trigger" href="#mob-menu"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
		<div id="mob-menu">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => '',
				'fallback_cb'    => 'company_elite_primary_navigation_fallback',
			) );
			?>
		</div>
		<?php
	}

endif;

add_action( 'company_elite_action_before', 'company_elite_mobile_navigation', 20 );

if ( ! function_exists( 'company_elite_footer_copyright' ) ) :

	/**
	 * Footer copyright.
	 *
	 * @since 1.0.0
	 */
	function company_elite_footer_copyright() {

		// Check if footer is disabled.
		$footer_status = apply_filters( 'company_elite_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}

		// Copyright content.
		$copyright_text = company_elite_get_option( 'copyright_text' );
		$copyright_text = apply_filters( 'company_elite_filter_copyright_text', $copyright_text );
	?>

	<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<?php
		$footer_menu_content = wp_nav_menu( array(
			'theme_location' => 'footer',
			'container'      => 'div',
			'container_id'   => 'footer-navigation',
			'depth'          => 1,
			'fallback_cb'    => false,
		) );
		?>
	<?php endif; ?>
	<?php if ( ! empty( $copyright_text ) ) : ?>
		<div class="copyright">
			<?php echo wp_kses_post( $copyright_text ); ?>
		</div>
	<?php endif; ?>
	<div class="site-info">
		<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'company-elite' ) ); ?>"><?php printf( esc_html__( 'Powered by %s', 'company-elite' ), 'WordPress' ); ?></a>
		<span class="sep"> | </span>
		<?php printf( esc_html__( '%1$s by %2$s', 'company-elite' ), 'Company Elite', '<a href="http://axlethemes.com">Axle Themes</a>' ); ?>
	</div>
	<?php
	}

endif;

add_action( 'company_elite_action_footer', 'company_elite_footer_copyright', 10 );

if ( ! function_exists( 'company_elite_add_sidebar' ) ) :

	/**
	 * Add sidebar.
	 *
	 * @since 1.0.0
	 */
	function company_elite_add_sidebar() {

		global $post;

		$global_layout = company_elite_get_option( 'global_layout' );
		$global_layout = apply_filters( 'company_elite_filter_theme_global_layout', $global_layout );

		// Check if single template.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'company_elite_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}

		// Include primary sidebar.
		if ( 'no-sidebar' !== $global_layout ) {
			get_sidebar();
		}

		// Include secondary sidebar.
		switch ( $global_layout ) {
			case 'three-columns':
				get_sidebar( 'secondary' );
				break;

			default:
				break;
		}

	}

endif;

add_action( 'company_elite_action_sidebar', 'company_elite_add_sidebar' );

if ( ! function_exists( 'company_elite_custom_posts_navigation' ) ) :

	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function company_elite_custom_posts_navigation() {

		the_posts_pagination();

	}

endif;

add_action( 'company_elite_action_posts_navigation', 'company_elite_custom_posts_navigation' );

if ( ! function_exists( 'company_elite_add_image_in_single_display' ) ) :

	/**
	 * Add image in single template.
	 *
	 * @since 1.0.0
	 */
	function company_elite_add_image_in_single_display() {

		if ( has_post_thumbnail() ) {
			$args = array(
				'class' => 'company-elite-post-thumb aligncenter',
			);
			the_post_thumbnail( 'large', $args );
		}

	}

endif;

add_action( 'company_elite_single_image', 'company_elite_add_image_in_single_display' );

if ( ! function_exists( 'company_elite_add_custom_header' ) ) :

	/**
	 * Add custom header.
	 *
	 * @since 1.0.0
	 */
	function company_elite_add_custom_header() {

		if ( ( is_front_page() && ! is_home() ) ) {
			return;
		}
		?>
		<div id="custom-header" style="background-image: url('<?php header_image(); ?>');">
			<div class="container">
				<div class="custom-header-content">
					<?php do_action( 'company_elite_action_custom_header_title' ); ?>
				</div><!-- .custom-header-content -->
				<?php do_action( 'company_elite_action_breadcrumb' ); ?>
			</div><!-- .container -->
		</div><!-- #custom-header -->
		<?php
	}

endif;

add_action( 'company_elite_action_before_content', 'company_elite_add_custom_header', 6 );

if ( ! function_exists( 'company_elite_add_title_in_custom_header' ) ) :

	/**
	 * Add title in custom header.
	 *
	 * @since 1.0.0
	 */
	function company_elite_add_title_in_custom_header() {

		echo '<h1 class="custom-header-title">';

		if ( is_home() ) {
			echo esc_html( company_elite_get_option( 'blog_page_title' ) );
		} elseif ( is_singular() ) {
			echo single_post_title( '', false );
		} elseif ( is_archive() ) {
			the_archive_title();
		} elseif ( is_search() ) {
			printf( esc_html__( 'Search Results for: %s', 'company-elite' ),  get_search_query() );
		} elseif ( is_404() ) {
			esc_html_e( '404 Error', 'company-elite' );
		}

		echo '</h1>';

	}

endif;

add_action( 'company_elite_action_custom_header_title', 'company_elite_add_title_in_custom_header' );

if ( ! function_exists( 'company_elite_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function company_elite_add_breadcrumb() {

		$breadcrumb_type = company_elite_get_option( 'breadcrumb_type' );

		// Bail if breadcrumb is disabled.
		if ( 'disabled' === $breadcrumb_type ) {
			return;
		}

		// Bail if home page.
		if ( is_front_page() || is_home() ) {
			return;
		}

		echo '<div id="breadcrumb">';
		company_elite_breadcrumb();
		echo '</div><!-- #breadcrumb -->';
		return;

	}

endif;

add_action( 'company_elite_action_breadcrumb', 'company_elite_add_breadcrumb' );

if ( ! function_exists( 'company_elite_footer_goto_top' ) ) :

	/**
	 * Go to top.
	 *
	 * @since 1.0.0
	 */
	function company_elite_footer_goto_top() {
		echo '<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-angle-up"></i></a>';
	}

endif;

add_action( 'company_elite_action_after', 'company_elite_footer_goto_top', 20 );

if ( ! function_exists( 'company_elite_add_front_page_widget_area' ) ) :

	/**
	 * Add front page widget area.
	 *
	 * @since 1.0.0
	 */
	function company_elite_add_front_page_widget_area() {

		if ( is_front_page() && ! is_home() ) {
			if ( is_active_sidebar( 'sidebar-front-page-widget-area' ) ) {
				echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
				dynamic_sidebar( 'sidebar-front-page-widget-area' );
				echo '</div><!-- #sidebar-front-page-widget-area -->';
			} else {
				if ( current_user_can( 'edit_theme_options' ) ) {
					echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
					company_elite_message_front_page_widget_area();
					echo '</div><!-- #sidebar-front-page-widget-area -->';
				}
			}
		}

	}
endif;

add_action( 'company_elite_action_before_content', 'company_elite_add_front_page_widget_area', 7 );

if ( ! function_exists( 'company_elite_add_footer_widgets' ) ) :

	/**
	 * Add footer widgets.
	 *
	 * @since 1.0.0
	 */
	function company_elite_add_footer_widgets() {

		get_template_part( 'template-parts/footer-widgets' );

	}
endif;

add_action( 'company_elite_action_before_footer', 'company_elite_add_footer_widgets', 5 );

if ( ! function_exists( 'company_elite_add_sub_header' ) ) :

	/**
	 * Add sub header.
	 *
	 * @since 1.0.0
	 */
	function company_elite_add_sub_header() {
		$contact_email         = company_elite_get_option( 'contact_email' );
		$contact_number        = company_elite_get_option( 'contact_number' );
		$contact_address       = company_elite_get_option( 'contact_address' );
		$show_social_in_header = company_elite_get_option( 'show_social_in_header' );
		$show_search_in_header = company_elite_get_option( 'show_search_in_header' );

		if ( empty( $contact_number ) && empty( $contact_email ) && empty( $contact_address ) ) {
			$contact_status = false;
		} else {
			$contact_status = true;
		}

		if ( false === $contact_status && false === $show_search_in_header && ( false === company_elite_get_option( 'show_social_in_header' ) || false === has_nav_menu( 'social' ) ) ) {
			return;
		}
		?>
		<div id="sub-header" class="clear">
		<div class="container">
			<div class="quick-contact">
				<ul>
					<?php if ( $contact_email ) : ?>
						<li><a href="<?php echo esc_url( 'mailto:' . $contact_email ); ?>"><i class="fa fa-envelope" aria-hidden="true"></i><?php echo esc_html( $contact_email ); ?></a></li>
					<?php endif; ?>
					<?php if ( $contact_number ) : ?>
						<li><a href="<?php echo esc_url( 'tel:' . preg_replace( '/\D+/', '', $contact_number ) ); ?>"><i class="fa fa-phone" aria-hidden="true"></i><?php echo esc_html( $contact_number ); ?></a></li>
					<?php endif; ?>
					<?php if ( $contact_address ) : ?>
						<li><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo esc_html( $contact_address ); ?></li>
					<?php endif; ?>
				</ul>
			</div><!-- .quick-contact -->
			<div class="header-social">
				<?php if ( true === $show_social_in_header && has_nav_menu( 'social' ) ) : ?>
					<?php the_widget( 'Company_Elite_Social_Widget' ); ?>
				<?php endif; ?>
				<?php if ( true === $show_search_in_header ) : ?>
					<div class="sub-header-right">
						<?php get_search_form(); ?>
					</div><!-- sub-header-right -->
				<?php endif; ?>
			</div><!-- .header-social -->
			</div> <!-- .container -->
		</div><!-- #sub-header -->
		<div class="header-shadow clear"></div>
		<?php
	}
endif;

add_action( 'company_elite_action_header', 'company_elite_add_sub_header', 12 );
