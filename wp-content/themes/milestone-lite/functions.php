<?php 
/**
 *Milestone Lite functions and definitions
 *
 * @package Milestone Lite 
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! function_exists( 'milestone_lite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.  
 */
function milestone_lite_setup() {		
	global $content_width;   
    if ( ! isset( $content_width ) ) {
        $content_width = 680; /* pixels */
    }	

	load_theme_textdomain( 'milestone-lite', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('woocommerce');
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-header', array( 
		'default-text-color' => false,
		'header-text' => false,
	) );
	add_theme_support( 'title-tag' );	
	add_theme_support( 'custom-logo', array(
		'height'      => 50,
		'width'       => 100,
		'flex-height' => true,
	) );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'milestone-lite' ),		
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );
	add_editor_style( 'editor-style.css' );
} 
endif; // milestone_lite_setup
add_action( 'after_setup_theme', 'milestone_lite_setup' );
function milestone_lite_widgets_init() { 	
	
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'milestone-lite' ),
		'description'   => __( 'Appears on blog page sidebar', 'milestone-lite' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Header Contact info', 'milestone-lite' ),
		'description'   => __( 'Appears on the header when you add something here.', 'milestone-lite' ),
		'id'            => 'header-1',
		'before_widget' => '<aside id="%1$s" class="hdrright %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="infotitle">',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'milestone-lite' ),
		'description'   => __( 'Appears on footer', 'milestone-lite' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="cols-4 widget-column-1 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'milestone-lite' ),
		'description'   => __( 'Appears on footer', 'milestone-lite' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="cols-4 widget-column-2 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 3', 'milestone-lite' ),
		'description'   => __( 'Appears on footer', 'milestone-lite' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="cols-4 widget-column-3 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 4', 'milestone-lite' ),
		'description'   => __( 'Appears on footer', 'milestone-lite' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="cols-4 widget-column-4 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );	
	
}
add_action( 'widgets_init', 'milestone_lite_widgets_init' );


function milestone_lite_font_url(){
		$font_url = '';		
		
		/* Translators: If there are any character that are not
		* supported by Montserrat, trsnalate this to off, do not
		* translate into your own language.
		*/
		$montserrat = _x('on','montserrat:on or off','milestone-lite');			
		
		if('off' !== $montserrat ){
			$font_family = array();
			
			if('off' !== $montserrat){
				$font_family[] = 'Montserrat:300,400,600,700,800,900';
			}
					
						
			$query_args = array(
				'family'	=> urlencode(implode('|',$font_family)),
			);
			
			$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
		}
		
	return $font_url;
	}


function milestone_lite_scripts() {
	wp_enqueue_style('milestone-lite-font', milestone_lite_font_url(), array());
	wp_enqueue_style( 'milestone-lite-basic-style', get_stylesheet_uri() );	
	wp_enqueue_style( 'nivo-slider', get_template_directory_uri()."/css/nivo-slider.css" );
	wp_enqueue_style( 'milestone-lite-responsive', get_template_directory_uri()."/css/responsive.css" );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri()."/css/font-awesome.css" );
	wp_enqueue_script( 'jquery-nivo-slider', get_template_directory_uri() . '/js/jquery.nivo.slider.js', array('jquery') );
	wp_enqueue_script( 'milestone-lite-editable', get_template_directory_uri() . '/js/editable.js' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'milestone_lite_scripts' );

function milestone_lite_ie_stylesheet(){
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style('milestone-lite-ie', get_template_directory_uri().'/css/ie.css', array( 'milestone-lite-style' ), '20160928' );
	wp_style_add_data('milestone-lite-ie','conditional','lt IE 10');
	
	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'milestone-lite-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'milestone-lite-style' ), '20160928' );
	wp_style_add_data( 'milestone-lite-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'milestone-lite-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'milestone-lite-style' ), '20160928' );
	wp_style_add_data( 'milestone-lite-ie7', 'conditional', 'lt IE 8' );	
	}
add_action('wp_enqueue_scripts','milestone_lite_ie_stylesheet');

define('MILESTONE_LITE_THEME_DOC','https://www.gracethemes.com/documentation/milestone-doc/','milestone-lite');
define('MILESTONE_LITE_PROTHEME_URL','https://gracethemes.com/themes/responsive-simple-wordpress-theme/','milestone-lite');
define('MILESTONE_LITE_LIVE_DEMO','https://www.gracethemes.com/demo/milestonez/','milestone-lite');

if ( ! function_exists( 'milestone_lite_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
function milestone_lite_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom template for about theme.
 */
if ( is_admin() ) { 
require get_template_directory() . '/inc/about-themes.php';
}

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';