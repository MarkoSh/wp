<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Grand-Popo
 */
global $grand_popo_options;

$single_layout = grand_popo_get_proper_value($grand_popo_options, 'single-layout-template');

get_header();

if ($single_layout == "no-sidebar") {
    $gutter = "o-wrap";
    $col = "col xl-1-1 lg-1-1 md-1-1 sm-1-1";
} else {
    $gutter = "o-wrap xl-gutter-24 lg-gutter-24 md-gutter-0 sm-gutter-0";
    $col = "col xl-3-4 lg-3-4 md-1-1 sm-1-1";
}
?>

<div class="<?php echo esc_attr($gutter) ; ?>">
    
<?php
if ($single_layout == "left-sidebar")
    get_sidebar();
?>
    <div id="primary" class="<?php echo esc_attr($col); ?>">
            <main id="main" class="" role="main">

            <?php
            while ( have_posts() ) : the_post();

                    get_template_part( 'components/post/content', get_post_format() );?>
                    
                    <?php grand_popo_get_post_comment_author() ?>
        
    <?php

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        
                    //comment_form_title('0 comment','%s comments',true);
                            comments_template();
                            
                    endif;

            endwhile; // End of the loop.
            ?>

            </main>
    </div>
<?php
if ($single_layout == "right-sidebar")
    get_sidebar();
?>
</div>
<?php

get_footer();