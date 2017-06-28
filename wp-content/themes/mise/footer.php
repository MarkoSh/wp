<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mise
 */

?>

	</div><!-- #content -->
	<?php $showSearchButton = mise_options('_search_button', '1');
	if ($showSearchButton) : ?>
		<!-- Start: Search Form -->
		<div class="opacityBoxSearch"></div>
		<div class="search-container">
			<?php get_search_form(); ?>
		</div>
		<!-- End: Search Form -->
	<?php endif; ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="mainFooter">
			<div class="miseFooterWidget">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<aside id="footer-1" class="widget-area footer" role="complementary">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</aside><!-- #footer-1 -->
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<aside id="footer-2" class="widget-area footer" role="complementary">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</aside><!-- #footer-2 -->
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<aside id="footer-3" class="widget-area footer" role="complementary">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</aside><!-- #footer-3 -->
				<?php endif; ?>
			</div>
			<div class="miseFooterInfo">
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'mise' ) ); ?>">
					<?php
					/* translators: %s: WordPress name */
					printf( esc_html__( 'Proudly powered by %s', 'mise' ), 'WordPress' );
					?>
					</a>
					<span class="sep"> | </span>
					<?php
					/* translators: 1: theme name, 2: theme developer */
					printf( esc_html__( 'Theme: %1$s by %2$s.', 'mise' ), '<a target="_blank" href="https://crestaproject.com/downloads/mise/" rel="nofollow" title="Mise Theme">Mise Light</a>', 'CrestaProject' );
					?>
				</div><!-- .site-info -->
				<?php 
				$showInFooter =  mise_options('_social_footer', '1');
				if ($showInFooter == 1) {
					mise_show_social_network('footer');
				} ?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
<a href="#top" id="toTop"><i class="fa fa-angle-up fa-lg"></i></a>
<?php wp_footer(); ?>

</body>
</html>
