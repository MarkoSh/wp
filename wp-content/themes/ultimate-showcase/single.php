<?php
/* Single Post Template */
get_header();
?>
	
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('singlePage'); ?>>
				<section class="titleArea">
					<div class="wrapper">
						<div class="container">
							<h1><?php the_title(); ?></h1>
						</div> <!-- container -->
					</div> <!-- wrapper -->				
				</section>
				<div class="clear"></div>
				<section class="panel">
					<div class="wrapper">
						<div class="container">
							<section class="pageWithSidebarContent">
								<p style="margin-bottom: 16px;">
									<?php echo __('Posted by', 'ultimate-showcase') . ' <a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a> ' . __('on', 'ultimate-showcase') . ' ' . get_post_time('F j, Y') . ' ' . __('in', 'ultimate-showcase') . ' ' . get_the_category_list( ', ' ); ?>
								</p>
								<div class="clear"></div>
								<?php if ( has_post_thumbnail() ){ ?>
									<div class="thumbnailImage"><?php the_post_thumbnail(); ?></div>
								<?php } ?>
								<?php the_content(); ?>
								<div class="clear"></div>
								<p><?php echo get_the_tag_list( __('<p>Tags: ', 'ultimate-showcase'),', ',__('</p>', 'ultimate-showcase') ); ?></p>
								<?php edit_post_link(__('Edit', 'ultimate-showcase'), '<p>', '</p>'); ?>
								<div class="clear"></div>
								<?php
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'ultimate-showcase' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
									'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'ultimate-showcase' ) . ' </span>%',
									'separator'   => '<span class="screen-reader-text">, </span>',
								) );
								?>
								<div class="clear"></div>
								<div class="postsNavigation">
									<?php
									the_post_navigation( array(
										'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next:', 'ultimate-showcase' ) . '</span> ' .
											'<span class="screen-reader-text">' . __( 'Next post:', 'ultimate-showcase' ) . '</span> ' .
											'<span class="post-title">%title</span>&nbsp;&nbsp;&gt;&gt;',
										'prev_text' => '&lt;&lt;&nbsp;&nbsp;<span class="meta-nav" aria-hidden="true">' . __( 'Previous:', 'ultimate-showcase' ) . '</span> ' .
											'<span class="screen-reader-text">' . __( 'Previous post:', 'ultimate-showcase' ) . '</span> ' .
											'<span class="post-title">%title</span>',
									) );
									?>
								</div> <!-- postsNavigation -->	
								<div class="clear"></div>
								<div class="postComments">
									<?php
									if ( comments_open() || get_comments_number() ) {
										comments_template();
									}
									?>
								</div> <!-- postComments -->	
							</section> <!-- pageWithSidebarContent -->
							<?php get_sidebar('blog'); ?>
						</div> <!-- container -->
					</div> <!-- wrapper -->
				</section>
			</div> <!-- singlePage -->	
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no content matched your criteria.', 'ultimate-showcase'); ?></p>
		<?php endif; ?>							
		
		<div class="clear"></div>
		
<?php
get_footer();
?>		