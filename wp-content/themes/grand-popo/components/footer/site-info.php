<div class="site-info">
<?php 
        global $grand_popo_options;
        
	$site_info = grand_popo_get_proper_value($grand_popo_options,'opt-footer-copyright-msg','');
                
	if($site_info != ""){
	    echo wp_kses_post($site_info);
	}else{
	    $year = date_i18n( __( 'Y', 'grand-popo' ) );
            $sitename = get_bloginfo('name');
            /* Translators: %1$s : current year, %2$s : sitename  */
            $copyright = sprintf(esc_html__('Copyright %1$s %2$s. All rights reserved.', 'grand-popo'), esc_attr($year), $sitename);
            echo wp_kses_post($copyright);
	}
    ?>	
</div><!-- .site-info -->