<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

get_header(); ?>
			<div id="primary" class="page-header header-filter header-small" data-parallax="active" style="background-image: url('<?php echo hestia_featured_header(); ?>');">
				<div class="container">
					<div class="row">
						<div class="col-md-10 col-md-offset-1 text-center">
							<?php single_post_title( '<h1 class="title">', '</h1>' ); ?>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="<?php echo hestia_layout(); ?>">
			<div class="blog-post">
				<div class="container">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content', 'page' );
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						endwhile;
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					?>
				</div>
			</div>
<?php get_footer(); ?>
