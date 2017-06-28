
<div class="post-content">	
    <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>

    <div class="excerpt-wrap">

        <?php the_excerpt(); ?>

    </div>
    <div>
        <a class='read-more' href="<?php echo  esc_url(get_permalink()) ?>" ><?php esc_html_e('Continue Reading','grand-popo') ?></a>

    </div> 
</div>