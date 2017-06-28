<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package HamzahShop
 */

get_header(); ?>

<!-- Section: Page Header -->
<section class="section-page-header">
    <div class="container">
        <div class="row">

            <!-- Page Title -->
            <div class="col-md-12">
				<h1 class="page-title"> <?php echo esc_html( 'Search Results for: %s', 'hamzahshop' );?><?php echo esc_attr( get_search_query() ); ?></h1>
            </div>
            <!-- /Page Title -->

        </div>
    </div>
</section>
<!-- /Section: Page Header -->

	     
  <div class="blog-page-area">        
		<main id="main" class="site-main container" role="main">
			<div class="row">
            <div class="col-md-9">
		<?php
		if ( have_posts() ) :
		
			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );;

			endwhile;
			
			the_posts_pagination( array(
					'format' => '/page/%#%',
					'type' => 'list',
					'mid_size' => 2,
					'prev_text' => __( 'Previous', 'hamzahshop' ),
					'next_text' => __( 'Next', 'hamzahshop' ),
					'screen_reader_text' => __( '&nbsp;', 'hamzahshop' ),
				) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
        </div>
        <div class="col-md-3">
        	<?php get_sidebar(); ?>
        </div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php
get_footer();
