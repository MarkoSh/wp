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
        switch ($post_type) {
            case 'order_':
                $defaults['customer']   = 'Идентификатор покупателя';
                $defaults['cart']       = 'Идентификатор корзины';
                break;
            case 'cart':
                $defaults['cart_reference'] = 'Артикул корзины';
                $defaults['order']          = 'Идентификатор заказа';
                break;
        }
        $defaults['summary'] = 'Общая стоимость товаров';
    }
    if ( in_array($post_type, array(
        'product_'
    )) ) {
        $defaults['reference']  = 'Артикул товара';
        $defaults['brand']      = 'Бренд товара';
        $defaults['price']      = 'Цена';
    }
    return $defaults;
    
}
 
// SHOW THE COLUMN DATA
function ST4_columns_content($column_name, $post_ID) {
    $post_type = get_post_type($post_ID);
    if (in_array($column_name, array(
        'customer',
        'brand'
    ))) {
        $post = get_post(get_post_meta($post_ID, 'zt-' . $column_name, 1));
        echo '<a href="' . get_edit_post_link($post->ID) . '">' . ($post->post_title ? $post->post_title : $post->ID) . '</a>';
    }
    if (in_array($column_name, array(
        'cart'
    ))) {
        $post = get_post(get_post_meta($post_ID, 'zt-' . $column_name, 1));
        echo '<a href="' . get_edit_post_link($post->ID) . '">Корзина ' . $post->ID . '</a>';
    }
    if (in_array($column_name, array(
        'order'
    ))) {
        $post = end(get_posts(array(
            'post_type'     => 'order_',
            'meta_key'      => 'zt-cart',
            'meta_value'    => $post_ID
        )));
        echo '<a href="' . get_edit_post_link($post->ID) . '">Заказ ' . $post->ID . '</a>';
    }
    if (in_array($column_name, array(
        'reference',
        'price'
    ))) {
        $data = get_post_meta($post_ID, 'zt-' . $column_name, 1);
        switch ($column_name) {
            case 'reference':
                echo $data;
                break;
            case 'price':
                //echo $data . 'руб.';
                break;
        }
    }
    if (in_array($column_name, array(
        'summary'
    ))) {
        if ($post_type == 'cart')
            $summary = getCartSummary($post_ID);
        else
            $summary = getOrderSummary($post_ID);
        echo $summary . 'руб.';
    }

}

add_filter('manage_posts_columns', 'ST4_columns_head');
add_action('manage_posts_custom_column', 'ST4_columns_content', 1, 2);

function my_column_register_sortable( $columns ) {
  $columns['price']     = 'price';
  $columns['reference'] = 'reference';
 
  return $columns;
}
add_filter( 'manage_edit-product__sortable_columns', 'my_column_register_sortable' );
function my_column_orderby( $vars ) {
  if ( isset( $vars['orderby'] ) ) {
      if ('price' == $vars['orderby']) {
        $vars = array_merge( $vars, array(
            'meta_key'  => 'zt-price',
            'orderby'   => 'meta_value_num'
        ) );
      } elseif ('reference' == $vars['orderby']) {
        $vars = array_merge( $vars, array(
            'meta_key'  => 'zt-reference',
            'orderby'   => 'meta_value'
        ) );
      }
  }
 
  return $vars;
}
add_filter( 'request', 'my_column_orderby' );


function zt_get_meta_box( $meta_boxes ) {
	$prefix = 'zt-';
    $post = get_post(intval($_GET['post']));

    $brands = get_posts(array(
        'post_type'     => 'brand',
        'post_per_page' => -1
    ));
    
    $brands_options = [];

    foreach ($brands as $item) {
        $brands_options[$item->ID] = $item->post_title;
    }

    $carts = get_posts(array(
        'post_type'     => 'cart',
        'post_per_page' => -1
    ));
    
    $carts_options = [];

    foreach ($carts as $item) {
        $carts_options[$item->ID] = 'Корзина ' . $item->ID;
    }

    $customers = get_posts(array(
        'post_type'     => 'customer',
        'post_per_page' => -1
    ));
    
    $customers_options = [];

    foreach ($customers as $item) {
        $customers_options[$item->ID] = $item->post_title;
    }

    $products = get_posts(array(
        'post_type'     => 'product_',
        'post_per_page' => -1,
        'post__not_in'  => array($post->ID)
    ));
    
    $products_options = [];

    foreach ($products as $item) {
        $products_options[$item->ID] = $item->post_title;
    }

    $meta_boxes[] = array(
		'id'            => 'products',
		'title'         => esc_html__( 'Информация о товаре', $prefix . 'metabox' ),
		'post_types'    => array( 'product_' ),
		'context'       => 'advanced',
		'priority'      => 'default',
		'autosave'      => true,
		'fields'        => array(
                array(
                    'id'            => $prefix . 'price',
                    'name'          => esc_html__( 'Цена', $prefix . 'metabox' ),
                    'type'          => 'text',
                    'placeholder'   => esc_html__( 'Цена', $prefix . 'metabox' )
                ),
                array(
                    'id'            => $prefix . 'reference',
                    'name'          => esc_html__( 'Артикул', $prefix . 'metabox' ),
                    'type'          => 'text',
                    'placeholder'   => esc_html__( 'Артикул', $prefix . 'metabox' )
                ),
                array(
                    'id'            => $prefix . 'brand',
                    'name'          => esc_html__( 'Бренд', $prefix . 'metabox' ),
                    'type'          => 'select_advanced',
                    'placeholder'   => esc_html__( 'Выберите бренд', $prefix . 'metabox' ),
                    'options'       => $brands_options,
                    'js_options' => array(
                        1 => 'Select2 options',
                    ),
                    'attributes' => array(
                        1 => 'Custom Attributes',
                    ),
                ),
                array(
                    'id'            => $prefix . 'parent',
                    'name'          => esc_html__( 'Родительский товар', $prefix . 'metabox' ),
                    'type'          => 'select_advanced',
                    'placeholder'   => esc_html__( 'Выберите родительский товар', $prefix . 'metabox' ),
                    'options'       => $products_options,
                ),
            ),
	);
    $meta_boxes[] = array(
		'id'            => 'order_information',
		'title'         => esc_html__( 'Информация о заказе', $prefix . 'metabox' ),
		'post_types'    => array( 'order_' ),
		'context'       => 'advanced',
		'priority'      => 'default',
		'autosave'      => true,
		'fields'        => array(
                array(
                        'id'            => $prefix . 'cart',
                        'name'          => esc_html__( 'Идентификатор корзины', $prefix . 'metabox' ),
                        'type'          => 'select_advanced',
                        'placeholder'   => esc_html__( 'Идентификатор корзины', $prefix . 'metabox' ),
                        'attributes'    => array(
                                'disabled' => 'disabled',
                            ),
                        'options' => $carts_options,
                    ),
                array(
                        'id'            => $prefix . 'customer',
                        'name'          => esc_html__( 'Идентификатор покупателя', $prefix . 'metabox' ),
                        'type'          => 'select_advanced',
                        'placeholder'   => esc_html__( 'Идентификатор покупателя', $prefix . 'metabox' ),
                        'attributes'    => array(
                                'disabled' => 'disabled',
                            ),
                        'options' => $customers_options,
                    ),
                array(
                        'id'    => $prefix . 'address',
                        'type'  => 'textarea',
                        'name'  => esc_html__( 'Адрес доставки', $prefix . 'metabox' ),
                    )
            ),
	);
    $meta_boxes[] = array(
		'id'            => 'order_contain',
		'title'         => esc_html__( 'Содержимое корзины', $prefix . 'metabox' ),
		'post_types'    => array( 'order_' ),
		'context'       => 'advanced',
		'priority'      => 'default',
		'autosave'      => true,
		'fields'        => array(
			array(
                    'id'            => $prefix . 'products',
                    'name'          => esc_html__( 'Товары в корзине', $prefix . 'metabox' ),
                    'type'          => 'select_advanced',
                    'placeholder'   => esc_html__( 'Товары', $prefix . 'metabox' ),
                    'options'       => $products_options,
                    'std'           => getOrderProducts($post->ID),
                    'multiple'      => true,
                    'attributes'    => array(
                            'disabled'      => 'disabled'
                        ),
                ),
            array(
                    'id'            => $prefix . 'summary',
                    'type'          => 'text',
                    'name'          => esc_html__( 'Общая стоимость товаров', $prefix . 'metabox' ),
                    'desc'          => esc_html__( 'Будет пересчитана автоматически после сохранения', $prefix . 'metabox' ),
                    'attributes'    => array(
                            'value'         => getOrderSummary($post->ID),
                            'disabled'      => 'disabled'
                        ),
                ),
		),
	);
    $meta_boxes[] = array(
		'id'            => 'cart_contain',
		'title'         => esc_html__( 'Содержимое корзины', $prefix . 'metabox' ),
		'post_types'    => array( 'cart' ),
		'context'       => 'advanced',
		'priority'      => 'default',
		'autosave'      => true,
		'fields'        => array(
            array(
                    'id'            => $prefix . 'cart_reference',
                    'type'          => 'text',
                    'name'          => esc_html__( 'Артикул корзины', $prefix . 'metabox' ),
                    'attributes'    => array(
                            'disabled'  => !current_user_can('administrator')
                        ),
                ),
			array(
                    'id'            => $prefix . 'products',
                    'name'          => esc_html__( 'Товары в корзине', $prefix . 'metabox' ),
                    'type'          => 'select_advanced',
                    'placeholder'   => esc_html__( 'Выберите товары', $prefix . 'metabox' ),
                    'options'       => $products_options,
                    'multiple'      => true,
                ),
            array(
                    'id'            => $prefix . 'summary',
                    'type'          => 'text',
                    'name'          => esc_html__( 'Общая стоимость товаров', $prefix . 'metabox' ),
                    'desc'          => esc_html__( 'Будет пересчитана автоматически после сохранения', $prefix . 'metabox' ),
                    'attributes'    => array(
                            'value'     => getCartSummary($post->ID),
                            'disabled'  => 'disabled'
                        ),
                ),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'zt_get_meta_box' );

/**
* Получение общей стоимости корзины
*
* @param идентификатор корзины $cartId
* @return число, сумма стоимости всех товаров в корзине
*/
function getCartSummary($cartId = false) {
    if ($cartId) {
        $products = get_post_meta($cartId, 'zt-products');

        $products_summary = 0;
        foreach ($products as $product) {
            $products_summary += intval(get_post_meta($product, 'zt-price', 1));
        }
        return $products_summary;
    }
}

/**
* Получение общей стоимости заказа
*
* @param идентификатор заказа $orderId
* @return число, сумма стоимости всех товаров в корзине заказа
*/
function getOrderSummary($orderId = false) {
    if ($orderId) {
        $cartId = get_post_meta($orderId, 'zt-cart', 1);
        return getCartSummary($cartId);
    }
}

/**
* Получение идентификаторов товаров в заказе
*
* @param идентификатор заказа $orderId
* @return массив идентификаторов всех товаров в корзине заказа
*/
function getOrderProducts($orderId = false) {
    if ($orderId) {
        $cartId = get_post_meta($orderId, 'zt-cart', 1);
        $products = get_post_meta($cartId, 'zt-products');
        return $products;
    }
}


/*
 *
 * wooCommerce
 *
 */
define('WOOCOMMERCE_USE_CSS', false);
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
  echo '<section id="main">';
}

function my_theme_wrapper_end() {
  echo '</section>';
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'RUB': $currency_symbol = 'руб.'; break;
     }
     return $currency_symbol;
}

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/*
 *
 * /wooCommerce
 *
 */