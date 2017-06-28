<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Grand-Popo
 */
global $grand_popo_options;

$blog_layout = grand_popo_get_proper_value($grand_popo_options, 'blog-layout-template','left-sidebar');

get_header();

if ($blog_layout == "no-sidebar") {
    $gutter = "o-wrap";
    $col = "col xl-1-1 lg-1-1 md-1-1 sm-1-1";
} else {

    $gutter = "o-wrap xl-gutter-24 lg-gutter-24 md-gutter-0 sm-gutter-0";
    $col = "col xl-3-4 lg-3-4 md-1-1 sm-1-1";
}
?>

<div class="<?php echo esc_attr($gutter); ?>">

<?php
if ($blog_layout == "left-sidebar")
    get_sidebar();
?>

    <div id="primary" class="<?php echo esc_attr($col); ?>">
        <main id="main" class="">

<?php
if (have_posts()) :

    /* Start the Loop */
    while (have_posts()) : the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part('components/post/content', get_post_format());

    endwhile;
    grand_popo_theme_core_page_navi();

else :

    get_template_part('components/post/content', 'none');

endif;
?>

        </main>
    </div>

<?php
if ($blog_layout == "right-sidebar")
    get_sidebar();
?>
</div>
    <?php
    get_footer();
    