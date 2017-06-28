<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Grand-Popo
 */

if ('post' === get_post_type()) : ?>
<div class="post-wrap gp-search-item">
<?php 
   get_template_part('components/post/content', 'meta'); ?>
      
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


            <?php if ( '' != get_the_post_thumbnail() ) : ?>
                    <div class="post-thumbnail">
                            <a href="<?php echo esc_url(get_the_permalink()); ?>">

                                <?php the_post_thumbnail( 'large' ); ?>	

                            </a>
                    </div>
                    <?php else: ?>
                         <?php echo grand_popo_get_post_thumb();?>
                <?php endif; ?>

                    <?php get_template_part( 'components/post/common-content', 'archive' ); ?>

    </article>
</div>
<?php

    elseif('page' === get_post_type()) : 
    ?>
    <div class="gp-search-item"> 
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php get_template_part( 'components/page/content', 'search' ); ?>
        </article>  
    </div>
    <?php
    
    elseif('product' === get_post_type()) :
        
    ?>
    <div  class="grand_popo-products grand_popo-prod-list gp-search-item ">
        <?php 
        get_template_part( 'components/product/content', 'search' );
        ?>
    </div>  
    <?php
    else:
        ?>
    <div class="gp-search-item">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php get_template_part( 'components/page/content', 'search' ); ?>
        </article>  
    </div>
    <?php  
    endif;


