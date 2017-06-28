<?php $postFormat = get_post_format(); ?>

<div class="entry-content post-content">

    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    <?php get_template_part('components/post/content', 'extra'); ?>

    <?php
    the_content(sprintf(
                    /* translators: %s: Name of current post. */
                    wp_kses(esc_html__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'grand-popo'), array('span' => array('class' => array()))), the_title('<span class="screen-reader-text">"', '"</span>', false)
    ));
    ?>

    <div id="blog-content-footer">
        <?php
        if(function_exists('grand_popo_get_post_share_html')){
        ?>
        <div> <?php echo esc_html__('Share: ','grand-popo'); grand_popo_get_post_share_html($type="post");?></div>
        <?php
        }
        ?>
        <div><?php grand_popo_get_single_post_nav();?></div>
     
    </div>
    
    
</div>

