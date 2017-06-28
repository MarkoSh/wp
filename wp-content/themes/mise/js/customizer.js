/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	/* Text */
	wp.customize( 'mise_theme_options[_onepage_text_1_slider]', function( value ) {
		value.bind( function( to ) {
			$( '.flexslider .slides > li:first-child .flexText .inside h2' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_text_2_slider]', function( value ) {
		value.bind( function( to ) {
			$( '.flexslider .slides > li:nth-child(2) .flexText .inside h2' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_text_3_slider]', function( value ) {
		value.bind( function( to ) {
			$( '.flexslider .slides > li:nth-child(3) .flexText .inside h2' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtext_1_slider]', function( value ) {
		value.bind( function( to ) {
			$( '.flexslider .slides > li:first-child .flexText .inside span' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtext_2_slider]', function( value ) {
		value.bind( function( to ) {
			$( '.flexslider .slides > li:nth-child(2) .flexText .inside span' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtext_3_slider]', function( value ) {
		value.bind( function( to ) {
			$( '.flexslider .slides > li:nth-child(3) .flexText .inside span' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_title_aboutus]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_aboutus .misee_main_text' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtitle_aboutus]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_aboutus .mise_subtitle' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_title_features]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_features .misee_main_text' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtitle_features]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_features .mise_subtitle' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_title_skills]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_skills .misee_main_text' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtitle_skills]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_skills .mise_subtitle' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_title_services]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_services .misee_main_text' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtitle_services]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_services .mise_subtitle' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_title_blog]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_blog .misee_main_text' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtitle_blog]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_blog .mise_subtitle' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_title_team]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_team .misee_main_text' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtitle_team]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_team .mise_subtitle' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_title_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_contact .misee_main_text' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_subtitle_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.mise_action_contact .mise_subtitle' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textbutton_aboutus]', function( value ) {
		value.bind( function( to ) {
			$( '.aboutus_columns_three.one .miseButton a' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_boxtextbutton_1_features]', function( value ) {
		value.bind( function( to ) {
			$( '.features_columns_single:first-child .miseButton a' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_boxtextbutton_2_features]', function( value ) {
		value.bind( function( to ) {
			$( '.features_columns_single:nth-child(2) .miseButton a' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_boxtextbutton_3_features]', function( value ) {
		value.bind( function( to ) {
			$( '.features_columns_single:nth-child(3) .miseButton a' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_boxtextbutton_4_features]', function( value ) {
		value.bind( function( to ) {
			$( '.features_columns_single:nth-child(4) .miseButton a' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_phrase_services]', function( value ) {
		value.bind( function( to ) {
			$( '.services_columns_single .serviceContent h3' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textarea_services]', function( value ) {
		value.bind( function( to ) {
			$( '.services_columns_single .serviceContent p' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_additionaltext_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.miseAdditionalText p' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_companyname_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.miseCompanyName h3' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_companyaddress1_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.miseCompanyAddress1 p' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_companyaddress2_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.miseCompanyAddress2 p' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_companyaddress3_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.miseCompanyAddress3 p' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_companyphone_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.miseCompanyPhone p' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_companyfax_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.miseCompanyFax p' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_companyemail_contact]', function( value ) {
		value.bind( function( to ) {
			$( '.miseCompanyEmail p' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_social_float_text]', function( value ) {
		value.bind( function( to ) {
			$( '.site-social .socialText span' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_phrase_cta]', function( value ) {
		value.bind( function( to ) {
			$( '.cta_columns .ctaPhrase h3' ).text( to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_desc_cta]', function( value ) {
		value.bind( function( to ) {
			$( '.cta_columns .ctaPhrase p' ).text( to );
		} );
	} );
	/* Background Color and Text */
	wp.customize( 'mise_theme_options[_onepage_imgcolor_aboutus]', function( value ) {
		value.bind( function( to ) {
			$('.mise_aboutus_color').css('background-color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textcolor_aboutus]', function( value ) {
		value.bind( function( to ) {
			$('section.mise_aboutus').css('color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_imgcolor_features]', function( value ) {
		value.bind( function( to ) {
			$('.mise_features_color').css('background-color', to );
			$('.featuresIcon').css('color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textcolor_features]', function( value ) {
		value.bind( function( to ) {
			$('section.mise_features, .featuresIconCyrcle').css('color', to );
			$('.featuresIcon').css('background', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_imgcolor_skills]', function( value ) {
		value.bind( function( to ) {
			$('.mise_skills_color').css('background-color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textcolor_skills]', function( value ) {
		value.bind( function( to ) {
			$('section.mise_skills').css('color', to );
			$('.skillBottom .skillBar, .skillBottom .skillRealBar, .skillBottom .skillRealBarCyrcle').css('background', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_imgcolor_cta]', function( value ) {
		value.bind( function( to ) {
			$('.mise_cta_color').css('background-color', to );
			$('.cta_columns .ctaIcon').css('color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textcolor_cta]', function( value ) {
		value.bind( function( to ) {
			$('section.mise_cta, .cta_columns .ctaIcon .ctaIconCyrcle').css('color', to );
			$('.cta_columns .ctaIcon').css('background', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_imgcolor_services]', function( value ) {
		value.bind( function( to ) {
			$('.mise_services_color').css('background-color', to );
			$('.serviceIcon, .services_columns_single .serviceContent').css('color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textcolor_services]', function( value ) {
		value.bind( function( to ) {
			$('section.mise_services, .services_columns .serviceIcon .serviceIconCyrcle').css('color', to );
			$('.serviceIcon').css('background', to );
			$('.services_columns_single.two .serviceColumnSingleColor').css('background-color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_imgcolor_blog]', function( value ) {
		value.bind( function( to ) {
			$('.mise_blog_color').css('background-color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textcolor_blog]', function( value ) {
		value.bind( function( to ) {
			$('section.mise_blog').css('color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_imgcolor_team]', function( value ) {
		value.bind( function( to ) {
			$('.mise_team_color').css('background-color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textcolor_team]', function( value ) {
		value.bind( function( to ) {
			$('section.mise_team').css('color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_imgcolor_contact]', function( value ) {
		value.bind( function( to ) {
			$('.mise_contact_color, .contact_columns .miseContactForm input:not([type="submit"]), .contact_columns .miseContactForm textarea').css('background-color', to );
			$('.miseCompanyAddress1Icon, .miseCompanyPhoneIcon, .miseCompanyFaxIcon, .miseCompanyEmailIcon').css('color', to );
		} );
	} );
	wp.customize( 'mise_theme_options[_onepage_textcolor_contact]', function( value ) {
		value.bind( function( to ) {
			$('section.mise_contact, .contact_columns .miseContactForm input:not([type="submit"]), .contact_columns .miseContactForm textarea').css('color', to );
			$('.miseCompanyAddress1Icon, .miseCompanyPhoneIcon, .miseCompanyFaxIcon, .miseCompanyEmailIcon').css('background', to );
		} );
	} );
} )( jQuery );
