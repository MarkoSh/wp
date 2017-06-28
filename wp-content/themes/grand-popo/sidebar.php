<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grand-Popo
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="blog-sidebar col xl-1-4 lg-1-4 md-1-1 sm-1-1" role="complementary">
    <div id="blog-sidebar">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div>
</div>
