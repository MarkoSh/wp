<?php

/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */
if (!class_exists('Redux')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "grand_popo_options";
//    $domain="grand-popo";

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name' => $opt_name,
    'disable_tracking' => true,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version' => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type' => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true,
    // Show the sections below the admin menu item or not
    'menu_title' => esc_html__('Grand-Popo Options', 'grand-popo'),
    'page_title' => esc_html__('Grand-Popo Options', 'grand-popo'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key' => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography' => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar' => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority' => 50,
    // Choose an priority for the admin bar menu
    'global_variable' => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode' => false,
    // Show the time the page took to load, etc
    'update_notice' => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    // OPTIONAL -> Give you extra features
    'page_priority' => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon' => get_template_directory_uri()."/assets/images/m-icon.png",
    // Specify a custom URL to an icon
    'last_tab' => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon' => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug' => '_options',
    // Page slug used to denote the panel
    'save_defaults' => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show' => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark' => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => true,
    // Shows the Import/Export panel when not used as a field.
    // CAREFUL -> These options are for advanced use only
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'output' => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn' => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
    //'compiler'             => true,
    // HINTS
    'hints' => array(
        'icon' => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'light',
            'shadow' => true,
            'rounded' => false,
            'style' => '',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'mouseover',
            ),
            'hide' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'click mouseleave',
            ),
        ),
    )
);


$args['admin_bar_links'][] = array(
    'id' => 'grand_popo-support',
    'href' => 'https://help.orionorigin.com',
    'title' => esc_html__('Support', 'grand-popo'),
);

$args['share_icons'][] = array(
    'url' => 'https://www.facebook.com/OrionOrigin',
    'title' => 'Like us on Facebook',
    'icon' => 'el el-facebook'
);
$args['share_icons'][] = array(
    'url' => 'http://twitter.com/OrionOrigin',
    'title' => 'Follow us on Twitter',
    'icon' => 'el el-twitter'
);

Redux::setArgs($opt_name, $args);

/*
 * ---> END ARGUMENTS
 */


/*
 *
 * ---> START SECTIONS
 *
 */


Redux::setSection($opt_name, array(
    'title' => __('General', 'grand-popo'),
    'id' => 'opt-grand_popo-general',
    'desc' => __('Set general options here', 'grand-popo'),
    'icon' => 'el el-home',
    'fields' => array(
        array(
            'id' => 'display-tagline',
            'type' => 'switch',
            'default' => '0', // 1 = on | 0 = off
            'title' => esc_html__('Tagline', 'grand-popo'),
            'desc' => esc_html__('Enables/Disables the tagline display below the logo.', 'grand-popo')
        ),
        array(
            'id' => 'opt-scroll-top',
            'type' => 'switch',
            'title' => esc_html__('Scroll to top', 'grand-popo'),
            'default' => '0',
            'desc' => esc_html__('Enables/Disables the scroll to the top button.', 'grand-popo'),
        ),
        array(
            'id' => 'opt-display-breadcrumb',
            'type' => 'switch',
            'title' => esc_html__('Display Breadcrumb', 'grand-popo'),
            'default' => '1',
            'desc' => esc_html__('Enables/Disables the breadcrumb to the page.', 'grand-popo'),
        ),
        array(
            'id' => 'opt-display-page-header',
            'type' => 'switch',
            'title' => esc_html__('Other Page Header', 'grand-popo'),
            'default' => '1',
            'desc' => esc_html__('Enables/Disables page title area.', 'grand-popo'),
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Logo', 'grand-popo'),
    'desc' => __('Set your logo here', 'grand-popo'),
    'id' => 'logo-section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'upload-logo-image',
            'type' => 'media',
            'title' => __('Logo URL', 'grand-popo'),
            'url' => true,
            'compiler' => 'true',
            'default' => "",
            'desc' => esc_html__('Website Logo URL.', 'grand-popo'),
        ),
        array(
            'id' => 'logo-width',
            'type' => 'text',
            'title' => __('Max Width (px)', 'grand-popo'),
            'default' => "100",
            'validate' => 'numeric',
            'desc' => esc_html__('Maximum display width for the logo.', 'grand-popo'),
        ),
        array(
            'id' => 'logo-height',
            'type' => 'text',
            'title' => __('Max Height (px)', 'grand-popo'),
            'default' => "",
            'validate' => 'numeric',
            'desc' => esc_html__('Maximum display height for the logo.', 'grand-popo'),
        ),
        array(
            'id' => 'logo-typography',
            'type' => 'typography',
            'google' => true,
            'output' => array('.site-title a'),
            'title' => __('Typography', 'grand-popo'),
            'text-align' => false,
            'required' => array('upload-logo-image', 'equals', ''),
            'line-height' => false,
            'desc' => esc_html__('Typography to use for the text logo when the image logo URL is not set.', 'grand-popo'),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('Header', 'grand-popo'),
    'id' => 'opt-header',
    'desc' => esc_html__('Set header options here', 'grand-popo'),
    'icon' => 'fa fa-header',
    'fields' => array(
        array(
            'id' => 'opt-header-background',
            'type' => 'background',
            'title' => __('Header background', 'grand-popo'),
            'output' => array('header.site-header,.mobile-nav-container'),
            'default' => "",
        ),
        array(
            'id' => 'opt-enable-header-sticky',
            'type' => 'switch',
            'title' => esc_html__('Sticky Header', 'grand-popo'),
            'default' => "1",
            'desc' => esc_html__('Enables/Disables the sticky header behaviour.', 'grand-popo'),
        ),
        array(
            'id' => 'opt-sticky-background',
            'type' => 'background',
            'title' => esc_html__('Sticky Background', 'grand-popo'),
            'output' => array('#masthead.fixed-nav,#sticky-menu.fixed-nav'),
            'default' => "",
            'required' => array('opt-enable-header-sticky', 'equals', '1')
        ),
        array(
            'id' => 'opt-enable-header-search',
            'type' => 'switch',
            'title' => esc_html__('Search bar', 'grand-popo'),
            'default' => "1",
            'desc' => esc_html__('Enables/Disables the header search bar.', 'grand-popo'),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('Top header', 'grand-popo'),
    'id' => 'top-header-section',
    'desc' => esc_html__('Set top header options here', 'grand-popo'),
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-enable-top-header',
            'type' => 'switch',
            'title' => esc_html__('Display', 'grand-popo'),
            'default' => "1",
            'desc' => esc_html__('Enables/Disables the top header section.', 'grand-popo'),
        ),
        array(
            'id' => 'opt-top-header-background',
            'type' => 'background',
            'title' => esc_html__('Background', 'grand-popo'),
            'output' => array('.top-header'),
            'default' => "",
            'required' => array('opt-enable-top-header', 'equals', '1')
        ),
        array(
            'id' => 'opt-top-header-menu-color',
            'type' => 'link_color',
            'title' => esc_html__('Menu Color', 'grand-popo'),
            'output' => array('.top-header-menu-container .menu li a'),
            'visited' => false,
            'active' => false,
            'default' => array(
            ),
            'required' => array('opt-enable-top-header', 'equals', '1')
        ),
        array(
            'id' => 'opt-top-header-menu-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('.top-header-menu-container .menu li a'),
            'title' => esc_html__('Menu Typography', 'grand-popo'),
            'text-align' => false,
            'line-height' => false,
            'text-transform' => true,
            'font-family' => false,
            'font-size' => false,
            'color' => false,
            'default' => array(),
            'required' => array('opt-enable-top-header', 'equals', '1')
        ),
    )
));

/**
 * Menu info
 */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Menu', 'grand-popo'),
    'id' => 'opt-navigation',
    "icon"=> "fa fa-bars",
    'desc' => esc_html__('Set the menu options here', 'grand-popo'),
    'fields' => array(
        array(
            'id' => 'opt-main-menu-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('.main-menu-container .menu li a'),
            'title' => esc_html__('Main Menu Typography', 'grand-popo'),
            'text-align' => false,
            'line-height' => false,
            'text-transform' => true,
            'font-size' =>  false,
            'font-family' => false,
            'color' => false,
            'default' => array(),
        ),
        array(
            'id' => 'opt-main-menu-color',
            'type' => 'link_color',
            'title' => esc_html__('Main Menu Color', 'grand-popo'),
            'output' => array('.main-menu-container .menu li a'),
            'visited' => false,
            'active' => false,
            'default' => array(
            ),
        ),
    )
        )
);
/**
 * Typography
 */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Styles & typography', 'grand-popo'),
    'id' => 'h1-section',
    'desc' => esc_html__('Set global typography options here', 'grand-popo'),
    //'subsection' => true,
    "icon" => "el el-text-width",
    'fields' => array(
        array(
            'id' => 'opt-h1-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('h1'),
            'title' => esc_html__('Heading 1', 'grand-popo'),
            'text-align' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'font-family' => false,
            'font-size' => false,
            'default' => array(),
        ),
        array(
            'id' => 'opt-h2-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('h2'),
            'title' => esc_html__('Heading 2', 'grand-popo'),
            'text-align' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'font-family' => false,
            'font-size' => false,
            'default' => array(),
        ),
        array(
            'id' => 'opt-h3-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('h3'),
            'title' => esc_html__('Heading 3', 'grand-popo'),
            'text-align' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'font-family' => false,
            'font-size' => false,
            'default' => array(),
        ),
        array(
            'id' => 'opt-h4-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('h4'),
            'title' => esc_html__('Heading 4', 'grand-popo'),
            'text-align' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'font-family' => false,
            'font-size' => false,
            'default' => array(),
        ),
        array(
            'id' => 'opt-h5-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('h5'),
            'title' => esc_html__('Heading 5', 'grand-popo'),
            'text-align' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'font-family' => false,
            'font-size' => false,
            'default' => array(),
        ),
        array(
            'id' => 'opt-h6-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('h6'),
            'title' => esc_html__('Heading 6', 'grand-popo'),
            'text-align' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'font-family' => false,
            'font-size' => false,
            'default' => array(),
        ),
        array(
            'id' => 'opt-body-typo',
            'type' => 'typography',
            'google' => true,
            'output' => array('body'),
            'title' => esc_html__('Body', 'grand-popo'),
            'text-align' => false,
            'letter-spacing' => true,
            'font-family' => false,
            'font-size' => false,
            'default' => array(),
        ),
    )
));

/**
 * Color
 */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Color', 'grand-popo'),
    'id' => 'color-section',
    'desc' => esc_html__('Set global color options here', 'grand-popo'),
    //'subsection' => true,
    "icon" => 'fa fa-adjust',
    'fields' => array(
        
        array(
            'id' => 'opt-default-color',
            'type' => 'color',
            'validate' => 'color',
            'title' => esc_html__('Default color', 'grand-popo'),
            'subtitle' => esc_html__('General color body,input, select, textarea', 'grand-popo'),
            'output' => array('body,input, select, textarea'),
            'default'=>'#404040',
        ),
        array(
            'id' => 'opt-body-background',
            'type' => 'background',
            'title' => esc_html__('Body background', 'grand-popo'),
            'output' => array('body'),
            'default' => array(),
        ),
        array(
            'id' => 'opt-link-color',
            'type'     => 'link_color',
            'title'    => esc_html__('Links Color', 'grand-popo'),
            'subtitle' => esc_html__('General link colors', 'grand-popo'),
            'default'  => array(
                'regular'  => '', 
                'hover'    => '', 
                'active'   => '', 
                'visited'  => '',  
            ),
            'output' => array('a'),
        ),
        array(
            'id'       => 'opt-button-color',
            'type'     => 'color',
            'title'    => esc_html__('Button Color', 'grand-popo'), 
            'subtitle' => esc_html__('Pick a color for the button (default: #fff).', 'grand-popo'),
            'default'  => '#FFFFFF',
            'output' => array('button, input[type="button"], input[type="reset"], input[type="submit"], .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.disabled, .woocommerce a.button.disabled, .woocommerce button.button.disabled, .woocommerce input.button.disabled, .woocommerce #respond input#submit.alt.disabled, .woocommerce a.button.alt.disabled, .woocommerce button.button.alt.disabled, .woocommerce input.button.alt.disabled, .yith-wcwl-add-button.show a, .cart-detail p.buttons a, .grand_popo-newsletter input[type="submit"], .grand_popo-newsletter button'),
            'validate' => 'color',
        ),
        array(
            'id'       => 'opt-button-color-hover',
            'type'     => 'color',
            'title'    => esc_html__('Button Hover Color', 'grand-popo'), 
            'subtitle' => esc_html__('Pick a color for the button on hover (default: #fff).', 'grand-popo'),
            'default'  => '#FFFFFF',
            'output' => array('button:hover,
            input[type="button"]:hover,
            input[type="reset"]:hover,
            input[type="submit"]:hover,
            .woocommerce #respond input#submit:hover, .woocommerce a.button:hover,
            .woocommerce button.button:hover, .woocommerce input.button:hover, 
            .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, 
            .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.disabled:hover,
            .woocommerce a.button.disabled:hover, .woocommerce button.button.disabled:hover,
            .woocommerce input.button.disabled:hover, .woocommerce #respond input#submit.alt.disabled:hover,
            .woocommerce a.button.alt.disabled:hover, .woocommerce button.button.alt.disabled:hover, .woocommerce input.button.alt.disabled:hover,
            .yith-wcwl-add-button.show a:hover,.cart-detail p.buttons a:hover,.grand_popo-newsletter input[type="submit"]:hover, .grand_popo-newsletter button:hover'),
            'validate' => 'color',
        ),
        array(
            'id' => 'opt-button-bg-color',
            'type' => 'background',
            'background-repeat' => false,
            'background-attachment' => false,
            'background-position' => false,
            'background-image' => false,
            'background-size' => false,
            'preview' => false,
            'validate' => 'color',
            'title' => esc_html__('Button Background Color', 'grand-popo'),
            'default' => array('background-color' => '#252525'),
            'output' => array('button, input[type="button"], input[type="reset"], input[type="submit"], .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.disabled, .woocommerce a.button.disabled, .woocommerce button.button.disabled, .woocommerce input.button.disabled, .woocommerce #respond input#submit.alt.disabled, .woocommerce a.button.alt.disabled, .woocommerce button.button.alt.disabled, .woocommerce input.button.alt.disabled, .yith-wcwl-add-button.show a, .cart-detail p.buttons a, .grand_popo-newsletter input[type="submit"], .grand_popo-newsletter button'),
            'desc' => esc_html__('Color to use as background color for all button.', 'grand-popo'),
        ),
        array(
            'id' => 'opt-button-bg-color-hover',
            'type' => 'background',
            'background-repeat' => false,
            'background-attachment' => false,
            'background-position' => false,
            'background-image' => false,
            'background-size' => false,
            'preview' => false,
            'validate' => 'color',
            'title' => esc_html__('Button Hover Background Color', 'grand-popo'),
            'default' => array('background-color' => '#edb324'),
            'output' => array('button:hover,
            input[type="button"]:hover,
            input[type="reset"]:hover,
            input[type="submit"]:hover,
            .woocommerce #respond input#submit:hover, .woocommerce a.button:hover,
            .woocommerce button.button:hover, .woocommerce input.button:hover, 
            .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, 
            .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.disabled:hover,
            .woocommerce a.button.disabled:hover, .woocommerce button.button.disabled:hover,
            .woocommerce input.button.disabled:hover, .woocommerce #respond input#submit.alt.disabled:hover,
            .woocommerce a.button.alt.disabled:hover, .woocommerce button.button.alt.disabled:hover, .woocommerce input.button.alt.disabled:hover,
            .yith-wcwl-add-button.show a:hover,.cart-detail p.buttons a:hover,.grand_popo-newsletter input[type="submit"]:hover, .grand_popo-newsletter button:hover,.woocommerce .grand_popo-product-caption a.add_to_cart_button,.woocommerce a.added_to_cart'),
            'desc' => esc_html__('Color to use as hover background color for all button.', 'grand-popo'),
        ),
    )
));  
        
    
/**
 * Social info
 */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Social info', 'grand-popo'),
    'id' => 'opt-social',
    "icon" => "el el-icon-facebook",
    'desc' => esc_html__('Set the social info here', 'grand-popo'),
    'fields' => array(
        array(
            'id' => 'opt-social-enable',
            'type' => 'switch',
            'title' => esc_html__('Social Links', 'grand-popo'),
            'default' => "1",
            'desc' => esc_html__('Enables/Disables the social links display.', 'grand-popo')
        ),
        array(
            'id' => 'opt-social-facebook',
            'type' => 'text',
            'title' => esc_html__('Facebook URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-twitter',
            'type' => 'text',
            'title' => esc_html__('Twitter URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-pinterest',
            'type' => 'text',
            'title' => esc_html__('Pinterest URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-behance',
            'type' => 'text',
            'title' => esc_html__('Behance URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-dribbble',
            'type' => 'text',
            'title' => esc_html__('Dribbble URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-vimeo',
            'type' => 'text',
            'title' => esc_html__('Vimeo URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-tumblr',
            'type' => 'text',
            'title' => esc_html__('Tumblr URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-linkedIn',
            'type' => 'text',
            'title' => esc_html__('LinkedIn URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-google-plus',
            'type' => 'text',
            'title' => esc_html__('Google+ URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-flickr',
            'type' => 'text',
            'title' => esc_html__('Flickr URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-youtube',
            'type' => 'text',
            'title' => esc_html__('Youtube URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-foursquare',
            'type' => 'text',
            'title' => esc_html__('Foursquare URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-instagram',
            'type' => 'text',
            'title' => esc_html__('Instagram URL', 'grand-popo'),
            'default' => "",
        ),
        array(
            'id' => 'opt-social-github',
            'type' => 'text',
            'title' => esc_html__('GitHub URL', 'grand-popo'),
            'default' => "",
        ),
    )
        )
);
//Footer 
Redux::setSection($opt_name, array(
    'title' => __('Footer', 'grand-popo'),
    'id' => 'opt-footer',
    'desc' => __('Set footer options here', 'grand-popo'),
    'icon' => 'fa fa-pencil-square-o',
    'fields' => array(
        array(
            'id' => 'footer-sidebar-column',
            'type' => 'select',
            'title' => esc_html__('Number of column', 'grand-popo'),
            'desc' => esc_html__('Number of columns availble for the widgets in the footer.', 'grand-popo'),
            'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8'
            ),
            'default' => '4',
        ),
        array(
            'id' => 'opt-footer-copyright-msg',
            'type' => 'editor',
            'title' => esc_html__('Copyright', 'grand-popo'),
            'default' => '',
        ),
        array(
            'id' => 'opt-footer-bg',
            'type' => 'background',
            'title' => __('Background', 'grand-popo'),
            'output' => array('.site-footer'),
            'default' => array(
                'background-repeat' => 'no-repeat',
                'background-position' => 'center center',
                'background-size' => 'contain'
            ),
        ),
        array(
            'id' => 'opt-footer-color',
            'type' => 'color',
            'validate' => 'color',
            'title' => esc_html__('Footer Color', 'grand-popo'),
            'subtitle' => esc_html__('Color to use as color of footer', 'grand-popo'),
            'output' => array('.site-footer'),
            'default'=>'#969696',
        ),
    )
));
//SHOP
Redux::setSection($opt_name, array(
    'title' => __('Shop', 'grand-popo'),
    'id' => 'opt-shop',
    'desc' => __('Set shop page options', 'grand-popo'),
    "icon"=>'fa fa-shopping-bag',
    'fields' => array(
        array(
            'id' => 'opt-enable-mini-cart',
            'type' => 'switch',
            'title' => esc_html__('Minicart', 'grand-popo'),
            'default' => "1",
            'desc' => esc_html__('Enables/Disables the shop minicart.', 'grand-popo')
        ),
        array(
            'id' => 'shop-layout-template',
            'type' => 'select',
            'title' => esc_html__('Sidebar position', 'grand-popo'),
            'desc' => esc_html__('Configures the shop pages layout.', 'grand-popo'),
            'options' => array(
                'right-sidebar' => 'Right sidebar',
                'no-sidebar' => 'No sidebar',
                'left-sidebar' => 'Left sidebar',
            ),
            'default' => 'left-sidebar',
        ),
        
        array(
            'id' => 'opt-enable-toggle-sidebar',
            'type' => 'switch',
            'title' => esc_html__('Toggle Sidebar Element', 'grand-popo'),
            'desc' => esc_html__('Toggle sidebar widget when you click on the widget title.', 'grand-popo'),
            'default' => "1",
            'required' => array('shop-layout-template', '!=', 'no-sidebar'),
        ),
        array(
            'id' => 'shop-number-column',
            'type' => 'select',
            'title' => esc_html__('Number of Products per Row', 'grand-popo'),
            'desc' => esc_html__('Number of products to display per row in the shop pages.', 'grand-popo'),
            'options' => array(
                '1' =>'1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ),
            'default' => '3',
        ),
        
        
    )
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Related Products', 'grand-popo'),
    'id' => 'related-product-section',
    'desc' => esc_html__('Set related products options here', 'grand-popo'),
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-number-per-page',
            'type' => 'select',
            'title' => esc_html__('Number of Related Products per Page', 'grand-popo'),
            'desc' => esc_html__('Number of related products to display per page in the product page.', 'grand-popo'),
            'options' => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ),
            'default' => '4',
        ),
        array(
            'id' => 'opt-number-per-row',
            'type' => 'select',
            'title' => esc_html__('Number of Related Products per Row', 'grand-popo'),
            'desc' => esc_html__('Number of related products to display per row in the product page.', 'grand-popo'),
            'options' => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ),
            'default' => '4',
        ),
    )
));

//Blog
Redux::setSection($opt_name, array(
    'title' => esc_html__('Blog', 'grand-popo'),
    'id' => 'opt-blog',
    'desc' => esc_html__('Set blog page options', 'grand-popo'),
    'icon' => 'el el-icon-wordpress',
    'fields' => array(
        array(
            'id' => 'blog-layout-template',
            'type' => 'select',
            'title' => esc_html__('Categories/Archive Template', 'grand-popo'),
            'desc' => esc_html__('Configures the blog categories/archive layout.', 'grand-popo'),
            'options' => array(
                'right-sidebar' => 'Right sidebar',
                'no-sidebar' => 'No sidebar',
                'left-sidebar' => 'Left sidebar',
            ),
            'default' => 'left-sidebar',
        ),
        array(
            'id' => 'single-layout-template',
            'type' => 'select',
            'title' => esc_html__('Post Template', 'grand-popo'),
            'desc' => esc_html__('Posts pages layout.', 'grand-popo'),
            'options' => array(
                'right-sidebar' => 'Right sidebar',
                'no-sidebar' => 'No sidebar',
                'left-sidebar' => 'Left sidebar',
            ),
            'default' => 'right-sidebar',
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('Go Premium', 'grand-popo'),
    'id' => 'opt-premium',
    'desc' =>'<div class="gp_upgrade_wrap"><h4>Upgrade to Grand-Popo Premium for more great features. Over 50 more theme options, premium shop features, custom post types and much much more!</h4><a class="button button-primary " href="http://demos.orionorigin.com/grand-popo/?utm_source=Free%20Trial&utm_medium=cpc&utm_term='.urlencode("upgrade-page").'&utm_campaign=Grand-Popo">'
    . 'Upgrade</a><br><br><a href="http://demos.orionorigin.com/grand-popo/?utm_source=Free%20Trial&utm_medium=cpc&utm_term='.urlencode("upgrade-page").'&utm_campaign=Grand-Popo">
            <img class="gp-feature-img" src="'. get_template_directory_uri().'/assets/images/gp-features.jpeg" alt="Premium features"></a></div>',
    'icon' => 'fa fa-graduation-cap'
));

/*
 *
 * ---> END SECTIONS
 *
 */