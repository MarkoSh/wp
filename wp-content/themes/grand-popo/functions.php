<?php
/**
 * Grand-Popo functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Grand-Popo
 */
if (!function_exists('grand_popo_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function grand_popo_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on components, use a find and replace
         * to change 'grand-popo' to the name of your theme in all the template files.
         */

    //load TGMPA
    require_once( get_template_directory() . '/inc/class-tgm-plugin-activation.php');
    
    //load theme textdomain for translate
    load_theme_textdomain('grand-popo', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    add_image_size('grand_popo-featured-image', 640, 9999);

    //This theme uses wp_nav_menu() in one location.
    register_nav_menus(array(
        'top-header-menu-left' => esc_html__('Top header left', 'grand-popo'),
        'top-header-menu-right' => esc_html__('Top header right', 'grand-popo'),
        'main-menu' => esc_html__('Main', 'grand-popo'),
    ));

    /**
     * Add support for core custom logo.
     */
    add_theme_support('custom-logo', array(
        'height' => 200,
        'width' => 200,
        'flex-width' => true,
        'flex-height' => true,
    ));

    /*
     * Switch default core markup for comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    /*
     * Enable support for Post Formats.
     * See http://codex.wordpress.org/Post_Formats
     */
    add_theme_support('post-formats', array(
        'image',
        'video',
        'quote',
        'gallery',
        'audio',
        'link'
    ));

    // Set up the WordPress core custom background feature.
    add_theme_support('custom-background', apply_filters('grand_popo_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));

}
endif;
add_action('after_setup_theme', 'grand_popo_setup');

//load redux framework to allow custom options for the theme
require_once (get_template_directory() . '/inc/redux/grand_popo-config.php');

//Add theme support woocommerce
function grand_popo_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'grand_popo_woocommerce_support');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function grand_popo_content_width() {
    $GLOBALS['content_width'] = apply_filters('grand_popo_content_width', 640);
}

add_action('after_setup_theme', 'grand_popo_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function grand_popo_widgets_init() {
    //Default sidebar (blog sidebar)
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'grand-popo'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Blog sidebar', 'grand-popo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    //Display widget on the top of product archive page
    register_sidebar(array(
        'name' => esc_html__('Product Archive Top Sidebar', 'grand-popo'),
        'id' => 'top-shop-sidebar',
        'description' => esc_html__('Product Archive Top Sidebar', 'grand-popo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    //Display widget on the single product page 
    register_sidebar(array(
        'name' => esc_html__('Product Advantage', 'grand-popo'),
        'id' => 'product-avantage-sidebar',
        'description' => esc_html__('Product Avantage Sidebar', 'grand-popo'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    //Display widget on the shop sidebar 
    register_sidebar(array(
        'name' => esc_html__('Shop sidebar', 'grand-popo'),
        'id' => 'shop-sidebar',
        'description' => esc_html__('Shop sidebar', 'grand-popo'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'grand_popo_widgets_init');

/**
 * Enqueue google fonts url.
 * returns an aarray of font
 */

function grand_popo_google_fonts_url() {
    $fonts_url = '';

    $grand_popo_montserrat = _x('on', 'Montserrat font: on or off', 'grand-popo');
    $grand_popo_open_sans = _x('on', 'Open Sans font: on or off', 'grand-popo');
    $grand_popo_playfair = _x('on', 'Playfair Dispaly font: on or off', 'grand-popo');

    if ('off' !== $grand_popo_montserrat || 'off' !== $grand_popo_open_sans  || 'off' !== $grand_popo_playfair ) {
        $font_families = array();

        if ('off' !== $grand_popo_montserrat) {
            $font_families[] = 'Montserrat:400,700';
        }

        if ('off' !== $grand_popo_open_sans) {
            $font_families[] = 'Open Sans:300i,400,400i,700,800';
        }

        if ('off' !== $grand_popo_playfair) {
            $font_families[] = 'Playfair Display:400,400italic';
        }

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('latin,latin-ext'),
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/**
 * Enqueue scripts and styles.
 */
function grand_popo_scripts() {
    wp_enqueue_style('grand_popo-google-font', grand_popo_google_fonts_url(), array());

    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), time(), 'all');

    wp_enqueue_style('themify', get_template_directory_uri() . '/assets/themify-icons/themify-icons.css');

    wp_enqueue_style('flexiblegs', get_template_directory_uri() . '/assets/stylesheets/flexiblegs.css');

    wp_enqueue_style('mCustomScrollbar-css', get_template_directory_uri() . '/assets/stylesheets/jquery.mCustomScrollbar.min.css');

    wp_enqueue_style('owl-carousel-css', get_template_directory_uri() . '/assets/stylesheets/owl.carousel.css');

    wp_enqueue_style('owl-carousel-theme-css', get_template_directory_uri() . '/assets/stylesheets/owl.theme.css');

    wp_enqueue_style('grand_popo-select2-css', get_template_directory_uri() . '/assets/stylesheets/select2.css');
    
    wp_enqueue_style('tooltip-css', get_template_directory_uri() . '/assets/stylesheets/tooltip.css');

    wp_enqueue_style('grand_popo-style', get_stylesheet_uri(), array());

    wp_enqueue_script('grand_popo-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('grand_popo-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true);
    
    wp_enqueue_script('unveil-js', get_template_directory_uri() . '/assets/js/jquery.unveil.min.js', array('jquery'), null, true);

    wp_enqueue_script('mCustomScrollbar-js', get_template_directory_uri() . '/assets/js/jquery.mCustomScrollbar.concat.min.js', array('jquery'), false, true);

    wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), null, true);
    
    wp_enqueue_script('tooltip-js', get_template_directory_uri() . '/assets/js/tooltip.min.js', array(), null, true);

    wp_enqueue_script('bx-slider-js', get_template_directory_uri() . '/assets/js/jquery.bxslider.min.js', array(), null, true);
    
    wp_enqueue_script('grand_popo-select2-js', get_template_directory_uri() . '/assets/js/select2.min.js', array(), null, true);
    
    wp_enqueue_script('grand_popo-scripts-js', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery','grand_popo-select2-js'), null, true);
    
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

}

add_action('wp_enqueue_scripts', 'grand_popo_scripts');
/**
 * Add fontawesome to redux panel
 * Allow to use fontawesome in redux panel
 */
function grand_popo_add_font_awesome_to_redux_panel() {
    wp_enqueue_style('redux-font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), time(), 'all');
}
add_action('redux/page/grand_popo_options/enqueue', 'grand_popo_add_font_awesome_to_redux_panel');

/**
 * Registers an editor stylesheet for the theme.
 */
function wpdocs_theme_add_editor_styles() {
    add_editor_style(get_template_directory_uri() . '/assets/stylesheets/editor-style.css');
}
add_action('admin_init', 'wpdocs_theme_add_editor_styles');
/**
 * Enqueue admin scripts and admin styles.
 */
function grand_popo_admin_script_css($hook) {
    if ( 'edit-tags.php' != $hook || 'admin.php'!= $hook ) {
        return;
    }
    wp_enqueue_style('grand_popo-admin-css', get_template_directory_uri() . '/assets/admin/admin.css');
}
add_action('admin_enqueue_scripts', 'grand_popo_admin_script_css');

function grand_popo_admin_notice_script_css() {
    wp_enqueue_style('grand_popo-admin-css', get_template_directory_uri() . '/assets/admin/admin-notices.css');
}
add_action('admin_enqueue_scripts', 'grand_popo_admin_notice_script_css');

function grand_popo_admin_script_js($hook){
    if ( 'edit-tags.php' != $hook ) {
        return;
    }
    wp_enqueue_script('grand_popo-admin-js', get_template_directory_uri() . '/assets/admin/admin.js', array('jquery'));
}
add_action('admin_enqueue_scripts', 'grand_popo_admin_script_js');
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
 * Load notices.
 */
require get_template_directory() . '/inc/notices.php';

/**
 * Get a value by key in an array if defined
 * @param array $values Array to search into
 * @param string $search_key Searched key
 * @param mixed $default_value Value if the key does not exist in the array
 * @return mixed
 */
function grand_popo_get_proper_value($values, $search_key, $default_value = "") {
    if (isset($values[$search_key]))
        $default_value = $values[$search_key];
    return $default_value;
}

/**
 * Get a mini cart 
 * @param string $mode (mobile or "") 
 * returns mini cart 
 */
function grand_popo_get_mini_cart($mode="") {
    global $grand_popo_options;
    
    if (function_exists('woocommerce_mini_cart') && grand_popo_get_proper_value($grand_popo_options, 'opt-enable-mini-cart', '1') == '1') {
            if($mode=="mobile"){
            ?>
            <div class="mobile-header-cart-box">
                <div id="mini-cart-container">
            <?php
            }
            ?>
                    <div class="mini-cart">
                        <?php
                        if($mode!="mobile"){
                            ?>
                            <a class="cart-contents cart-top-icon"  title="<?php esc_attr_e('View your shopping cart', 'grand-popo'); ?>">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </a>
                        <?php echo esc_html__('CART', 'grand-popo'); ?>
                         <?php
                    }
                    else{
                        ?>
                        <i class="ti-shopping-cart"></i>
                        <a class="cart-contents cart-top-icon"  title="<?php esc_attr_e('View your shopping cart', 'grand-popo'); ?>">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </a>
                        <?php
                    }
                    ?>
                    </div>
                    <div class="cart-detail">
                        <?php
                        woocommerce_mini_cart();
                        ?>
                    </div>
            <?php
            if($mode=="mobile"){
            ?>
                </div>
            </div>
            <?php
            }
    }
}

/**
 * Register page meta boxes
 * @param string $post  
 */
function grand_popo_register_page_meta_boxes($post) {
    add_meta_box('header_meta_box', esc_html__('Header options', 'grand-popo'), 'grand_popo_build_page_meta_boxes', 'page', 'normal', 'low');
}
add_action('add_meta_boxes_page', 'grand_popo_register_page_meta_boxes');
/**
 * Build Page meta boxes 
 * @param string $post 
 * return array of options field 
 */
function grand_popo_build_page_meta_boxes($post) {
    if(class_exists("Orion_Library"))
    { 
    $options = array();
    $header_settings_begin = array(
        'type' => 'sectionbegin',
        'id' => 'grand_popo_header_section',
        'title' => esc_html__('Header Settings', 'grand-popo')
    );

    $page_title = array(
        'title' => esc_html__('Display Page Title', 'grand-popo'),
        'desc' => esc_html__('Hide or show title', 'grand-popo'),
        'name' => 'grand_popo_page_options[page-title]',
        'type' => 'select',
        'default' => 'yes',
        'options' => array(
            'yes' => esc_html__('Yes', 'grand-popo'),
            'no' => esc_html__('No', 'grand-popo'),
            'all'=> esc_html__('Hide All', 'grand-popo')
        )
    );
    
    $sidebar_position = array(
        'title' => esc_html__('Sidebar Position', 'grand-popo'),
        'desc' => esc_html__('Choose the sidebar position', 'grand-popo'),
        'name' => 'grand_popo_page_options[sidebar-position]',
        'type' => 'select',
        'default' => 'no-sidebar',
        'options' => array(
            'left' => esc_html__('Left Sidebar', 'grand-popo'),
            'right' => esc_html__('Right Sidebar', 'grand-popo'),
            'no-sidebar' => esc_html__('No Sidebar', 'grand-popo')
        )
    );

    $page_layout = array(
        'title' => esc_html__('Page Layout', 'grand-popo'),
        'desc' => esc_html__('Choose the page layout', 'grand-popo'),
        'name' => 'grand_popo_page_options[page-layout]',
        'type' => 'select',
        'default' => 'boxed',
        'options' => array(
            'boxed' => esc_html__('Boxed', 'grand-popo'),
            'full-width' => esc_html__('Full Width', 'grand-popo'),
        )
    );
          
    $header_settings_end = array('type' => 'sectionend');

    array_push($options, $header_settings_begin);
    array_push($options, $page_title);
    array_push($options, $page_layout);
    array_push($options, $sidebar_position);
    array_push($options, $header_settings_end);

    echo Orion_Library::o_admin_fields($options);
    ?>
    <input type="hidden" name="grand_popo_page_options_nonce" value="<?php echo wp_create_nonce( 'grand_popo_page_options_nonce' ); ?>" />
    <?php 
    }
    else
        esc_html_e("Please install Grand-Popo core plugin in order to be able to define different pages templates.", "grand-popo");
}
/**
 * Sanitize each field of array field
 * @param array $array_field 
 * return sanitize array  
 */
function grand_popo_array_sanitize($arr){
   $newArr = array();
   foreach( $arr as $key => $value )
   {
       $newArr[ $key ]=(is_array($value) ? vpc_array_sanitize($value) : sanitize_text_field(esc_html($value))) ;
   }
   return $newArr;
}
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function grand_popo_save_meta_box($grand_popo_post_id) {
// Save logic goes here. Don't forget to include nonce checks!
   
    if ( isset($_REQUEST['grand_popo_page_options_nonce'] ) &&  wp_verify_nonce($_REQUEST['grand_popo_page_options_nonce'], 'grand_popo_page_options_nonce' ) ) {
        $_POST= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(isset($_POST['grand_popo_page_options']) && !empty($_POST['grand_popo_page_options']) && current_user_can('edit_post',$grand_popo_post_id)) {
           $options=grand_popo_array_sanitize($_POST['grand_popo_page_options']);
           if(is_array($options)){
               $esc_gp_page_options=array();
               $gp_page_options=$options;
               
               foreach($gp_page_options as $key=>$gp_page_option){
                   $esc_gp_page_options[$key]=sanitize_text_field(esc_html($gp_page_option));
                   update_post_meta($grand_popo_post_id, 'grand_popo_page_options', $esc_gp_page_options);
               }
           }
           
       }
    }
    
}

add_action('save_post', 'grand_popo_save_meta_box');

/**
 * Get page title
 * return page title  
 */
function grand_popo_get_page_title() {
    global $post, $grand_popo_options;
    $show_page_header = grand_popo_get_proper_value($grand_popo_options, 'opt-display-page-header', '1');
    $page_id=  get_the_ID();
    if (function_exists('is_shop') && is_shop())
        $page_id=get_option( 'woocommerce_shop_page_id' ); 
        
    if (function_exists('is_shop') && (is_page() || is_shop() )){
       // $grand_popo_meta_boxes = get_post_meta($post->ID, 'grand_popo_page_options', true);
        $page_metas = get_post_meta($page_id, 'grand_popo_page_options', true);
        $page_metas_title=grand_popo_get_proper_value($page_metas, 'page-title', 'yes');
        if ($page_metas_title != "all") {
            $page_header_class = "grand_popo-page-title";
        } else {
            $page_header_class = "grand_popo-page-title no-header";
        }
    }else{
        
        if ($show_page_header==1) {
            $page_header_class = "grand_popo-page-title";
        } else {
            $page_header_class = "grand_popo-page-title no-header ";
        }
    }
    
    if (is_front_page()) {
        
    } else {
        
        ?>
        <div class="<?php echo esc_attr($page_header_class); ?>">
            <div class="site-wrap">
                <?php
                if (function_exists('is_product') && is_product()) {
                    ?>
                    <div class="page-header">
                        <header class="entry-header">
                            <h1 class="entry-title">
                                <?php esc_html_e('Product Details', 'grand-popo'); ?>
                            </h1>

                        </header>

                        <?php grand_popo_breadcrumbs(); ?>
                    </div>

                    <?php
                } elseif (is_single()) {
                    ?>
                    <header class="page-header">
                        <h1 class="">
                            <?php esc_html_e('BLOG DETAIL', 'grand-popo'); ?>
                        </h1>

                        <?php grand_popo_breadcrumbs(); ?>

                    </header>
                    <?php
                } elseif (function_exists('is_shop') && (is_shop() || is_product_category())) {
                    ?>
                    <div class="page-header">
                        <?php
                        if (apply_filters('woocommerce_show_page_title', true)) :
                            
                        
                            if(woocommerce_page_title($echo =false)=="")
                                $shop_title= esc_html__("SHOP","grand-popo");
                            
                            else
                                $shop_title= woocommerce_page_title($echo =false);
                            ?>
                            
                            <h1 class="page-title"><?php echo $shop_title; ?></h1>

                        <?php endif; ?>
                        <?php grand_popo_breadcrumbs(); ?>
                    </div>

                    <?php
                    do_action('woocommerce_archive_description');
                }
                elseif (is_search()) {
                    ?>
                    <div class="page-header">
                        <header class="entry-header">
                            <h1 class="entry-title">
                                <?php esc_html_e('SEARCH', 'grand-popo'); ?>
                            </h1>

                        </header>

                        <?php grand_popo_breadcrumbs(); ?>
                    </div>
                    <?php
                } elseif (is_404()) {
                    ?>
                    <div class="page-header">
                        <header class="entry-header">
                            <h1 class="entry-title">
                                <?php esc_html_e('404 ERROR', 'grand-popo'); ?>
                            </h1>

                        </header>

                        <?php grand_popo_breadcrumbs(); ?>
                    </div>
                    <?php
                } elseif (is_page()) {
                    $show_title = get_post_meta($post->ID, 'grand_popo_page_options', true);

                    $show_title = grand_popo_get_proper_value($show_title, 'page-title', 'yes');

                    $page_title = "";

                    if ($show_title == "yes") {

                        $page_title.= "<header class='entry-header'> <h1 class='entry-title'>";
                        $page_title.= get_the_title();
                        $page_title.="</h1></header>";
                    }
                    ?>
                    <div class="page-header">
                        <?php
                        echo $page_title;

                        grand_popo_breadcrumbs();
                        ?>
                    </div>

                    <?php
                } elseif (is_home()) {
                    ?>
                    <header class="page-header">
                        <h1 class="">
                            <?php esc_html_e('BLOG', 'grand-popo'); ?>
                        </h1>

                        <?php grand_popo_breadcrumbs(); ?>
                    </header>

                    <?php
                } else {
                    ?>
                    <header class="page-header">
                        <?php
                        the_archive_title('<h1 class="page-title">', '</h1>');
                        grand_popo_breadcrumbs();
                        ?>

                    </header>
                    <div> <?php the_archive_description('<div class="taxonomy-description">', '</div>'); ?></div>
                    <?php
                }
                ?>
            </div>
        </div>

        <?php
    }
}
/**
 * Get custom Breadcrumbs
 * return breadcrumbs 
 */
function grand_popo_breadcrumbs() {
    global $grand_popo_options;
    $display_breadcrumb = grand_popo_get_proper_value($grand_popo_options, 'opt-display-breadcrumb', '1');

    if ($display_breadcrumb == "1") {

        // Settings
        $separator = '<i class="fa fa-chevron-right"></i> ';
        $breadcrums_id = 'breadcrumbs';
        $breadcrums_class = 'breadcrumbs';
        $home_title = esc_html__('Home','grand-popo');
        $custom_taxonomy = 'product_cat';

        // Get the query & post information
        global $post, $wp_query;

        // Do not display on the homepage
        if (!is_front_page()) {

            // Build the breadcrums
            echo '<ul id="' . esc_attr($breadcrums_id) . '" class="' . esc_attr($breadcrums_class) . '">';

            // Home page
            echo '<li class="item-home"><a class="bread-link bread-home" href="' . esc_url(get_home_url()) . '" title="' . esc_attr($home_title) . '">' . $home_title . '</a></li>';
            echo '<li class="separator separator-home"> ' . $separator. ' </li>';

            if (is_archive() && !is_tax() && !is_category() && !is_tag()) {

                echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title('', false) . '</strong></li>';
            } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

                // If post is a custom post type
                $post_type = get_post_type();

                // If it is a custom post type display name and link
                if ($post_type != 'post') {

                    $post_type_object = get_post_type_object($post_type);
                    $post_type_archive = get_post_type_archive_link($post_type);
                    $no_found = esc_html__('No Post Found', 'grand-popo');
                    echo '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . (isset($post_type_archive) ? esc_url($post_type_archive) : "") . '" title="' . (isset($post_type_object) ? esc_attr($post_type_object->labels->name) : "") . '">' . (isset($post_type_object) ? $post_type_object->labels->name : $no_found) . '</a></li>';
                    echo '<li class="separator"> ' . $separator . ' </li>';
                }

                $custom_tax_name = get_queried_object()->name;
                echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . (($custom_tax_name))? $custom_tax_name : "" . '</strong></li>';
            } else if (is_single()) {

                // If post is a custom post type
                $post_type = get_post_type();

                // If it is a custom post type display name and link
                if ($post_type != 'post') {

                    $post_type_object = get_post_type_object($post_type);
                    $post_type_archive = get_post_type_archive_link($post_type);
                    $no_found = esc_html__('No Post Found', 'grand-popo');
                    echo '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . (isset($post_type_archive) ? esc_url($post_type_archive) : "") . '" title="' . (isset($post_type_object) ? esc_attr($post_type_object->labels->name) : "") . '">' . (isset($post_type_object) ? $post_type_object->labels->name : $no_found) . '</a></li>';
                    echo '<li class="separator"> ' . $separator . ' </li>';
                }

                // Get post category info
                $category = get_the_category();

                if (!empty($category)) {

                    // Get last category post is in
                    $category_values = array_values($category);

                    $last_category = end($category_values);

                    // Get parent any categories and create array
                    $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                    $cat_parents = explode(',', $get_cat_parents);

                    // Loop through parent categories and store in variable $cat_display
                    $cat_display = '';
                    foreach ($cat_parents as $parents) {
                        $cat_display .= '<li class="item-cat">' . $parents . '</li>';
                        $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                    }
                }

                // If it's a custom post type within a custom taxonomy
                $taxonomy_exists = taxonomy_exists($custom_taxonomy);
                if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                    $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
                    if (isset($taxonomy_terms[0]) && property_exists($taxonomy_terms[0], 'term_id')) {
                        $cat_id = $taxonomy_terms[0]->term_id;
                        $cat_nicename = $taxonomy_terms[0]->slug;
                        $cat_link = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                        $cat_name = $taxonomy_terms[0]->name;
                    }
                }

                // Check if the post is in a category
                if (!empty($last_category)) {
                    echo wp_kses_post($cat_display);
                    echo '<li class="item-current item-' . esc_attr($post->ID) . '"><strong class="bread-current bread-' . esc_attr($post->ID) . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</strong></li>';

                    // Else if post is in a custom taxonomy
                } else if (!empty($cat_id)) {

                    echo '<li class="item-cat item-cat-' . esc_attr($cat_id) . ' item-cat-' . esc_attr($cat_nicename) . '"><a class="bread-cat bread-cat-' . esc_attr($cat_id) . ' bread-cat-' . esc_attr($cat_nicename) . '" href="' . esc_url($cat_link) . '" title="' . esc_attr($cat_name) . '">' . esc_html($cat_name) . '</a></li>';
                    echo '<li class="separator"> ' . $separator . ' </li>';
                    echo '<li class="item-current item-' . esc_attr($post->ID) . '"><strong class="bread-current bread-' . esc_attr($post->ID) . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</strong></li>';
                } else {

                    echo '<li class="item-current item-' . esc_attr($post->ID) . '"><strong class="bread-current bread-' . esc_attr($post->ID) . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</strong></li>';
                }
            } else if (is_category()) {

                // Category page
                echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . esc_html(single_cat_title('', false)) . '</strong></li>';
            } else if (is_page()) {

                // Standard page
                if ($post->post_parent) {

                    // If child page, get parents
                    $anc = get_post_ancestors($post->ID);

                    // Get parents in the right order
                    $anc = array_reverse($anc);

                    // Parent page loop
                    $parents = "";
                    foreach ($anc as $ancestor) {
                        $parents .= '<li class="item-parent item-parent-' . esc_attr($ancestor) . '"><a class="bread-parent bread-parent-' . esc_attr($ancestor) . '" href="' . esc_url(get_permalink($ancestor)) . '" title="' . esc_attr(get_the_title($ancestor)) . '">' . get_the_title($ancestor) . '</a></li>';
                        $parents .= '<li class="separator separator-' . esc_attr($ancestor) . '"> ' . $separator . ' </li>';
                    }

                    // Display parent pages
                    echo $parents;

                    // Current page
                    echo '<li class="item-current item-' . esc_attr($post->ID) . '"><strong title="' . esc_attr(get_the_title()) . '"> ' . get_the_title() . '</strong></li>';
                } else {

                    // Just display current page if not parents
                    echo '<li class="item-current item-' . esc_attr($post->ID) . '"><strong class="bread-current bread-' . esc_attr($post->ID) . '"> ' . get_the_title() . '</strong></li>';
                }
            } else if (is_tag()) {

                // Tag page
                // Get tag information
                $term_id = get_query_var('tag_id');
                $taxonomy = 'post_tag';
                $args = 'include=' . $term_id;
                $terms = get_terms($taxonomy, $args);
                $get_term_id = $terms[0]->term_id;
                $get_term_slug = $terms[0]->slug;
                $get_term_name = $terms[0]->name;

                // Display the tag name
                echo '<li class="item-current item-tag-' . esc_attr($get_term_id) . ' item-tag-' . esc_attr($get_term_slug) . '"><strong class="bread-current bread-tag-' . esc_attr($get_term_id) . ' bread-tag-' . esc_attr($get_term_slug) . '">' . esc_html($get_term_name) . '</strong></li>';
            } elseif (is_day()) {

                // Day archive
                // Year link
                echo '<li class="item-year item-year-' . esc_attr(get_the_time('Y')) . '"><a class="bread-year bread-year-' . esc_attr(get_the_time('Y')) . '" href="' . esc_url(get_year_link(get_the_time('Y'))) . '" title="' . esc_attr(get_the_time('Y')) . '">' . get_the_time('Y') . ' Archives</a></li>';
                echo '<li class="separator separator-' . esc_attr(get_the_time('Y')) . '"> ' . $separator . ' </li>';

                // Month link
                echo '<li class="item-month item-month-' . esc_attr(get_the_time('m')) . '"><a class="bread-month bread-month-' . esc_attr(get_the_time('m')) . '" href="' . esc_url(get_month_link(get_the_time('Y')), get_the_time('m')) . '" title="' . esc_attr(get_the_time('M')) . '">' . get_the_time('M') . ' Archives</a></li>';
                echo '<li class="separator separator-' . esc_attr(get_the_time('m')) . '"> ' .$separator . ' </li>';

                // Day display
                echo '<li class="item-current item-' . esc_attr(get_the_time('j')) . '"><strong class="bread-current bread-' . esc_attr(get_the_time('j')) . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
            } else if (is_month()) {

                // Month Archive
                // Year link
                echo '<li class="item-year item-year-' . esc_attr(get_the_time('Y')) . '"><a class="bread-year bread-year-' . esc_attr(get_the_time('Y')) . '" href="' . esc_url(get_year_link(get_the_time('Y'))) . '" title="' . esc_attr(get_the_time('Y')) . '">' . get_the_time('Y') . ' Archives</a></li>';
                echo '<li class="separator separator-' . esc_attr(get_the_time('Y')) . '"> ' . $separator . ' </li>';

                // Month display
                echo '<li class="item-month item-month-' . esc_attr(get_the_time('m')) . '"><strong class="bread-month bread-month-' . esc_attr(get_the_time('m')) . '" title="' . esc_attr(get_the_time('M')) . '">' . get_the_time('M') . ' Archives</strong></li>';
            } else if (is_year()) {

                // Display year archive
                echo '<li class="item-current item-current-' . esc_attr(get_the_time('Y')) . '"><strong class="bread-current bread-current-' . esc_attr(get_the_time('Y')) . '" title="' . esc_attr(get_the_time('Y')) . '">' . get_the_time('Y') . ' Archives</strong></li>';
            } else if (is_author()) {

                // Auhor archive
                // Get the author information
                global $author;
                $userdata = get_userdata($author);

                // Display author name
                echo '<li class="item-current item-current-' . esc_attr($userdata->user_nicename) . '"><strong class="bread-current bread-current-' . esc_attr($userdata->user_nicename) . '" title="' . esc_attr($userdata->display_name) . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
            } else if (get_query_var('paged')) {

                // Paginated archives
                echo '<li class="item-current item-current-' . esc_attr(get_query_var('paged')) . '"><strong class="bread-current bread-current-' . esc_attr(get_query_var('paged')) . '" title="Page ' . esc_attr(get_query_var('paged')) . '">' . esc_html__('Page', 'grand-popo') . ' ' . get_query_var('paged') . '</strong></li>';
            } else if (is_search()) {

                // Search results page
                echo '<li class="item-current item-current-' . esc_attr(get_search_query()) . '"><strong class="bread-current bread-current-' . esc_attr(get_search_query()) . '" title="'.esc_html__('Search results for:', 'grand-popo') . esc_attr(get_search_query()) . '">'. esc_html__('Search results for:', 'grand-popo') . get_search_query() . '</strong></li>';
            } elseif (is_404()) {

                // 404 page
                echo '<li>' . esc_html__('Error 404', 'grand-popo') . '</li>';
            }

            echo '</ul>';
        }
    }
}
/**
 * remove woocommerce breadcrumb to woocommerce_before_main_content
 * replace with custom breadcrumb  
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
/**
 * Get custom sale price
 * @param objet $product 
 * @param string $price
 * return sale price html  
 */
function grand_popo_get_custom_sales_price($price, $product) {
    $regular_price = wc_price($product->get_regular_price());
    $sale_price = wc_price($product->get_sale_price());
    $get_price_html = sprintf("<del>") . $regular_price . sprintf("</del><ins>") . $sale_price . sprintf("</ins>");
    return $get_price_html;
}
add_filter('woocommerce_sale_price_html', 'grand_popo_get_custom_sales_price', 10, 2);
/**
 * Get custom variable sale price
 * @param objet $product 
 * @param string $price
 * return variable  price html  
 */
function grand_popo_custom_variable_price($price, $product) {
    // Main Price
    $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));
    $price = $prices[0] !== $prices[1] ? sprintf('%1$s', wc_price($prices[0])) : wc_price($prices[0]);

    // Sale Price
    $prices = array($product->get_variation_regular_price('min', true), $product->get_variation_regular_price('max', true));
    sort($prices);
    $saleprice = $prices[0] !== $prices[1] ? sprintf('%1$s', wc_price($prices[0])) : wc_price($prices[0]);

    if ($price !== $saleprice) {
        $price = '<del>' . $saleprice . '</del><ins>' . $price . '</ins>';
    }

    return $price;
}

add_filter('woocommerce_variable_sale_price_html', 'grand_popo_custom_variable_price', 10, 2);
add_filter('woocommerce_variable_price_html', 'grand_popo_custom_variable_price', 10, 2);
/**
 * Get social network
 * return liste of network set  
 */
function grand_popo_get_social_link() {
    global $grand_popo_options;
    $enable_social = grand_popo_get_proper_value($grand_popo_options, 'opt-social-enable');
    if ($enable_social == "1") {
        ?>

        <div class="social-links-container ">
            <ul class="social-links">
                <?php
                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-facebook') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-facebook')) . '"><i class="fa fa-facebook"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-twitter') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-twitter')) . '"><i class="fa fa-twitter"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-pinterest') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-pinterest')) . '"><i class="fa fa-pinterest"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-instagram') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-instagram')) . '"><i class="fa fa-instagram"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-google-plus') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-google-plus')) . '"><i class="fa fa-google-plus"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-behance') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-behance')) . '"><i class="fa fa-behance"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-dribbble') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-dribbble')) . '"><i class="fa fa-dribbble"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-vimeo') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-vimeo')) . '"><i class="fa fa-vimeo"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-tumblr') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-tumblr')) . '"><i class="fa fa-tumblr"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-linkedIn') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-linkedIn')) . '"><i class="fa fa-linkedin"></i></a></li>' : '';


                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-flickr') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-flickr')) . '"><i class="fa fa-flickr"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-youtube') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-youtube')) . '"><i class="fa fa-youtube"></i></a></li>' : '';

                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-foursquare') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-foursquare')) . '"><i class="fa fa-foursquare"></i></a></li>' : '';


                echo (grand_popo_get_proper_value($grand_popo_options, 'opt-social-github') != '') ? '<li><a href="' . esc_url(grand_popo_get_proper_value($grand_popo_options, 'opt-social-github')) . '"><i class="fa fa-github"></i></a></li>' : '';
                ?>

            </ul>
        </div>

        <?php
    }
}
/**
 * Get Recommanded plugins notice
 * return liste of Recommanded plugins 
 */

function grand_popo_register_required_plugins() {

    $plugins = array(
        array(
            'name' => esc_html__('Redux Framework', 'grand-popo'), // The plugin name.
            'slug' => 'redux-framework', // The plugin slug (typically the folder name).
            'required' => false, // If false, the plugin is only 'recommended' instead of required.
        ),
        array(
            'name' => esc_html__('Grand-Popo Core', 'grand-popo'), // The plugin name.
            'slug' => 'grand-popo-core', // The plugin slug (typically the folder name).
            'required' => false, // If false, the plugin is only 'recommended' instead of required.
        ),    
        array(
            'name' => esc_html__('WooCommerce', 'grand-popo'), // The plugin name.
            'slug' => 'woocommerce', // The plugin slug (typically the folder name).
            'required' => false, // If false, the plugin is only 'recommended' instead of required.
        ),        
        
    );

    $config = array(
        'id' => 'grand-popo', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message' => '', // Message to output right before the plugins table.
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'grand_popo_register_required_plugins');

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
function grand_popo_vcSetAsTheme() {
    vc_set_as_theme();
}
add_action( 'vc_before_init', 'grand_popo_vcSetAsTheme' );

//REMOVE SUBCATEGORIES COUNT
function grand_popo_remove_category_products_count() {
    return;
}
add_filter('woocommerce_subcategory_count_html', 'grand_popo_remove_category_products_count');
/**
 * Get Footer sidebar
 * Display widget set in footer-sidebar on footer 
 */
function grand_popo_custom_widgets_init() {

    global $grand_popo_options;

    $number = grand_popo_get_proper_value($grand_popo_options, 'footer-sidebar-column', 4);
    $search_number = grand_popo_get_proper_value($grand_popo_options, 'search-sidebar-column', 4);

    if ($number == 1) {
        $args = array(
            'name' => esc_html__('footer column 1', 'grand-popo'),
            'id' => 'footer-sidebar',
            'description' => 'One of the footer sidebar column',
            'class' => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>');
    } else {
        $args = array(
            'name' => esc_html__('footer column %d', 'grand-popo'),
            'id' => 'footer-sidebar',
            'description' => 'One of the footer sidebar column',
            'class' => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>');
    }

    register_sidebars($number, $args);
}

add_action('widgets_init', 'grand_popo_custom_widgets_init');
/**
 * WOOCOMERCE LOOP WRAPPER
 * Wrapper start  
 *Wrapper close
 */
function woocommerce_product_loop_start() {

    echo"<div class='products o-wrap '>";
}
function woocommerce_product_loop_end() {
    echo "</div>";
}
//CUSTOM WOOCOMMERCE BREADCRUMBS
function grand_popo_get_grand_popo_breadcrumbss() {
    return array(
        'delimiter' => '&nbsp;&nbsp;>&nbsp;&nbsp;',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
        'wrap_after' => '</nav>',
        'before' => '',
        'after' => '',
        'home' => _x('Home', 'breadcrumb', 'grand-popo'),
    );
}
add_filter('grand_popo_breadcrumbs_defaults', 'grand_popo_get_grand_popo_breadcrumbss');

/**
 * replace the default add_to_cart_link
 * @global type $product
 * @param type $add_to_cart_link
 * @return type
 */
function grand_popo_add_to_cart_link($add_to_cart_link) {
    global $product, $product_id, $product_type, $link_classes;
    $product_type = $product->get_type();
    $product_id = $product->get_id();
    $product_link = get_the_permalink($product_id);

    ob_start();
    ?>
    <div class="archive-product-buttons">
        <?php if (function_exists('yith_wishlist_install')): ?>
            <a href="<?php echo esc_url(add_query_arg('add_to_wishlist', $product_id)) ?>" data-placement="left" data-original-title="<?php esc_html_e("whishlist", 'grand-popo') ?>"  rel="nofollow" data-product-id="<?php echo esc_attr($product_id) ?>" data-product-type="<?php echo esc_attr($product_type) ?>" class="add_to_wishlist yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($product_id) ?>" >
                <i class="fa fa-heart"></i>
            </a>
            <?php
        endif;
        ?>
        <a href="?action=yith-woocompare-add-product&amp;id=<?php echo esc_attr($product_id); ?>" data-placement="left" data-original-title="<?php esc_html_e("Compare", 'grand-popo') ?>"  class="compare button" data-product_id="<?php echo esc_attr($product_id); ?>" rel="nofollow"><i class="fa fa-pie-chart" ></i></a>
        <?php
        if ($product_type == "variable") {
            ?>
            <a href="<?php echo esc_attr($product_link); ?>" class="" rel="nofollow" data-placement="left" data-original-title="<?php esc_html_e("Options", 'grand-popo') ?>" ><i class="fa fa-sliders"></i></a>

            <?php
        } else {
            ?>
            <a href="?add-to-cart=<?php echo esc_attr($product_id); ?>" class="" rel="nofollow" data-placement="left" data-original-title="<?php esc_html_e("cart", 'grand-popo') ?>" ><i class="fa fa-shopping-cart"></i></a> 
            <?php
        }
        ?>


    </div>

    <?php
    $add_to_cart_link = ob_get_clean();
    echo $add_to_cart_link;
}
//Remove woocommerce template loop add to cart
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
//Move woocommerce template loop add to cart
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 25);
//custom woocommerce template loop product title
function grand_popo_woocommerce_template_loop_product_title() {
    echo '<a class="grand_popo-product-title" href="' . esc_url(get_the_permalink()) . '"><h3>' . get_the_title() . '</h3></a>';
}
add_action('woocommerce_shop_loop_item_title', 'grand_popo_woocommerce_template_loop_product_title', 10);
//Remove woocommerce template loop product title
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

//CUSTOM FILTER PRICE WIDGET 
function grand_popo_custom_woocommerce_filter_widgets() {
    // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
    if (class_exists('WC_Widget_Price_Filter')) {
        unregister_widget('WC_Widget_Price_Filter');

        require_once( get_template_directory() . '/woocommerce/widgets/grand_popo-widget-price-filter.php');

        register_widget('Grand_Popo_Widget_Price_Filter');
    }
}
add_action('widgets_init', 'grand_popo_custom_woocommerce_filter_widgets');
/**
 *Get custom chekout field
 * @param type $field
 * @return type $field
 */
function grand_popo_override_checkout_fields($fields) {
    $fields['billing']['billing_company']['placeholder'] = esc_html__('Company','grand-popo');
    $fields['billing']['billing_first_name']['placeholder'] = esc_html__('First name','grand-popo');
    $fields['billing']['billing_last_name']['placeholder'] = esc_html__('Last name','grand-popo');
    $fields['billing']['billing_email']['placeholder'] = esc_html__('Email','grand-popo');
    $fields['billing']['billing_phone']['placeholder'] = esc_html__('Phone','grand-popo');
    $fields['billing']['billing_address_1']['placeholder'] = esc_html__('Address','grand-popo');
    $fields['billing']['billing_city']['placeholder'] = esc_html__('City / Town','grand-popo');
    $fields['billing']['billing_state']['placeholder'] = esc_html__('State / Country','grand-popo');
    $fields['billing']['billing_postcode']['placeholder'] = esc_html__('Post Code','grand-popo');
    $fields['order']['order_comments']['placeholder'] = esc_html__('Your comment','grand-popo');

    unset($fields['billing']['billing_company']['label']);
    unset($fields['billing']['billing_first_name']['label']);
    unset($fields['billing']['billing_last_name']['label']);
    unset($fields['billing']['billing_email']['label']);
    unset($fields['billing']['billing_phone']['label']);
    unset($fields['billing']['billing_country']['label']);
    unset($fields['billing']['billing_address_1']['label']);
    unset($fields['billing']['billing_city']['label']);
    unset($fields['billing']['billing_state']['label']);
    unset($fields['billing']['billing_postcode']['label']);
    unset($fields['order']['order_comments']['label']);


    return $fields;
}
add_filter('woocommerce_checkout_fields', 'grand_popo_override_checkout_fields');

//REMOVE SALE ON SINGLE PRODUCT BEFORE
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

/**
 *Get custom chekout field
 * @param array $matches
 * @return raw url 
 */
function grand_popo_get_post_format_raw_url() {
    if (!preg_match("/(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?/im", get_the_content(), $matches)) {
        return false;
    }
    return esc_url_raw($matches[0]);
}
/**
 * Get poste thumbnail
 * @return type $post_thumbnail 
 */
function grand_popo_get_post_thumb() {

    $post_id = get_the_ID();
    $post_format = get_post_format();
    $meta = get_post_meta($post_id, "grand-popo", true);

    $post_thumb = "";
    switch ($post_format) {

        case 'quote':
            global $post;
            $regexp = "<blockquote>(.*)<\/blockquote>";
            $input = get_the_content();
            if (preg_match_all("/$regexp/siU", $input, $matches)) {
                $post_thumb = $matches[0][0];
            }
            break;

        case 'link':
            global $post;
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
            $input = get_the_content();
            if (preg_match_all("/$regexp/siU", $input, $matches)) {
                $post_thumb = "<div class='post-thumb'>" . $matches[0][0] . "</div>";
            }
            break;

        case 'video':
        case 'audio':
            global $post;
            global $wp_embed;
            $pattern = get_shortcode_regex(array("embed", "audio", "wpvideo"));
            $matches = array();
            preg_match("/$pattern/s", get_the_content(), $matches);
            if (!empty($matches)) {
                $post_thumb = do_shortcode($matches[0]);
            } else {
                $post_thumb_url = grand_popo_get_post_format_raw_url();
                if ($post_thumb_url) {
                    $post_thumb = wp_oembed_get($post_thumb_url);
                }
            }
            break;

        case 'image':
            $url = grand_popo_grab_first_image();
            if ($url)
                $post_thumb = '<img src="' . esc_attr($url) . '" alt="' . esc_attr__('Post thumbnail', 'grand-popo') . '" >';
        case 'gallery':
            global $post;
            $pattern = get_shortcode_regex(array("gallery"));
            $matches = array();
            preg_match("/$pattern/s", get_the_content(), $matches);
            if (!empty($matches)) {
                $post_thumb = do_shortcode($matches[0]);
            } else {
                
            }

            break;

        default:
            global $post;
            $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
            if ($url)
                $post_thumb = '<img src="' . esc_attr($url) . '" alt="' . esc_attr__('Post thumbnail', 'grand-popo') . '" >';

            break;
    }

    return $post_thumb;
}
/**
 * Get first attached image 
 * @global $post
 * @return type $first_img 
 */
function grand_popo_grab_first_image() {
    global $post;
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];

    if (empty($first_img)) { //return false
        $first_img = false;
    }
    return $first_img;
}
/**
 * Get custom post excerpt more 
 * @param $more
 * @return custom $more 
 */
function grand_popo_sbt_auto_excerpt_more($more) {
    return '.';
}
add_filter('excerpt_more', 'grand_popo_sbt_auto_excerpt_more', 20);

// Grand-Popo get single post navigation
function grand_popo_get_single_post_nav() {
    if (is_singular()) {
        ?>
        <nav class="single-product-nav">
            <span class="nav-previous nav-alignleft"><?php previous_post_link('%link', '<i class="fa fa-chevron-left"></i> PREV', FALSE); ?></span>
            <span class="nav-next nav-alignright"><?php next_post_link('%link', ' | NEXT <i class="fa fa-chevron-right"></i>', FALSE); ?></span>
        </nav>
        <?php
    }
}

// Get Post Author
function grand_popo_get_post_comment_author() {
    
    $author_description = get_the_author_meta('description');
    if(empty($author_description))
        return;
    ?>
    <div class="single-section">
        
        <div class="single-section-title">
            <?php echo esc_html__('About The Author', 'grand-popo') ;?>
        </div>
        <div class="article-author">
            <?php
            $author_id = get_the_author_meta('ID');
            $author_thumbnail = get_avatar($author_id, '110');
            $author_name = get_the_author_link($author_id);

            echo wp_kses_post($author_thumbnail);

            echo '<div class="author-info"><h3 class="author-name">'
            . $author_name . '</h3>' . $author_description . ' </div>';
            ?>
        </div>
    </div>
    <?php
}

/**
 * Get comment layout
 * @global $comment
 * @param array $args
 * @param type $depth 
 */
function grand_popo_comments($comment, $args, $depth) {
    ?>
    <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
        <article  class="cf">
            <?php
            // create variable
            $bgauthemail = get_comment_author_email();
            $author_thumbnail = get_avatar($bgauthemail, '70');
            echo $author_thumbnail;
            ?>
            <div>
                <header class="comment-author vcard">
                    <?php
                    /*
                      this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
                      echo get_avatar($comment,$size='32',$default='<path_to_url>' );
                     */
                    ?>

                    <?php // end custom gravatar call   ?>
                    <?php printf('<cite class="fn">%1$s</cite>', get_comment_author_link()) ?>

                    <time datetime="<?php echo esc_attr(comment_time('Y-m-j')); ?>"><a href="<?php echo esc_attr(htmlspecialchars(get_comment_link($comment->comment_ID))) ?>"><?php comment_time(esc_html__('jS F , Y', 'grand-popo')); ?> / </a></time> 
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                    <?php printf('%2$s', get_comment_author_link(), edit_comment_link(esc_html__('(Edit)', 'grand-popo'), '  ', '')) ?>
                </header>
                <?php if ($comment->comment_approved == '0') : ?>
                    <div class="alert alert-info">
                        <p><?php esc_html_e('Your comment is awaiting moderation.', 'grand-popo') ?></p>
                    </div>
                <?php endif; ?>
                <section class="comment_content cf">
                    <?php comment_text() ?>
                </section>
            </div>

        </article>
        <?php
    }
/**
 * Move comment field to bottom
 * @param type $fields
 * @return  $fields
 */
function grand_popo_move_comment_field_to_bottom($fields) {
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter('comment_form_fields', 'grand_popo_move_comment_field_to_bottom');
/**
 * Get gallery attachment ids
 * @global $post
 * @return  $attachment_id
 */
function grand_popo_theme_core_get_gallery_attachments_ids() {
    global $post;

    $post_content = $post->post_content;
    preg_match('/\[gallery.*ids=.(.*).\]/', $post_content, $ids);
    if(!empty($ids))
        $images_id = explode(",", $ids[1]);
    else 
        $images_id ="";

    return $images_id;
}
//Custom grand-popo product on sale badge html
function grand_popo_sale_html() {
    ?>
    <span class="onsale"><?php esc_html_e('Sale', 'grand-popo'); ?> </span>
    <?php
}
add_filter('woocommerce_sale_flash', 'grand_popo_sale_html');
//Get Grand-popo custom page navigation
function grand_popo_theme_core_page_navi() {
    global $wp_query;
    $bignum = 999999999;
    if ($wp_query->max_num_pages <= 1)
        return;
    echo '<nav class="pagination grand_popo-pagination"><div class="site-wrap">';
    echo paginate_links(array(
        'base' => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
        'format' => '',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<i class="fa fa-chevron-left"></i>' . esc_html__("PREVIOUS", "grand-popo"),
        'next_text' => esc_html__("NEXT", "grand-popo") . ' <i class="fa fa-chevron-right"></i>',
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
    ));
    echo '</div></nav>';
}
add_filter('wp_nav_menu_items', 'grand_popo_add_logout_link', 10, 2);
/**
 * Add a logout link
 * @param type $items
 * @param type $args
 * @return  $item
 */
function grand_popo_add_logout_link($items, $args) {
    if ($args->theme_location == 'top-header-menu-right') {
        if (is_user_logged_in()) {
            $items .= '<li class="fa fa-unlock"><a href="' . esc_url(wp_logout_url()) . '">' . esc_html__("Log Out", "grand-popo") . '</a></li>';
        } else {
            $items .= '<li class="fa fa-lock"><a href="' . esc_url(wp_login_url()) . '">' . esc_html__("Log In", "grand-popo") . '</a></li>';
        }
    }
    return $items;
}
/**
 * Get header on sticky mode
 * @global  $grand_popo_options
 * @return  $sticky_class
 */
function grand_popo_header_sticky() {
    global $grand_popo_options;
    $sticky = grand_popo_get_proper_value($grand_popo_options, 'opt-enable-header-sticky', '1');

    if ($sticky == "1")
        $sticky_class = "sticky";
    else
        $sticky_class = "";

    echo $sticky_class;
}

/**
 * Get scroll to top button
 * @global  $grand_popo_options
 * @return  $scroll_to_top_class
 */
function grand_popo_get_scroll_to_top() {
    global $grand_popo_options;
    $scroll_to_top = grand_popo_get_proper_value($grand_popo_options, 'opt-scroll-top', '0');

    if ($scroll_to_top == "1")
        $scroll_to_top_class = "grand_popo-scroll-to-top";
    else
        $scroll_to_top_class = "";

    echo $scroll_to_top_class;
}

//Add custom css with theme option
function grand_popo_add_editor_styles() {
    add_editor_style(get_template_directory_uri() . '/assets/stylesheets/editor-style.css');
}
add_action('admin_init', 'grand_popo_add_editor_styles');

//Removes redux notices
function grand_popo_remove_redux_notices() {
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2);
    }
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
    }
}

add_action('init', 'grand_popo_remove_redux_notices');
//Get shop tools, display on top of product archive pages to filter product   
function grand_popo_get_shop_tools($shop_layout) {
        ?>
        <div class="wc-bf-loop-wrap">
            <?php
            if ($shop_layout == "left-sidebar"){
                ?>
            <div>
                <span class="masthead-icon" id="top-menu-icon"><i class="fa fa-filter"></i><?php echo esc_html__('Filter', 'grand-popo') ;?></span>
                <?php echo grand_popo_get_result_count(); ?>
            </div>
                <?php
            }
                
            ?>
            <?php
            if ($shop_layout != "right-sidebar" && $shop_layout != "left-sidebar" ){
                echo grand_popo_get_result_count();
            }
            ?>
            <?php
            if ($shop_layout == "right-sidebar"){
                ?>
            <div>
                <?php echo grand_popo_get_result_count(); ?>
                <span class="masthead-icon" id="top-menu-icon"><?php echo esc_html__('Filter', 'grand-popo') ;?><i class="fa fa-filter"></i></span>
            </div>
                <?php
            }
            
            ?>
            <div>
                <?php
                /**
                 * woocommerce_before_shop_loop hook.
                 *
                 * @hooked woocommerce_result_count - 20
                 * @hooked woocommerce_catalog_ordering - 30
                 */
                do_action('woocommerce_before_shop_loop');
                ?>
            </div>
            
            

        </div>
        <?php
    }
remove_action("woocommerce_before_shop_loop","woocommerce_result_count",20);
/**
 * Custom Get product result count
 * @global  $wp_query
 * @return  $result_html
 */
function grand_popo_get_result_count() {
        global $wp_query;

        if (!woocommerce_products_will_display())
            return;
        ?>
        <p class="woocommerce-result-count">
        <?php
            $per_page = $wp_query->get( 'posts_per_page' );
            $total    = $wp_query->found_posts;
            if($total==1){
                printf( _x('Showing the single result', 'single result', 'grand-popo'));
            }
            elseif ($total <= $per_page || -1 === $per_page) {
                /* translators: %d: total results */
		printf( _n( 'Showing %1$s result', 'All %d results', $total, 'grand-popo' ), $total );
            } else {
                /* translators: 1: number of results */
                printf(
						
                            _nx(
                                    '%1$s result found',
                                    '%1$s results found',
                                    $total,
                                    'Number of results found', 
                                    'grand-popo'
                            ),
                            number_format_i18n( $total )
                        );
            }
        ?>
        </p>
        <?php
    }
// Get number per page filter on product archive page
function grand_popo_get_number_per_page_filter() {
        $sizes = array(10, 30, 60, 90, 180);
        $min_size = min($sizes);
        $selected = "";
        if ( isset($_REQUEST['number-per-page_nonce'] ) &&  wp_verify_nonce($_REQUEST['number-per-page_nonce'], 'number-per-page_nonce' ) ){
            if (isset($_GET["page-size"]))
                $selected = $_GET["page-size"];
        }
        ?>
        <form class="page-size-container" method="GET">
            <select class="select autosubmit select-custom" name="page-size" >
                <?php
                foreach ($sizes as $size) {                           
                    ?><option value="<?php echo esc_attr($size); ?>" <?php selected($selected, $size, true); ?>><?php echo esc_attr($size) . " " . esc_html__('per page', 'grand-popo'); ?></option><?php
                }
                ?>
            </select>   
            <input type="hidden" name="number-per-page_nonce" value="<?php echo wp_create_nonce( 'number-per-page_nonce' ); ?>" />
        </form>
        <?php
    }
add_action('woocommerce_before_shop_loop', 'grand_popo_get_number_per_page_filter', 20);
/**
 * Get product archives page size
 * @param  $cols
 * @return  $cols
 */
function grand_popo_get_shop_page_size($cols) {
    if (isset($_GET["page-size"]))
        return $_GET["page-size"];

    return $cols;
}
add_filter('loop_shop_per_page', 'grand_popo_get_shop_page_size');

/**
 * Get related products args
 * @param  $args
 * @global  $grand_popo_options
 * @return  $args
 */
function grand_popo_related_products_args($args) {
    global $grand_popo_options;
    $number = grand_popo_get_proper_value($grand_popo_options, 'opt-number-per-page', '4');

    $args['posts_per_page'] = $number; // 4 related products
    return $args;
}

add_filter('woocommerce_output_related_products_args', 'grand_popo_related_products_args');
//Remove redux framework admin notices action
function grand_popo_remove_redux_framework_admin_notices_action() {
    grand_popo_remove_anonymous_object_filter(
            'admin_notices', 'ReduxFramework', '_admin_notices'
    );
}
add_action('admin_init', 'grand_popo_remove_redux_framework_admin_notices_action');

if (!function_exists('grand_popo_remove_anonymous_object_filter')) {

        /**
         * Remove an anonymous object filter.
         *
         * @param  string $tag    Hook name.
         * @param  string $class  Class name
         * @param  string $method Method name
         * @return void
         */
        function grand_popo_remove_anonymous_object_filter($tag, $class, $method) {
            $filters = $GLOBALS['wp_filter'][$tag];

            if (empty($filters)) {
                return;
            }

            foreach ($filters as $priority => $filter) {
                foreach ($filter as $identifier => $function) {
                    if (is_array($function)
                            and is_a($function['function'][0], $class)
                            and $method === $function['function'][1]) {

                        remove_filter(
                                $tag, array($function['function'][0], $method), $priority
                        );
                    }
                }
            }
        }

    }
/**
 * Get product cat icon field
 * @param  $term
 * @return  $icon field
 */
function grand_popo_get_icon_fields($term = false) {
        $icon_url = "";
        $img_placeholder = get_template_directory_uri() . '/assets/images/placeholder.png';
        $img_src = $img_placeholder;
        if ($term) {
            $icon_url = get_term_meta($term->term_id, "prod_cat_icon", true);
            $img_src = $icon_url;
            if (empty($icon_url))
                $img_src = $img_placeholder;
        }
        ?>
        <label for="prod_cat_icon"><?php esc_html_e('Icon', 'grand-popo'); ?></label>
        <input type="hidden" name="prod_cat_icon" id="prod_cat_icon" class="cat-icon" value="<?php echo esc_url($icon_url); ?>">
        <div class="img-wrap">
            <img src="<?php echo esc_url($img_src); ?>" id="prod-cat-image" data-src="<?php echo esc_url($img_placeholder); ?>">
        </div>
        <input class="button" name="grand_popo-add-product-cat-icon" id="grand_popo-add-product-cat-icon" type="button" value="<?php echo esc_attr("Upload/Add Icon", 'grand-popo'); ?>" />
        <input class="grand_popo_remove_file button" name="grand_popo_remove_file"  type="button" value="<?php echo esc_attr('Remove Icon', 'grand-popo'); ?>" />
        <input type="hidden" name="gp-product-cat_nonce" value="<?php echo wp_create_nonce( 'gp-product-cat_nonce' ); ?>" />
        <?php
    }

// Add Upload fields to "Add New Product Category" form
function grand_popo_add_product_cat_icon_field() {
    // this will add the custom meta field to the add new term page
    ?>
    <div class="form-field">

        <?php grand_popo_get_icon_fields(); ?>

    </div>
    <?php
}
add_action('product_cat_add_form_fields', 'grand_popo_add_product_cat_icon_field', 10, 2);
//Add Upload fields to "Update Product Category" form
function grand_popo_prod_cat_edit_meta_field($term) {
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="_prod_cat_icon"><?php esc_html_e('Icon', 'grand-popo'); ?></label></th>
        <td>
            <?php grand_popo_get_icon_fields($term); ?>
        </td>
    </tr>
    <?php
}
add_action('product_cat_edit_form_fields', 'grand_popo_prod_cat_edit_meta_field', 10, 2);

// Save Taxonomy Icon fields callback function.
function grand_popo_save_icon_custom_meta($term_id) {
    if ( isset($_REQUEST['gp-product-cat_nonce'] ) &&  wp_verify_nonce($_REQUEST['gp-product-cat_nonce'], 'gp-product-cat_nonce' ) ) {
        $_POST= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $meta_key = "prod_cat_icon";
        if(isset($_POST[$meta_key]) && !empty($_POST[$meta_key])) {
            $esc_gp_prod_cat_icon = sanitize_text_field(esc_html($_POST[$meta_key]));
            update_term_meta($term_id, $meta_key, $esc_gp_prod_cat_icon);
        }
    }
}

add_action('edited_product_cat', 'grand_popo_save_icon_custom_meta', 10, 2);
add_action('create_product_cat', 'grand_popo_save_icon_custom_meta', 10, 2);

// Single product advantage sidebar
function grand_popo_get_product_advantage_sidebar() {
    if (is_active_sidebar('product-avantage-sidebar')) {
        ?>
        <div class="product-avantage-sidebar">
            <div class="o-wrap">
                <div id="product-avantage-sidebar" class="sidebar col xl-1-1 lg-1-1 md-1-1 sm-1-1 " role="complementary">
                    <?php dynamic_sidebar('product-avantage-sidebar'); ?>
                </div>    

            </div>
        </div>
        <?php
    }
}

add_action("woocommerce_single_product_summary", "grand_popo_get_product_advantage_sidebar", 60);

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 * @param  type $fragments
 * @return  $fragments
 */
function grand_popo_woocommerce_header_add_to_cart_fragment($fragments) {
    ob_start();
    ?>
    <a class="cart-contents cart-top-icon"  title="<?php esc_attr_e('View your shopping cart', 'grand-popo'); ?>">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </a>

    <?php
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'grand_popo_woocommerce_header_add_to_cart_fragment');
//Get Product cat description on the top of product cat page
function grand_popo_excerpt_in_product_archives() {
    ?>
    <div class="grand_popo-prod-description">   
    <?php
        the_excerpt();
     ?>
    </div> 
    <?php
}
add_action( 'woocommerce_after_shop_loop_item_title', 'grand_popo_excerpt_in_product_archives', 5 );
//Get product info wrapper start
function grand_popo_get_prod_info_start(){
    ?>
        <div>
    <?php
}
add_action( 'woocommerce_shop_loop_item_title', 'grand_popo_get_prod_info_start', 5 );
//Get product info wrapper end
function grand_popo_get_prod_info_end(){
    ?>
        </div>
    <?php
}
add_action( 'woocommerce_after_shop_loop_item_title', 'grand_popo_get_prod_info_end', 6 );
add_action( 'woocommerce_after_shop_loop_item_title', 'grand_popo_get_prod_info_start', 8 );
/**
 * Get product stock
 * @global $product
 * @return  $in_stock_html
 */
function grand_popo_get_product_stock(){
    global $product;
    ?>
    <div class="grand_popo-prod-stock">
    <?php
    
    if ( $product->is_in_stock() ) {
        echo '<div class="stock" >' . $product->get_stock_quantity() . esc_html__('in stock', 'grand-popo' ) . '</div>';
    } else {
        echo '<div class="out-of-stock" >' . esc_html__('out of stock', 'grand-popo' ) . '</div>';
    }
    ?>
    </div>
    <?php
}
add_action( 'woocommerce_after_shop_loop_item_title', 'grand_popo_get_product_stock', 9 );
add_action('woocommerce_after_shop_loop_item_title', 'grand_popo_get_prod_info_end', 25);

 /*
  * RENAME REVIEWS TABS
 *  @param  type $tabs
 *  @return  $tabs
 */
function grand_popo_rename_reviews_tabs($tabs) {
    if(isset($tabs['additional_information'])){
        $tabs['additional_information']['title'] = __('All Specifications', 'grand-popo');    // Rename the reviews tab
    }
    
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'grand_popo_rename_reviews_tabs', 98);
// Custom product additional information heading
function grand_popo_change_all_specifications_heading() {
    echo "<h2>". esc_html__('Detailed specifications','grand-popo') . "</h2>" ;   
}
add_filter('woocommerce_product_additional_information_heading', 'grand_popo_change_all_specifications_heading');
/*
  * Get compare button
 *  @global  $product
 *  @return  $compare_link
 */
function grand_popo_get_compare_btn(){
    global $product;
    if(class_exists( 'YITH_Woocompare' ) ) {
        ?>
        <a href="?action=yith-woocompare-add-product&amp;id=<?php echo esc_attr($product->get_id()); ?>" data-placement="top" data-original-title="<?php esc_html_e("Compare", 'grand-popo') ?>"  class="compare button grand_popo-compare" data-product_id="<?php echo esc_attr($product->get_id()); ?>" rel="nofollow"><i class="fa fa-pie-chart" ></i></a>

        <?php
    }
}
add_action("woocommerce_single_product_summary","grand_popo_get_compare_btn",30);
//Custom single add to cart text
function grand_popo_single_add_to_cart_text(){
    $product_id= get_the_ID();

    $product = wc_get_product($product_id);
    if ($product->get_type() == "variation") 
        $product_parent_id=wp_get_post_parent_id( $product_id);
    else
        $product_parent_id=$product_id;

    $products_metas =get_post_meta($product_parent_id,'shipping-date-start',true);
    if(isset($products_metas[$product_id]) && !empty($products_metas[$product_id]) && $products_metas[$product_id]>date('Y-m-d')){
        echo esc_html__( 'Pre order', 'grand-popo' );
    }
    elseif($product->get_type() == "external"){

    }else{
        echo esc_html__( 'Add to cart', 'grand-popo' );
    }
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'grand_popo_single_add_to_cart_text' );
//remove woocommerce template loop product link close
remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
/*
  * Get texte of external product button
 *  @param  type $product
 *  @param string $button_text
 *  @return  $button_text
 */
function grand_popo_wc_external_product_button( $button_text, $product ) {
    if ( 'external' === $product->get_type() ) {
        // enter the default text for external products
        return $product->button_text ? $product->button_text : esc_html__('Buy at Amazon','grand-popo');
    }

    return $button_text;
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'grand_popo_wc_external_product_button', 10, 2 );
// Get Grand-popo Pro features messages
function grand_popo_get_pro_features_messages()
   {
       $messages=array(
           "Improved Speed"=> esc_html__('Do you feel the theme is a bit slow? Upgrade to make it faster.','grand-popo'),
           "Pre-Orders"=> esc_html__('Sell new products, not on the market yet in exclusivity and enable your customers to be the first to receive the product as soon as it drops.','grand-popo'),
           "Products Pack Recommendation"=> esc_html__('Recommend accessories and packs related to a product directly on its page.','grand-popo'),
           "Product Comparison"=> esc_html__('Do you feel the theme is a bit slow? Upgrade to make it faster.','grand-popo'),
           "Grouped Attributes"=> esc_html__('Create and assign a set of product attributes to any product, no more wasting of time to write them one by one.','grand-popo'),
           "Brands Module"=> esc_html__('Allows you to manage multiple brands in your shop and help your customers browse your platform by brands.','grand-popo'),
           "+600 Google fonts"=> esc_html__('Grand-Popo is offering you a large variety of typefaces, to enable you create the typography that best suits your online shop.','grand-popo'),
           "Highly customizable"=> esc_html__('Personalize the look and feel of your website with colors, icons, font and logo.','grand-popo'),
           "Flexible shop layout"=> esc_html__('The theme offers an unlimited option such as customizable sidebars, pagination options, filter options, shop layout styles and more.','grand-popo'),
           "Authentic customer support"=> esc_html__('No matter the technical problems you face, our developers are ever-ready to give you a helping hand.','grand-popo'),
           "Simple Installation & Setup"=> esc_html__('Includes a user manual that would help you build pages easily and without stress.','grand-popo'),
           "Onclick demo"=> esc_html__('Includes a many demo of home page that would help you build pages easily and without stress.','grand-popo'),
       );
       return $messages;
   }