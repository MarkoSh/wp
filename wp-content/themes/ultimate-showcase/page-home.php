<?php
/* Template Name: Homepage */
get_header();

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$pluginSlider = "ultimate-slider/Main.php";
$installedSlider = is_plugin_active($pluginSlider);
$pluginThemeCompanion = "etoile-theme-companion/etoile-theme-companion.php";
$installedThemeCompanion = is_plugin_active($pluginThemeCompanion);
$pluginUPCP = "ultimate-product-catalogue/UPCP_Main.php";
$installedUPCP = is_plugin_active($pluginUPCP);

$Featured_Products = get_option("EWD_UPCP_Theme_Featured_Products");

$Carousel = get_option("EWD_US_Carousel");


if (get_option("EWD_UPCP_Theme_Featured_Products_Label") == "") {$Featured_Products_Label = __("Featured Products", "ultimate-showcase");}
else {$Featured_Products_Label = get_option("EWD_UPCP_Theme_Featured_Products_Label");}
if (get_option("EWD_UPCP_Theme_Testimonials_Label") == "") {$Testimonials_Label = __("Testimonials", "ultimate-showcase");}
else {$Testimonials_Label = get_option("EWD_UPCP_Theme_Testimonials_Label");}
if (get_option("EWD_UPCP_Theme_Full_Catalog_Label") == "") {$Full_Catalog_Label = __("FULL CATALOG", "ultimate-showcase");}
else {$Full_Catalog_Label = get_option("EWD_UPCP_Theme_Full_Catalog_Label");}
?>

<style>
	<?php
	$pageHomeCSS = "";
	$pageHomeCSS .= ".textOnPic .innerText .innerTextTitle { color: " . get_theme_mod( 'upcp_theme_setting_textonpic_text_color' ) . "; }";
	$pageHomeCSS .= ".textOnPic .innerText .innerTextExcerpt { color: " . get_theme_mod( 'upcp_theme_setting_textonpic_text_color' ) . "; }";
	$pageHomeCSS .= ".textOnPic { background: url(" . get_theme_mod( 'upcp_theme_setting_textonpic_background_image' ) . "); }";
	echo esc_attr($pageHomeCSS);
	?>
</style>

		<?php
		$sliderEnable = get_theme_mod( 'upcp_theme_setting_homepage_slider_enable', 'yes' );
		if ($sliderEnable == "yes" && $installedSlider) {
			?>
			<div id="sliderMenuClear"></div>
			<?php
			if(function_exists(EWD_US_Display_Slider)){
				echo EWD_US_Display_Slider(
					array(
						'posts' => 4,
						'static' => get_theme_mod( 'upcp_theme_setting_homepage_slider_static_first' ),
					)
				);
			}
		}
		?>

		<section class="panel">
			<div class="wrapper">
				<div class="container centerText<?php echo ( ( get_theme_mod( 'upcp_theme_setting_homepage_slider_enable' ) == 'no' || ! $installedSlider ) ? ' homeContentNoSlider' : ''); ?>">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<h1><?php the_title(); ?></h1>
						<p class="tagline"><?php the_content(); ?></p>
						<?php wp_link_pages(); ?>
					<?php endwhile; else: ?>
						<p><?php _e('Sorry, but it seems that a homepage hasn\'t been created.', 'ultimate-showcase'); ?></p>
					<?php endif; ?>
					<?php
					$jumpBoxesEnable = get_theme_mod( 'upcp_theme_setting_homepage_jumpboxes_enable', 'yes' );
					if ($jumpBoxesEnable == 'yes' && $installedThemeCompanion) { ?>
						<hr class="starHR" />
						<?php
						if(function_exists(upcp_theme_jumpbox_shortcode)){
							echo upcp_theme_jumpbox_shortcode(
								array(
									'posts' => 3,
								)
							);
						}
						?>
					<?php } ?>
				</div> <!-- container -->
			</div> <!-- wrapper -->
		</section>

		<div class="clear"></div>

		<?php $featuredProdsEnable = get_theme_mod( 'upcp_theme_setting_homepage_featured_enable', 'yes' ); ?>
		<?php if ($featuredProdsEnable == 'yes' && $installedThemeCompanion && $installedUPCP) { ?>
			<section class="panel grayPanel">
				<div class="wrapper">
					<div class="container">
						<h2 class="centerText">
							<?php echo esc_html($Featured_Products_Label); ?>
						</h2>
						<section class="featuredProds" id="homeFeaturedProds">
							<ul class="fourCols">
								<?php
									if (!is_array($Featured_Products)) {$Featured_Products = array();}
									if (class_exists('UPCP_Product')) {
										foreach ($Featured_Products as $Featured_Product) {
											$Product = new UPCP_Product(array('ID' => $Featured_Product['ProductID']));
											$Product_Permalink = $Product->Get_Permalink(get_theme_mod( 'upcp_theme_setting_catalog_url_text' ));
											echo "<li>";
												echo "<img src='" . esc_url( $Product->Get_Field_Value('Item_Photo_URL') ) . "' alt='" . esc_attr( $Product->Get_Product_Name() ) . "' />";
												echo "<a href='" . esc_url($Product_Permalink) . "' class='proLink'>";
													echo "<div class='prodInfo'>";
														echo "<div class='prodTitle'>" . esc_html( substr($Product->Get_Product_Name(), 0, 30) ) . "</div>";
														echo "<div class='prodExcerpt'>" . esc_html( substr(strip_tags($Product->Get_Field_Value('Item_Description')), 0, 60) ) . "</div>";
														echo "<div class='readMore'><i class='fa fa-external-link-square'></i></div>";
													echo "</div>";
												echo "</a>";
											echo "</li>";
										}
									}
								?>
							</ul>
						</section> <!-- featuredProds -->
						<div class="clear"></div>
						<?php
						$CatalogUrlDefault = get_option('EWD_UPCP_Theme_Catalogue_Page_ID');
						$CatalogUrl = get_theme_mod( 'upcp_theme_setting_catalog_url_text', $CatalogUrlDefault );
						?>
						<a href="<?php echo esc_url($CatalogUrl); ?>" class="newButton centerButton"><?php echo esc_html($Full_Catalog_Label); ?></a>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		<?php } ?>

		<div class="clear"></div>

		<?php $textPicEnable = get_theme_mod( 'upcp_theme_setting_textonpic_enable', 'yes' ); ?>
		<?php if($textPicEnable == "yes" && $installedThemeCompanion){ ?>
			<section class="textOnPic">
				<div class="wrapper">
					<div class="container">
						<div class="textOnPicImage">
							<img src="<?php echo esc_url( get_theme_mod( 'upcp_theme_setting_textonpic_overlay_image' ) ); ?>">
						</div>
						<div class="innerText">
							<div class="innerTextTitle"><?php echo esc_html( get_theme_mod( 'upcp_theme_setting_textonpic_heading_text' ) ); ?></div>
							<div class="clear"></div>
							<div class="innerTextExcerpt"><?php echo esc_html( get_theme_mod( 'upcp_theme_setting_textonpic_subheading_text' ) ); ?></div>
							<div class="clear"></div>
							<?php if(get_theme_mod( 'upcp_theme_setting_textonpic_button_text' ) != ''){echo '<a href="' . esc_url( get_theme_mod( 'upcp_theme_setting_textonpic_button_link' ) ) . '" class="newButton whiteButton">' . esc_html( get_theme_mod( 'upcp_theme_setting_textonpic_button_text' ) ) . '</a>'; } ?>
						</div> <!-- innerText -->
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		<?php } ?>

		<div class="clear"></div>

		<?php $testiEnable = get_theme_mod( 'upcp_theme_setting_homepage_testimonials_enable', 'yes' ); ?>
		<?php if($testiEnable == 'yes' && $installedThemeCompanion){ ?>
			<section class="panel">
				<div class="wrapper">
					<div class="container">
						<?php
						if(function_exists(upcp_theme_testimonials_shortcode)){
							echo upcp_theme_testimonials_shortcode(
								array(
									'posts' => 3,
									'title' => esc_html($Testimonials_Label),
								)
							);
						}
						?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		<?php } ?>

		<?php
		$calloutEnable = get_theme_mod( 'upcp_theme_setting_callout_enable', 'yes' );
		if($calloutEnable == "yes" && $installedThemeCompanion){
			if(function_exists(upcp_theme_callout_shortcode)){
				echo upcp_theme_callout_shortcode(
					array(
						'color' => esc_attr( get_theme_mod( 'upcp_theme_setting_callout_background_color' ) ),
						'text_color' => esc_attr( get_theme_mod( 'upcp_theme_setting_callout_text_color' ) ),
						'button_text' => esc_html( get_theme_mod( 'upcp_theme_setting_callout_button_text' ) ),
						'button_link' => esc_url( get_theme_mod( 'upcp_theme_setting_callout_button_link' ) ),
						'subtext' => esc_html( get_theme_mod( 'upcp_theme_setting_callout_subheading_text' ) ),
					),
					esc_html( get_theme_mod( 'upcp_theme_setting_callout_heading_text' ) )
				);
			}
		}
		?>

<?php
get_footer();
