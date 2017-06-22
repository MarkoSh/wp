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
        $defaults['customer'] = 'Идентификатор покупателя';
        switch ($post_type) {
            case 'order_':
                $defaults['cart'] = 'Идентификатор корзины';
                break;
            case 'cart':
                $defaults['order'] = 'Идентификатор заказа';
                break;
        }
        $defaults['summary'] = 'Общая стоимость товаров';
    }
    if ( in_array($post_type, array(
        'product'
    )) ) {
        $defaults['brand'] = 'Бренд товара';
    }
    return $defaults;
    
}
 
// SHOW THE COLUMN DATA
function ST4_columns_content($column_name, $post_ID) {
    
    if (in_array($column_name, array(
        'cart',
        'order_',
        'customer',
        'brand'
    ))) {
        $post = get_post(get_post_meta($post_ID, 'zt-' . $column_name, 1));
        echo '<a href="' . get_edit_post_link($post->ID) . '">' . ($post->post_title ? $post->post_title : $post->ID) . '</a>';
    }
    if (in_array($column_name, array(
        'summary'
    ))) {
        $summary = get_post_meta($post_ID, 'zt-' . $column_name, 1);
        echo $summary . 'руб.';
    }

}

add_filter('manage_posts_columns', 'ST4_columns_head');
add_action('manage_posts_custom_column', 'ST4_columns_content', 1, 2);

function zt_get_meta_box( $meta_boxes ) {
	$prefix = 'zt-';
    global $post;
    print_r($post);

    $brands = get_posts(array(
        'post_type' => 'brand',
        'post_per_page' => -1
    ));
    
    $brands_options = [];

    foreach ($brands as $item) {
        $brands_options[$item->ID] = $item->post_title;
    }

    $carts = get_posts(array(
        'post_type' => 'cart',
        'post_per_page' => -1
    ));
    
    $carts_options = [];

    foreach ($carts as $item) {
        $carts_options[$item->ID] = 'Корзина ' . $item->ID;
    }

    $customers = get_posts(array(
        'post_type' => 'customer',
        'post_per_page' => -1
    ));
    
    $customers_options = [];

    foreach ($customers as $item) {
        $customers_options[$item->ID] = $item->post_title;
    }

	$meta_boxes[] = array(
		'id' => 'brands',
		'title' => esc_html__( 'Бренд товара', 'zt-metabox' ),
		'post_types' => array( 'product' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => true,
		'fields' => array(
			array(
				'id' => $prefix . 'brand',
				'name' => esc_html__( 'Выберите бренд', 'zt-metabox' ),
				'type' => 'select',
				'placeholder' => esc_html__( 'Выберите бренд', 'zt-metabox' ),
				'options' => $brands_options,
			),
		),
	);
    $meta_boxes[] = array(
		'id' => 'order_information',
		'title' => esc_html__( 'Информация о заказе', 'zt-metabox' ),
		'post_types' => array( 'order_' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => true,
		'fields' => array(
			array(
				'id' => $prefix . 'cart',
				'name' => esc_html__( 'Идентификатор корзины', 'zt-metabox' ),
				'type' => 'select_advanced',
				'placeholder' => esc_html__( 'Идентификатор корзины', 'zt-metabox' ),
                'attributes' => !is_admin() ? array(
					'disabled' => 'disabled',
				) : false,
				'options' => $carts_options,
			),
            array(
				'id' => $prefix . 'customer',
				'name' => esc_html__( 'Идентификатор покупателя', 'zt-metabox' ),
				'type' => 'select_advanced',
				'placeholder' => esc_html__( 'Идентификатор покупателя', 'zt-metabox' ),
                'attributes' => !is_admin() ? array(
					'disabled' => 'disabled',
				) : false,
				'options' => $customers_options,
			),
            array(
				'id' => $prefix . 'address',
				'type' => 'textarea',
				'name' => esc_html__( 'Адрес доставки', 'zt-metabox' ),
			)
		),
	);
    $meta_boxes[] = array(
		'id' => 'order_contain',
		'title' => esc_html__( 'Содержимое корзины', 'zt-metabox' ),
		'post_types' => array( 'order_', 'cart' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => true,
		'fields' => array(
			array(
				'id' => $prefix . 'products',
				'name' => esc_html__( 'Товары в корзине', 'zt-metabox' ),
				'type' => 'checkbox_list',
				'options' => array(
					1 => 'Какой-то товар',
                    2 => 'Какой-то товар',
                    3 => 'Какой-то товар',
                    4 => 'Какой-то товар',
                    5 => 'Какой-то товар',
                    6 => 'Какой-то товар',
                    7 => 'Какой-то товар',
				),
                'std' => array( '1', '2', '3', '4', '5', '6', '7' )
			),
            array(
				'id' => $prefix . 'summary',
				'type' => 'text',
				'name' => esc_html__( 'Общая стоимость товаров', 'zt-metabox' ),
                'attributes' => !is_admin() ? array(
					'disabled' => 'disabled',
				) : false,
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'zt_get_meta_box' );