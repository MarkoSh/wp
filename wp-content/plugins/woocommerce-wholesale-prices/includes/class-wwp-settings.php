<?php
/**
 * Woocommerce Wholesale Prices Settings
 *
 * @author      Rymera Web
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WWP_Settings' ) ) {

    class WWP_Settings extends WC_Settings_Page {

        /**
         * Constructor.
         */
        public function __construct() {

            $this->id    = 'wwp_settings';
            $this->label = __( 'Wholesale Prices', 'woocommerce-wholesale-prices' );

            add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 30 ); // 30 so it is after the emails tab
            add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
            add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
            add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );

            add_action( 'woocommerce_admin_field_upsell_banner' , array( $this, 'render_upsell_banner' ) );

            do_action( 'wwp_settings_construct' );

        }

        /**
         * Get sections.
         *
         * @return array
         * @since 1.0.0
         */
        public function get_sections() {

            $generalSettingsSectionTitle = '';

            $sections = array(
                            ''  =>  apply_filters( 'wwp_filter_settings_general_section_title' , $generalSettingsSectionTitle )
                        );

            $sections = apply_filters( 'wwp_filter_settings_sections' , $sections );

            return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );

        }

        /**
         * Output the settings.
         *
         * @since 1.0.0
         */
        public function output() {

            global $current_section;

            $settings = $this->get_settings( $current_section );
            WC_Admin_Settings::output_fields( $settings );

        }

        /**
         * Save settings.
         *
         * @since 1.0.0
         */
        public function save() {

            global $current_section;

            $settings = $this->get_settings( $current_section );

            do_action( 'wwp_before_save_settings' , $settings );

            WC_Admin_Settings::save_fields( $settings );

            do_action( 'wwp_after_save_settings' , $settings );

        }

        /**
         * Get settings array.
         *
         * @param string $current_section
         *
         * @return mixed
         * @since 1.0.0
         */
        public function get_settings( $current_section = '' ) {

            $settings = array();
            $settings = apply_filters( 'wwp_settings_section_content' , $settings, $current_section );

            return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );

        }




        /*
         |--------------------------------------------------------------------------------------------------------------
         | Custom Settings Fields
         |--------------------------------------------------------------------------------------------------------------
         */

        /**
         * Render custom setting field (upsell banner)
         *
         * @param $value
         * @since 1.0.1
         */
        public function render_upsell_banner ( $value ) {

            // Custom attribute handling
            $custom_attributes = array();

            if ( ! empty( $value[ 'custom_attributes' ] ) && is_array( $value[ 'custom_attributes' ] ) ) {
                foreach ( $value[ 'custom_attributes' ] as $attribute => $attribute_value ) {
                    $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
                }
            }

            ob_start();
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <img src="<?php echo WWP_IMAGES_URL ?>woocommerce-wholesale-prices-upgrade-notice.jpg" alt=""/>
                </th>
                <th class="forminp forminp-<?php echo sanitize_title( $value['type'] ); ?>">
                    <a style="display: inline-block; outline: none; margin-bottom: 30px;" target="_blank" href="https://wholesalesuiteplugin.com/product/woocommerce-wholesale-prices-premium/?utm_source=Free%20Plugin&utm_medium=Settings&utm_campaign=Premium%20Upsell"><img src="<?php echo WWP_IMAGES_URL ?>wholesale-suite-upsell-banner.jpg" alt="<?php _e( 'WooCommerce Wholesale Suite' , 'woocommerce-wholesale-prices' ); ?>"/></a>
                    <a style="display: inline-block; outline: none;" target="_blank" href="https://wholesalesuiteplugin.com/?utm_source=Free%20Plugin&utm_medium=Settings&utm_campaign=Suite%20Upsell"><img src="<?php echo WWP_IMAGES_URL ?>wholesale-suite-prices-upsell-banner.jpg" alt="<?php _e( 'WooCommerce Wholesale Prices Premium' , 'woocommerce-wholesale-prices' ); ?>"/></a>
                </th>
            </tr>

            <style>
                p.submit {
                    display: none !important;
                }
            </style>
            <?php
            echo ob_get_clean();

        }

    }

}

return new WWP_Settings();
