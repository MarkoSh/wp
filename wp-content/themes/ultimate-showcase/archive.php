<?php
/* Main template file */
get_header();
?>

		<div class="singlePage">
			<section class="titleArea">
				<div class="wrapper">
					<div class="container">
						<?php the_archive_title( '<h1>', '</h1>' ); ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->				
			</section>
			<div class="clear"></div>
			<section class="panel">
				<div class="wrapper">
					<div class="container">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<div id="post-<?php the_ID(); ?>" <?php post_class('archivePost'); ?>>
								<h2 class="archiveH2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<?php if ( has_post_thumbnail() ){ ?>
									<div class="thumbnailImage"><?php the_post_thumbnail(); ?></div>
								<?php } ?>
								<?php the_excerpt(); ?>
							</div> <!-- archivePost -->	
						<?php endwhile;
						the_posts_pagination( array(
							'prev_text'          => __( 'Previous page', 'ultimate-showcase' ),
							'next_text'          => __( 'Next page', 'ultimate-showcase' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'ultimate-showcase' ) . ' </span>',
						) );
						else: ?>
							<p><?php _e('Sorry, no content matched your criteria.', 'ultimate-showcase'); ?></p>
						<?php endif; ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		</div> <!-- singlePage -->							
		
		<div class="clear"></div>

<?php
get_footer();
?>		