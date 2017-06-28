<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grand-Popo
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php
        global $grand_popo_options;

        $top_header = grand_popo_get_proper_value($grand_popo_options, 'opt-enable-top-header', '1');
        
       
        ?>
        
        <?php
            if(function_exists('is_shop'))
                $woo_exist="woo-exist";
            else
                $woo_exist="";
        ?>
        <input id="woo-exist" type="hidden" value="" class="<?php echo esc_attr($woo_exist) ?>" >
        

        <div id="page" class="site">
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'grand-popo'); ?></a>
            
                <div id="header-container" class="header-container ">
    <?php
    if ($top_header == "1") {
        ?>
                        <div class="top-header">
                            <div class="site-wrap">
                                <div class="left-menu">
                        <?php get_template_part('components/navigation/navigation', 'top-header-left'); ?>
                                </div>
                                <div class="right-menu">
                        <?php get_template_part('components/navigation/navigation', 'top-header-right'); ?>
                                </div>
                            </div>
                        </div>
                                    <?php
                                }
                                ?>
                    <header id="masthead" class="site-header <?php grand_popo_header_sticky(); ?>">
                        <div class="site-wrap">
    <?php get_template_part('components/header/site', 'branding'); ?>
                            <div>
                    <?php get_template_part('components/navigation/navigation', 'main'); ?>
                    <?php grand_popo_get_mini_cart($mode=""); ?>
                            </div>
                        </div>
                    </header>                
                </div>
                <div id="header-menu-mask"></div>
                <nav id="mobile-site-navigation" class="mobile-navigation">

                    <span id="header-menu-close"><i class="ti-close"></i></span>

                    <div id="site-navigation-wrap" class="">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'top-header-menu-left',
                            'fallback_cb' => '',
                            'menu_class' => 'mobile-nav-menu'
                        ));
                        ?>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'top-header-menu-right',
                            'fallback_cb' => '',
                            'menu_class' => 'mobile-nav-menu'
                        ));
                        ?>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'main-menu',
                            'fallback_cb' => '',
                            'menu_class' => 'mobile-nav-menu'
                        ));
                        ?>
                    </div>
                </nav>
                <div class="mobile-nav-container">
                    <div id="sticky-menu" class=" mobile-sticky sticky-menu  ">
                        <div class="site-wrap">
                            <div id="menu-bars-container">
                                <span class="masthead-icon" id="header-menu-icon"><i class="fa fa-bars"></i></span>
                            </div>
                            <?php get_template_part('components/header/site', 'branding'); ?>
                            
                                <?php grand_popo_get_mini_cart($mode="mobile"); ?>
                        </div>

                    </div>
                </div>

    <?php
    $header_search = grand_popo_get_proper_value($grand_popo_options, 'opt-enable-header-search', 1);
    if ($header_search == 1 && function_exists('grand_popo_advanced_product_search')) {
        echo grand_popo_advanced_product_search($atts = array('all' => true, 'categories' => ''));
    }

    $page_id = get_the_ID();
    if (function_exists('is_shop') && is_shop())
        $page_id = get_option('woocommerce_shop_page_id');
    $page_metas = get_post_meta($page_id, 'grand_popo_page_options', true);
    $page_layout = grand_popo_get_proper_value($page_metas, 'page-layout', 'boxed');
    ?>
                <?php grand_popo_get_page_title(); ?>

           

            <div id="site-content" class="site-content <?php echo esc_attr($page_layout); ?>-layout">      
            <?php
            if (function_exists('is_shop') && (is_shop() || is_product_category())) {
                ?>
                    <div class="shop-wrap">
                <?php
            } else {
                ?>
                        <div class="site-wrap">
                    <?php

                }
                
