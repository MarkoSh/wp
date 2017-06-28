<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Grand-Popo
 */
get_header();

global $post;

$page_layout = get_post_meta($post->ID, 'grand_popo_page_options', true);
if (is_page('wishlist') || is_page('cart') || is_page('checkout') || is_page('my-account') || is_front_page()) {
        $page_layout = grand_popo_get_proper_value($page_layout, 'sidebar-position', 'no-sidebar');
    } else {
        $page_layout = grand_popo_get_proper_value($page_layout, 'sidebar-position', 'left');
    }
$layout=$page_layout;


if ($layout == "no-sidebar") {
    $gutter = "o-wrap";
    $col = "col xl-1-1 lg-1-1 md-1-1 sm-1-1";
} else {
    $gutter = "o-wrap xl-gutter-24 lg-gutter-24 md-gutter-0 sm-gutter-0";
    $col = "col xl-3-4 lg-3-4 md-1-1 sm-1-1";
}

?>
<div class=" <?php echo esc_attr($gutter);?>">
    <?php
    if ($layout == "left") {
        get_sidebar();
    }
    ?>

    <div id="primary" class="<?php echo esc_attr($col); ?>">
        <main id="main" class="">

            <?php
            while (have_posts()) : the_post();


                get_template_part('components/page/content', 'page');

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

        </main>
    </div>
    <?php
    if ($layout == "right") {
        get_sidebar();
    }
    ?>
</div>
<?php
get_footer();