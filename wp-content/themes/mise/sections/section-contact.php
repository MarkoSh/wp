<?php $showContact = mise_options('_onepage_section_contact', ''); ?>
<?php if ($showContact == 1) : ?>
	<?php
		$contactSectionID = mise_options('_onepage_id_contact', 'contact');
		$contactTitle = mise_options('_onepage_title_contact', __('Contact Us', 'mise'));
		$contactSubTitle = mise_options('_onepage_subtitle_contact', __('Get in touch', 'mise'));
		$contactAddText = mise_options('_onepage_additionaltext_contact', '');
		$contactCompanyName = mise_options('_onepage_companyname_contact', '');
		$contactCompanyAddress1 = mise_options('_onepage_companyaddress1_contact', '');
		$contactCompanyAddress2 = mise_options('_onepage_companyaddress2_contact', '');
		$contactCompanyAddress3 = mise_options('_onepage_companyaddress3_contact', '');
		$contactCompanyPhone = mise_options('_onepage_companyphone_contact', '');
		$contactCompanyFax = mise_options('_onepage_companyfax_contact', '');
		$contactCompanyEmail = mise_options('_onepage_companyemail_contact', '');
		$contactShortcode = mise_options('_onepage_shortcode_contact', '');
		$contactIcon = mise_options('_onepage_icon_contact', 'fa fa-envelope');
	?>
<section class="mise_contact <?php echo $contactShortcode ? 'withForm' : 'noForm' ?>" id="<?php echo esc_attr($contactSectionID); ?>">
	<div class="mise_contact_color"></div>
	<div class="mise_action_contact">
		<?php if($contactTitle || is_customize_preview()): ?>
			<h2 class="misee_main_text"><?php echo esc_html($contactTitle); ?></h2>
		<?php endif; ?>
		<?php if($contactSubTitle || is_customize_preview()): ?>
			<p class="mise_subtitle"><?php echo esc_html($contactSubTitle); ?></p>
		<?php endif; ?>
		<div class="contact_columns">
			<div class="miseContactField">
				<?php if($contactAddText || is_customize_preview()): ?>
					<div class="miseAdditionalText"><p><?php echo wp_kses($contactAddText, mise_allowed_html()); ?></p></div>
				<?php endif; ?>
				<?php if($contactCompanyName || is_customize_preview()): ?>
					<div class="miseCompanyName"><h3><?php echo esc_html($contactCompanyName); ?></h3></div>
				<?php endif; ?>
				<?php if($contactCompanyAddress1 || is_customize_preview()): ?>
					<div class="miseCompanyAddress1"><div class="miseCompanyAddress1Icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div><p><?php echo esc_html($contactCompanyAddress1); ?></p></div>
				<?php endif; ?>
				<?php if($contactCompanyAddress2 || is_customize_preview()): ?>
					<div class="miseCompanyAddress2"><p><?php echo esc_html($contactCompanyAddress2); ?></p></div>
				<?php endif; ?>
				<?php if($contactCompanyAddress3 || is_customize_preview()): ?>
					<div class="miseCompanyAddress3"><p><?php echo esc_html($contactCompanyAddress3); ?></p></div>
				<?php endif; ?>
				<?php if($contactCompanyPhone || is_customize_preview()): ?>
					<div class="miseCompanyPhone"><div class="miseCompanyPhoneIcon"><i class="fa fa-phone" aria-hidden="true"></i></div><p><?php echo esc_html($contactCompanyPhone); ?></p></div>
				<?php endif; ?>
				<?php if($contactCompanyFax || is_customize_preview()): ?>
					<div class="miseCompanyFax"><div class="miseCompanyFaxIcon"><i class="fa fa-fax" aria-hidden="true"></i></div><p><?php echo esc_html($contactCompanyFax); ?></p></div>
				<?php endif; ?>
				<?php if(is_email($contactCompanyEmail) || is_customize_preview()): ?>
					<div class="miseCompanyEmail"><div class="miseCompanyEmailIcon"><i class="fa fa-envelope" aria-hidden="true"></i></div><p><?php echo esc_html(antispambot($contactCompanyEmail)); ?></p></div>
				<?php endif; ?>
			</div>
			<?php if($contactShortcode): ?>
			<div class="miseContactForm">
				<?php echo do_shortcode(wp_kses_post($contactShortcode)); ?>
			</div>
			<?php endif; ?>
			<?php if($contactIcon): ?>
				<div class="miseContactIcon"><i class="<?php echo esc_attr($contactIcon); ?>" aria-hidden="true"></i></div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>