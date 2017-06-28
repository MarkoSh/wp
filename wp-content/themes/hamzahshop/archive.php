<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
				<?php
                the_archive_title( '<h1 class="page-title title">', '</h1>' );
                the_archive_description( '<div class="archive-description subtitle">', '</div>' );
                ?>
            </div>
            <!-- /Page Title -->

        </div>
    </div>
</section>
<!-- /Section: Page Header -->

<div class="blog-page-area">        
		<main id="main" class="site-main container" role="main">
			<div class="row">
            <?php if( get_theme_mod( 'hamzahshop_theme_blog_layout','sidebar') == 'sidebar' ):?> 
                <div class="col-md-9">
            <?php else: ?>
            <div class="col-md-12">
            <?php endif;?>  
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
				get_template_part( 'template-parts/post/content', get_post_format() );

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
		<?php if( get_theme_mod( 'hamzahshop_theme_blog_layout','sidebar') == 'sidebar' ):?> 
        <div class="col-md-3">
        <?php get_sidebar(); ?>
        </div>
        <?php endif;?>
                
                
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php
get_footer();
