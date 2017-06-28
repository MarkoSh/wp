<?php 
$showBlog = mise_options('_onepage_section_blog', '');
?>
<?php if ($showBlog == 1) : ?>
	<?php
		$blogSectionID = mise_options('_onepage_id_blog','blog');
		$blogTitle = mise_options('_onepage_title_blog',__('News', 'mise'));
		$blogSubTitle = mise_options('_onepage_subtitle_blog', __('Latest Posts', 'mise'));
		$blogtoShow = mise_options('_onepage_noposts_blog','3');
		$blogTextButton = mise_options('_onepage_textbutton_blog',__('Go to the blog!', 'mise'));
		$blogLinkButton = mise_options('_onepage_linkbutton_blog', '#');
	?>
<section class="mise_blog" id="<?php echo esc_attr($blogSectionID); ?>">
	<div class="mise_blog_color"></div>
	<div class="mise_action_blog">
	<?php if($blogTitle || is_customize_preview()): ?>
		<h2 class="misee_main_text"><?php echo esc_html($blogTitle); ?></h2>
	<?php endif; ?>
	<?php if($blogSubTitle || is_customize_preview()): ?>
		<p class="mise_subtitle"><?php echo esc_html($blogSubTitle); ?></p>
	<?php endif; ?>
		<div class="blog_columns">
				<?php
					$args = array( 'posts_per_page' => intval($blogtoShow), 'post_status'=>'publish', 'post_type'=>'post', 'orderby'=>'date', 'ignore_sticky_posts' => true );
					$the_query = new WP_Query( $args );
					if ($the_query->have_posts()) :
					while( $the_query->have_posts() ) : $the_query->the_post();
				?>
					<div class="miseBlogSingle">
						<?php
							if ( '' != get_the_post_thumbnail() ) {
								echo '<div class="entry-featuredImg">';
								the_post_thumbnail('mise-little-post');
								echo '<div class="insideImage"><span><a href="' .esc_url(get_permalink()). '">'.esc_html__( 'Read More', 'mise' ).'<i class="spaceLeft fa fa-angle-right" aria-hidden="true"></i></a></span></div></div>';
							}
						?>
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
						<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta">
							<?php mise_posted_on(); ?>
						</div><!-- .entry-meta -->
						<?php
						endif; ?>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-content -->
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				<?php endif; ?>
				<?php if($blogTextButton): ?>
					<div class="miseButton goToBlog"><a href="<?php echo esc_url($blogLinkButton); ?>"><?php echo esc_html($blogTextButton); ?></a></div>
				<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>