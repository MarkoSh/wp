<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HamzahShop
 */

get_header(); ?>
<!-- Section: Page Header -->

<?php if ( !is_front_page() ) :  ?>
<section class="section-page-header">
  <div class="container">
    <div class="row"> 
      
      <!-- Page Title -->
      <div class="col-md-6">
        <?php the_title( '<h1 class="entry-title blog-post-title">', '</h1>' );?>
       
      </div>
      
      <!-- /Page Title --> 
       <div class="col-md-6">
      <?php do_action('hamzahshop_key_action_breadcrumb');?>
      </div>
      
    </div>
  </div>
</section>
<!-- /Section: Page Header -->
<?php endif; ?>

<?php if ( is_front_page() ) : 
	  if ( is_active_sidebar( 'static' ) ) :
?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php dynamic_sidebar( 'static' ); ?>
      </div>
    </div>
  </div>
<?php endif; endif; ?>

<div id="primary" class="content-area blog-page-area details-page">
    <main id="main" class="site-main" role="main">
        <div class="container">
            <div class="row">
            <?php if( get_theme_mod( 'hamzahshop_theme_page_layout','sidebar') == 'sidebar' ):?> 
                <div class="col-md-9">
            <?php else: ?>
            <div class="col-md-12">
            <?php endif;?>    
                    <?php
                    while ( have_posts() ) : the_post();
                      
                        get_template_part( 'template-parts/content', 'page' );
                    
                       
                    
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    
                    endwhile; // End of the loop.
                    ?>
                </div>
                <?php if( get_theme_mod( 'hamzahshop_theme_page_layout','sidebar') == 'sidebar' ):?> 
                <div class="col-md-3">
                <?php get_sidebar(); ?>
                </div>
                <?php endif;?>
            </div>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php

get_footer();

