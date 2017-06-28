<?php
/**
 * Functions for WooCommerce which only needs to be used when WooCommerce is active.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_add_to_cart' ) ) :
	/**
	 * Custom add to cart button for WooCommerce.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_add_to_cart() {
		global $product;

		if ( function_exists( 'method_exists' ) && method_exists( $product, 'get_type' ) ) {
			$prod_type = $product->get_type();
		} else {
			$prod_type = $product->product_type;
		}

		if ( function_exists( 'method_exists' ) && method_exists( $product, 'get_stock_status' ) ) {
			$prod_in_stock = $product->get_stock_status();
		} else {
			$prod_in_stock = $product->is_in_stock();
		}

		if ( $product ) {
			$args = array();
			$defaults = array(
				'quantity' => 1,
				'class'    => implode( ' ', array_filter( array(
					'button',
					'product_type_' . $prod_type,
					$product->is_purchasable() && $prod_in_stock ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				) ) ),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

			wc_get_template( 'inc/woocommerce/add-to-cart.php', $args );
		}
	}
endif;

/**
 * Refresh WooCommerce cart count instantly.
 *
 * @since Hestia 1.0
 */
function hestia_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>

	<a class="cart-contents btn btn-white pull-right" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hestia' ); ?>">
		<i class="fa fa-shopping-cart"></i>
		<?php
		echo
		/* translators: %d is number of items */
		sprintf( _n( '%d item', '%d items', absint( $woocommerce->cart->cart_contents_count ), 'hestia' ), absint( $woocommerce->cart->cart_contents_count ) );?> - <?php echo wp_kses( $woocommerce->cart->get_cart_total(), array(
			'span' => array(
			'class' => array(),
			),
		) ); ?></a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}

/**
 * Change the layout before the shop page main content
 */
function hestia_woocommerce_before_main_content() {

	$hestia_page_sidebar_layout = get_theme_mod( 'hestia_page_sidebar_layout', 'full-width' );

	$args = array(
		'sidebar-right' => 'content-sidebar-right col-md-9',
		'sidebar-left' => 'content-sidebar-left col-md-9',
		'full-width' => 'col-md-12',
		'is_shop'   => true,
	);
	$class_to_add = hestia_get_content_classes( $hestia_page_sidebar_layout, 'sidebar-woocommerce', $args ); ?>
	<div id="primary" class="page-header header-filter" data-parallax="active" style="background-image: url('<?php echo hestia_featured_header(); ?>');">
		<div class="container">
			<div class="row title-row">
				<div class="col-md-4 col-md-offset-8">
					<a class="cart-contents btn btn-white pull-right" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hestia' ); ?>"><i class="fa fa-shopping-cart"></i> </a>
				</div>
			</div>
		</div>
	</div>
	</header>
	<div class="<?php echo hestia_layout(); ?>">
		<div class="blog-post">
			<div class="container">
				<article id="post-<?php the_ID(); ?>" class="section section-text">
					<div class="row">
						<?php
						if ( $hestia_page_sidebar_layout === 'sidebar-left' ) {
							hestia_shop_sidebar();
						}
						?>
						<div class="<?php echo esc_attr( $class_to_add ); ?>">
	<?php
}

/**
 * Change the layout after the shop page main content
 */
function hestia_woocommerce_after_main_content() {
	$hestia_page_sidebar_layout = get_theme_mod( 'hestia_page_sidebar_layout', 'full-width' );
						?>
						</div>
						<?php
						if ( $hestia_page_sidebar_layout === 'sidebar-right' ) {
							hestia_shop_sidebar();
						}
						?>
					</div>
				</article>
			</div>
		</div>
	<?php
}

/**
 * Change the layout before each single product listing
 */
function hestia_woocommerce_before_shop_loop_item() {

	echo '<div class="card card-product">';

}

/**
 * Change the layout after each single product listing
 */
function hestia_woocommerce_after_shop_loop_item() {

	echo '</div>';

}

/**
 * Change the layout of the thumbnail on single product listing
 */
function hestia_woocommerce_template_loop_product_thumbnail() {
	if ( has_post_thumbnail() ) {
		?>
			<div class="card-image">
				<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail( 'hestia-shop' ); ?>
				</a>
				<div class="ripple-container"></div>
			</div>
		<?php
	}
}

/**
 * Change the main content for single product listing
 */
function hestia_woocommerce_template_loop_product_title() {
		global $post;
		$current_product = wc_get_product( get_the_ID() );
		?>
		<div class="content">
			<?php
			$product_categories = get_the_terms( $post->ID, 'product_cat' );
			$i = false;
			if ( ! empty( $product_categories ) ) {
				echo '<h6 class="category">';
				foreach ( $product_categories as $product_category ) {
					$product_cat_id = $product_category->term_id;
					$product_cat_name = $product_category->name;
					if ( ! empty( $product_cat_id ) && ! empty( $product_cat_name ) ) {
						if ( $i ) {
							echo ' , ';
						}
						echo '<a href="' . esc_url( get_term_link( $product_cat_id, 'product_cat' ) ) . '">' . esc_html( $product_cat_name ) . '</a>';
						$i = true;
					}
				}
				echo '</h6>';
			}
			?>
			<h4 class="card-title">
				<a class="shop-item-title-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html( the_title() ); ?></a>
			</h4>
			<?php if ( $post->post_excerpt ) : ?>
				<div class="card-description"><?php echo apply_filters( 'woocommerce_short_description', strip_tags( $post->post_excerpt ) ) ?></div>
			<?php endif; ?>
			<div class="footer">
					<?php
					$product_price = $current_product->get_price_html();
					if ( ! empty( $product_price ) ) {

						echo '<div class="price"><h4>';

							echo wp_kses( $product_price, array(
								'span' => array(
									'class' => array(),
								),
								'del' => array(),
							) );

							echo '</h4></div>';

					} ?>
				<div class="stats">
					<?php hestia_add_to_cart(); ?>
				</div>
			</div>
		</div>
		<?php
}

/**
 * Checkout page
 * Move the coupon fild and message info after the order table
 **/
function hestia_coupon_after_order_table_js() {
	wc_enqueue_js( '
		$( $( "div.woocommerce-info, .checkout_coupon" ).detach() ).appendTo( "#hestia-checkout-coupon" );
	');
}

/**
 * Checkout page
 * Add the id hestia-checkout-coupon to be able to Move the coupon fild and message info after the order table
 **/
function hestia_coupon_after_order_table() {
	echo '<div id="hestia-checkout-coupon"></div><div style="clear:both"></div>';
}

/**
 * Function to display sidebar on shop.
 *
 * @since 1.1.24
 * @access public
 */
function hestia_shop_sidebar() {
	$hestia_page_sidebar_layout = get_theme_mod( 'hestia_page_sidebar_layout', 'full-width' );

	$class_to_add = '';
	if ( $hestia_page_sidebar_layout === 'sidebar-right' ) {
		$class_to_add = 'hestia-has-sidebar';
	}

	if ( is_active_sidebar( 'sidebar-woocommerce' ) && ! is_singular( 'product' ) ) { ?>
		<div class="shop-sidebar-wrapper">
			<aside id="secondary" class="col-md-3 shop-sidebar card card-raised <?php echo esc_attr( $class_to_add ); ?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-woocommerce' ); ?>
			</aside><!-- .sidebar .widget-area -->
		</div>
		<?php
	} elseif ( is_customize_preview() && ! is_singular( 'product' ) ) {
		hestia_sidebar_placeholder( $class_to_add );
	}
}

/**
 * Limit products per row when shop have sidebar
 *
 * @since 1.1.24
 * @access public
 * @return int
 */
function hestia_shop_loop_columns() {
	return apply_filters( 'hestia_shop_loop_columns', 3 ); // 3 products per row
}
