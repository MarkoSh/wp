<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Grand-Popo
 */
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="" role="main">

        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('404', 'grand-popo'); ?></h1>
            </header>
            <div class="page-content">
                <p><?php esc_html_e('Sorry but we couldn\'t find this page', 'grand-popo'); ?></p>
                <div><?php esc_html_e(' This page you are looking for doesn\'t exist', 'grand-popo'); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Report this?','grand-popo')?></a> </div>

                <?php get_search_form(); ?>
                
            </div>
        </section>
    </main>
</div>
<?php
get_footer();
