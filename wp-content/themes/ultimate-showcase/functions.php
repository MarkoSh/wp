<?php
/*
=====================================================================
Enqueue styles and scripts
=====================================================================
*/

function upcp_theme_load_styles(){
	wp_enqueue_style( 'upcp_theme_load_style_css', get_stylesheet_uri() );
	wp_enqueue_style( 'upcp_theme_load_googlefonts_css', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic|Montserrat:400|Roboto+Slab:400' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/inc/font-awesome/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'upcp_theme_load_styles' );

function upcp_theme_load_scripts(){
	wp_enqueue_script( 'upcp_theme_load_upcp_theme_js', get_template_directory_uri() . '/js/base.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'upcp_theme_load_scripts' );

function upcp_theme_load_customizer_scripts() {
	wp_enqueue_script( 'upcp_theme_load_customizer_js', get_template_directory_uri() . '/js/customizer.js', array( 'jquery' ) );
}
add_action( 'customize_controls_enqueue_scripts', 'upcp_theme_load_customizer_scripts' );




/*
=====================================================================
TGM Plugin Stuff
=====================================================================
*/

require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'upcp_theme_register_required_plugins' );

function upcp_theme_register_required_plugins() {
	$plugins = array(
		array(
			'name'			=> 'Etoile Theme Companion',
			'slug'			=> 'etoile-theme-companion',
			'required'		=> false,
		),
		array(
			'name'			=> 'Ultimate Slider',
			'slug'			=> 'ultimate-slider',
			'required'		=> false,
		),
		array(
			'name'			=> 'Ultimate Product Catalog',
			'slug'			=> 'ultimate-product-catalogue',
			'required'		=> false,
		),
	);

	// Only uncomment the strings in the config array if you want to customize the strings.
	$config = array(
		'id'           => 'ultimate-showcase',     // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}




/*
=====================================================================
Load text domain
=====================================================================
*/

add_action('after_setup_theme', 'upcp_theme_text_domain');
function upcp_theme_text_domain(){
    load_theme_textdomain('ultimate-showcase', get_template_directory() . '/lang');
}




/*
=====================================================================
Add customizable navigation
=====================================================================
*/

function upcp_theme_register_my_menu() {
  register_nav_menu('main-menu', __('Main Menu', 'ultimate-showcase'));
}
add_action( 'init', 'upcp_theme_register_my_menu' );




/*
=====================================================================
Widgetize sidebar and footer
=====================================================================
*/

function upcp_theme_widgets_init() {
	register_sidebar( array(
		'name' => __('Page Sidebar', 'ultimate-showcase'),
		'id' => 'sidebar_widget',
		'before_widget' => '<div class="widgetBox">',
		'after_widget' => '</div> <!-- widgetBox -->',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="clear"></div>',
	) );
	register_sidebar( array(
		'name' => __('Blog Sidebar', 'ultimate-showcase'),
		'id' => 'sidebar_widget_blog',
		'before_widget' => '<div class="widgetBox">',
		'after_widget' => '</div> <!-- widgetBox -->',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="clear"></div>',
	) );
	register_sidebar( array(
		'name' => __('Footer', 'ultimate-showcase'),
		'id' => 'footer_widget',
		'before_widget' => '<div class="widgetBox">',
		'after_widget' => '</div><!-- widgetBox --></div><!-- column -->',
		'before_title' => '<div class="column"><h3>',
		'after_title' => '</h3><div class="clear"></div>',
	) );
}
add_action( 'widgets_init', 'upcp_theme_widgets_init' );




/*
=====================================================================
Post thumbnails
=====================================================================
*/

add_action( 'after_setup_theme', 'upcp_theme_post_thumbnails' );
function upcp_theme_post_thumbnails(){
	add_theme_support('post-thumbnails');
	//set_post_thumbnail_size(250, 250, true);
}




/*
=====================================================================
Custom background
=====================================================================
*/

add_action( 'after_setup_theme', 'upcp_theme_custom_background' );
function upcp_theme_custom_background(){
	$args = array(
		'default-color' => 'ffffff',
	);
	add_theme_support( 'custom-background', $args );
}




/*
=====================================================================
Feeds
=====================================================================
*/

add_action( 'after_setup_theme', 'upcp_theme_automatic_feed_links' );
function upcp_theme_automatic_feed_links(){
	add_theme_support( 'automatic-feed-links' );
}




/*
=====================================================================
Content width
=====================================================================
*/

if ( ! isset( $content_width ) ) $content_width = 960;




/*
=====================================================================
Title tag
=====================================================================
*/

add_action( 'after_setup_theme', 'upcp_theme_slug_setup' );
function upcp_theme_slug_setup(){
	add_theme_support( 'title-tag' );
}



/*
=====================================================================
Custom logo
=====================================================================
*/

add_action( 'after_setup_theme', 'upcp_theme_custom_header' );
function upcp_theme_custom_header(){
	add_theme_support( "custom-header" );
	if ( ! defined('NO_HEADER_TEXT') ){
		define( 'NO_HEADER_TEXT', true );
	}
}
function upcp_theme_custom_logo() {
	add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'upcp_theme_custom_logo' );




/*
=====================================================================
Threaded comments
=====================================================================
*/

function upcp_theme_threaded_comments(){
	if ( is_singular() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'upcp_theme_threaded_comments' );




/*
=====================================================================
Customizer Stuff
=====================================================================
*/

function upcp_theme_customize_register( $wp_customize ){

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$pluginThemeCompanion = "etoile-theme-companion/etoile-theme-companion.php";
	$installedThemeCompanion = is_plugin_active($pluginThemeCompanion);
	$pluginUPCP = "ultimate-product-catalogue/UPCP_Main.php";
	$installedUPCP = is_plugin_active($pluginUPCP);

	$wp_customize->remove_section('background_image');
	$wp_customize->get_section('header_image')->title = __( 'Logo', 'ultimate-showcase');
	if ( function_exists('the_custom_logo') ){
		$wp_customize->remove_section('header_image');
	}

	// LOGO HEIGHT
	$wp_customize->add_setting( 'upcp_theme_setting_logo_height', array(
		'default'		=> '24px',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		'upcp_theme_setting_logo_height',
		array(
			'section'	=> 'title_tagline',
			'label'		=> __( 'Logo Height', 'ultimate-showcase' ),
			'description'		=> __( 'Specify the logo height in pixels (e.g. 24px)', 'ultimate-showcase' ),
			'type'    => 'text',
		)
	);

	// LOGO TOP MARGIN
	$wp_customize->add_setting( 'upcp_theme_setting_logo_top_margin', array(
		'default'		=> '28px',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		'upcp_theme_setting_logo_top_margin',
		array(
			'section'	=> 'title_tagline',
			'label'		=> __( 'Logo Top Margin', 'ultimate-showcase' ),
			'description'		=> __( 'Specify the margin above the logo in pixels (e.g. 28px)', 'ultimate-showcase' ),
			'type'    => 'text',
		)
	);

	/*==============
	START COLOURS
	==============*/

	// TEXT COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_text_color', array(
		'default'		=> '#999',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_text_color',
			array(
				'label'		=> __( 'Text Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_text_color'
			)
		)
	);

	// LINK COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_link_color', array(
		'default'		=> '#34ADCF',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_link_color',
			array(
				'label'		=> __( 'Link Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_link_color'
			)
		)
	);

	// HEADER BACKGROUND COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_header_background_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_header_background_color',
			array(
				'label'		=> __( 'Header Background Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_header_background_color'
			)
		)
	);

	// MENU TEXT COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_menu_text_color', array(
		'default'		=> '#111',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_menu_text_color',
			array(
				'label'		=> __( 'Menu Text Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_menu_text_color'
			)
		)
	);

	// MENU TEXT HOVER COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_menu_text_hover_color', array(
		'default'		=> '#34ADCF',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_menu_text_hover_color',
			array(
				'label'		=> __( 'Menu Text Hover Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_menu_text_hover_color'
			)
		)
	);

	// MENU DROP DOWN BACKGROUND COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_menu_dropdown_background_color', array(
		'default'		=> '#111',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_menu_dropdown_background_color',
			array(
				'label'		=> __( 'Menu Drop Down Background Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_menu_dropdown_background_color'
			)
		)
	);

	// MENU DROP DOWN BACKGROUND HOVER COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_menu_dropdown_background_hover_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_menu_dropdown_background_hover_color',
			array(
				'label'		=> __( 'Menu Drop Down Background Hover Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_menu_dropdown_background_hover_color'
			)
		)
	);

	// MENU DROP DOWN TEXT COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_menu_dropdown_text_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_menu_dropdown_text_color',
			array(
				'label'		=> __( 'Menu Drop Down Text Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_menu_dropdown_text_color'
			)
		)
	);

	// MENU DROP DOWN TEXT HOVER COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_menu_dropdown_text_hover_color', array(
		'default'		=> '#111',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_menu_dropdown_text_hover_color',
			array(
				'label'		=> __( 'Menu Drop Down Text Hover Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_menu_dropdown_text_hover_color'
			)
		)
	);

	// PAGE TITLE BAR BACKGROUND COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_page_title_bar_background_color', array(
		'default'		=> '#34ADCF',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_page_title_bar_background_color',
			array(
				'label'		=> __( 'Page Title Bar Background Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_page_title_bar_background_color'
			)
		)
	);

	// PAGE TITLE BAR TEXT COLOR
	$wp_customize->add_setting( 'upcp_theme_setting_page_title_bar_text_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upcp_theme_setting_page_title_bar_text_color',
			array(
				'label'		=> __( 'Page Title Bar Text Color', 'ultimate-showcase' ),
				'section'	=> 'colors',
				'settings'	=> 'upcp_theme_setting_page_title_bar_text_color'
			)
		)
	);

	/*==============
	END COLOURS
	==============*/

	/*==============
	START FONTS
	==============*/

	// CREATE FONTS SECTION
	$wp_customize->add_section(
		'upcp_theme_setting_fonts',
		array(
			'title'			=> __( 'Fonts', 'ultimate-showcase'),
			'description'	=> __( 'Please note that, if you use a Google font or other webfont, you must also properly include that font (i.e. in the header file, the functions file or via CSS).', 'ultimate-showcase'),
			'priority'		=> 50
		)
	);

	// MAIN BODY FONT
	$wp_customize->add_setting( 'upcp_theme_setting_font_main', array(
		'default'			=> '',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
		'transport'			=> 'refresh',
	) );
	$wp_customize->add_control(
		'upcp_theme_setting_font_main',
		array(
			'section'	=> 'upcp_theme_setting_fonts',
			'label'		=> __( 'Main Body Font', 'ultimate-showcase' ),
			'type'    	=> 'text',
		)
	);

	// HEADING FONT
	$wp_customize->add_setting( 'upcp_theme_setting_font_heading', array(
		'default'			=> '',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
		'transport'			=> 'refresh',
	) );
	$wp_customize->add_control(
		'upcp_theme_setting_font_heading',
		array(
			'section'	=> 'upcp_theme_setting_fonts',
			'label'		=> __( 'Heading Font', 'ultimate-showcase' ),
			'type'    	=> 'text',
		)
	);

	// MENU FONT
	$wp_customize->add_setting( 'upcp_theme_setting_font_menu', array(
		'default'			=> '',
		'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
		'transport'			=> 'refresh',
	) );
	$wp_customize->add_control(
		'upcp_theme_setting_font_menu',
		array(
			'section'	=> 'upcp_theme_setting_fonts',
			'label'		=> __( 'Menu Font', 'ultimate-showcase' ),
			'type'    	=> 'text',
		)
	);

	/*==============
	END FONTS
	==============*/

	/*==============
	START CALLOUT
	==============*/

	if($installedThemeCompanion){

		// CREATE CALLOUT SECTION
		$wp_customize->add_section(
			'upcp_theme_setting_callout_section',
			array(
				'title'     => __( 'Callout Area', 'ultimate-showcase'),
				'priority'  => 200
			)
		);

		// CALLOUT ENABLE
		$wp_customize->add_setting( 'upcp_theme_setting_callout_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_callout_enable',
			array(
				'section'	=> 'upcp_theme_setting_callout_section',
				'label'		=> __( 'Display Callout Area on Homepage', 'ultimate-showcase' ),
				'type'    => 'radio',
				'choices'  => array(
					'yes'    => __( 'Yes', 'ultimate-showcase' ),
					'no'   => __( 'No', 'ultimate-showcase' ),
				)
			)
		);

		// CALLOUT HEADING TEXT
		$wp_customize->add_setting( 'upcp_theme_setting_callout_heading_text', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_callout_heading_text',
			array(
				'section'	=> 'upcp_theme_setting_callout_section',
				'label'		=> __( 'Heading Text', 'ultimate-showcase' ),
				'type'    => 'text',
			)
		);

		// CALLOUT SUB-HEADING TEXT
		$wp_customize->add_setting( 'upcp_theme_setting_callout_subheading_text', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_callout_subheading_text',
			array(
				'section'	=> 'upcp_theme_setting_callout_section',
				'label'		=> __( 'Sub-Heading Text', 'ultimate-showcase' ),
				'type'    => 'text',
			)
		);

		// CALLOUT BUTTON TEXT
		$wp_customize->add_setting( 'upcp_theme_setting_callout_button_text', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_callout_button_text',
			array(
				'section'	=> 'upcp_theme_setting_callout_section',
				'label'		=> __( 'Button Text', 'ultimate-showcase' ),
				'type'    => 'text',
			)
		);

		// CALLOUT BUTTON LINK
		$wp_customize->add_setting( 'upcp_theme_setting_callout_button_link', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_url_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_callout_button_link',
			array(
				'section'	=> 'upcp_theme_setting_callout_section',
				'label'		=> __( 'Button Link', 'ultimate-showcase' ),
				'type'    => 'text',
			)
		);

		// CALLOUT BACKGROUND COLOR
		$wp_customize->add_setting( 'upcp_theme_setting_callout_background_color', array(
			'default'		=> '#34ADCF',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'upcp_theme_setting_callout_background_color',
				array(
					'label'		=> __( 'Background Color', 'ultimate-showcase' ),
					'section'	=> 'upcp_theme_setting_callout_section',
					'settings'	=> 'upcp_theme_setting_callout_background_color'
				)
			)
		);

		// CALLOUT TEXT COLOR
		$wp_customize->add_setting( 'upcp_theme_setting_callout_text_color', array(
			'default'		=> '#fff',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'upcp_theme_setting_callout_text_color',
				array(
					'label'		=> __( 'Text Color', 'ultimate-showcase' ),
					'section'	=> 'upcp_theme_setting_callout_section',
					'settings'	=> 'upcp_theme_setting_callout_text_color'
				)
			)
		);

	} //if theme companion active

	/*==============
	END CALLOUT
	==============*/

	/*==============
	START TEXT ON PIC
	==============*/

	if($installedThemeCompanion){

		// CREATE TEXT ON PIC SECTION
		$wp_customize->add_section(
			'upcp_theme_setting_textonpic_section',
			array(
				'title'     => __( 'Text on Picture', 'ultimate-showcase'),
				'priority'  => 200
			)
		);

		// TEXT ON PIC ENABLE
		$wp_customize->add_setting( 'upcp_theme_setting_textonpic_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_textonpic_enable',
			array(
				'section'	=> 'upcp_theme_setting_textonpic_section',
				'label'		=> __( 'Display Text-on-Picture Area on Homepage', 'ultimate-showcase' ),
				'description' => __('Should the text overlay on a background image area be displayed?', 'ultimate-showcase'),
				'type'    => 'radio',
				'choices'  => array(
					'yes'    => __( 'Yes', 'ultimate-showcase' ),
					'no'   => __( 'No', 'ultimate-showcase' ),
				)
			)
		);

		// TEXT ON PIC HEADING TEXT
		$wp_customize->add_setting( 'upcp_theme_setting_textonpic_heading_text', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_textonpic_heading_text',
			array(
				'section'	=> 'upcp_theme_setting_textonpic_section',
				'label'		=> __( 'Heading Text', 'ultimate-showcase' ),
				'type'    => 'text',
			)
		);

		// TEXT ON PIC SUB-HEADING TEXT
		$wp_customize->add_setting( 'upcp_theme_setting_textonpic_subheading_text', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_textonpic_subheading_text',
			array(
				'section'	=> 'upcp_theme_setting_textonpic_section',
				'label'		=> __( 'Sub-Heading Text', 'ultimate-showcase' ),
				'type'    => 'text',
			)
		);

		// TEXT ON PIC BUTTON TEXT
		$wp_customize->add_setting( 'upcp_theme_setting_textonpic_button_text', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_textonpic_button_text',
			array(
				'section'	=> 'upcp_theme_setting_textonpic_section',
				'label'		=> __( 'Button Text', 'ultimate-showcase' ),
				'type'    => 'text',
			)
		);

		// TEXT ON PIC BUTTON LINK
		$wp_customize->add_setting( 'upcp_theme_setting_textonpic_button_link', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_url_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_textonpic_button_link',
			array(
				'section'	=> 'upcp_theme_setting_textonpic_section',
				'label'		=> __( 'Button Link', 'ultimate-showcase' ),
				'type'    => 'text',
			)
		);

		// TEXT ON PIC TEXT COLOR
		$wp_customize->add_setting( 'upcp_theme_setting_textonpic_text_color', array(
			'default'		=> '#fff',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_color_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'upcp_theme_setting_textonpic_text_color',
				array(
					'label'		=> __( 'Text Color', 'ultimate-showcase' ),
					'section'	=> 'upcp_theme_setting_textonpic_section',
					'settings'	=> 'upcp_theme_setting_textonpic_text_color'
				)
			)
		);

		// TEXT ON PIC TEXT BACKGROUND IMAGE
		$wp_customize->add_setting( 'upcp_theme_setting_textonpic_background_image', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_url_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'upcp_theme_setting_textonpic_background_image',
				array(
					'label'      => __( 'Background Image', 'ultimate-showcase' ),
					'section'    => 'upcp_theme_setting_textonpic_section',
					'settings'   => 'upcp_theme_setting_textonpic_background_image',
				)
			)
		);

		// TEXT ON PIC TEXT OVERLAY IMAGE
		$wp_customize->add_setting( 'upcp_theme_setting_textonpic_overlay_image', array(
			'default'		=> '',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_url_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'upcp_theme_setting_textonpic_overlay_image',
				array(
					'label'      => __( 'Overlay Image', 'ultimate-showcase' ),
					'section'    => 'upcp_theme_setting_textonpic_section',
					'settings'   => 'upcp_theme_setting_textonpic_overlay_image',
				)
			)
		);

	} //if theme companion active

	/*==============
	END TEXT ON PIC
	==============*/

	/*==============
	START HOMEPAGE GENERAL
	==============*/

	if($installedThemeCompanion){

		// CREATE HOMEPAGE GENERAL SECTION
		$wp_customize->add_section(
			'upcp_theme_setting_homepage_section',
			array(
				'title'       => __( 'Homepage General', 'ultimate-showcase'),
				'description' => __( 'The options to enable the Callout and Text-on-Picture areas can be found in the "Callout Area" and "Text on Picture" sections just below.', 'ultimate-showcase'),
				'priority'    => 199
			)
		);

		// SLIDER ENABLE
		$wp_customize->add_setting( 'upcp_theme_setting_homepage_slider_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_homepage_slider_enable',
			array(
				'section'		=> 'upcp_theme_setting_homepage_section',
				'label'			=> __( 'Display Slider', 'ultimate-showcase' ),
				'description'	=> __( 'Should the slider be displayed on the homepage?', 'ultimate-showcase' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'ultimate-showcase' ),
					'no'			=> __( 'No', 'ultimate-showcase' ),
				)
			)
		);

		// SLIDER STATIC FIRST SLIDE
		$wp_customize->add_setting( 'upcp_theme_setting_homepage_slider_static_first', array(
			'default'		=> 'no',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_homepage_slider_static_first',
			array(
				'section'		=> 'upcp_theme_setting_homepage_section',
				'label'			=> __( 'Display Static First Slide Only', 'ultimate-showcase' ),
				'description'	=> __( 'Select this option to display your first slide as a static image, with no sliding or animation.', 'ultimate-showcase' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'ultimate-showcase' ),
					'no'			=> __( 'No', 'ultimate-showcase' ),
				)
			)
		);

		// JUMP BOXES ENABLE
		$wp_customize->add_setting( 'upcp_theme_setting_homepage_jumpboxes_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_homepage_jumpboxes_enable',
			array(
				'section'		=> 'upcp_theme_setting_homepage_section',
				'label'			=> __( 'Display Jump Boxes', 'ultimate-showcase' ),
				'description'	=> __( 'Should the jump boxes be displayed on the homepage?', 'ultimate-showcase' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'ultimate-showcase' ),
					'no'			=> __( 'No', 'ultimate-showcase' ),
				)
			)
		);

		// TESTIMONIALS ENABLE
		$wp_customize->add_setting( 'upcp_theme_setting_homepage_testimonials_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_homepage_testimonials_enable',
			array(
				'section'		=> 'upcp_theme_setting_homepage_section',
				'label'			=> __( 'Display Testimonials', 'ultimate-showcase' ),
				'description'	=> __( 'Should the testimonials be displayed on the homepage?', 'ultimate-showcase' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'ultimate-showcase' ),
					'no'			=> __( 'No', 'ultimate-showcase' ),
				)
			)
		);

		// FEATURED PRODUCTS ENABLE
		$wp_customize->add_setting( 'upcp_theme_setting_homepage_featured_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_homepage_featured_enable',
			array(
				'section'		=> 'upcp_theme_setting_homepage_section',
				'label'			=> __( 'Display Featured Products', 'ultimate-showcase' ),
				'description'	=> __( 'Should featured products be displayed on the homepage?', 'ultimate-showcase' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'ultimate-showcase' ),
					'no'			=> __( 'No', 'ultimate-showcase' ),
				)
			)
		);

	} //if theme companion active

	/*==============
	END HOMEPAGE GENERAL
	==============*/

	/*==============
	START CATALOG URL
	==============*/

	if($installedUPCP){

		// CREATE CATALOG URL SECTION
		$wp_customize->add_section(
			'upcp_theme_setting_catalog_url',
			array(
				'title'     => __( 'Catalogue URL', 'ultimate-showcase'),
				'priority'  => 1
			)
		);

		// CATALOG URL TEXT
		$wp_customize->add_setting( 'upcp_theme_setting_catalog_url_text', array(
			'default'			=> get_option('EWD_UPCP_Theme_Catalogue_Page_ID'),
			'sanitize_callback' => 'upcp_theme_setting_sanitize_all_url_fields',
			'transport'			=> 'refresh',
		) );
		$wp_customize->add_control(
			'upcp_theme_setting_catalog_url_text',
			array(
				'section'	=> 'upcp_theme_setting_catalog_url',
				'label'		=> __( 'Catalogue URL', 'ultimate-showcase' ),
				'description'		=> __( 'Input here the URL of the page on which you\'ve placed the [product-catalogue id="X"] shortcode. This will ensure correct functionality of the catalogue-specific features.', 'ultimate-showcase' ),
				'type'    	=> 'text',
			)
		);

	} //if is active UPCP

	/*==============
	END CATALOG URL
	==============*/

	/*==============
	START IMPORTANT LINKS
	==============*/
	
	// DEFINE IMPORTANT LINKS
	class upcp_theme_setting_important_links_class extends WP_Customize_Control {

		public $type = "upcp_theme_setting_important_links_type";

		public function render_content() {
			$important_links = array(
				'view-pro' => array(
					'link' => esc_url('http://www.etoilewebdesign.com/themes/ultimate-showcase/'),
					'text' => esc_html__('View Premium Version', 'ultimate-showcase'),
				),
				'theme-info' => array(
					'link' => esc_url('https://wordpress.org/themes/ultimate-showcase/'),
					'text' => esc_html__('Theme Info', 'ultimate-showcase'),
				),
				'support' => array(
					'link' => esc_url('https://wordpress.org/support/theme/ultimate-showcase/'),
					'text' => esc_html__('Support Forum', 'ultimate-showcase'),
				),
				/*'documentation' => array(
					'link' => esc_url('https://wordpress.org/themes/ultimate-showcase/documentation/'),
					'text' => esc_html__('Documentation', 'ultimate-showcase'),
				),*/
				'demo' => array(
					'link' => esc_url('http://www.etoilewebdesign.com/ultimate-showcase/'),
					'text' => esc_html__('View Demo', 'ultimate-showcase'),
				),
				'rating' => array(
					'link' => esc_url('http://wordpress.org/support/view/theme-reviews/ultimate-showcase'),
					'text' => esc_html__('Leave a Review', 'ultimate-showcase'),
				),
				'feedback' => array(
					'link' => esc_url('mailto:contact@etoilewebdesign.com'),
					'text' => esc_html__('Send Us Feedback', 'ultimate-showcase'),
				),
			);

			foreach ( $important_links as $important_link ) {
				echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr( $important_link['text'] ) . ' </a></p>';
			}
		}
	}

	// CREATE IMPORTANT SECTION
	$wp_customize->add_section(
		'upcp_theme_setting_important_links_section',
		array(
			'title'     => __( 'Ultimate Showcase Important Links', 'ultimate-showcase'),
			'priority'  => 1000
		)
	);

	// DISPLAY IMPORTANT LINKS
	$wp_customize->add_setting( 'upcp_theme_setting_important_links', array(
		'sanitize_callback' => 'upcp_theme_setting_sanitize_false',
	) );
	$wp_customize->add_control(
		new upcp_theme_setting_important_links_class(
			$wp_customize, 'important_links', array(
				'section'	=> 'upcp_theme_setting_important_links_section',
				'settings'	=> 'upcp_theme_setting_important_links'
			)
		)
	);

	// IMPORTANT LINKS CSS
	add_action( 'customize_controls_print_footer_scripts', 'upcp_theme_setting_important_links_css' );
	function upcp_theme_setting_important_links_css() { ?>
		<style>
			li#accordion-section-upcp_theme_setting_important_links_section h3 {
				background-color: #34ADCF !important;
				color: #fff !important;
			}
			li#accordion-section-upcp_theme_setting_important_links_section h3:after {
				color: #fff !important;
			}
			li#accordion-section-upcp_theme_setting_important_links_section:hover h3 {
				background-color: #53C1E0 !important;
			}
			.customize-control-upcp_theme_setting_important_links_type p a {
				text-decoration: none;
				width: 75%;
				margin-left: 12.5%;
				background-color: #34ADCF;
				color: #fff;
				text-align: center;
				float: left;
				clear: both;
				padding: 6px 0;
				margin-bottom: 10px;
			}
			.customize-control-upcp_theme_setting_important_links_type p a:hover {
				background-color: #53C1E0;
			}
			#ewd-ust-lite-ugrade-button {
				text-decoration: none;
				text-align: center;
				margin-top: 4px;
				background: #34ADCF;
				color: #fff;
				font-size: 12px;
				padding: 5px 8px;
				display: inline-block;
			}
			#ewd-ust-lite-ugrade-button:hover {
				background: #53C1E0;
			}
		</style>
	<?php }

	/*==============
	END IMPORTANT LINKS
	==============*/

} // END upcp_theme_customize_register FUNCTION
add_action( 'customize_register', 'upcp_theme_customize_register' );


function upcp_theme_customizer_css(){
	$fontMain = get_theme_mod( 'upcp_theme_setting_font_main', '' );
	$fontHeadings = get_theme_mod( 'upcp_theme_setting_font_heading', '' );
	$fontMenu = get_theme_mod( 'upcp_theme_setting_font_menu', '' );

	echo "<style type='text/css'>";
		$usCustomizerCSS = "";
		$usCustomizerCSS .= "body { color: " . get_theme_mod( 'upcp_theme_setting_text_color' ) . "; }";
		$usCustomizerCSS .= "a { color: " . get_theme_mod( 'upcp_theme_setting_link_color' ) . "; }";
		$usCustomizerCSS .= "#header { background: " . get_theme_mod( 'upcp_theme_setting_header_background_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li a { color: " . get_theme_mod( 'upcp_theme_setting_menu_text_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li a:hover { color: " . get_theme_mod( 'upcp_theme_setting_menu_text_hover_color' ) . "; border-bottom-color: " . get_theme_mod( 'upcp_theme_setting_menu_text_hover_color' ) . "; }";
		$usCustomizerCSS .= "#header input:hover { background: " . get_theme_mod( 'upcp_theme_setting_menu_text_hover_color' ) . "; border-color: " . get_theme_mod( 'upcp_theme_setting_menu_text_hover_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li ul { background: " . get_theme_mod( 'upcp_theme_setting_menu_dropdown_background_color' ) . "; }";
		$usCustomizerCSS .= "/*#menu ul li ul { border-color: " . get_theme_mod( 'upcp_theme_setting_menu_dropdown_background_color' ) . "; }*/";
		$usCustomizerCSS .= "#menu ul li ul li a:hover { background: " . get_theme_mod( 'upcp_theme_setting_menu_dropdown_background_hover_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li ul li a { color: " . get_theme_mod( 'upcp_theme_setting_menu_dropdown_text_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li ul li a:hover { color: " . get_theme_mod( 'upcp_theme_setting_menu_dropdown_text_hover_color' ) . "; }";
		$usCustomizerCSS .= "#logo { height: " . get_theme_mod( 'upcp_theme_setting_logo_height', '24px' ) . "; margin-top: " . get_theme_mod( 'upcp_theme_setting_logo_top_margin', '28px' ) . "; }";
		$usCustomizerCSS .= ".singlePage .titleArea { background-color: " . get_theme_mod( 'upcp_theme_setting_page_title_bar_background_color' ) . "; }";
		$usCustomizerCSS .= ".singlePage .titleArea h1 { color: " . get_theme_mod( 'upcp_theme_setting_page_title_bar_text_color' ) . "; }";
		if($fontMain != ''){
			$usCustomizerCSS .= "body { font-family: " . $fontMain . "; }";
		}
		if($fontHeadings != ''){
			$usCustomizerCSS .= "h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { font-family: " . $fontHeadings . "; }";
		}
		if($fontMenu != ''){
			$usCustomizerCSS .= "#menu ul li a, #header input { font-family: " . $fontMenu . "; }";
		}
		echo esc_attr($usCustomizerCSS);
	echo "</style>";
}
add_action( 'wp_head', 'upcp_theme_customizer_css' );

function upcp_theme_setting_sanitize_all_text_fields($input){
	return sanitize_text_field($input);
}
function upcp_theme_setting_sanitize_all_textarea_fields($input){
	return sanitize_textarea_field($input);
}
function upcp_theme_setting_sanitize_all_color_fields($input){
	return sanitize_hex_color($input);
}
function upcp_theme_setting_sanitize_all_url_fields($input){
	return esc_url_raw($input);
}
function upcp_theme_setting_sanitize_all_radio_fields($input, $setting){
	$input = sanitize_key($input);
	$choices = $setting->manager->get_control($setting->id)->choices;
	return ( array_key_exists($input, $choices) ? $input : $setting->default );
}
function upcp_theme_setting_sanitize_false(){
	return false;
}




/*
=====================================================================
Excerpt Read More link
=====================================================================
*/

function upcp_theme_excerpt_read_more($more) {
	global $post;
	return '<br><a class="excerptReadMore" href="'. get_permalink($post->ID) . '">' . __('Read More', 'ultimate-showcase') . '</a>';
}
add_filter('excerpt_more', 'upcp_theme_excerpt_read_more');




/*
=====================================================================
WooCommerce
=====================================================================
*/

//Declare support
add_action( 'after_setup_theme', 'upcp_theme_woocommerce_support' );
function upcp_theme_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
