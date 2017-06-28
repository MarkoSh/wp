<?php
/**
 * Customizer functionality for Color customizations.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

// include the alpha color picker control class
$color_picker_path = get_template_directory() . '/inc/customizer-alpha-color-picker/class-hestia-customize-alpha-color-control.php';
if ( file_exists( $color_picker_path ) ) {
	require_once( $color_picker_path );
}

/**
 * Hook controls for Color Settings.
 *
 * @since Hestia 1.0
 */
function hestia_colors_customize_register( $wp_customize ) {

	if ( ! class_exists( 'Hestia_Customize_Alpha_Color_Control' ) ) {
		return;
	}

	// Alpha Color Picker setting.
	$wp_customize->add_setting( 'accent_color', array(
			'default'     => '#e91e63',
			'transport'     => 'postMessage',
			'sanitize_callback' => 'hestia_sanitize_colors',
	));

	// Alpha Color Picker control.
	$wp_customize->add_control(	new Hestia_Customize_Alpha_Color_Control( $wp_customize, 'accent_color', array(
				'label'         => esc_html__( 'Accent Color', 'hestia' ),
				'section'       => 'colors',
				'palette'       => false,
	)));
}

add_action( 'customize_register', 'hestia_colors_customize_register' );

/**
 * Adds inline style from customizer
 *
 * @since Hestia 1.0
 */
function hestia_custom_colors_inline_style() {

	$color_accent   = get_theme_mod( 'accent_color', '#e91e63' );

	$custom_css = '';

	if ( ! empty( $color_accent ) ) {

		$custom_css .= '	
a,.hestia-blogs article:nth-child(6n+1) .category a, a:hover, .card-blog a.moretag:hover, .card-blog a.more-link:hover, .widget a:hover, .navbar.navbar-not-transparent li.active a {
    color:' . esc_attr( $color_accent ) . ';
}
           
button,
button:hover,           
input[type="button"],
input[type="button"]:hover,
input[type="submit"],
input[type="submit"]:hover,
input#searchsubmit, 
.pagination span.current, 
.pagination span.current:focus, 
.pagination span.current:hover,
.btn.btn-primary,
.btn.btn-primary:link,
.btn.btn-primary:hover, 
.btn.btn-primary:focus, 
.btn.btn-primary:active, 
.btn.btn-primary.active, 
.btn.btn-primary.active:focus, 
.btn.btn-primary.active:hover,
.btn.btn-primary:active:hover, 
.btn.btn-primary:active:focus, 
.btn.btn-primary:active:hover, 
 
.open > .btn.btn-primary.dropdown-toggle, 
.open > .btn.btn-primary.dropdown-toggle:focus, 
.open > .btn.btn-primary.dropdown-toggle:hover,
.navbar .dropdown-menu li > a:hover, 
.navbar .dropdown-menu li > a:focus, 
.navbar.navbar-default .dropdown-menu li > a:hover, 
.navbar.navbar-default .dropdown-menu li > a:focus,
.label.label-primary,
.hestia-work .portfolio-item:nth-child(6n+1) .label,

.added_to_cart.wc-forward:hover, 
#add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
#add_payment_method .wc-proceed-to-checkout a.checkout-button, 
.added_to_cart.wc-forward, 
.woocommerce-message a.button,
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce ul.products li.product .onsale, 
.woocommerce span.onsale,
.woocommerce .single-product div.product form.cart .button, 
.woocommerce #respond input#submit, 
.woocommerce button.button, 
.woocommerce input.button, 
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button, 
.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt, 
.woocommerce input.button:disabled, 
.woocommerce input.button:disabled[disabled],
.woocommerce a.button.wc-backward:hover, 
.woocommerce a.button.wc-backward, 
.woocommerce .single-product div.product form.cart .button:hover, 
.woocommerce #respond input#submit:hover, 
.woocommerce-message a.button:hover, 
.woocommerce button.button:hover, 
.woocommerce input.button:hover, 
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover, 
.woocommerce #respond input#submit.alt:hover, 
.woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, 
.woocommerce input.button.alt:hover, 
.woocommerce input.button:disabled:hover, 
.woocommerce input.button:disabled[disabled]:hover,
.woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a, 
.woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a:hover,
.woocommerce #respond input#submit.alt.disabled, 
.woocommerce #respond input#submit.alt.disabled:hover, 
.woocommerce #respond input#submit.alt:disabled, 
.woocommerce #respond input#submit.alt:disabled:hover, 
.woocommerce #respond input#submit.alt:disabled[disabled], 
.woocommerce #respond input#submit.alt:disabled[disabled]:hover, 
.woocommerce a.button.alt.disabled, 
.woocommerce a.button.alt.disabled:hover, 
.woocommerce a.button.alt:disabled, 
.woocommerce a.button.alt:disabled:hover, 
.woocommerce a.button.alt:disabled[disabled], 
.woocommerce a.button.alt:disabled[disabled]:hover, 
.woocommerce button.button.alt.disabled, 
.woocommerce button.button.alt.disabled:hover, 
.woocommerce button.button.alt:disabled, 
.woocommerce button.button.alt:disabled:hover, 
.woocommerce button.button.alt:disabled[disabled], 
.woocommerce button.button.alt:disabled[disabled]:hover, 
.woocommerce input.button.alt.disabled, 
.woocommerce input.button.alt.disabled:hover, 
.woocommerce input.button.alt:disabled, 
.woocommerce input.button.alt:disabled:hover, 
.woocommerce input.button.alt:disabled[disabled], 
.woocommerce input.button.alt:disabled[disabled]:hover,
.woocommerce a.button.woocommerce-Button,
#secondary div[id^=woocommerce_price_filter] .price_slider .ui-slider-range,
.footer div[id^=woocommerce_price_filter] .price_slider .ui-slider-range,
div[id^=woocommerce_product_tag_cloud].widget a,
div[id^=woocommerce_widget_cart].widget .buttons .button {
    background-color: ' . esc_attr( $color_accent ) . ';
}

button,
.button,
input[type="submit"], 
input[type="button"], 
.btn.btn-primary,
.added_to_cart.wc-forward, 
.woocommerce .single-product div.product form.cart .button, 
.woocommerce #respond input#submit, 
.woocommerce button.button, 
.woocommerce input.button, 
#add_payment_method .wc-proceed-to-checkout a.checkout-button, 
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button, 
.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt, 
.woocommerce input.button:disabled, 
.woocommerce input.button:disabled[disabled],
.woocommerce-message a.button,
.woocommerce a.button.wc-backward,
.woocommerce div[id^=woocommerce_widget_cart].widget .buttons .button {
    -webkit-box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $color_accent, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $color_accent, '0.12' ) . ';
    box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $color_accent, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $color_accent, '0.12' ) . ';
}

.card .header-primary, .card .content-primary {
    background: ' . esc_attr( $color_accent ) . ';
}';

		// Hover box shadow
		$custom_css .= '
.button:hover,
button:hover,
input[type="submit"]:hover,
input[type="button"]:hover,
input#searchsubmit:hover, 
.pagination span.current, 
.btn.btn-primary:hover, 
.btn.btn-primary:focus, 
.btn.btn-primary:active, 
.btn.btn-primary.active, 
.btn.btn-primary:active:focus, 
.btn.btn-primary:active:hover, 
.woocommerce nav.woocommerce-pagination ul li span.current,
.added_to_cart.wc-forward:hover, 
.woocommerce .single-product div.product form.cart .button:hover, 
.woocommerce #respond input#submit:hover, 
.woocommerce button.button:hover, 
.woocommerce input.button:hover, 
#add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover, 
.woocommerce #respond input#submit.alt:hover, 
.woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, 
.woocommerce input.button.alt:hover, 
.woocommerce input.button:disabled:hover, 
.woocommerce input.button:disabled[disabled]:hover,
.woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a, 
.woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a:hover,
.woocommerce-message a.button:hover,
.woocommerce a.button.wc-backward:hover,
.woocommerce div[id^=woocommerce_widget_cart].widget .buttons .button:hover {
	-webkit-box-shadow: 0 14px 26px -12px' . hestia_hex_rgba( $color_accent, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ';
    box-shadow: 0 14px 26px -12px ' . hestia_hex_rgba( $color_accent, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $color_accent, '0.2' ) . ';
	color: #fff;
}';

		// FORMS UNDERLINE COLOR
		$custom_css .= '
.form-group.is-focused .form-control {
background-image: -webkit-gradient(linear,left top, left bottom,from(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . ')),-webkit-gradient(linear,left top, left bottom,from(#d2d2d2),to(#d2d2d2));
	background-image: -webkit-linear-gradient(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . '),-webkit-linear-gradient(#d2d2d2,#d2d2d2);
	background-image: linear-gradient(' . esc_attr( $color_accent ) . '),to(' . esc_attr( $color_accent ) . '),linear-gradient(#d2d2d2,#d2d2d2);
}

#secondary div[id^=woocommerce_price_filter] .price_slider .ui-slider-handle,
.footer div[id^=woocommerce_price_filter] .price_slider .ui-slider-handle {
	border-color: ' . esc_attr( $color_accent ) . ';
}';

		// Hover Effect for navbar items
		$custom_css .= '
.navbar:not(.navbar-transparent) .navbar-nav > li > a:hover, .navbar:not(.navbar-transparent) .navbar-nav > li.active > a {
	color:' . esc_attr( $color_accent ) . '}';
	}// End if().

	wp_add_inline_style( 'hestia_style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'hestia_custom_colors_inline_style', 10 );

/**
 * HEX colors conversion to RGBA.
 *
 * @return string RGBA string.
 * @since Hestia 1.0
 */
function hestia_hex_rgba( $input, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	// Return default if no color provided
	if ( empty( $input ) ) {
		return $default;
	}

	// Sanitize $color if "#" is provided
	if ( $input[0] == '#' ) {
		$input = substr( $input, 1 );
	}

	// Check if color has 6 or 3 characters and get values
	if ( strlen( $input ) == 6 ) {
		$hex = array( $input[0] . $input[1], $input[2] . $input[3], $input[4] . $input[5] );
	} elseif ( strlen( $input ) == 3 ) {
		$hex = array( $input[0] . $input[0], $input[1] . $input[1], $input[2] . $input[2] );
	} else {
		return $default;
	}

	// Convert hexadeciomal color to rgb(a)
	$rgb = array_map( 'hexdec', $hex );

	// Check for opacity
	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ',',$rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',',$rgb ) . ')';
	}

	// Return rgb(a) color.
	return $output;
}
