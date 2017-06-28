<?php /* Header */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$pluginUPCP = "ultimate-product-catalogue/UPCP_Main.php";
$installedUPCP = is_plugin_active($pluginUPCP);

$Catalog_Page_ID = get_option("EWD_UPCP_Theme_Catalogue_Page_ID");
$Catalog_Page_Link = get_permalink($Catalog_Page_ID);
$Logo_Pic = get_option("EWD_UPCP_Theme_Logo_Pic");

if (get_option("EWD_UPCP_Theme_Search_Catalog_Label") == "") {$Search_Catalog_Label = __("SEARCH CATALOG", "ultimate-showcase");}
else {$Search_Catalog_Label = get_option("EWD_UPCP_Theme_Search_Catalog_Label");}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, user-scalable=false,">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div id="toTopButton"></div>

		<nav id="mobileMenu"<?php echo ( is_admin_bar_showing() ? ' class="headerAdminBarClear"' : '' ) ?>>
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		</nav>

		<header id="header"<?php echo ( is_admin_bar_showing() ? ' class="headerAdminBarClear"' : '' ) ?>>
			<div class="wrapper">
				<div class="container">
					<?php
					if ( function_exists('the_custom_logo') ){
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$custom_logo_image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						$theLogoURL = $custom_logo_image[0];
					}
					else{
						$theLogoURL = get_header_image();
					}
					if($theLogoURL != ''){
						?>
						<a href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo esc_url($theLogoURL); ?>" id="logo"></a>
						<?php
					}
					else{
						$theSiteTitle = get_bloginfo('name');
						$theSiteTagline = get_bloginfo('description');
						?>
						<div id="logoTitleAndDescription">
							<div id="logoTitle">
								<a href="<?php echo esc_url( home_url('/') ); ?>"><?php echo esc_html($theSiteTitle); ?></a>
							</div>
							<div class="clear"></div>
							<div id="logoDescription">
								<?php echo esc_html($theSiteTitle); ?>
							</div>
						</div>
						<?php
					}
					if($installedUPCP){
						$CatalogUrlDefault = get_option('EWD_UPCP_Theme_Catalogue_Page_ID');
						$CatalogUrl = get_theme_mod( 'upcp_theme_setting_catalog_url_text', $CatalogUrlDefault );
						?>
						<form id="headerSearch" method="post" action="<?php echo esc_url($CatalogUrl); ?>">
							<input type="text" name="prod_name" id="headerSearchCatalog" placeholder="<?php echo esc_attr($Search_Catalog_Label); ?>">
						</form>
					<?php } ?>
					<nav id="menu">
						<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
					</nav>
					<div id="menuBars"><i class="fa fa-bars"></i></div>
				</div> <!-- container -->
			</div> <!-- wrapper -->
		</header>

		<div class="clear"></div>
