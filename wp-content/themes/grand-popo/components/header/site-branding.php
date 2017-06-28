<div class="site-branding">
    <?php
    global $grand_popo_options;
    $display_tagline = grand_popo_get_proper_value($grand_popo_options, 'display-tagline');
    $custom_logo = grand_popo_get_proper_value($grand_popo_options, 'upload-logo-image');
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    $url="";
    if($image[0])
        $url=$image[0];
    $url = grand_popo_get_proper_value($custom_logo, "url", $url);
    $check_logo_width = grand_popo_get_proper_value($grand_popo_options, 'logo-width');
    $check_logo_height = grand_popo_get_proper_value($grand_popo_options, 'logo-height');
    
    if ($url == "") {
        if (is_front_page() && is_home()) :
            ?>
            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
        <?php else : ?>
            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
        <?php
        endif;
    }
    else {
        ?>
            <a class="logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <img <?php echo ($check_logo_width=="") ? "" : "width='".esc_attr($check_logo_width)."'" ;  ?>  <?php echo ($check_logo_height=="") ? "" : "height='".esc_attr($check_logo_height)."'" ;  ?> src="<?php echo esc_url($url); ?>" alt="logo">
            </a>
        <?php
    }

    if ($display_tagline == "1")
        $description = get_bloginfo('description', 'display');
    else
        $description = "";

    if ($description || is_customize_preview()) :
        ?>
        <p class="site-description"><?php echo wp_kses_post($description); /* WPCS: xss ok. */ ?></p>
    <?php endif;
    ?>
</div>