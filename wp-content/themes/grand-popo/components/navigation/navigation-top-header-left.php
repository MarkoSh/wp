<nav id="top-header-left-navigation" class="top-header-navigation">
    <?php 
        wp_nav_menu( array( 'theme_location' => 'top-header-menu-left', 'menu_id' => 'top-header-menu-left', 'fallback_cb' => 'wp_page_menu', 'container_class' => 'top-header-menu-container' ) ); 
    ?>
</nav>