<?php

if ( !function_exists('hamzahshop_custom_product_search') ):
	
	/**
	 * hamzahshop_custom_product_search.
	 *
	 * @since 1.0.0
	 */
	 
	function hamzahshop_custom_product_search(){	
		?>
		
		  <?php if ( class_exists( 'WooCommerce' ) ) :?>
		  
		<div class="col-lg-6 col-md-6 col-sm-8">
		<div id="search-category">
			<form class="search-box" action="<?php echo esc_url(get_permalink( wc_get_page_id( 'shop' ) )); ?>" method="post">
				<div class="search-categories">
					<div class="search-cat">
					  <?php 
					  $args = array(
					  'taxonomy' => 'product_cat',
					  'orderby' => 'name',
					  'show_count' => '0',
					  'pad_counts' => '0',
					  'hierarchical' => '1',
					  'title_li' => '',
					  'hide_empty' => '0',
					  
					  );
					  $all_categories = get_categories( $args );
					  ?>
	<select class="category-items" name="category">
	<option><?php esc_html_e('All Categories','hamzahshop') ?></option>
	<?php foreach( $all_categories as $category ) { ?>
	<option value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_attr($category->cat_name); ?></option>
	<?php } ?>
	</select>
					</div>
				</div>
			
				 <input type="search" name="s" id="text-search" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_html_e('Search here...','hamzahshop') ?>" />
	
				<button id="btn-search-category" type="submit">
					<i class="icon-search"></i>
				</button>
				<input type="hidden" name="post_type" value="product" />
			</form>
		</div>
	  </div>
	  <?php endif;?>
	  
		<?php
	}
	add_action( 'hamzahshop_custom_product_search', 'hamzahshop_custom_product_search');
endif;




if ( ! function_exists( 'hamzahshop_key_breadcrumb' ) ) :

	/**
	 * Breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function hamzahshop_key_breadcrumb() {
		
		if ( is_front_page() || is_home() ) {
			return;
		}
		if ( ! function_exists( 'breadcrumb_trail' ) ) {
			require_once trailingslashit( get_template_directory() ) . 'vendors/breadcrumbs/breadcrumbs.php';
		}

		$breadcrumb_args = array(
			'container'   => 'div',
			'show_browse' => false,
		);

		breadcrumb_trail( $breadcrumb_args );

	}
add_action( 'hamzahshop_key_action_breadcrumb', 'hamzahshop_key_breadcrumb' );
endif;

if ( !function_exists('hamzahshop_custom_min_cart')):
function hamzahshop_custom_min_cart(){ ?>
<?php if ( class_exists( 'WooCommerce' ) ) :?>
<div class="col-lg-3 col-md-3 col-sm-4">
  <ul class="header-r-cart">
    <li><a class="cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
      <?php echo esc_attr(WC()->cart->get_cart_contents_count()).esc_html_e(' items' ,'hamzahshop') .' - '.WC()->cart->get_cart_total();
	?>
    </a>
    </li>
  </ul>
</div>
<?php endif;?>
<?php }
add_action( 'hamzahshop_custom_min_cart', 'hamzahshop_custom_min_cart' );
endif;




if ( !function_exists('hamzahshop_register_required_plugins') ):
add_action( 'tgmpa_register', 'hamzahshop_register_required_plugins' );

/**
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function hamzahshop_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Subtitles',
			'slug'      => 'subtitles',
			'required'  => false,
		),
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'name'      => 'YITH WooCommerce Brands Add-On',
			'slug'      => 'yith-woocommerce-brands-add-on',
			'required'  => false,
		),
		array(
			'name'      => 'Unlimited Logo Carousel',
			'slug'      => 'unlimited-logo-carousel',
			'required'  => false,
		),
		
		
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'hamzahshop',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}

endif;

