<?php
/**
 * HamzahShop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package HamzahShop
 */

if ( ! function_exists( 'hamzahshop_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hamzahshop_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on HamzahShop, use a find and replace
	 * to change 'hamzahshop' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'hamzahshop', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary / Main Menu', 'hamzahshop' ),
		'account_after_log' => esc_html__( 'My Account After Login', 'hamzahshop' ),
		'account_before_log' => esc_html__( 'My Account Before Login', 'hamzahshop' ),
		
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'video',
		'gallery',
		'audio',
	) );
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hamzahshop_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	
		// Declare WooCommerce support.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
	// Add custom Logo.
	 add_theme_support( 'custom-logo' );
	
}
endif;
add_action( 'after_setup_theme', 'hamzahshop_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hamzahshop_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hamzahshop_content_width', 640 );
}
add_action( 'after_setup_theme', 'hamzahshop_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hamzahshop_widgets_init() {

	 register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'hamzahshop' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'hamzahshop' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	 register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar', 'hamzahshop' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add widgets here.', 'hamzahshop' ),
		'before_widget' => ' <div id="%1$s" class="col-lg-3 col-md-3 col-sm-4 col-xs-12 %2$s"><div class="single-widget footer-widget-list">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="footer-widget-title"><h3>',
		'after_title'   => '</h3></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Top  Sidebar', 'hamzahshop' ),
		'id'            => 'footer-top',
		'description'   => esc_html__( 'Add widgets here.', 'hamzahshop' ),
		'before_widget' => ' <div id="%1$s" class="col-lg-3 col-md-3 col-sm-4 col-xs-12 %2$s"><div class="single-service">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Home Page Slider Sidebar', 'hamzahshop' ),
		'id'            => 'slider',
		'description'   => esc_html__( 'Add widgets here.', 'hamzahshop' ),
		'before_widget' => '<div class="slider-area %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="slider_title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Static Front Page Content ', 'hamzahshop' ),
		'id'            => 'static',
		'description'   => esc_html__( 'Add widgets here.', 'hamzahshop' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	
    
	
	
	
}
add_action( 'widgets_init', 'hamzahshop_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hamzahshop_scripts() {
	wp_enqueue_style( 'hamzahshop-Lato-fonts', '//fonts.googleapis.com/css?family=Lato:400,400italic,900,700,700italic,300' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css' );
	wp_enqueue_style( 'hamzahshop-meanmenu', get_template_directory_uri() . '/assets/css/meanmenu.css' );
	wp_enqueue_style( 'hamzahshop-style', get_stylesheet_uri() );
	wp_enqueue_style( 'hamzahshop-responsive', get_template_directory_uri() . '/assets/css/responsive.css' );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', array(), '20151215', true );
	wp_enqueue_script( 'jquery.meanmenu', get_template_directory_uri() . '/assets/js/jquery.meanmenu.js', array(), '20151215', true );
	wp_enqueue_script( 'jquery.sticky', get_template_directory_uri() . '/assets/js/jquery.sticky.js', array(), '20151215', true );
	wp_enqueue_script('jquery-scrollUp', get_template_directory_uri().'/assets/js/jquery.scrollUp.js',0,0,true);
	
	wp_enqueue_script( 'hamzahshop.main', get_template_directory_uri() . '/assets/js/main.js', array(), '20151215', true );



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hamzahshop_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';



/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/comment-helper.php';



/**
 * Load customize file.
 */
require get_template_directory() . '/customizer/class-customize.php';



/**
 * Load customize file.
 */
require get_template_directory() . '/inc/pro.php';

/**
 * Load customize file.
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';


/**
 * Load theme-hooks-n-function file.
 */
require get_template_directory() . '/inc/template-functions.php';
