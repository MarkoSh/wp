<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WWP_Wholesale_Prices {

    private static $_instance;

    public static function getInstance() {

        if( !self::$_instance instanceof self )
            self::$_instance = new self;

        return self::$_instance;

    }

    /**
     * Return product wholesale price for a given wholesale user role.
     *
     * @deprecated
     * @since 1.0.0
     * @param $product_id
     * @param $userWholesaleRole
     * @return string
     */
    public static function getUserProductWholesalePrice( $product_id , $userWholesaleRole ) {

        return self::getProductWholesalePrice( $product_id , $userWholesaleRole );

    }

    /**
     * Return product wholesale price for a given wholesale user role.
     *
     * @param $product_id
     * @param $userWholesaleRole
     * @param $quantity
     *
     * @return string
     * @since 1.0.0
     */
    public static function getProductWholesalePrice( $product_id , $userWholesaleRole , $quantity = 1 ) {

        if ( empty( $userWholesaleRole ) ) {

            return '';

        } else {

            if ( WWP_ACS_Integration_Helper::aelia_currency_switcher_active() ) {

                $baseCurrencyWholesalePrice = $wholesalePrice = get_post_meta( $product_id , $userWholesaleRole[ 0 ] . '_wholesale_price' , true );

                if ( $baseCurrencyWholesalePrice ) {

                    $activeCurrency = get_woocommerce_currency();
                    $baseCurrency   = WWP_ACS_Integration_Helper::get_product_base_currency( $product_id );

                    if ( $activeCurrency == $baseCurrency )
                        $wholesalePrice = $baseCurrencyWholesalePrice; // Base Currency
                    else {

                        $wholesalePrice = get_post_meta( $product_id , $userWholesaleRole[ 0 ] . '_' . $activeCurrency . '_wholesale_price' , true );

                        if ( !$wholesalePrice ) {

                            /*
                             * This specific currency has no explicit wholesale price (Auto). Therefore will need to convert the wholesale price
                             * set on the base currency to this specific currency.
                             *
                             * This is why it is very important users set the wholesale price for the base currency if they want wholesale pricing
                             * to work properly with aelia currency switcher plugin integration.
                             */
                            $wholesalePrice = WWP_ACS_Integration_Helper::convert( $baseCurrencyWholesalePrice , $activeCurrency , $baseCurrency );

                        }

                    }

                    $wholesalePrice = apply_filters( 'wwp_filter_' . $activeCurrency . '_wholesale_price' , $wholesalePrice , $product_id , $userWholesaleRole , $quantity );

                } else
                    $wholesalePrice = ''; // Base currency not set. Ignore the rest of the wholesale price set on other currencies.

            } else
                $wholesalePrice = get_post_meta( $product_id , $userWholesaleRole[ 0 ] . '_wholesale_price' , true );

            return apply_filters( 'wwp_filter_wholesale_price' , $wholesalePrice , $product_id , $userWholesaleRole , $quantity );

        }

    }

    /**
     * Filter callback that alters the product price, it embeds the wholesale price of a product for a wholesale user.
     *
     * @since 1.0.0
     * @since 1.2.8 Now if empty $price then don't bother creating wholesale html price.
     * @access public
     *
     * @param $price
     * @param $product
     * @param $userWholesaleRole
     * @return mixed|string
     */
    public function wholesalePriceHTMLFilter( $price , $product , $userWholesaleRole ) {

        if ( !empty( $userWholesaleRole ) && !empty( $price ) ) {

            $wholesalePrice = '';

            if ( WWP_Helper_Functions::wwp_get_product_type( $product ) === 'simple' ) {

                $wholesalePrice = trim( $this->getProductWholesalePrice( WWP_Helper_Functions::wwp_get_product_id( $product ) , $userWholesaleRole ) );
                $wholesalePrice = apply_filters( 'wwp_filter_wholesale_price_shop' , $wholesalePrice , WWP_Helper_Functions::wwp_get_product_id( $product ) , $userWholesaleRole );

                if ( strcasecmp( $wholesalePrice , '' ) != 0 )
                    $wholesalePrice = WWP_Helper_Functions::wwp_formatted_price( $wholesalePrice ) . apply_filters( 'wwp_filter_wholesale_price_display_suffix' , $product->get_price_suffix() );

            } elseif ( WWP_Helper_Functions::wwp_get_product_type( $product ) === 'variable' ) {

                $variations = $product->get_available_variations();
                $minPrice = '';
                $maxPrice = '';
                $someVariationsHaveWholesalePrice = false;

                foreach ( $variations as $variation ) {

                    if ( !$variation[ 'is_purchasable' ] )
                        continue;

                    $variation             = wc_get_product( $variation[ 'variation_id' ] );
                    $currVarWholesalePrice = trim( $this->getProductWholesalePrice( WWP_Helper_Functions::wwp_get_product_id( $variation ) , $userWholesaleRole ) );
                    $currVarWholesalePrice = apply_filters( 'wwp_filter_wholesale_price_shop' , $currVarWholesalePrice , WWP_Helper_Functions::wwp_get_product_id( $variation ) , $userWholesaleRole );
                    $currVarPrice          = WWP_Helper_Functions::wwp_get_product_display_price( $variation );

                    if ( strcasecmp( $currVarWholesalePrice , '' ) != 0 ) {

                        $currVarPrice = $currVarWholesalePrice;

                        if ( !$someVariationsHaveWholesalePrice )
                            $someVariationsHaveWholesalePrice = true;

                    }

                    if ( strcasecmp( $minPrice , '' ) == 0 || $currVarPrice < $minPrice )
                        $minPrice = $currVarPrice;

                    if ( strcasecmp( $maxPrice , '' ) == 0 || $currVarPrice > $maxPrice )
                        $maxPrice = $currVarPrice;

                }

                // Only alter price html if, some/all variations of this variable product have sale price and
                // min and max price have valid values
                if ( $someVariationsHaveWholesalePrice && strcasecmp( $minPrice , '' ) != 0 && strcasecmp( $maxPrice , '' ) != 0 ) {

                    if ( $minPrice != $maxPrice && $minPrice < $maxPrice )
                        $wholesalePrice = WWP_Helper_Functions::wwp_formatted_price( $minPrice ) . ' - ' . WWP_Helper_Functions::wwp_formatted_price( $maxPrice ) . apply_filters( 'wwp_filter_wholesale_price_display_suffix' , $product->get_price_suffix() );
                    else
                        $wholesalePrice = WWP_Helper_Functions::wwp_formatted_price( $maxPrice ) . apply_filters( 'wwp_filter_wholesale_price_display_suffix' , $product->get_price_suffix() );

                }

                $wholesalePrice = apply_filters( 'wwp_filter_variable_product_wholesale_price_range' , $wholesalePrice , $price , $product , $userWholesaleRole , $minPrice , $maxPrice );

            } elseif ( WWP_Helper_Functions::wwp_get_product_type( $product ) === 'variation' ) {

                $curr_var_wholesale_price = trim( $this->getProductWholesalePrice( WWP_Helper_Functions::wwp_get_product_id( $product ) , $userWholesaleRole ) );
                $curr_var_wholesale_price = apply_filters( 'wwp_filter_wholesale_price_shop' , $curr_var_wholesale_price , WWP_Helper_Functions::wwp_get_product_id( $product ) , $userWholesaleRole );

                if ( strcasecmp( $curr_var_wholesale_price , '' ) != 0 )
                    $wholesalePrice = WWP_Helper_Functions::wwp_formatted_price( $curr_var_wholesale_price ) . apply_filters( 'wwp_filter_wholesale_price_display_suffix' , $product->get_price_suffix() );

            }

            if ( strcasecmp( $wholesalePrice , '' ) != 0 ) {

                $wholesalePriceHTML = apply_filters( 'wwp_product_original_price' , '<del class="original-computed-price">' . $price . '</del>' , $wholesalePrice , $price , $product , $userWholesaleRole );

                $wholesalePriceTitleText = __( 'Wholesale Price:' , 'woocommerce-wholesale-prices' );
                $wholesalePriceTitleText = apply_filters( 'wwp_filter_wholesale_price_title_text' , $wholesalePriceTitleText );

                $wholesalePriceHTML .= '<span style="display: block;" class="wholesale_price_container">
                                            <span class="wholesale_price_title">' . $wholesalePriceTitleText . '</span>
                                            <ins>' . $wholesalePrice . '</ins>
                                        </span>';

                return apply_filters( 'wwp_filter_wholesale_price_html' , $wholesalePriceHTML , $price , $product , $userWholesaleRole , $wholesalePriceTitleText , $wholesalePrice );

            }

        }

        return apply_filters( 'wwp_filter_variable_product_price_range_for_none_wholesale_users' , $price , $product );

    }

    /**
     * Apply wholesale price whenever "get_html_price" function gets called inside a variation product.
     * Variation product is the actual variation of a variable product.
     * Variable product is the parent product which contains variations.
     *
     * @param $price
     * @param $variation
     * @param $userWholesaleRole
     * @return mixed
     *
     * @since 1.0.3
     * @since 1.4.0 This is deprecated. Not used anymore since WC 3.0
     */
    public function wholesaleSingleVariationPriceHTMLFilter ( $price , $variation , $userWholesaleRole ) {

        if ( !empty( $userWholesaleRole ) ) {

            $currVarWholesalePrice = trim( $this->getProductWholesalePrice( WWP_Helper_Functions::wwp_get_product_id( $variation ) , $userWholesaleRole ) );
            $currVarWholesalePrice = apply_filters( 'wwp_filter_wholesale_price_shop' , $currVarWholesalePrice , WWP_Helper_Functions::wwp_get_product_id( $variation ) , $userWholesaleRole );
            $currVarPrice          = WWP_Helper_Functions::wwp_get_product_display_price( $variation );

            if ( strcasecmp( $currVarWholesalePrice , '' ) != 0 )
                $currVarPrice = $currVarWholesalePrice;

            $wholesalePrice = WWP_Helper_Functions::wwp_formatted_price( $currVarPrice ) . apply_filters( 'wwp_filter_wholesale_price_display_suffix' , $variation->get_price_suffix() );

            if ( strcasecmp( $currVarWholesalePrice , '' ) != 0 ) {

                $wholesalePriceHTML = apply_filters( 'wwp_product_original_price' , '<del class="original-computed-price">' . $price . '</del>' , $wholesalePrice , $price , $variation , $userWholesaleRole );

                $wholesalePriceTitleText = __( 'Wholesale Price:' , 'woocommerce-wholesale-prices' );
                $wholesalePriceTitleText = apply_filters( 'wwp_filter_wholesale_price_title_text' , $wholesalePriceTitleText );

                $wholesalePriceHTML .= '<span style="display: block;" class="wholesale_price_container">
                                            <span class="wholesale_price_title">' . $wholesalePriceTitleText . '</span>
                                            <ins>' . $wholesalePrice . '</ins>
                                        </span>';

                return apply_filters( 'wwp_filter_wholesale_price_html' , $wholesalePriceHTML , $price , $variation , $userWholesaleRole , $wholesalePriceTitleText , $wholesalePrice );

            } else {

                // If wholesale price is empty (""), means that this product has no wholesale price set
                // Just return the regular price
                return $price;

            }

        } else {

            // If $userWholeSaleRole is an empty array, meaning current user is not a wholesale customer,
            // just return original $price html
            return $price;

        }

    }

    /**
     * Apply product wholesale price upon adding to cart.
     *
     * @since 1.0.0
     * @since 1.2.3 Add filter hook 'wwp_filter_get_custom_product_type_wholesale_price' for which extensions can attach and add support for custom product types.
     * @since 1.4.0 Add filter hook 'wwp_wholesale_requirements_not_passed' for which extensions can attach and do something whenever wholesale requirement is not meet.
     * @access public
     *
     * @param $cart_object
     * @param $userWholesaleRole
     */
    public function applyProductWholesalePrice( $cart_object , $userWholesaleRole ) {

        $apply_wholesale_price = $this->checkIfApplyWholesalePrice( $cart_object , $userWholesaleRole );

        if ( !empty( $userWholesaleRole ) && $apply_wholesale_price === true ) {

            foreach ( $cart_object->cart_contents as $cart_item_key => $value ) {

                $apply_wholesale_price_product_level = $this->checkIfApplyWholesalePricePerProductLevel( $value , $cart_object , $userWholesaleRole );

                if ( $apply_wholesale_price_product_level === true ) {

                    $wholesalePrice = '';

                    if ( WWP_Helper_Functions::wwp_get_product_type( $value[ 'data' ]) === 'simple' ) {

                        $wholesalePrice = trim( $this->getProductWholesalePrice( WWP_Helper_Functions::wwp_get_product_id( $value[ 'data' ] ) , $userWholesaleRole ) );
                        $wholesalePrice = apply_filters( 'wwp_filter_wholesale_price_cart' , $wholesalePrice , WWP_Helper_Functions::wwp_get_product_id( $value[ 'data' ] ) , $userWholesaleRole , $value );

                    } elseif ( WWP_Helper_Functions::wwp_get_product_type( $value[ 'data' ]) === 'variation' ) {

                        $wholesalePrice = trim( $this->getProductWholesalePrice( WWP_Helper_Functions::wwp_get_product_id( $value[ 'data' ] ) , $userWholesaleRole ) );
                        $wholesalePrice = apply_filters( 'wwp_filter_wholesale_price_cart' , $wholesalePrice , WWP_Helper_Functions::wwp_get_product_id( $value[ 'data' ] ) , $userWholesaleRole , $value );

                    } else
                        $wholesalePrice = apply_filters( 'wwp_filter_get_custom_product_type_wholesale_price' , $wholesalePrice , $value , $userWholesaleRole );

                    if ( strcasecmp ( $wholesalePrice , '' ) != 0 ) {

                        do_action( 'wwp_action_before_apply_wholesale_price' , $wholesalePrice );
                        $value['data']->set_price( WWP_Helper_Functions::wwp_wpml_price( $wholesalePrice ) );

                        $wwp_data = array(
                            'wholesale_priced' => 'yes',
                            'wholesale_role'   => $userWholesaleRole[0]
                        );

                    } else {

                        $wwp_data = array(
                            'wholesale_priced' => 'no',
                            'wholesale_role'   => $userWholesaleRole[0]
                        );

                    }

                    // Add additional wwp data to cart item
                    $value[ 'data' ]->wwp_data = apply_filters( 'wwp_add_cart_item_meta' , $wwp_data );

                } else {

                    do_action( 'wwp_wholesale_requirements_not_passed' , $apply_wholesale_price_product_level , $userWholesaleRole );

                    if ( ( is_cart() || is_checkout() ) && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) )
                        $this->printWCNotice( $apply_wholesale_price_product_level );

                }

            }

        } else {

            do_action( 'wwp_wholesale_requirements_not_passed' , $apply_wholesale_price , $userWholesaleRole );

            if ( ( is_cart() || is_checkout() ) && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) )
                $this->printWCNotice( $apply_wholesale_price );

        }

    }

    /**
     * Add notice to WC Widget if the user (wholesale user) fails to avail the wholesale price requirements.
     * Only applies to wholesale users.
     *
     * @param $userWholesaleRole
     *
     * @since 1.0.0
     */
    public function beforeWCWidget( $userWholesaleRole ) {

        // We have to explicitly call this.
        // You see, WC Widget uses get_sub_total() to for its total field displayed on the widget.
        // This function gets only synced once calculate_totals() is triggered.
        // calculate_totals() is only triggered on the cart and checkout page.
        // So if we don't trigger calculate_totals() manually, there will be a scenario where the cart widget total isn't
        // synced with the cart page total. The user will have to go to the cart page, which triggers calculate_totals,
        // which synced get_sub_total(), for the user to have the cart widget synced the price.
        WC()->cart->calculate_totals();

        $applyWholesalePrice = $this->checkIfApplyWholesalePrice( WC()->cart , $userWholesaleRole );

        // Only display notice if user is a wholesale user.
        if ( !empty( $userWholesaleRole ) && $applyWholesalePrice === true ) {

            foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {

                $apply_wholesale_price_product_level = $this->checkIfApplyWholesalePricePerProductLevel( $values , WC()->cart , $userWholesaleRole );

                if ( $apply_wholesale_price_product_level !== true )
                    $this->printWCNotice( $apply_wholesale_price_product_level );

            }

        } else
            $this->printWCNotice( $applyWholesalePrice );

    }

    /**
     * Apply wholesale price on WC Cart Widget.
     *
     * @since 1.0.0
     * @since 1.2.4 Add filter hook 'wwp_filter_get_custom_product_type_wholesale_price' for which extensions can attach and add support for custom product types.
     * @access public
     *
     * @param $product_price
     * @param $cart_item
     * @param $cart_item_key
     * @param $userWholesaleRole
     * @return mixed
     */
    public function applyProductWholesalePriceOnDefaultWCCartWidget( $product_price , $cart_item , $cart_item_key ,  $userWholesaleRole ) {

        $apply_wholesale_price = $this->checkIfApplyWholesalePrice( WC()->cart , $userWholesaleRole );

        if ( !empty( $userWholesaleRole ) && $apply_wholesale_price === true ) {

            $apply_wholesale_price_product_level = $this->checkIfApplyWholesalePricePerProductLevel( $cart_item , WC()->cart , $userWholesaleRole );

            if ( $apply_wholesale_price_product_level === true ) {

                $wholesalePrice = '';

                if ( WWP_Helper_Functions::wwp_get_product_type( $cart_item[ 'data' ] ) === 'simple' ) {

                    $wholesalePrice = trim( $this->getProductWholesalePrice( WWP_Helper_Functions::wwp_get_product_id( $cart_item[ 'data' ] ) , $userWholesaleRole ) );
                    $wholesalePrice = apply_filters( 'wwp_filter_wholesale_price_cart' , $wholesalePrice , WWP_Helper_Functions::wwp_get_product_id( $cart_item[ 'data' ] ) , $userWholesaleRole , $cart_item );

                } elseif ( WWP_Helper_Functions::wwp_get_product_type( $cart_item[ 'data' ] ) === 'variation' ) {

                    $wholesalePrice = trim( $this->getProductWholesalePrice( WWP_Helper_Functions::wwp_get_product_id( $cart_item[ 'data' ] ) , $userWholesaleRole ) );
                    $wholesalePrice = apply_filters( 'wwp_filter_wholesale_price_cart' , $wholesalePrice , WWP_Helper_Functions::wwp_get_product_id( $cart_item[ 'data' ] ) , $userWholesaleRole , $cart_item );

                } else
                    $wholesalePrice = apply_filters( 'wwp_filter_get_custom_product_type_wholesale_price' , $wholesalePrice , $cart_item , $userWholesaleRole );

                if ( strcasecmp( $wholesalePrice , '' ) != 0 ) {

                    do_action( 'wwp_action_before_apply_wholesale_price' , $wholesalePrice );
                    return WWP_Helper_Functions::wwp_formatted_price( $wholesalePrice );

                }

            }

        }

        return $product_price;

    }

    /**
     * Check if we are good to apply wholesale price. Returns boolean true if we are ok to apply it.
     * Else returns an array of error message.
     *
     * @param $cart_object
     * @param $userWholesaleRole
     * @return bool
     *
     * @since 1.0.0
     */
    public function checkIfApplyWholesalePrice( $cart_object , $userWholesaleRole ) {

        $apply_wholesale_price = true;
        $apply_wholesale_price = apply_filters( 'wwp_filter_apply_wholesale_price_flag' , $apply_wholesale_price , $cart_object , $userWholesaleRole );
        return $apply_wholesale_price;

    }

    /**
     * Check if we are good to apply wholesale price per product basis.
     *
     * @param $value
     * @param $cart_object
     * @param $userWholesaleRole
     * @return bool
     *
     * @since 1.0.7
     */
    public function checkIfApplyWholesalePricePerProductLevel( $value , $cart_object , $userWholesaleRole ) {

        $apply_wholesale_price = true;
        $apply_wholesale_price = apply_filters( 'wwp_filter_apply_wholesale_price_per_product_basis' , $apply_wholesale_price , $value , $cart_object , $userWholesaleRole );
        return $apply_wholesale_price;

    }

    /**
     * Print WP Notices.
     *
     * @param $notices
     *
     * @since 1.0.7
     */
    public function printWCNotice( $notices ) {

        if ( is_array( $notices ) && array_key_exists( 'message' , $notices ) && array_key_exists( 'type' , $notices ) ) {
            // Pre Version 1.2.0 of wwpp where it sends back single dimension array of notice

            wc_print_notice( $notices[ 'message' ] , $notices[ 'type' ] );

        } elseif ( is_array( $notices ) ) {
            // Version 1.2.0 of wwpp where it sends back multiple notice via multi dimensional arrays

            foreach ( $notices as $notice ) {

                if ( array_key_exists( 'message' , $notice ) && array_key_exists( 'type' , $notice ) )
                    wc_print_notice( $notice[ 'message' ] , $notice[ 'type' ] );

            }

        }

    }

    /**
     * Add notice to wc notice queue.
     * Not used, might be useful in the future.
     *
     * @param $notices
     *
     * @since 1.1.4
     */
    public function addWCNotice( $notices ) {

        if ( is_array( $notices ) && array_key_exists( 'message' , $notices ) && array_key_exists( 'type' , $notices ) ) {
            // Pre Version 1.2.0 of wwpp where it sends back single dimension array of notice

            if ( !wc_has_notice( $notices[ 'message' ] , $notices[ 'type' ] ) )
                wc_add_notice( $notices[ 'message' ] , $notices[ 'type' ] );

        } elseif ( is_array( $notices ) ) {
            // Version 1.2.0 of wwpp where it sends back multiple notice via multi dimensional arrays

            foreach ( $notices as $notice ) {

                if ( array_key_exists( 'message' , $notice ) && array_key_exists( 'type' , $notice ) && !wc_has_notice( $notice[ 'message' ] , $notice[ 'type' ] ) )
                    wc_add_notice( $notice[ 'message' ] , $notice[ 'type' ] );

            }

        }

    }

}
