
<?php 
global $post;
 $post_ID=$post->ID;
?>
<div class="post-extra">

    <div>
        <i class='fa fa-user'></i>
        <?php the_author(); ?>
    </div>
    <?php
    if(function_exists('grand_popo_get_post_views')){
    ?>
        <div>
            <i class='fa fa-eye'></i>
            <?php echo grand_popo_get_post_views($post_ID);?>
        </div>
    <?php
    }
    ?>
    <div>
        <i class='fa fa-comment-o'></i>
        <a href="<?php echo esc_url(get_the_permalink()); ?>">
            <?php comments_number(esc_html__('No Comments', 'grand-popo'), '1&nbsp;' . esc_html__('Comment', 'grand-popo'), '%&nbsp;' . esc_html__('Comments', 'grand-popo')); ?>
        </a>
    </div>
    <?php
        $categories_list = get_the_category_list( esc_html__( ', ', 'grand-popo' ) );
        if ( $categories_list && grand_popo_categorized_blog() ) {
            ?>
            <div>
                <i class='fa fa-archive'></i>
                <?php printf( '<span class="cat-links">' . esc_html__( ' %1$s', 'grand-popo' ) . '</span>', $categories_list ); // WPCS: XSS OK. ?>
            </div>   
            <?php   
        }
    ?>
    
    <?php
        $tags_list = get_the_tag_list( '', esc_html__( ', ', 'grand-popo' ) );
        if ($tags_list ) {
            ?>
            <div>
                <i class='fa fa-tags'></i>
                <?php printf( '<span class="tags-links">' . esc_html__( ' %1$s', 'grand-popo' ) . '</span>', $tags_list ); // WPCS: XSS OK.  ?>
            </div>   
            <?php   
        }
    ?>

</div>
