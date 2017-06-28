<?php
/**
 * The default template for displaying content
 *
 * Used for pages.
 *
 * @package Hestia
 * @since Hestia 1.0
 */
?>

<?php
$hestia_page_sidebar_layout = get_theme_mod( 'hestia_page_sidebar_layout', 'full-width' );

$args         = array(
	'sidebar-right' => 'col-md-9 page-content-wrap',
	'sidebar-left'  => 'col-md-9 page-content-wrap',
	'full-width'    => 'col-md-8 col-md-offset-2 page-content-wrap',
);
$class_to_add = hestia_get_content_classes( $hestia_page_sidebar_layout, 'sidebar-woocommerce', $args ); ?>

<article id="post-<?php the_ID(); ?>" class="section section-text">
	<div class="row">
		<?php
		if ( $hestia_page_sidebar_layout === 'sidebar-left' ) {
			if ( ( class_exists( 'WooCommerce' ) && ! is_cart() && ! is_checkout() && ! is_account_page() ) || ! class_exists( 'WooCommerce' ) ) {
				get_sidebar( 'woocommerce' );
			}
		}
		?>
		<div class="<?php echo esc_attr( $class_to_add ); ?>">
			<?php the_content(); ?>
		</div>
		<?php
		if ( $hestia_page_sidebar_layout === 'sidebar-right' ) {
			if ( ( class_exists( 'WooCommerce' ) && ! is_cart() && ! is_checkout() && ! is_account_page() ) || ! class_exists( 'WooCommerce' ) ) {
				get_sidebar( 'woocommerce' );
			}
		}
		?>
	</div>
</article>
<div class="section section-blog-info">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="row">
				<div class="col-md-12">
					<?php
					hestia_wp_link_pages( array(
						'before'      => '<div class="text-center"> <ul class="nav pagination pagination-primary">',
						'after'       => '</ul> </div>',
						'link_before' => '<li>',
						'link_after'  => '</li>',
					) );
					?>
				</div>
			</div>
		</div>
	</div>
</div>
