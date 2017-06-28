<?php
/* Main template file */
get_header();

if (get_option("EWD_UPCP_Theme_Blog_Label") == "") {$Blog_Label = __("Blog", "ultimate-showcase");}
else {$Blog_Label = get_option("EWD_UPCP_Theme_Blog_Label");}
?>

		<div class="singlePage">
			<section class="titleArea">
				<div class="wrapper">
					<div class="container">
						<h1><?php echo esc_html($Blog_Label); ?></h1>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
			<div class="clear"></div>
			<section class="panel">
				<div class="wrapper">
					<div class="container">
						<section class="pageWithSidebarContent">
							<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
								<div class="archivePost">
									<h2 class="archiveH2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p style="margin-bottom: 16px;">
										<?php echo __('Posted by', 'ultimate-showcase') . ' <a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a> ' . __('on', 'ultimate-showcase') . ' ' . get_post_time('F j, Y') . ' ' . __('in', 'ultimate-showcase') . ' ' . get_the_category_list( ', ' ); ?>
									</p>
									<div class="clear"></div>
									<?php if ( has_post_thumbnail() ){ ?>
										<div class="thumbnailImage"><?php the_post_thumbnail(); ?></div>
									<?php } ?>
									<?php the_excerpt(); ?>
								</div> <!-- archivePost -->
							<?php endwhile; else: ?>
								<p><?php _e('Sorry, no content matched your criteria.', 'ultimate-showcase'); ?></p>
							<?php endif; ?>
						</section> <!-- pageWithSidebarContent -->
						<?php get_sidebar('blog'); ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		</div> <!-- singlePage -->

		<div class="clear"></div>

<?php
get_footer();
?>
