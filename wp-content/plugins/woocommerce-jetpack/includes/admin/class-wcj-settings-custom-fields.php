<?php
/**
 * Booster for WooCommerce - Settings Custom Fields
 *
 * @version 2.8.0
 * @since   2.8.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WCJ_Settings_Custom_Fields' ) ) :

class WCJ_Settings_Custom_Fields {

	/**
	 * Constructor.
	 *
	 * @version 2.8.0
	 * @since   2.8.0
	 */
	function __construct() {
		add_action( 'woocommerce_admin_field_wcj_number_plus_checkbox_start',   array( $this, 'output_wcj_number_plus_checkbox_start' ) );
		add_action( 'woocommerce_admin_field_wcj_number_plus_checkbox_end',     array( $this, 'output_wcj_number_plus_checkbox_end' ) );
		add_filter( 'woocommerce_admin_settings_sanitize_option',               array( $this, 'format_wcj_number_plus_checkbox_end' ), PHP_INT_MAX, 3 );
		add_action( 'woocommerce_admin_field_custom_textarea',                  array( $this, 'output_custom_textarea' ) );
		add_filter( 'woocommerce_admin_settings_sanitize_option',               array( $this, 'unclean_custom_textarea' ), PHP_INT_MAX, 3 );
		add_action( 'woocommerce_admin_field_custom_number',                    array( $this, 'output_custom_number' ) );
		add_action( 'woocommerce_admin_field_custom_link',                      array( $this, 'output_custom_link' ) );
		add_action( 'woocommerce_admin_field_module_tools',                     array( $this, 'output_module_tools' ) );
	}

	/**
	 * format_wcj_number_plus_checkbox_end.
	 *
	 * @version 2.8.0
	 * @since   2.8.0
	 */
	function format_wcj_number_plus_checkbox_end( $value, $option, $raw_value ) {
		return ( 'wcj_number_plus_checkbox_end' === $option['type'] ) ? ( '1' === $raw_value || 'yes' === $raw_value ? 'yes' : 'no' ) : $value;
	}

	/**
	 * output_wcj_number_plus_checkbox_start.
	 *
	 * @version 2.8.0
	 * @since   2.8.0
	 */
	function output_wcj_number_plus_checkbox_start( $value ) {
		// Custom attribute handling
		$custom_attributes = array();
		if ( ! empty( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) {
			foreach ( $value['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}
		// Description handling
		$field_description = WC_Admin_Settings::get_field_description( $value );
		extract( $field_description );
		// Option value
		$option_value = WC_Admin_Settings::get_option( $value['id'], $value['default'] );
		// Output
		?><tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
				<?php echo $tooltip_html; ?>
			</th>
			<td class="forminp forminp-number-checkbox">
				<input
					name="<?php echo esc_attr( $value['id'] ); ?>"
					id="<?php echo esc_attr( $value['id'] ); ?>"
					type="number"
					style="<?php echo esc_attr( $value['css'] ); ?>"
					value="<?php echo esc_attr( $option_value ); ?>"
					class="<?php echo esc_attr( $value['class'] ); ?>"
					placeholder="<?php echo esc_attr( $value['placeholder'] ); ?>"
					<?php echo implode( ' ', $custom_attributes ); ?>
					/> <?php echo $description . ' ';
	}

	/**
	 * output_wcj_number_plus_checkbox_end.
	 *
	 * @version 2.8.0
	 * @since   2.8.0
	 */
	function output_wcj_number_plus_checkbox_end( $value ) {
		// Custom attribute handling
		$custom_attributes = array();
		if ( ! empty( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) {
			foreach ( $value['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}
		// Description handling
		$field_description = WC_Admin_Settings::get_field_description( $value );
		extract( $field_description );
		// Option value
		$option_value = WC_Admin_Settings::get_option( $value['id'], $value['default'] );
		// Output
				?><label for="<?php echo $value['id'] ?>">
					<input
						name="<?php echo esc_attr( $value['id'] ); ?>"
						id="<?php echo esc_attr( $value['id'] ); ?>"
						type="checkbox"
						class="<?php echo esc_attr( isset( $value['class'] ) ? $value['class'] : '' ); ?>"
						value="1"
						<?php checked( $option_value, 'yes' ); ?>
						<?php echo implode( ' ', $custom_attributes ); ?>
					/> <?php echo $description ?>
				</label> <?php echo $tooltip_html; ?>
			</td>
		</tr><?php
	}

	/**
	 * unclean_custom_textarea.
	 *
	 * @version 2.5.7
	 * @since   2.5.7
	 */
	function unclean_custom_textarea( $value, $option, $raw_value ) {
		return ( 'custom_textarea' === $option['type'] ) ? $raw_value : $value;
	}

	/**
	 * output_custom_textarea.
	 *
	 * @version 2.6.0
	 * @since   2.2.6
	 */
	function output_custom_textarea( $value ) {
		$option_value = get_option( $value['id'], $value['default'] );
		$custom_attributes = ( isset( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) ?
			$value['custom_attributes'] : array();
		$description = ' <p class="description">' . $value['desc'] . '</p>';
		$tooltip_html = ( isset( $value['desc_tip'] ) && '' != $value['desc_tip'] ) ?
			'<span class="woocommerce-help-tip" data-tip="' . $value['desc_tip'] . '"></span>' : '';
		// Output
		?><tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
				<?php echo $tooltip_html; ?>
			</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
				<?php echo $description; ?>

				<textarea
					name="<?php echo esc_attr( $value['id'] ); ?>"
					id="<?php echo esc_attr( $value['id'] ); ?>"
					style="<?php echo esc_attr( $value['css'] ); ?>"
					class="<?php echo esc_attr( $value['class'] ); ?>"
					placeholder="<?php echo esc_attr( $value['placeholder'] ); ?>"
					<?php echo implode( ' ', $custom_attributes ); ?>
					><?php echo esc_textarea( $option_value );  ?></textarea>
			</td>
		</tr><?php
	}

	/**
	 * output_module_tools.
	 *
	 * @version 2.7.0
	 * @since   2.2.3
	 */
	function output_module_tools( $value ) {
		?><tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
				<span class="woocommerce-help-tip" data-tip="<?php echo __( 'To use tools, module must be enabled.', 'woocommerce-jetpack' ); ?>"></span>
			</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
				<?php if ( isset( $_GET['section'] ) ) do_action( 'wcj_module_tools_' . $_GET['section'] ); ?>
			</td>
		</tr><?php
	}

	/**
	 * output_custom_link.
	 *
	 * @version 2.7.0
	 * @since   2.2.8
	 */
	function output_custom_link( $value ) {
		$tooltip_html = ( isset( $value['desc_tip'] ) && '' != $value['desc_tip'] ) ?
			'<span class="woocommerce-help-tip" data-tip="' . $value['desc_tip'] . '"></span>' : '';
		?><tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label><?php echo $tooltip_html; ?>
			</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
				<?php echo $value['link']; ?>
			</td>
		</tr><?php
	}

	/**
	 * output_custom_number.
	 *
	 * @version 2.5.5
	 */
	function output_custom_number( $value ) {
		$type         = 'number';
		$option_value = get_option( $value['id'], $value['default'] );
		$tooltip_html = ( isset( $value['desc_tip'] ) && '' != $value['desc_tip'] ) ?
			'<span class="woocommerce-help-tip" data-tip="' . $value['desc_tip'] . '"></span>' : '';
		$description  = ' <span class="description">' . $value['desc'] . '</span>';
		$save_button  = apply_filters( 'booster_get_option', '',
			' <input name="save" class="button-primary" type="submit" value="' . __( 'Save changes', 'woocommerce' ) . '">' );
		// Custom attribute handling
		$custom_attributes = array();
		if ( ! empty( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) {
			foreach ( $value['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}
		// Output
		?><tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
				<?php echo $tooltip_html; ?>
			</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
				<input
					name="<?php echo esc_attr( $value['id'] ); ?>"
					id="<?php echo esc_attr( $value['id'] ); ?>"
					type="<?php echo esc_attr( $type ); ?>"
					style="<?php echo esc_attr( $value['css'] ); ?>"
					value="<?php echo esc_attr( $option_value ); ?>"
					class="<?php echo esc_attr( $value['class'] ); ?>"
					placeholder="<?php echo esc_attr( $value['placeholder'] ); ?>"
					<?php echo implode( ' ', $custom_attributes ); ?>
					/><?php echo $save_button; ?><?php echo $description; ?>
			</td>
		</tr><?php
	}

}

endif;

return new WCJ_Settings_Custom_Fields();
