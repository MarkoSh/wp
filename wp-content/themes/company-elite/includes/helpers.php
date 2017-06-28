<?php
/**
 * Helper functions.
 *
 * @package Company_Elite
 */

if ( ! function_exists( 'company_elite_get_global_layout_options' ) ) :

	/**
	 * Returns global layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function company_elite_get_global_layout_options() {
		$choices = array(
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'company-elite' ),
			'right-sidebar' => esc_html__( 'Right Sidebar', 'company-elite' ),
			'three-columns' => esc_html__( 'Three Columns', 'company-elite' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'company-elite' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'company_elite_get_site_layout_options' ) ) :

	/**
	 * Returns site layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function company_elite_get_site_layout_options() {
		$choices = array(
			'fluid' => esc_html__( 'Fluid', 'company-elite' ),
			'boxed' => esc_html__( 'Boxed', 'company-elite' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'company_elite_get_breadcrumb_type_options' ) ) :

	/**
	 * Returns breadcrumb type options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function company_elite_get_breadcrumb_type_options() {
		$choices = array(
			'disabled' => esc_html__( 'Disabled', 'company-elite' ),
			'enabled'  => esc_html__( 'Enabled', 'company-elite' ),
		);
		return $choices;
	}

endif;


if ( ! function_exists( 'company_elite_get_archive_layout_options' ) ) :

	/**
	 * Returns archive layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function company_elite_get_archive_layout_options() {
		$choices = array(
			'full'    => esc_html__( 'Full Post', 'company-elite' ),
			'excerpt' => esc_html__( 'Post Excerpt', 'company-elite' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'company_elite_get_image_sizes_options' ) ) :

	/**
	 * Returns image sizes options.
	 *
	 * @since 1.0.0
	 *
	 * @param bool  $add_disable    True for adding No Image option.
	 * @param array $allowed        Allowed image size options.
	 * @param bool  $show_dimension True for showing dimension.
	 * @return array Image size options.
	 */
	function company_elite_get_image_sizes_options( $add_disable = true, $allowed = array(), $show_dimension = true ) {

		global $_wp_additional_image_sizes;

		$choices = array();

		if ( true === $add_disable ) {
			$choices['disable'] = esc_html__( 'No Image', 'company-elite' );
		}

		$choices['thumbnail'] = esc_html__( 'Thumbnail', 'company-elite' );
		$choices['medium']    = esc_html__( 'Medium', 'company-elite' );
		$choices['large']     = esc_html__( 'Large', 'company-elite' );
		$choices['full']      = esc_html__( 'Full (original)', 'company-elite' );

		if ( true === $show_dimension ) {
			foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
				$choices[ $_size ] = $choices[ $_size ] . ' (' . get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
			}
		}

		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key;
				if ( true === $show_dimension ) {
					$choices[ $key ] .= ' (' . $size['width'] . 'x' . $size['height'] . ')';
				}
			}
		}

		if ( ! empty( $allowed ) ) {
			foreach ( $choices as $key => $value ) {
				if ( ! in_array( $key, $allowed, true ) ) {
					unset( $choices[ $key ] );
				}
			}
		}

		return $choices;

	}

endif;

if ( ! function_exists( 'company_elite_get_image_alignment_options' ) ) :

	/**
	 * Returns image options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function company_elite_get_image_alignment_options() {
		$choices = array(
			'none'   => esc_html_x( 'None', 'alignment', 'company-elite' ),
			'left'   => esc_html_x( 'Left', 'alignment', 'company-elite' ),
			'center' => esc_html_x( 'Center', 'alignment', 'company-elite' ),
			'right'  => esc_html_x( 'Right', 'alignment', 'company-elite' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'company_elite_get_featured_slider_transition_effects' ) ) :

	/**
	 * Returns the featured slider transition effects.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function company_elite_get_featured_slider_transition_effects() {
		$choices = array(
			'fade'       => esc_html_x( 'fade', 'transition effect', 'company-elite' ),
			'fadeout'    => esc_html_x( 'fadeout', 'transition effect', 'company-elite' ),
			'none'       => esc_html_x( 'none', 'transition effect', 'company-elite' ),
			'scrollHorz' => esc_html_x( 'scrollHorz', 'transition effect', 'company-elite' ),
		);
		ksort( $choices );
		return $choices;
	}

endif;

if ( ! function_exists( 'company_elite_get_featured_slider_content_options' ) ) :

	/**
	 * Returns the featured slider content options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function company_elite_get_featured_slider_content_options() {
		$choices = array(
			'home-page' => esc_html__( 'Static Front Page', 'company-elite' ),
			'disabled'  => esc_html__( 'Disabled', 'company-elite' ),
		);
		return $choices;
	}

endif;

if ( ! function_exists( 'company_elite_get_featured_slider_type' ) ) :

	/**
	 * Returns the featured slider type.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function company_elite_get_featured_slider_type() {
		$choices = array(
			'featured-page' => esc_html__( 'Featured Pages', 'company-elite' ),
		);
		return $choices;
	}

endif;
