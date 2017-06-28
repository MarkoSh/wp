<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HamzahShop
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
   <header>
        <div class="header-top">
            <div class="container">
                <div class="header-container">
                   <?php get_template_part( 'template-parts/parts/top-bar'); ?>
                </div>    
            </div>
        </div>
      
                 
                
          <?php get_template_part( 'template-parts/parts/header'); ?>
          
        <?php get_template_part( 'template-parts/parts/nav'); ?>
    </header>
	<?php if ( is_front_page() ) : ?>          
        <?php dynamic_sidebar( 'slider' ); ?>
    <?php endif; ?>        