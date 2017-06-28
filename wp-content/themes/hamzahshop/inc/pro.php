<?php


/*Add theme menu page*/
 
add_action('admin_menu', 'hamzah_admin_menu');

function hamzah_admin_menu() {
	
	$hamzah_page_title = esc_html__("Hamzah Premium",'hamzahshop');
	
	$hamzah_menu_title = esc_html__("Hamzah Premium",'hamzahshop');
	
	add_theme_page($hamzah_page_title, $hamzah_menu_title, 'edit_theme_options', 'hamzah_pro', 'hamzah_pro_page');
	
}

/*
**
** Premium Theme Feature Page
**
*/

function hamzah_pro_page(){
	if ( is_admin() ) {
		get_template_part('/inc/admin/premium-screen/index');
		
	} 
}

function hamzah_admin_script($hamzah_hook){
	
	if($hamzah_hook != 'appearance_page_hamzah_pro') {
		return;
	} 
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css' );
	wp_enqueue_style( 'hamzahshop-custom-css', get_template_directory_uri() .'/assets/css/hamzah-custom.css',array(),'1.0' );

}

add_action( 'admin_enqueue_scripts', 'hamzah_admin_script' );



