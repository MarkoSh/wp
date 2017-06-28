<?php
	$showReverseText = mise_options('_onepage_reverse_slider', '1');
	$showScrollDown = mise_options('_onepage_scrolldown_slider', '1');
	$sliderSectionID = mise_options('_onepage_id_slider', 'slider');
	$firstSlideImage = mise_options('_onepage_image_1_slider', get_template_directory_uri().'/images/example/mise_slider_example_1.jpg');
	$firstSlideText = mise_options('_onepage_text_1_slider', __('Say Hello to Mise Theme!', 'mise'));
	$firstSlideSubtext = mise_options('_onepage_subtext_1_slider', __('Onepage, blog and WooCommerce WordPress Theme', 'mise'));
	$secondSlideImage = mise_options('_onepage_image_2_slider', get_template_directory_uri().'/images/example/mise_slider_example_2.jpg');
	$secondSlideText = mise_options('_onepage_text_2_slider', __('Say Hello to Mise Theme!', 'mise'));
	$secondSlideSubtext = mise_options('_onepage_subtext_2_slider', __('Onepage, blog and WooCommerce WordPress Theme', 'mise'));
	$thirdSlideImage = mise_options('_onepage_image_3_slider', get_template_directory_uri().'/images/example/mise_slider_example_3.jpg');
	$thirdSlideText = mise_options('_onepage_text_3_slider', __('Say Hello to Mise Theme!', 'mise'));
	$thirdSlideSubtext = mise_options('_onepage_subtext_3_slider', __('Onepage, blog and WooCommerce WordPress Theme', 'mise'));
?>
<section class="mise_slider <?php echo $showReverseText ? 'reverse' : 'classic' ?>" id="<?php echo esc_attr($sliderSectionID); ?>">
	<div class="flexslider">
	  <ul class="slides">
		<?php if ($firstSlideImage) : ?>
		<li>
			<div class="flexImage" style="background-image: url(<?php echo esc_url($firstSlideImage); ?>);">
			</div>
			<div class="flexText">
				<div class="inside">
					<?php if ($firstSlideText || is_customize_preview()) : ?>
					<h2><?php echo esc_html($firstSlideText); ?></h2>
					<?php endif; ?>
					<?php if ($firstSlideSubtext || is_customize_preview()) : ?>
					<span><?php echo esc_html($firstSlideSubtext); ?></span>
					<?php endif; ?>
				</div>
			</div>
		</li>
		<?php endif; ?>
		<?php if ($secondSlideImage) : ?>
		<li>
			<div class="flexImage" style="background-image: url(<?php echo esc_url($secondSlideImage); ?>);">
			</div>
			<div class="flexText">
				<div class="inside">
					<?php if ($secondSlideText || is_customize_preview()) : ?>
					<h2><?php echo esc_html($secondSlideText); ?></h2>
					<?php endif; ?>
					<?php if ($secondSlideSubtext || is_customize_preview()) : ?>
					<span><?php echo esc_html($secondSlideSubtext); ?></span>
					<?php endif; ?>
				</div>
			</div>
		</li>
		<?php endif; ?>
		<?php if ($thirdSlideImage) : ?>
		<li>
			<div class="flexImage" style="background-image: url(<?php echo esc_url($thirdSlideImage); ?>);">
			</div>
			<div class="flexText">
				<div class="inside">
					<?php if ($thirdSlideText || is_customize_preview()) : ?>
					<h2><?php echo esc_html($thirdSlideText); ?></h2>
					<?php endif; ?>
					<?php if ($thirdSlideSubtext || is_customize_preview()) : ?>
					<span><?php echo esc_html($thirdSlideSubtext); ?></span>
					<?php endif; ?>
				</div>
			</div>
		</li>
		<?php endif; ?>
	  </ul>
	  <?php if ($showScrollDown) : ?>
		<div class="scrollDown"><span class="mouse-wheel"></span></div>
	<?php endif; ?>
	</div>
</section>