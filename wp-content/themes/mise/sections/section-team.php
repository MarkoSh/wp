<?php $showTeam = mise_options('_onepage_section_team', ''); ?>
<?php if ($showTeam == 1) : ?>
	<?php
		$teamSectionID = mise_options('_onepage_id_team', 'team');
		$teamTitle = mise_options('_onepage_title_team', __('Our Team', 'mise'));
		$teamSubTitle = mise_options('_onepage_subtitle_team', __('Nice to meet you', 'mise'));
		$teamTestimonialBox1 = mise_options('_onepage_choosepage_1_team');
		$teamTestimonialBox2 = mise_options('_onepage_choosepage_2_team');
		$teamTestimonialBox3 = mise_options('_onepage_choosepage_3_team');
		$teamTestimonialBox4 = mise_options('_onepage_choosepage_4_team');
		$teamTestimonialBox5 = mise_options('_onepage_choosepage_5_team');
		$teamTestimonialBox6 = mise_options('_onepage_choosepage_6_team');
	?>
<section class="mise_team" id="<?php echo esc_attr($teamSectionID); ?>">
	<div class="mise_team_color"></div>
	<div class="mise_action_team">
		<?php if($teamTitle || is_customize_preview()): ?>
			<h2 class="misee_main_text"><?php echo esc_html($teamTitle); ?></h2>
		<?php endif; ?>
		<?php if($teamSubTitle || is_customize_preview()): ?>
			<p class="mise_subtitle"><?php echo esc_html($teamSubTitle); ?></p>
		<?php endif; ?>
		<div class="team_columns">
			<?php if($teamTestimonialBox1): ?>
				<div class="miseTeamSingle">
					<?php if ('' != get_the_post_thumbnail($teamTestimonialBox1)) : ?>
						<?php echo get_the_post_thumbnail(intval($teamTestimonialBox1), 'mise-little-post'); ?>
					<?php endif; ?>
					<div class="miseTeamName"><?php echo get_the_title(intval($teamTestimonialBox1)); ?></div>
					<div class="miseTeamDesc">
					<?php 
						$post_content1 = get_post(intval($teamTestimonialBox1));
						$content1 = $post_content1->post_content;
						echo do_shortcode($content1);
					?>
					</div>
				</div>
			<?php endif; ?>
			<?php if($teamTestimonialBox2): ?>
				<div class="miseTeamSingle">
					<?php if ('' != get_the_post_thumbnail($teamTestimonialBox2)) : ?>
						<?php echo get_the_post_thumbnail(intval($teamTestimonialBox2), 'mise-little-post'); ?>
					<?php endif; ?>
					<div class="miseTeamName"><?php echo get_the_title(intval($teamTestimonialBox2)); ?></div>
					<div class="miseTeamDesc">
					<?php 
						$post_content2 = get_post(intval($teamTestimonialBox2));
						$content2 = $post_content2->post_content;
						echo do_shortcode($content2);
					?>
					</div>
				</div>
			<?php endif; ?>
			<?php if($teamTestimonialBox3): ?>
				<div class="miseTeamSingle">
					<?php if ('' != get_the_post_thumbnail($teamTestimonialBox3)) : ?>
						<?php echo get_the_post_thumbnail(intval($teamTestimonialBox3), 'mise-little-post'); ?>
					<?php endif; ?>
					<div class="miseTeamName"><?php echo get_the_title(intval($teamTestimonialBox3)); ?></div>
					<div class="miseTeamDesc">
					<?php 
						$post_content3 = get_post(intval($teamTestimonialBox3));
						$content3 = $post_content3->post_content;
						echo do_shortcode($content3);
					?>
					</div>
				</div>
			<?php endif; ?>
			<?php if($teamTestimonialBox4): ?>
				<div class="miseTeamSingle">
					<?php if ('' != get_the_post_thumbnail($teamTestimonialBox4)) : ?>
						<?php echo get_the_post_thumbnail(intval($teamTestimonialBox4), 'mise-little-post'); ?>
					<?php endif; ?>
					<div class="miseTeamName"><?php echo get_the_title(intval($teamTestimonialBox4)); ?></div>
					<div class="miseTeamDesc">
					<?php 
						$post_content4 = get_post(intval($teamTestimonialBox4));
						$content4 = $post_content4->post_content;
						echo do_shortcode($content4);
					?>
					</div>
				</div>
			<?php endif; ?>
			<?php if($teamTestimonialBox5): ?>
				<div class="miseTeamSingle">
					<?php if ('' != get_the_post_thumbnail($teamTestimonialBox5)) : ?>
						<?php echo get_the_post_thumbnail(intval($teamTestimonialBox5), 'mise-little-post'); ?>
					<?php endif; ?>
					<div class="miseTeamName"><?php echo get_the_title(intval($teamTestimonialBox5)); ?></div>
					<div class="miseTeamDesc">
					<?php 
						$post_content5 = get_post(intval($teamTestimonialBox5));
						$content5 = $post_content5->post_content;
						echo do_shortcode($content5);
					?>
					</div>
				</div>
			<?php endif; ?>
			<?php if($teamTestimonialBox6): ?>
				<div class="miseTeamSingle">
					<?php if ('' != get_the_post_thumbnail($teamTestimonialBox6)) : ?>
						<?php echo get_the_post_thumbnail(intval($teamTestimonialBox6), 'mise-little-post'); ?>
					<?php endif; ?>
					<div class="miseTeamName"><?php echo get_the_title(intval($teamTestimonialBox6)); ?></div>
					<div class="miseTeamDesc">
					<?php 
						$post_content6 = get_post(intval($teamTestimonialBox6));
						$content6 = $post_content6->post_content;
						echo do_shortcode($content6);
					?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>