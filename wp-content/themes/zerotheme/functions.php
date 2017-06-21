<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 09/06/17
 * Time: 17:48
 */

$theme_features = [
    'title-tag',
    'html5',
    'post-thumbnails',
    'post-formats',
    'admin-bar'
];

foreach ($theme_features as $feature)
    add_theme_support($feature);

function enqueue_styles() {
    wp_enqueue_style( 'meyer-reset', '//cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css', false );
    wp_enqueue_style( 'normalize', '//cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css', false );
    wp_enqueue_style( 'tether', '//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/css/tether.min.css', false );
    wp_enqueue_style( 'bootstrap4', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css', false );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.min.css', array() );
}

function enqueue_scripts() {
    wp_enqueue_script( 'tether', '//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js', false );
    wp_enqueue_script( 'bootstrap4', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js', array('jquery', 'tether') );
    wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.min.js', array() );
}

add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

// ADD NEW COLUMN
function ST4_columns_head($defaults) {
    $screen = get_current_screen();
    $post_type = $screen->post_type;
    if ( in_array($post_type, array(
        'order_',
        'cart'
    )) ) {
        $defaults['id_customer'] = 'Идентификатор покупателя';
        switch ($post_type) {
            case 'order_':
                $defaults['id_cart'] = 'Идентификатор корзины';
                break;
            case 'cart':
                $defaults['id_order'] = 'Идентификатор заказа';
                break;
        }
    }
    return $defaults;
    
}
 
// SHOW THE COLUMN DATA
function ST4_columns_content($column_name, $post_ID) {

    if (in_array($column_name, array(
        'id_cart',
        'id_order',
        'id_customer'
    ))) {
        $id = types_get_field_meta_value( $column_name, $post_ID );
        echo '<a href="' . get_edit_post_link($id) . '">' . $id . '</a>';
    }

}

add_filter('manage_posts_columns', 'ST4_columns_head');
add_action('manage_posts_custom_column', 'ST4_columns_content', 10, 2);