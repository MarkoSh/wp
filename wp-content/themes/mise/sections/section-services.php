<?php $showServices = mise_options('_onepage_section_services', ''); ?>
<?php if ($showServices == 1) : ?>
	<?php
		$servicesSectionID = mise_options('_onepage_id_services', 'services');
		$servicesTitle = mise_options('_onepage_title_services', __('Services', 'mise'));
		$servicesSubTitle = mise_options('_onepage_subtitle_services', __('What We Offer', 'mise'));
		$servicesPhrase = mise_options('_onepage_phrase_services', '');
		$servicesTextarea = mise_options('_onepage_textarea_services', '');
		$servicesImage = mise_options('_onepage_servimage_services');
		$textLenght = mise_options('_onepage_lenght_services', '30');
		$singleServiceBox1 = mise_options('_onepage_choosepage_1_services');
		$singleServiceBox2 = mise_options('_onepage_choosepage_2_services');
		$singleServiceBox3 = mise_options('_onepage_choosepage_3_services');
		$singleServiceBox4 = mise_options('_onepage_choosepage_4_services');
		$singleServiceBox5 = mise_options('_onepage_choosepage_5_services');
		$singleServiceBox6 = mise_options('_onepage_choosepage_6_services');
		$customMore = mise_options('_excerpt_more', '&hellip;');
	?>
<section class="mise_services" id="<?php echo esc_attr($servicesSectionID); ?>">
	<div class="mise_services_color"></div>
	<div class="mise_action_services">
		<?php if($servicesTitle || is_customize_preview()): ?>
			<h2 class="misee_main_text"><?php echo esc_html($servicesTitle); ?></h2>
		<?php endif; ?>
		<?php if($servicesSubTitle || is_customize_preview()): ?>
			<p class="mise_subtitle"><?php echo esc_html($servicesSubTitle); ?></p>
		<?php endif; ?>
		<div class="services_columns">
			<div class="one services_columns_single">
				<div class="singleServiceContent">
				<?php if ($singleServiceBox1): ?>
					<?php
						$singleServiceFont1 = mise_options('_onepage_fontawesome_1_services', 'fa fa-bell');
					?>
					<div class="singleService">
						<div class="serviceIcon"><div class="serviceIconCyrcle"></div><i class="<?php echo esc_attr($singleServiceFont1); ?>" aria-hidden="true"></i></div>
						<div class="serviceText">
							<h3><?php echo get_the_title(intval($singleServiceBox1)); ?></h3>
							<?php
							$post_content1 = get_post(intval($singleServiceBox1));
							$content1 = $post_content1->post_content;
							?>
							<p><?php echo wp_trim_words($content1 , intval($textLenght), esc_html($customMore) ); ?></p>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($singleServiceBox2): ?>
					<?php
						$singleServiceFont2 = mise_options('_onepage_fontawesome_2_services', 'fa fa-bell');
					?>
					<div class="singleService">
						<div class="serviceIcon"><div class="serviceIconCyrcle"></div><i class="<?php echo esc_attr($singleServiceFont2); ?>" aria-hidden="true"></i></div>
						<div class="serviceText">
							<h3><?php echo get_the_title(intval($singleServiceBox2)); ?></h3>
							<?php
							$post_content2 = get_post(intval($singleServiceBox2));
							$content2 = $post_content2->post_content;
							?>
							<p><?php echo wp_trim_words($content2 , intval($textLenght), esc_html($customMore) ); ?></p>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($singleServiceBox3): ?>
					<?php
						$singleServiceFont3 = mise_options('_onepage_fontawesome_3_services', 'fa fa-bell');
					?>
					<div class="singleService">
						<div class="serviceIcon"><div class="serviceIconCyrcle"></div><i class="<?php echo esc_attr($singleServiceFont3); ?>" aria-hidden="true"></i></div>
						<div class="serviceText">
							<h3><?php echo get_the_title(intval($singleServiceBox3)); ?></h3>
							<?php
							$post_content3 = get_post(intval($singleServiceBox3));
							$content3 = $post_content3->post_content;
							?>
							<p><?php echo wp_trim_words($content3 , intval($textLenght), esc_html($customMore) ); ?></p>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($singleServiceBox4): ?>
					<?php
						$singleServiceFont4 = mise_options('_onepage_fontawesome_4_services', 'fa fa-bell');
					?>
					<div class="singleService">
						<div class="serviceIcon"><div class="serviceIconCyrcle"></div><i class="<?php echo esc_attr($singleServiceFont4); ?>" aria-hidden="true"></i></div>
						<div class="serviceText">
							<h3><?php echo get_the_title(intval($singleServiceBox4)); ?></h3>
							<?php
							$post_content4 = get_post(intval($singleServiceBox4));
							$content4 = $post_content4->post_content;
							?>
							<p><?php echo wp_trim_words($content4 , intval($textLenght), esc_html($customMore) ); ?></p>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($singleServiceBox5): ?>
					<?php
						$singleServiceFont5 = mise_options('_onepage_fontawesome_5_services', 'fa fa-bell');
					?>
					<div class="singleService">
						<div class="serviceIcon"><div class="serviceIconCyrcle"></div><i class="<?php echo esc_attr($singleServiceFont5); ?>" aria-hidden="true"></i></div>
						<div class="serviceText">
							<h3><?php echo get_the_title(intval($singleServiceBox5)); ?></h3>
							<?php
							$post_content5 = get_post(intval($singleServiceBox5));
							$content5 = $post_content5->post_content;
							?>
							<p><?php echo wp_trim_words($content5 , intval($textLenght), esc_html($customMore) ); ?></p>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($singleServiceBox6): ?>
					<?php
						$singleServiceFont6 = mise_options('_onepage_fontawesome_6_services', 'fa fa-bell');
					?>
					<div class="singleService">
						<div class="serviceIcon"><div class="serviceIconCyrcle"></div><i class="<?php echo esc_attr($singleServiceFont6); ?>" aria-hidden="true"></i></div>
						<div class="serviceText">
							<h3><?php echo get_the_title(intval($singleServiceBox6)); ?></h3>
							<?php
							$post_content6 = get_post(intval($singleServiceBox6));
							$content6 = $post_content6->post_content;
							?>
							<p><?php echo wp_trim_words($content6 , intval($textLenght), esc_html($customMore) ); ?></p>
						</div>
					</div>
				<?php endif; ?>
				</div>
			</div>
			<div class="two services_columns_single" style="background-image: url(<?php echo esc_url($servicesImage); ?>);">
				<div class="serviceColumnSingleColor"></div>
				<div class="serviceContent">
					<?php if ($servicesPhrase || is_customize_preview()): ?>
						<h3><?php echo esc_html($servicesPhrase); ?></h3>
					<?php endif; ?>
					<?php if ($servicesTextarea || is_customize_preview()): ?>
						<p><?php echo wp_kses($servicesTextarea, mise_allowed_html()); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>