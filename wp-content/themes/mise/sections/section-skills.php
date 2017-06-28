<?php $showSkills = mise_options('_onepage_section_skills', ''); ?>
<?php if ($showSkills == 1) : ?>
	<?php
		$skillsSectionID = mise_options('_onepage_id_skills', 'skills');
		$skillsTitle = mise_options('_onepage_title_skills', __('Our Skills', 'mise'));
		$skillsSubTitle = mise_options('_onepage_subtitle_skills', __('What We Do', 'mise'));
		$skillName1 = mise_options('_onepage_skillname_1_skills', '');
		$skillName2 = mise_options('_onepage_skillname_2_skills', '');
		$skillName3 = mise_options('_onepage_skillname_3_skills', '');
		$skillName4 = mise_options('_onepage_skillname_4_skills', '');
		$skillName5 = mise_options('_onepage_skillname_5_skills', '');
		$skillName6 = mise_options('_onepage_skillname_6_skills', '');
		$skillName7 = mise_options('_onepage_skillname_7_skills', '');
		$skillName8 = mise_options('_onepage_skillname_8_skills', '');
		$skillName9 = mise_options('_onepage_skillname_9_skills', '');
		$skillName10 = mise_options('_onepage_skillname_10_skills', '');
	?>
<section class="mise_skills" id="<?php echo esc_attr($skillsSectionID); ?>">
	<div class="mise_skills_color"></div>
	<div class="mise_action_skills">
	<?php if($skillsTitle || is_customize_preview()): ?>
		<h2 class="misee_main_text"><?php echo esc_html($skillsTitle); ?></h2>
	<?php endif; ?>
	<?php if($skillsSubTitle || is_customize_preview()): ?>
		<p class="mise_subtitle"><?php echo esc_html($skillsSubTitle); ?></p>
	<?php endif; ?>
		<div class="skills_columns">
			<?php if($skillName1): ?>
			<?php $skillValue1 = mise_options('_onepage_skillvalue_1_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName1); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName1); ?></div>
						<div class="skillValue" data-delay="0"><span><?php echo intval($skillValue1); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue1); ?>%" data-delay="0"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName2): ?>
			<?php $skillValue2 = mise_options('_onepage_skillvalue_2_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName2); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName2); ?></div>
						<div class="skillValue" data-delay="150"><span><?php echo intval($skillValue2); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue2); ?>%" data-delay="150"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName3): ?>
			<?php $skillValue3 = mise_options('_onepage_skillvalue_3_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName3); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName3); ?></div>
						<div class="skillValue" data-delay="300"><span><?php echo intval($skillValue3); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue3); ?>%" data-delay="300"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName4): ?>
			<?php $skillValue4 = mise_options('_onepage_skillvalue_4_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName4); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName4); ?></div>
						<div class="skillValue" data-delay="450"><span><?php echo intval($skillValue4); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue4); ?>%" data-delay="450"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName5): ?>
			<?php $skillValue5 = mise_options('_onepage_skillvalue_5_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName5); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName5); ?></div>
						<div class="skillValue" data-delay="600"><span><?php echo intval($skillValue5); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue5); ?>%" data-delay="600"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName6): ?>
			<?php $skillValue6 = mise_options('_onepage_skillvalue_6_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName6); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName6); ?></div>
						<div class="skillValue" data-delay="750"><span><?php echo intval($skillValue6); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue6); ?>%" data-delay="750"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName7): ?>
			<?php $skillValue7 = mise_options('_onepage_skillvalue_7_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName7); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName7); ?></div>
						<div class="skillValue" data-delay="900"><span><?php echo intval($skillValue7); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue7); ?>%" data-delay="900"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName8): ?>
			<?php $skillValue8 = mise_options('_onepage_skillvalue_8_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName8); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName8); ?></div>
						<div class="skillValue" data-delay="1050"><span><?php echo intval($skillValue8); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue8); ?>%" data-delay="1050"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName9): ?>
			<?php $skillValue9 = mise_options('_onepage_skillvalue_9_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName9); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName9); ?></div>
						<div class="skillValue" data-delay="1200"><span><?php echo intval($skillValue9); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue9); ?>%" data-delay="1200"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if($skillName10): ?>
			<?php $skillValue10 = mise_options('_onepage_skillvalue_10_skills', '0'); ?>
				<div class="miseSkill">
					<div class="skillTop">
						<div class="skillName"><?php echo esc_html($skillName10); ?></div>
						<div class="skillNameUnder"><?php echo esc_html($skillName10); ?></div>
						<div class="skillValue" data-delay="1350"><span><?php echo intval($skillValue10); ?></span><i><?php esc_html_e('%', 'mise'); ?></i></div>
					</div>
					<div class="skillBottom">
						<div class="skillBar"></div>
						<div class="skillRealBar" data-number="<?php echo intval($skillValue10); ?>%" data-delay="1350"><div class="skillRealBarCyrcle"></div></div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>