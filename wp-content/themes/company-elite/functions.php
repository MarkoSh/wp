<?php
/**
 * Theme functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Company_Elite
 */

if ( ! function_exists( 'company_elite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function company_elite_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'company-elite' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'company-elite-thumb', 360, 270 );

		// Register nav menus.
		register_nav_menus( array(
			'primary'  => esc_html__( 'Primary Menu', 'company-elite' ),
			'footer'   => esc_html__( 'Footer Menu', 'company-elite' ),
			'social'   => esc_html__( 'Social Menu', 'company-elite' ),
		) );

		// Add support for HTML5 markup.
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'company_elite_custom_background_args', array(
			'default-color' => 'F1F0F0',
			'default-image' => '',
		) ) );

		// Enable support for selective refresh of widgets in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Enable support for custom logo.
		add_theme_support( 'custom-logo' );

		// Add WooCommerce support.
		add_theme_support( 'woocommerce' );

		// Set up Custom Header feature.
		add_theme_support( 'custom-header', apply_filters( 'company_elite_custom_header_args', array(
				'default-image' => get_template_directory_uri() . '/images/custom-header.jpg',
				'width'         => 1920,
				'height'        => 500,
				'flex-height'   => false,
				'header-text'   => false,
		) ) );

		// Register default header images.
		register_default_headers( array(
			'business-hour' => array(
				'url'           => '%s/images/custom-header.jpg',
				'thumbnail_url' => '%s/images/custom-header.jpg',
				'description'   => esc_html_x( 'Table Talk', 'custom header image description', 'company-elite' ),
			),
		) );

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Enable admin editor style.
		add_editor_style( array( company_elite_fonts_url(), 'css/editor-style' . $min . '.css' ) );

	}
endif;

add_action( 'after_setup_theme', 'company_elite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function company_elite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'company_elite_content_width', 640 );
}
add_action( 'after_setup_theme', 'company_elite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function company_elite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'company-elite' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your Primary Sidebar.', 'company-elite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Sidebar', 'company-elite' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your Secondary Sidebar.', 'company-elite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Widget Area', 'company-elite' ),
		'id'            => 'sidebar-front-page-widget-area',
		'description'   => esc_html__( 'Add widgets here to appear in your Front Page.', 'company-elite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="container">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2><span class="separator"></span>',
	) );
	register_sidebar( array(
		'name'          => sprintf( esc_html__( 'Footer %d', 'company-elite' ), 1 ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => sprintf( esc_html__( 'Footer %d', 'company-elite' ), 2 ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => sprintf( esc_html__( 'Footer %d', 'company-elite' ), 3 ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => sprintf( esc_html__( 'Footer %d', 'company-elite' ), 4 ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'company_elite_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function company_elite_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/vendors/font-awesome/css/font-awesome' . $min . '.css', '', '4.7.0' );

	$fonts_url = company_elite_fonts_url();
	if ( ! empty( $fonts_url ) ) {
		wp_enqueue_style( 'company-elite-google-fonts', $fonts_url, array(), null );
	}

	wp_enqueue_style( 'jquery-sidr', get_template_directory_uri() . '/vendors/sidr/css/jquery.sidr.dark' . $min . '.css', '', '2.2.1' );

	wp_enqueue_style( 'jquery-slick', get_template_directory_uri() .'/vendors/slick/slick' . $min . '.css', '', '1.5.9' );

	wp_enqueue_style( 'company-elite-style', get_stylesheet_uri(), array(), '1.0.2' );

	wp_enqueue_script( 'company-elite-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $min . '.js', array(), '20130115', true );

	wp_enqueue_script( 'jquery-cycle2', get_template_directory_uri() . '/vendors/cycle2/js/jquery.cycle2' . $min . '.js', array( 'jquery' ), '2.1.6', true );

	wp_enqueue_script( 'jquery-sidr', get_template_directory_uri() . '/vendors/sidr/js/jquery.sidr' . $min . '.js', array( 'jquery' ), '2.2.1', true );

	wp_enqueue_script( 'jquery-slick', get_template_directory_uri() . '/vendors/slick/slick' . $min . '.js', array( 'jquery' ), '1.5.9', true );

	wp_enqueue_script( 'company-elite-custom', get_template_directory_uri() . '/js/custom' . $min . '.js', array( 'jquery' ), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'company_elite_scripts' );

/**
 * Enqueue admin scripts and styles.
 *
 * @since 1.0.0
 *
 * @param string $hook Hook name.
 */
function company_elite_admin_scripts( $hook ) {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	if ( 'widgets.php' === $hook ) {
	    wp_enqueue_media();
		wp_enqueue_style( 'company-elite-widgets', get_template_directory_uri() . '/css/widgets' . $min . '.css', array(), '1.0.0' );
		wp_enqueue_script( 'company-elite-widgets', get_template_directory_uri() . '/js/widgets' . $min . '.js', array( 'jquery' ), '1.0.0', true );
	}

}

add_action( 'admin_enqueue_scripts', 'company_elite_admin_scripts' );

// Load starting file.
require_once trailingslashit( get_template_directory() ) . 'includes/start.php';