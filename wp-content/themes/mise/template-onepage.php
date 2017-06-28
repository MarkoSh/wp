<?php
/**
 *
 * Template Name: One Page Website
 *
 * The template used for displaying the website in onepage
 *
 * @package mise
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php get_template_part( 'sections/section', 'aboutus' ); ?>
			<?php get_template_part( 'sections/section', 'features' ); ?>
			<?php get_template_part( 'sections/section', 'skills' ); ?>
			<?php get_template_part( 'sections/section', 'cta' ); ?>
			<?php get_template_part( 'sections/section', 'services' ); ?>
			<?php get_template_part( 'sections/section', 'blog' ); ?>
			<?php get_template_part( 'sections/section', 'team' ); ?>
			<?php get_template_part( 'sections/section', 'contact' ); ?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar('push');
get_footer();