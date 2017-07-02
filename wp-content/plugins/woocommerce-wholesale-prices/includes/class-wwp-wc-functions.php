<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'WWP_WC_Functions' ) ) {

    /**
     * The main purpose of this class is for version compatibility. Specifically for porting woocommerce functions used
     * by this plugin that is not present yet on older versions of woocommerce.
     *
     * @class WWPP_WC_Functions
     */
    class WWP_WC_Functions {

        /**
         * This function isn't present in woocommerce 2.2.x series.
         * Legend:
         * $variableProduct->price = returns the calculated price ( if original price is $10, and sale is $9, this returns $9 )
         * $variableProduct->get_price() = same as above
         * $variableProduct->get_regular_price() = you guessed it, returns original price. In this case it returns $10 instead of $9
         * $variableProduct->get_sale_price() = you guessed it again, returns sale price. Returns $9.
         * $variableProduct->get_display_price() = returns calculated price, with taxing applied. So it returns $9 with tax. ( depending on the settings if tax should be applied or not )
         *
         * @since 1.1.5
         * @param $variationProduct
         * @param string $price
         * @param int $qty
         * @return mixed
         */
        static function get_display_price( $variationProduct , $price = '', $qty = 1 ) {

            if ( $price === '' )
                $price = $variationProduct->get_price();

            $tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
            $display_price    = $tax_display_mode == 'incl' ? $variationProduct->get_price_including_tax( $qty, $price ) : $variationProduct->get_price_excluding_tax( $qty, $price );

            return $display_price;

        }

        /**
         * This function isn't present in WC 2.1.x series.
         *
         * @since 1.1.5
         * @param bool|false $the_product
         * @param array $args
         * @return mixed
         */
        static function wc_get_product( $the_product = false, $args = array() ) {

            return WC()->product_factory->get_product( $the_product, $args );

        }

    }

}
