<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Grand-Popo
 */
?>
<?php
global $post;
$post_ID = $post->ID;
if(function_exists('grand_popo_set_post_views')){
    grand_popo_set_post_views($post_ID);
}

?>
<?php if (is_single() && !is_home()) : ?>
    <?php if ('' != get_the_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php endif; ?>
    <div class="post-wrap">
        <?php if ('post' === get_post_type()) : ?>
            <?php get_template_part('components/post/content', 'meta'); ?>
        <?php endif;
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php if ('post' === get_post_type()) : ?>

                <?php get_template_part('components/post/common-content', 'single'); ?>

            <?php endif; ?>

        </article><!-- #post-## -->
    </div>		
<?php endif; ?>

<?php if (is_archive() || is_front_page() || is_home()) : ?>
    <div class="post-wrap">

        <?php if ('post' === get_post_type()) : ?>
            <?php get_template_part('components/post/content', 'meta'); ?>
        <?php endif;
        ?>

        <?php if (is_sticky($post->ID)) : ?>

            <article id="post-<?php the_ID(); ?>" class="blog-archive-post sticky-post <?php echo esc_attr(get_post_format()) ?> <?php echo esc_attr(get_post_type()) ?>">

            <?php else : ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

                <?php endif; ?>


                <?php if ('' != get_the_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>">
                            <span class="mask"></span>
                            <?php the_post_thumbnail('large'); ?>	

                        </a>
                    </div>
                <?php else: ?>
                    <?php echo grand_popo_get_post_thumb(); ?>
                <?php endif; ?>

                <?php get_template_part('components/post/common-content', 'archive'); ?>
            </article><!-- #post-## -->
    </div>


<?php endif; ?>