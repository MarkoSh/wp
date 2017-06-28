<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Grand-Popo
 */
get_header();
?>
<?php if (have_posts()) : ?>
    <div class="o-wrap xl-gutter-24 lg-gutter-24 md-gutter-0 sm-gutter-0">
        <?php get_sidebar(); ?>
        <section id="primary" class="col xl-3-4 lg-3-4 md-1-1 sm-1-1">
            <main id="main" class="" role="main">

                <header class="page-header">
                    <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'grand-popo'), '<span>' . get_search_query() . '</span>'); ?></h1>
                </header>
                <?php
                /* Start the Loop */
                while (have_posts()) : the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part('components/post/content', 'search');

                endwhile;
                grand_popo_theme_core_page_navi();
                ?>

            </main>
        </section>
    </div>
    <?php
else :
    ?>
    <div class="o-wrap">
    
        <section id="primary" class="col xl-1-1 lg-1-1 md-1-1 sm-1-1">
            <main id="main" class="" role="main">
                <?php get_template_part('components/post/content', 'none'); ?>    
            </main>
        </section>
    </div>
<?php
endif;
get_footer();
