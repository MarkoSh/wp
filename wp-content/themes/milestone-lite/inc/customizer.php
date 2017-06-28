<?php
/**
 *Milestone Lite Theme Customizer
 *
 * @package Milestone Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function milestone_lite_customize_register( $wp_customize ) {	
	
	function milestone_lite_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
		
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	//Layout Options
	$wp_customize->add_section('layout_option',array(
			'title'	=> __('Layout Option','milestone-lite'),			
			'priority'	=> 1,
	));		
	
	$wp_customize->add_setting('box_layout',array(
			'sanitize_callback' => 'milestone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'box_layout', array(
    	   'section'   => 'layout_option',    	 
		   'label'	=> __('Check to Box Layout','milestone-lite'),
    	   'type'      => 'checkbox'
     )); //Layout Section 
	 
	 $wp_customize->add_setting('removed_sidebar',array(
			'sanitize_callback' => 'milestone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'removed_sidebar', array(
    	   'section'   => 'layout_option',    	 
		   'label'	=> __('Check to list layout without sidebar for homepage','milestone-lite'),
    	   'type'      => 'checkbox'
     )); //Site Layout Section 
	 
	 $wp_customize->add_setting('stickyheader',array(
			'default' => '',
			'sanitize_callback' => 'milestone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'stickyheader', array(
    	   'section'   => 'layout_option',    	 
		   'label'	=> __('Check to hide sticky header','milestone-lite'),
    	   'type'      => 'checkbox'
     )); //Site Layout Section 
	 
	  $wp_customize->add_setting('grid_without_sidebar',array(
			'sanitize_callback' => 'milestone_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'grid_without_sidebar', array(
    	   'section'   => 'layout_option',    	 
		   'label'	=> __('Check to grid layout without sidebar for homepage','milestone-lite'),
    	   'type'      => 'checkbox'
     )); //Site Layout Section 
	
	$wp_customize->add_setting('color_scheme',array(
			'default'	=> '#89c140',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => __('Color Scheme','milestone-lite'),			
			 'description'	=> __('More color options in PRO Version','milestone-lite'),
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);
	
	// Slider Section		
	$wp_customize->add_section( 'slider_options', array(
            'title' => __('Slider Options', 'milestone-lite'),
            'priority' => null,
			'description'	=> __('Featured Image Size Should be ( 1400x600 ).','milestone-lite'),            			
    ));
	
	
	$wp_customize->add_setting('slide-page7',array(
			'default'	=> '0',			
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('slide-page7',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for slide one:','milestone-lite'),
			'section'	=> 'slider_options'
	));	
	
	$wp_customize->add_setting('slide-page8',array(
			'default'	=> '0',			
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('slide-page8',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for slide two:','milestone-lite'),
			'section'	=> 'slider_options'
	));	
	
	$wp_customize->add_setting('slide-page9',array(
			'default'	=> '0',			
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('slide-page9',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for slide three:','milestone-lite'),
			'section'	=> 'slider_options'
	));	// Slider Section
	
	 $wp_customize->add_setting('slider_readmore',array(
	 		'default'	=> null,
			'sanitize_callback'	=> 'sanitize_text_field'
	 ));
	 
	 $wp_customize->add_control('slider_readmore',array(
	 		'settings'	=> 'slider_readmore',
			'section'	=> 'slider_options',
			'label'		=> __('Add text for slide read more button','milestone-lite'),
			'type'		=> 'text'
	 ));// Slider Read more	
	
	$wp_customize->add_setting('disabled_slides',array(
				'default' => true,
				'sanitize_callback' => 'milestone_lite_sanitize_checkbox',
				'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'disabled_slides', array(
			   'settings' => 'disabled_slides',
			   'section'   => 'slider_options',
			   'label'     => __('Uncheck To Show This Section','milestone-lite'),
			   'type'      => 'checkbox'
	 ));//hide Slider Section	
	
	
	// four services Boxes Section 	
	$wp_customize->add_section('pageboxes_section', array(
		'title'	=> __('Four Page Boxes Section','milestone-lite'),
		'description'	=> __('Select Pages from the dropdown for four services boxes section','milestone-lite'),
		'priority'	=> null
	));		
	
	$wp_customize->add_setting('pagebox-area1',	array(
			'default'	=> '0',			
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
		));
 
	$wp_customize->add_control(	'pagebox-area1',array('type' => 'dropdown-pages',			
			'section' => 'pageboxes_section',
	));		
	
	$wp_customize->add_setting('pagebox-area2',	array(
			'default'	=> '0',			
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
		));
 
	$wp_customize->add_control(	'pagebox-area2',array('type' => 'dropdown-pages',			
			'section' => 'pageboxes_section',
	));
	
	$wp_customize->add_setting('pagebox-area3',	array(
			'default'	=> '0',			
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
		));
 
	$wp_customize->add_control(	'pagebox-area3',array('type' => 'dropdown-pages',			
			'section' => 'pageboxes_section',
	));
	
	$wp_customize->add_setting('pagebox-area4',	array(
			'default'	=> '0',			
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
		));
 
	$wp_customize->add_control(	'pagebox-area4',array('type' => 'dropdown-pages',			
			'section' => 'pageboxes_section',
	));//end four column page boxes	
	
	$wp_customize->add_setting('disabled_pgboxes',array(
			'default' => true,
			'sanitize_callback' => 'milestone_lite_sanitize_checkbox',
			'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'disabled_pgboxes', array(
			   'settings' => 'disabled_pgboxes',
			   'section'   => 'pageboxes_section',
			   'label'     => __('Uncheck To show This Section','milestone-lite'),
			   'type'      => 'checkbox'
	 ));//show Homepage boxes Section	 
	
	 
	 $wp_customize->add_section('social_sec',array(
			'title'	=> __('Social Settings','milestone-lite'),
			'description' => __( 'Add social icons link here. more social icons available in PRO Version', 'milestone-lite' ),			
			'priority'		=> null
	));
	$wp_customize->add_setting('fb_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	
	$wp_customize->add_control('fb_link',array(
			'label'	=> __('Add facebook link here','milestone-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'fb_link'
	));	
	$wp_customize->add_setting('twitt_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('twitt_link',array(
			'label'	=> __('Add twitter link here','milestone-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'twitt_link'
	));
	$wp_customize->add_setting('gplus_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('gplus_link',array(
			'label'	=> __('Add google plus link here','milestone-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'gplus_link'
	));
	$wp_customize->add_setting('linked_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('linked_link',array(
			'label'	=> __('Add linkedin link here','milestone-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'linked_link'
	));
	
	$wp_customize->add_setting('disabled_social',array(
				'default' => true,
				'sanitize_callback' => 'milestone_lite_sanitize_checkbox',
				'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'disabled_social', array(
			   'settings' => 'disabled_social',
			   'section'   => 'social_sec',
			   'label'     => __('Uncheck To show This Section','milestone-lite'),
			   'type'      => 'checkbox'
	 ));//Show Slider Section 
		
}
add_action( 'customize_register', 'milestone_lite_customize_register' );

function milestone_lite_custom_css(){
		?>
        	<style type="text/css"> 					
					a, .siteblog_listing h2 a:hover,
					#sidebar ul li a:hover,									
					.siteblog_listing h3 a:hover,
					.cols-4 ul li a:hover, .cols-4 ul li.current_page_item a,
					.recent-post h6:hover,					
					.page-four-column:hover h3,
					.footer-icons a:hover,					
					.postmeta a:hover,
					.pagebutton:hover
					{ color:<?php echo esc_html( get_theme_mod('color_scheme','#89c140')); ?>;}
					 
					
					.pagination ul li .current, .pagination ul li a:hover, 
					#commentform input#submit:hover,					
					.nivo-controlNav a.active,
					.ReadMore,
					.slide_info .slide_more,
					.appbutton:hover,					
					#sidebar .search-form input.search-submit,				
					.wpcf7 input[type='submit'],
					#featureswrap			
					{ background-color:<?php echo esc_html( get_theme_mod('color_scheme','#89c140')); ?>;}					
					
					
			</style> 
<?php        
}
         
add_action('wp_head','milestone_lite_custom_css');	 

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function milestone_lite_customize_preview_js() {
	wp_enqueue_script( 'milestone_lite_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20161014', true );
}
add_action( 'customize_preview_init', 'milestone_lite_customize_preview_js' );