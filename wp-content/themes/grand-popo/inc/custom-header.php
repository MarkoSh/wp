<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
 *
 *
 * @package Grand-Popo
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses grand_popo_header_style()
 */
function grand_popo_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'grand_popo_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 2000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'grand_popo_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'grand_popo_custom_header_setup' );

if ( ! function_exists( 'grand_popo_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see grand_popo_custom_header_setup().
 */
function grand_popo_header_style() {
	$header_text_color = get_header_textcolor();
	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
	if ( get_theme_support('custom-header','default-text-color')== $header_text_color ) {
		return;
	}
        if ( 'blank' == $header_text_color ) :
            $custom_css=".site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}";
        else:
            $custom_css=".site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}";
        endif;
        wp_add_inline_style( 'custom-style', $custom_css );
	// If we get this far, we have custom styles. Let's do this.
	
}
endif; // grand_popo_header_style