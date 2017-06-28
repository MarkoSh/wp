<?php
/**
 * mise functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mise
 */

if ( ! function_exists( 'mise_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mise_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on mise, use a find and replace
	 * to change 'mise' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'mise', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 250,
		'flex-width' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'mise-the-post' , 1920, 99999);
	add_image_size( 'mise-little-post', 370, 260, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'mise' ),
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
}
endif;
add_action( 'after_setup_theme', 'mise_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mise_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mise_content_width', 765 );
}
add_action( 'after_setup_theme', 'mise_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mise_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Classic Sidebar', 'mise' ),
		'id'            => 'sidebar-classic',
		'description'   => esc_html__( 'Add widgets here.', 'mise' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title"><h3><span>',
		'after_title'   => '</span></h3></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Push Sidebar', 'mise' ),
		'id'            => 'sidebar-push',
		'description'   => esc_html__( 'Add widgets here.', 'mise' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title"><h3><span>',
		'after_title'   => '</span></h3></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'mise' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'mise' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title"><h3><span>',
		'after_title'   => '</span></h3></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'mise' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'mise' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title"><h3><span>',
		'after_title'   => '</span></h3></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'mise' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'mise' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title"><h3><span>',
		'after_title'   => '</span></h3></div>',
	) );
}
add_action( 'widgets_init', 'mise_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mise_scripts() {
	wp_enqueue_style( 'mise-style', get_stylesheet_uri() );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome.min.css');
	wp_enqueue_style( 'mise-ie', get_template_directory_uri() . '/css/ie.css', array(), '1.0', null );
	wp_style_add_data( 'mise-ie', 'conditional', 'IE' );
	$query_args = array(
		'family' => 'Roboto:400,700%7CMontserrat:400,700'
	);
	wp_enqueue_style( 'mise-googlefonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );

	wp_enqueue_script( 'mise-custom', get_template_directory_uri() . '/js/jquery.mise.js', array('jquery', 'jquery'), '1.0', true );
	if ( is_active_sidebar( 'sidebar-push' ) ) {
		wp_enqueue_script( 'mise-nanoScroll', get_template_directory_uri() . '/js/jquery.nanoscroller.min.js', array('jquery'), '1.0', true );
	}
	wp_enqueue_script( 'mise-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'mise-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	if (is_page_template('template-onepage.php') && mise_options('_onepage_section_slider', '1') == 1) {
		wp_enqueue_script( 'mise-flex-slider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array(), '20151215', true );
	}
	if (is_page_template('template-onepage.php')) {
		wp_enqueue_script( 'mise-waypoints', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array('jquery'), '1.0', true );
	}
	if ( mise_options('_smooth_scroll', '1') == 1) {
		wp_enqueue_script( 'mise-smooth-scroll', get_template_directory_uri() . '/js/SmoothScroll.min.js', array('jquery'), '1.0', true );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	/* Dequeue default WooCommerce Layout */
	wp_dequeue_style ( 'woocommerce-layout' );
	wp_dequeue_style ( 'woocommerce-smallscreen' );
	wp_dequeue_style ( 'woocommerce-general' );
}
add_action( 'wp_enqueue_scripts', 'mise_scripts' );

/**
 * WooCommerce Support
 */
if ( ! function_exists( 'mise_woocommerce_support' ) ) :
	function mise_woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
	}
	add_action( 'after_setup_theme', 'mise_woocommerce_support' );
endif; // mise_woocommerce_support

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

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

/**
 * Load PRO Button in the customizer
 */
require_once( trailingslashit( get_template_directory() ) . 'inc/pro-button/class-customize.php' );

/* Calling in the admin area for the Welcome Page */
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/mise-admin-page.php';
}
