<?php
/* Main page template */
get_header();
?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="singlePage">
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
							<?php if ( has_post_thumbnail() ){ ?>
								<div class="thumbnailImage"><?php the_post_thumbnail(); ?></div>
							<?php } ?>
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
							<?php edit_post_link(__('Edit', 'ultimate-showcase'), '<p>', '</p>'); ?>
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
