<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mise
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if(mise_options('_show_loader', '0') == 1 ) : ?>
	<div class="miseLoader">
		<?php mise_loadingPage(); ?>
	</div>
<?php endif; ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mise' ); ?></a>

	<?php if (is_singular(array( 'post', 'page' )) && '' != get_the_post_thumbnail() && !is_page_template('template-onepage.php') ) : ?>
		<?php while ( have_posts() ) : 
		the_post(); ?>
		<?php 
			$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'mise-the-post');
			$firstLetterReverseColor = mise_options('_reverse_color', '1');
			$showScrollDownButton = mise_options('_scrolldown_button', '1');
			$zoomEffectFeatImage = mise_options('_zoomeffect_featimage', '1');
		?>
		<div class="miseBox">
			<div class="miseBigImage <?php echo $zoomEffectFeatImage ? 'withZoom' : 'noZoom' ?>" style="background-image: url(<?php echo esc_url($src[0]); ?>);">
				<div class="miseImageOp">
				</div>
			</div>
			<div class="miseBigText">
				<header class="entry-header <?php echo $firstLetterReverseColor ? 'reverse' : 'noReverse' ?>">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php mise_posted_on(); ?>
						<?php if ($showScrollDownButton) : ?>
							<div class="scrollDown"><span class="mouse-wheel"></span></div>
						<?php endif; ?>
					</div><!-- .entry-meta -->
					<?php else: ?>
						<?php if ($showScrollDownButton) : ?>
							<div class="entry-meta">
								<div class="scrollDown"><span class="mouse-wheel"></span></div>
							</div><!-- .entry-meta -->
						<?php endif; ?>
					<?php endif; ?>
				</header><!-- .entry-header -->
			</div>
		</div>
		<?php endwhile; ?>
	<?php endif; ?>
	<?php if (is_page_template('template-onepage.php') && mise_options('_onepage_section_slider', '1') == 1) : ?>
		<?php get_template_part( 'sections/section', 'slider' ); ?>
	<?php endif; ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="mainLogo">
			<div class="miseSubHeader title">
				<div class="site-branding">
					<?php
					if ( function_exists( 'the_custom_logo' ) ) {
						the_custom_logo();
					}
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
					endif; ?>
				</div><!-- .site-branding -->
			</div>
		</div>
		<div class="mainHeader">
			<div class="miseHeader">
				<div class="miseSubHeader">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-lg fa-bars"></i></button>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</div>
		<?php $showSearchButton = mise_options('_search_button', '1');
			if ($showSearchButton) : ?>
		<div class="mainStuff <?php echo is_active_sidebar( 'sidebar-push' ) ? 'withSpace' : 'noSpace' ?>">
		  <span class="circle"></span>
		  <span class="handle"></span>
		</div>
		<?php endif; ?>
	</header><!-- #masthead -->
	<?php if ( is_active_sidebar( 'sidebar-push' ) ) : ?>
		<div class="hamburger">
			<span></span>
			<span></span>
			<span></span>
		</div>
	<?php endif; ?>
	<?php 
	$showInFloat = mise_options('_social_float', '1');
	if ($showInFloat == 1) {
		mise_show_social_network('float');
	} ?>

	<div id="content" class="site-content">
