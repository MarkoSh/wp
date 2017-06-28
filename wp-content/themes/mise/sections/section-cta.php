<?php 
$showCta = mise_options('_onepage_section_cta', '');
?>
<?php if ($showCta == 1) : ?>
	<?php
		$ctaSectionID = mise_options('_onepage_id_cta','cta');
		$ctaIcon = mise_options('_onepage_fontawesome_cta','fa fa-flash');
		$ctaPhrase = mise_options('_onepage_phrase_cta','');
		$ctaDesc = mise_options('_onepage_desc_cta','');
		$ctaTextButton = mise_options('_onepage_textbutton_cta',__('More Information', 'mise'));
		$ctaLinkButton = mise_options('_onepage_urlbutton_cta','#');
		$ctaOpenLink = mise_options('_onepage_openurl_cta','_blank');
	?>
<section class="mise_cta <?php echo $ctaDesc ? 'withDesc' : 'noDesc' ?>" id="<?php echo esc_attr($ctaSectionID); ?>">
	<div class="mise_cta_color"></div>
	<div class="mise_action_cta">
		<div class="cta_columns">
			<div class="ctaText">
				<div class="ctaIcon"><div class="ctaIconCyrcle"></div><i class="<?php echo esc_attr($ctaIcon); ?>" aria-hidden="true"></i></div>
				<div class="ctaPhrase">
					<?php if ($ctaPhrase || is_customize_preview()) : ?>
						<h3><?php echo esc_html($ctaPhrase); ?></h3>
					<?php endif; ?>
					<?php if ($ctaDesc || is_customize_preview()) : ?>
						<p><?php echo esc_html($ctaDesc); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<div class="ctaButton miseButton"><a href="<?php echo esc_url($ctaLinkButton); ?>" target="<?php echo esc_attr($ctaOpenLink); ?>"><?php echo esc_html($ctaTextButton); ?></a></div>
		</div>
	</div>
</section>
<?php endif; ?>