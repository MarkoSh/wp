<?php if ( ! defined( 'ABSPATH' ) )exit; // Exit if accessed directly

class WWP_Custom_Fields {

    private static $_instance;

    public static function getInstance() {

        if( !self::$_instance instanceof self )
            self::$_instance = new self;

        return self::$_instance;

    }




    /*
     |------------------------------------------------------------------------------------------------------------------
     | Variable Product Custom Bulk Action ( Single Product Page )
     |------------------------------------------------------------------------------------------------------------------
     */

    /**
     * Add variation custom bulk action options.
     *
     * @since 1.2.3
     * @access public
     * @param $registeredCustomRoles
     */
    public function addVariationCustomBulkActionOptions( $registeredCustomRoles ) {

        ob_start(); ?>

        <optgroup label="<?php esc_attr_e( 'Wholesale', 'woocommerce-wholesale-prices' ); ?>">

            <?php foreach ( $registeredCustomRoles as $roleKey => $role ) { ?>
                <option value="<?php echo $roleKey; ?>_wholesale_price"><?php echo sprintf( __( 'Set wholesale prices (%1$s)', 'woocommerce-wholesale-prices' ) , $role[ 'roleName' ] ); ?></option>
            <?php } ?>

            <?php do_action( 'wwp_custom_variation_bulk_action_options' , $registeredCustomRoles ); ?>

        </optgroup>

        <?php echo ob_get_clean();

    }

    /**
     * Execute variation custom bulk actions.
     *
     * @since 1.2.3
     * @access public
     *
     * @param $bulk_action
     * @param $data
     * @param $product_id
     * @param $variations
     * @param $registeredCustomRoles
     */
    public function executeVariationCustomBulkActions( $bulk_action , $data , $product_id , $variations , $registeredCustomRoles ) {

        if ( strpos( $bulk_action , '_wholesale_price' ) !== false ) {

            if ( is_array( $variations ) && isset( $data[ 'value' ] ) ) {

                $wholesale_role     = str_replace( '_wholesale_price' , '' , $bulk_action );
                $wholesale_role_arr = array( $wholesale_role => $registeredCustomRoles[ $wholesale_role ] );

                $variationIds    = array();
                $wholesalePrices = array();

                foreach ( $variations as $variationId ) {
                    $variationIds[]    = $variationId;
                    $wholesalePrices[] = $data[ 'value' ];
                }

                $this->saveVariableProductCustomFields( $product_id , $wholesale_role_arr , $variationIds , $wholesalePrices );

            }

        }

    }




    /**
     * Add wholesale custom price field to single product edit page.
     *
     * @since 1.0.0
     * @since 1.2.0 Add Aelia Currency Switcher Plugin Integratio
     *
     * @param $registeredCustomRoles
     */
    public function addSimpleProductCustomFields( $registeredCustomRoles ) {

        global $woocommerce, $post;

        if ( WWP_ACS_Integration_Helper::aelia_currency_switcher_active() ) {

            echo '<div class="options_group" style="border-top: 1px solid #EEEEEE;">';
            echo '<h3 style="padding-bottom: 10px;">' . __( 'Wholesale Prices' , 'woocommerce-wholesale-prices' ) . '</h3>';
            echo '<p style="margin:0; padding:0 12px; line-height: 16px; font-style: italic; font-size: 13px;">' . __( 'Wholesale prices are set per role and currency.<br/><br/><b>Note:</b> Wholesale price must be set for the base currency to enable wholesale pricing for that role. The base currency will be used for conversion to other currencies that have no wholesale price explicitly set (Auto).' , 'woocommerce-wholesale-prices') . '</p>';
            echo '<div class="wholesale-price-per-role-and-country-accordion">';

            // Get all woocommerce currencies
            $woocommerceCurrencies = get_woocommerce_currencies();

            // Get all active currencies
            $wacsEnabledCurrencies  = WWP_ACS_Integration_Helper::enabled_currencies();

            // Get base currency. Product base currency ( if present ) or shop base currency.
            $baseCurrency = WWP_ACS_Integration_Helper::get_product_base_currency( $post->ID );

            foreach ( $registeredCustomRoles as $roleKey => $role ) {

                echo "<h4>" . $role[ 'roleName' ] . "</h4>";
                echo "<div class='section-container'>";

                // Always put the base currency on top of the list

                // Get base currency wholesale price
                $wholesalePrice = get_post_meta( $post->ID , $roleKey . '_wholesale_price' , true );

                // Get base currency currency symbol
                $currencySymbol = get_woocommerce_currency_symbol( $baseCurrency );
                if ( array_key_exists( 'currency_symbol' , $role ) && !empty( $role[ 'currency_symbol' ] ) )
                    $currencySymbol = $role[ 'currency_symbol' ];

                $fieldID    = $roleKey . '_wholesale_price';
                $fieldLabel = $woocommerceCurrencies[ $baseCurrency ] . " (" . $currencySymbol . ") <em><b>Base Currency</b></em>";
                $fieldDesc  = sprintf( __( 'Only applies to users with the role of %1$s for %2$s currency' , 'woocommerce-wholesale-prices' ) , $role[ 'roleName' ] , $woocommerceCurrencies[ $baseCurrency ] . ' (' . $currencySymbol . ')' );

                $this->_renderProductWholesalePriceField( $fieldID , $fieldLabel , $fieldDesc , $wholesalePrice );

                foreach( $wacsEnabledCurrencies as $currencyCode ) {

                    if ( $currencyCode == $baseCurrency )
                        continue; // Base currency already processed above

                    $currencySymbol = get_woocommerce_currency_symbol( $currencyCode );

                    $wholesalePriceForSpecificCurrency = get_post_meta( $post->ID , $roleKey . '_' . $currencyCode . '_wholesale_price' , true );

                    $fieldID    = $roleKey . '_' . $currencyCode . '_wholesale_price';
                    $fieldLabel = $woocommerceCurrencies[ $currencyCode ] . " (" . $currencySymbol . ")";
                    $fieldDesc  = sprintf( __( 'Only applies to users with the role of %1$s for %2$s currency' , 'woocommerce-wholesale-prices' ) , $role[ 'roleName' ] , $woocommerceCurrencies[ $currencyCode ] . ' (' . $currencySymbol . ')' );

                    $this->_renderProductWholesalePriceField( $fieldID , $fieldLabel , $fieldDesc , $wholesalePriceForSpecificCurrency , 'Auto' );

                }

                echo "</div><!-- .section-contianer -->";

            }

            echo '</div><!--.wholesale-price-per-role-and-country-accordion-->';
            echo '</div><!--.options_group-->';

        } else {

            echo '<div class="options_group">';
            echo '<h3 style="padding-bottom: 10px;">' . __( 'Wholesale Prices' , 'woocommerce-wholesale-prices' ) . '</h3>';
            echo '<p style="margin:0; padding:0 12px; line-height: 16px; font-style: italic; font-size: 13px;">' . __( 'Wholesale Price for this product' , 'woocommerce-wholesale-prices') . '</p>';

            foreach ( $registeredCustomRoles as $roleKey => $role ) {

                $wholesalePrice = get_post_meta( $post->ID , $roleKey . '_wholesale_price' , true );

                $currencySymbol = get_woocommerce_currency_symbol();
                if ( array_key_exists( 'currency_symbol' , $role ) && !empty( $role[ 'currency_symbol' ] ) )
                    $currencySymbol = $role[ 'currency_symbol' ];

                $fieldID    = $roleKey . '_wholesale_price';
                $fieldLabel = $role[ 'roleName' ] . " (" . $currencySymbol . ")";
                $fieldDesc  = sprintf( __( 'Only applies to users with the role of %1$s' , 'woocommerce-wholesale-prices' ) , $role[ 'roleName' ] );

                $this->_renderProductWholesalePriceField( $fieldID , $fieldLabel , $fieldDesc , $wholesalePrice );

            }

            echo '</div><!--.options_group-->';

        }

    }

    /**
     * Add wholesale custom price field to variable product edit page (on the variations section).
     *
     * @since 1.0.0
     * @since 1.2.0 Add integration with Aelia Currency Switcher Plugin
     *
     * @param $loop
     * @param $variation_data
     * @param $variation
     * @param $registeredCustomRoles
     */
    public function addVariableProductCustomFields( $loop , $variation_data , $variation , $registeredCustomRoles ) {

        global $woocommerce, $post;

        // Get the variable product data manually
        // Don't rely on the variation data woocommerce supplied
        // There is a logic change introduced on 2.3 series where they only send variation data (or variation meta)
        // That is built in to woocommerce, so all custom variation meta added to a variable product don't get passed along
        $variable_product_meta = get_post_meta( $variation->ID );

        if ( WWP_ACS_Integration_Helper::aelia_currency_switcher_active() ) { ?>

            <tr>
                <td colspan="2">
                    <?php
                    echo '<hr>';
                    echo '<h4 style="margin:0; padding: 0 0 10px 0; font-size:14px;">' . __( 'Wholesale Prices' , 'woocommerce-wholesale-prices' ) . '</h4>';
                    echo '<p style="margin:0; padding:0; line-height: 16px; font-style: italic; font-size: 13px;">' . __( 'Wholesale prices are set per role and currency.<br/><br/><b>Note:</b> Wholesale price must be set for the base currency to enable wholesale pricing for that role. The base currency will be used for conversion to other currencies that have no wholesale price explicitly set (Auto).' , 'woocommerce-wholesale-prices' ) . '</p>';
                    ?>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="wholesale-price-per-role-and-country-accordion">

                        <?php // Get all woocommerce currencies
                        $woocommerceCurrencies = get_woocommerce_currencies();

                        // Get all active currencies
                        $wacsEnabledCurrencies  = WWP_ACS_Integration_Helper::enabled_currencies();

                        // Get base currency. Product base currency ( if present ) or shop base currency
                        $baseCurrency = WWP_ACS_Integration_Helper::get_product_base_currency( $variation->ID );

                        foreach( $registeredCustomRoles as $roleKey => $role ) {

                            echo "<h4>" . $role[ 'roleName' ] . "</h4>";
                            echo "<div class='section-container'>";

                            // Always put the base currency on top of the list

                            // Get base currency wholesale price
                            $wholesalePrice = isset( $variable_product_meta[ $roleKey . '_wholesale_price' ][ 0 ] ) ? $variable_product_meta[ $roleKey . '_wholesale_price' ][ 0 ] : '';

                            // Get base currency currency symbol
                            $currencySymbol = get_woocommerce_currency_symbol( $baseCurrency );
                            if ( array_key_exists( 'currency_symbol' , $role ) && !empty( $role[ 'currency_symbol' ] ) )
                                $currencySymbol = $role[ 'currency_symbol' ];

                            $fieldID    = $roleKey . '_wholesale_prices[' . $loop . ']';
                            $fieldLabel = $woocommerceCurrencies[ $baseCurrency ] . " (" . $currencySymbol . ") <em><b>Base Currency</b></em>";
                            $fieldDesc  = sprintf( __( 'Only applies to users with the role of %1$s for %2$s currency' , 'woocommerce-wholesale-prices' ) , $role[ 'roleName' ] , $woocommerceCurrencies[ $baseCurrency ] . " (" . $currencySymbol . ")" ); ?>

                            <tr>
                                <td colspan="2">
                                    <?php $this->_renderProductWholesalePriceField( $fieldID , $fieldLabel , $fieldDesc , $wholesalePrice ); ?>
                                </td>
                            </tr>

                            <?php foreach( $wacsEnabledCurrencies as $currencyCode ) {

                                if ( $currencyCode == $baseCurrency )
                                    continue; // Base currency already processed above

                                $currencySymbol = get_woocommerce_currency_symbol( $currencyCode );

                                $wholesalePriceForSpecificCurrency = isset( $variable_product_meta[ $roleKey . '_' . $currencyCode . '_wholesale_price' ][ 0 ] ) ? $variable_product_meta[ $roleKey . '_' . $currencyCode . '_wholesale_price' ][ 0 ] : '';

                                $fieldID    = $roleKey . '_' . $currencyCode . '_wholesale_prices[' . $loop . ']';;
                                $fieldLabel = $woocommerceCurrencies[ $currencyCode ] . " (" . $currencySymbol . ")";
                                $fieldDesc  = sprintf( __( 'Only applies to users with the role of %1$s for %2$s currency' , 'woocommerce-wholesale-prices' ) , $role[ 'roleName' ] , $woocommerceCurrencies[ $currencyCode ] . " (" . $currencySymbol . ")" ); ?>

                                <tr>
                                    <td colspan="2">
                                        <?php $this->_renderProductWholesalePriceField( $fieldID , $fieldLabel , $fieldDesc , $wholesalePriceForSpecificCurrency , 'Auto' ); ?>
                                    </td>
                                </tr>

                            <?php }

                            echo "</div><!-- .section-contianer -->";

                        } ?>

                    </div><!--.wholesale-price-per-role-and-country-accordion-->
                </td>
            </tr>

        <?php } else { ?>

            <tr>
                <td colspan="2">
                    <?php
                    echo '<hr>';
                    echo '<h4 style="margin:0; padding: 0 0 10px 0; font-size:14px;">' . __( 'Wholesale Prices' , 'woocommerce-wholesale-prices' ) . '</h4>';
                    echo '<p style="margin:0; padding:0; line-height: 16px; font-style: italic; font-size: 13px;">' . __( 'Wholesale Price for this product' , 'woocommerce-wholesale-prices' ) . '</p>';
                    ?>
                </td>
            </tr>

            <?php foreach ( $registeredCustomRoles as $roleKey => $role ) {

                $currencySymbol = get_woocommerce_currency_symbol();
                if( array_key_exists( 'currency_symbol' , $role ) && !empty( $role[ 'currency_symbol' ] ) )
                    $currencySymbol = $role[ 'currency_symbol' ]; ?>

                <tr>
                    <td colspan="2">
                        <?php
                        $fieldID    = $roleKey . '_wholesale_prices[' . $loop . ']';
                        $fieldLabel = $role[ 'roleName' ] . " (" . $currencySymbol . ")";
                        $fieldDesc  = sprintf( __( 'Only applies to users with the role of %1$s' , 'woocommerce-wholesale-prices' ) , $role[ 'roleName' ] );
                        $fieldValue = isset( $variable_product_meta[ $roleKey . '_wholesale_price' ][ 0 ] ) ? $variable_product_meta[ $roleKey . '_wholesale_price' ][ 0 ] : '';

                        $this->_renderProductWholesalePriceField( $fieldID , $fieldLabel , $fieldDesc , $fieldValue );
                        ?>
                    </td>
                </tr>

            <?php }

        }

    }

    /**
     * Render product wholesale price custom field.
     *
     * @since 1.2.0
     *
     * @param $fieldID Field Id
     * @param string $fieldLabel Field Label
     * @param string $fieldDesc Field Description
     * @param $fieldValue Field Value
     * @param string $fieldPlaceHolder Field Placeholder Text
     */
    private function _renderProductWholesalePriceField($fieldID , $fieldLabel , $fieldDesc , $fieldValue , $fieldPlaceHolder = '' ) {

        woocommerce_wp_text_input(
            array(
                'id'            =>  $fieldID,
                'label'         =>  $fieldLabel,
                'placeholder'   =>  $fieldPlaceHolder,
                'desc_tip'      =>  'true',
                'description'   =>  $fieldDesc,
                'data_type'     =>  'price',
                'value'         =>  $fieldValue ? $fieldValue : ''
            )
        );

    }

    /**
     * Add wholesale price column to the product listing page.
     *
     * @param $columns
     * @return array
     *
     * @since 1.0.1
     */
    public function addWholesalePriceListingColumn ( $columns ) {

        $allKeys = array_keys( $columns );
        $priceIndex = array_search( 'price' , $allKeys);

        $newColumnsArray = array_slice( $columns , 0 , $priceIndex + 1 , true ) +
            array( 'wholesale_price' => 'Wholesale Price' ) +
            array_slice( $columns , $priceIndex + 1 , NULL , true );

        return $newColumnsArray;

    }

    /**
     * Add wholesale price column data for each product on the product listing page
     *
     * @param $column
     * @param $post_id
     * @param $registeredCustomRoles
     *
     * @since 1.0.1
     */
    public function addWholesalePriceListingColumnData ( $column , $post_id , $registeredCustomRoles ) {

        switch ( $column ) {
            case 'wholesale_price': ?>

                <div class="wholesale_prices" id="wholesale_prices_<?php echo $post_id; ?>">

                    <?php

                    if ( function_exists( 'wc_get_product' ) )
                        $product = wc_get_product( $post_id );
                    else
                        $product = WWP_WC_Functions::wc_get_product( $post_id );

                    $aeliaCurrencySwitcherPluginActive = WWP_ACS_Integration_Helper::aelia_currency_switcher_active();

                    // Shop base currency
                    $shopBaseCurrency = WWP_ACS_Integration_Helper::shop_base_currency();

                    foreach ( $registeredCustomRoles as $roleKey => $role ) {

                        $wholesalePrice = "";

                        if ( $product->product_type == 'simple' ) {

                            $wholesalePrice = get_post_meta( $post_id , $roleKey . '_wholesale_price' , true );

                            if ( $aeliaCurrencySwitcherPluginActive ) {

                                if ( $wholesalePrice ) {

                                    // get product base currency
                                    $productBaseCurrency = WWP_ACS_Integration_Helper::get_product_base_currency( $post_id );

                                    // if shop base currency is different from product base currency
                                    if ( $productBaseCurrency != $shopBaseCurrency ) {

                                        // convert wholesale price from product base currency to shop base currency
                                        $wholesalePrice = WWP_ACS_Integration_Helper::convert( $wholesalePrice , $shopBaseCurrency , $productBaseCurrency );

                                    }

                                    $wholesalePrice = wc_price( $wholesalePrice );

                                }

                            } else {

                                if ( $wholesalePrice )
                                    $wholesalePrice = wc_price( $wholesalePrice );

                            }

                        } elseif ( $product->product_type == 'variable' ) {

                            $variations = $product->get_available_variations();
                            $minPrice = '';
                            $maxPrice = '';
                            $someVariationsHaveWholesalePrice = false;

                            foreach( $variations as $variation ) {

                                if ( function_exists( 'wc_get_product' ) )
                                    $variation = wc_get_product( $variation[ 'variation_id' ] );
                                else
                                    $variation = WWP_WC_Functions::wc_get_product( $variation[ 'variation_id' ] );

                                $currVarWholesalePrice = get_post_meta( $variation->variation_id , $roleKey . '_wholesale_price' , true );

                                if ( method_exists( $variation , 'get_display_price' ) )
                                    $currVarPrice = $variation->get_display_price();
                                else
                                    $currVarPrice = WWP_WC_Functions::get_display_price( $variation );

                                if ( strcasecmp( $currVarWholesalePrice , '' ) != 0 ) {

                                    $currVarPrice = $currVarWholesalePrice;

                                    if( !$someVariationsHaveWholesalePrice )
                                        $someVariationsHaveWholesalePrice = true;

                                    if ( $aeliaCurrencySwitcherPluginActive ) {

                                        // get product base currency
                                        $productBaseCurrency = WWP_ACS_Integration_Helper::get_product_base_currency( $variation->variation_id );

                                        // if shop base currency is different from product base currency
                                        if ( $productBaseCurrency != $shopBaseCurrency ) {

                                            // convert wholesale price from product base currency to shop base currency
                                            $currVarPrice = WWP_ACS_Integration_Helper::convert( $currVarPrice , $shopBaseCurrency , $productBaseCurrency );

                                        }

                                    }

                                }

                                if( strcasecmp( $minPrice , '' ) == 0 || $currVarPrice < $minPrice )
                                    $minPrice = $currVarPrice;

                                if( strcasecmp( $maxPrice , '' ) == 0 || $currVarPrice > $maxPrice )
                                    $maxPrice = $currVarPrice;

                            }

                            if ( $someVariationsHaveWholesalePrice && strcasecmp( $minPrice , '' ) != 0 && strcasecmp( $maxPrice , '' ) != 0 ) {

                                if ( $minPrice != $maxPrice && $minPrice < $maxPrice )
                                    $wholesalePrice = wc_price( $minPrice ) . ' - ' . wc_price( $maxPrice );
                                else
                                    $wholesalePrice = wc_price( $maxPrice );

                            }

                        } else
                            continue; ?>

                        <div id="<?php echo $roleKey; ?>_wholesale_price" class="wholesale_price">
                            <?php // Print the wholesale price
                            if ( !empty( $wholesalePrice ) )
                                echo '<div class="wholesale_role">' . $role[ 'roleName' ] . '</div>' . $wholesalePrice;
                            ?>
                        </div>

                <?php } // foreach ( $registeredCustomRoles as $roleKey => $role ) ?>

                </div>
                <?php

                break;

            default :
                break;
        }

    }

    /**
     * Save wholesale custom price field on simple products.
     *
     * @since 1.0.0
     * @since 1.2.0 Add Aelia Currency Switcher Plugin Integration
     *
     * @param $postId
     * @param $registeredCustomRoles
     */
    public function saveSimpleProductCustomFields ( $postId , $registeredCustomRoles ) {

        $thousandSep = get_option( 'woocommerce_price_thousand_sep' );
        $decimalSep = get_option( 'woocommerce_price_decimal_sep' );

        $aeliaCurrencySwitcherActive = WWP_ACS_Integration_Helper::aelia_currency_switcher_active();

        if ( $aeliaCurrencySwitcherActive ) {

            // Get all active currencies
            $wacsEnabledCurrencies = WWP_ACS_Integration_Helper::enabled_currencies();

            // Get base currency. Product base currency ( if present ) or shop base currency
            $baseCurrency = WWP_ACS_Integration_Helper::get_product_base_currency( $postId );

            foreach ( $registeredCustomRoles as $roleKey => $role ) {

                foreach( $wacsEnabledCurrencies as $currencyCode ) {

                    if ( $currencyCode == $baseCurrency ) {

                        // Base currency
                        $wholesalePriceKey    = $roleKey . '_wholesale_price';
                        $isBaseCurrency = true;

                    } else {

                        $wholesalePriceKey    = $roleKey . '_' . $currencyCode . '_wholesale_price';
                        $isBaseCurrency = false;

                    }

                    $hasWholesalePriceKey = $roleKey . '_have_wholesale_price';

                    $this->_saveSimpleProductWholesalePrice( $postId , $roleKey , $wholesalePriceKey , $hasWholesalePriceKey , $thousandSep , $decimalSep , $aeliaCurrencySwitcherActive , $isBaseCurrency , $currencyCode );

                }

            }

        } else {

            foreach ( $registeredCustomRoles as $roleKey => $role ) {

                $wholesalePriceKey    = $roleKey . '_wholesale_price';
                $hasWholesalePriceKey = $roleKey . '_have_wholesale_price';

                $this->_saveSimpleProductWholesalePrice( $postId , $roleKey , $wholesalePriceKey , $hasWholesalePriceKey , $thousandSep , $decimalSep );

            }

        }

    }

    /**
     * Save simple product wholesale price.
     *
     * @since 1.2.0
     *
     * @param $postId
     * @param $roleKey
     * @param $wholesalePriceKey
     * @param $hasWholesalePriceKey
     * @param $thousandSep
     * @param $decimalSep
     * @param bool|false $aeliaCurrencySwitcherActive
     * @param bool|false $baseCurrency
     * @param null $currencyCode
     */
    private function _saveSimpleProductWholesalePrice( $postId , $roleKey , $wholesalePriceKey , $hasWholesalePriceKey , $thousandSep , $decimalSep , $aeliaCurrencySwitcherActive = false , $baseCurrency = false , $currencyCode = null ) {

        /*
         * Sanitize and properly format wholesale price.
         * (This also supports comma as decimal separator currency format).
         */
        $wholesalePrice = trim( esc_attr( $_POST[ $wholesalePriceKey ] ) );

        if ( $thousandSep )
            $wholesalePrice = str_replace( $thousandSep , '' , $wholesalePrice );

        if ( $decimalSep )
            $wholesalePrice = str_replace( $decimalSep , '.' , $wholesalePrice );

        if ( !empty( $wholesalePrice ) ) {

            if( !is_numeric( $wholesalePrice ) )
                $wholesalePrice = '';
            elseif ( $wholesalePrice < 0 )
                $wholesalePrice = 0;
            else
                $wholesalePrice = wc_format_decimal( $wholesalePrice );

        }

        if ( $aeliaCurrencySwitcherActive )
            $wholesalePrice = wc_clean( apply_filters( 'wwp_filter_before_save_simple_product_' . $currencyCode . '_wholesale_price' , $wholesalePrice , $roleKey , $postId ) );
        else // Deprecated filter. Will be remove in future releases.
            $wholesalePrice = wc_clean( apply_filters( 'wwp_filter_before_save_wholesale_price' , $wholesalePrice , $roleKey , $postId , 'simple' ) );

        $wholesalePrice = wc_clean( apply_filters( 'wwp_filter_before_save_simple_product_wholesale_price' , $wholesalePrice , $roleKey , $postId ) );

        update_post_meta( $postId , $wholesalePriceKey , $wholesalePrice );

        // WWPP-147 : Delete the meta that is set when setting discount on per product category level
        delete_post_meta( $postId , $roleKey . '_have_wholesale_price_set_by_product_cat' );

        // Mark current simple product if having wholesale price or not
        if ( is_numeric( $wholesalePrice ) && $wholesalePrice > 0 ) {

            if ( $aeliaCurrencySwitcherActive ) {

                // Only base currency custom wholesale price field has the power to determine if a product has wholesale price or not.
                // Coz if wholesale price is not set for base currency, then even if user set wholesale pricing for other currencies
                // then it will not matter. The product is still considered to not having wholesale price.
                if ( $baseCurrency )
                    update_post_meta( $postId , $hasWholesalePriceKey , 'yes' );

            } else
                update_post_meta( $postId , $hasWholesalePriceKey , 'yes' );

        } else {

            update_post_meta( $postId , $hasWholesalePriceKey , 'no' );

            // Only Do this when WWPP is active. This is a WWPP feature ( Per category level discount )
            if ( in_array( 'woocommerce-wholesale-prices-premium/woocommerce-wholesale-prices-premium.bootstrap.php' , apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

                $terms = get_the_terms( $postId , 'product_cat' );
                if ( !is_array( $terms ) )
                    $terms = array();

                foreach ( $terms as $term ) {

                    $category_wholesale_prices = get_option( 'taxonomy_' . $term->term_id );

                    if ( is_array( $category_wholesale_prices ) && array_key_exists( $roleKey . '_wholesale_discount' , $category_wholesale_prices ) ) {

                        $curr_discount = $category_wholesale_prices[ $roleKey . '_wholesale_discount' ];

                        if ( !empty( $curr_discount ) ) {

                            update_post_meta( $postId , $hasWholesalePriceKey , 'yes' );

                            // Add additional meta to indicate that have wholesale price meta was set by the category
                            update_post_meta( $postId , $roleKey . '_have_wholesale_price_set_by_product_cat' , 'yes' );

                            break;

                        }

                    }

                }

            }

        }

    }

    /**
     * Save wholesale custom price field on variable products.
     * Since WooCommerce 2.4.x series, they introduced a new button "Save Changes" on the variation tab of a variable product.
     * This allows you to save the variations itself even if the main variable product isn't saved yet.
     *
     * @since 1.0.0
     * @since 1.2.0 Add Aelia Currency Switcher Plugin Integration
     * @since 1.2.3 Add support for custom variations bulk actions
     *
     * @param $postId
     * @param $registeredCustomRoles
     * @param null $variationIds
     * @param null $variationWholesalePrices
     */
    public function saveVariableProductCustomFields( $postId , $registeredCustomRoles , $variationIds = null , $variationWholesalePrices = null ) {

        global $_POST;

        if ( ( !is_null( $variationIds ) && !is_null( $variationWholesalePrices ) ) || ( isset( $_POST[ 'variable_post_id' ] ) && $_POST[ 'variable_post_id' ] ) ) {

            // We delete this meta in the beginning coz we are using add_post_meta, not update_post_meta below
            // If we don't delete this, the values will be stacked with the old values
            // Note: per role
            foreach( $registeredCustomRoles as $roleKey => $role )
                delete_post_meta( $postId , $roleKey . '_variations_with_wholesale_price' );

            $variablePostId = !is_null( $variationIds ) ? $variationIds : $_POST[ 'variable_post_id' ];

            $maxLoop = max( array_keys( $variablePostId ) );

            $thousandSep = get_option( 'woocommerce_price_thousand_sep' );
            $decimalSep = get_option( 'woocommerce_price_decimal_sep' );

            $aeliaCurrencySwitcherActive = WWP_ACS_Integration_Helper::aelia_currency_switcher_active();

            if ( $aeliaCurrencySwitcherActive ) {

                // Get all active currencies
                $wacsEnabledCurrencies = WWP_ACS_Integration_Helper::enabled_currencies();

                foreach( $registeredCustomRoles as $roleKey => $role ) {

                    foreach( $wacsEnabledCurrencies as $currencyCode ) {

                        for ( $i = 0; $i <= $maxLoop; $i++ ) {

                            if ( !isset( $variablePostId[ $i ] ) )
                                continue;

                            $variationId = (int) $variablePostId[ $i ];

                            // Get base currency. Product base currency ( if present ) or shop base currency.
                            // Note for the variation, note for the parent variable product
                            $baseCurrency = WWP_ACS_Integration_Helper::get_product_base_currency( $variationId );

                            if ( $currencyCode == $baseCurrency ) {

                                // Base Currency
                                $wholesalePrices   = !is_null( $variationWholesalePrices ) ? $variationWholesalePrices :  $_POST[ $roleKey . '_wholesale_prices' ];
                                $wholesalePriceKey = $roleKey . '_wholesale_price';
                                $isBaseCurrency    = true;

                            } else {

                                $wholesalePrices   = !is_null( $variationWholesalePrices ) ? $variationWholesalePrices :  $_POST[ $roleKey . '_' . $currencyCode . '_wholesale_prices' ];
                                $wholesalePriceKey = $roleKey . '_' . $currencyCode . '_wholesale_price';
                                $isBaseCurrency    = false;

                            }

                            if ( isset( $wholesalePrices[ $i ] ) )
                                $this->_saveVariableProductWholesalePrice( $postId , $variationId , $roleKey , $wholesalePrices[ $i ] , $wholesalePriceKey , $thousandSep , $decimalSep , $aeliaCurrencySwitcherActive , $isBaseCurrency , $currencyCode );

                        }

                    }

                }

            } else {

                foreach( $registeredCustomRoles as $roleKey => $role ) {

                    $wholesalePrices = !is_null( $variationWholesalePrices ) ? $variationWholesalePrices : $_POST[ $roleKey . '_wholesale_prices' ];
                    $wholesalePriceKey = $roleKey . '_wholesale_price';

                    for ( $i = 0; $i <= $maxLoop; $i++ ) {

                        if ( !isset( $variablePostId[ $i ] ) )
                            continue;

                        $variationId = (int) $variablePostId[ $i ];

                        if ( isset( $wholesalePrices[ $i ] ) )
                            $this->_saveVariableProductWholesalePrice( $postId , $variationId , $roleKey , $wholesalePrices[ $i ] , $wholesalePriceKey , $thousandSep , $decimalSep );

                    }

                }

            } // if ( $aeliaCurrencySwitcherActive ) else

            // Mark parent variable product if having wholesale price or not
            foreach( $registeredCustomRoles as $roleKey => $role ) {

                $postMeta = get_post_meta( $postId , $roleKey . '_variations_with_wholesale_price' );

                // WWPP-147 : Delete the meta that is set when setting discount on per product category level
                delete_post_meta( $postId , $roleKey . '_have_wholesale_price_set_by_product_cat' );

                if ( !empty( $postMeta ) )
                    update_post_meta( $postId , $roleKey . '_have_wholesale_price' , 'yes' );
                else {

                    update_post_meta( $postId , $roleKey . '_have_wholesale_price' , 'no' );

                    // Only Do this when WWPP is active. This is a WWPP feature ( Per category level discount )
                    if ( in_array( 'woocommerce-wholesale-prices-premium/woocommerce-wholesale-prices-premium.bootstrap.php' , apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

                        $terms = get_the_terms( $postId , 'product_cat' );
                        if ( !is_array( $terms ) )
                            $terms = array();

                        foreach ( $terms as $term ) {

                            $category_wholesale_prices = get_option( 'taxonomy_' . $term->term_id );

                            if ( is_array( $category_wholesale_prices ) && array_key_exists( $roleKey . '_wholesale_discount' , $category_wholesale_prices ) ) {

                                $curr_discount = $category_wholesale_prices[ $roleKey . '_wholesale_discount' ];

                                if ( !empty( $curr_discount ) ) {

                                    update_post_meta( $postId , $roleKey . '_have_wholesale_price' , 'yes' );

                                    // Add additional meta to indicate that have wholesale price meta was set by the category
                                    update_post_meta( $postId , $roleKey . '_have_wholesale_price_set_by_product_cat' , 'yes' );

                                    break;

                                }

                            }

                        }

                    }

                }

            }

            /*
             * The logic here is that we also check those variations that are not currently listed on the current page
             * WC 2.4.x series introduce variations pagination, now if we don't check those other variations that are not listed
             * currently coz they are on a different page, what will happen is we will only add on the $roleKey . '_variations_with_wholesale_price'
             * meta the variations that are currently listed on the current page.
             */
            if ( function_exists( 'wc_get_product' ) )
                $mainVariableProduct = wc_get_product( $postId );
            else
                $mainVariableProduct = WWP_WC_Functions::wc_get_product( $postId );

            // Get other variations that are not currently displayed coz they are on another page
            $otherPageVariations = array_diff( $mainVariableProduct->get_children() , $variablePostId );

            if ( !empty( $otherPageVariations ) ) {

                foreach ( $registeredCustomRoles as $roleKey => $role ) {

                    foreach ( $otherPageVariations as $variationId ) {

                        /*
                         * Code below on determining if other paged variations have wholesale pricing is already covers case
                         * if Aelia currency converter plugin is active. When Aelia plugin is active, we only need to check if wholesale price
                         * is set for the base currency to conclude that this variation have a wholesale price. Which the
                         * code below is already doing.
                         */

                        $wholesale_price = get_post_meta( $variationId , $roleKey . '_wholesale_price' , true );

                        if ( is_numeric( $wholesale_price ) && $wholesale_price > 0 ) {

                            add_post_meta( $postId , $roleKey . '_variations_with_wholesale_price' , $variationId );
                            update_post_meta( $postId , $roleKey . '_have_wholesale_price' , 'yes' );

                        }

                    }

                }

            }

        } // if ( isset( $_POST[ 'variable_post_id' ] ) && $_POST[ 'variable_post_id' ] )

    }

    /**
     * Save variable product wholesale price.
     *
     * @since 1.2.0
     *
     * @param $variableId
     * @param $variationId
     * @param $roleKey
     * @param $wholesalePrice
     * @param $wholesalePriceKey
     * @param $thousandSep
     * @param $decimalSep
     * @param bool|false $aeliaCurrencySwitcherActive
     * @param bool|false $baseCurrency
     * @param null $currencyCode
     */
    private function _saveVariableProductWholesalePrice( $variableId , $variationId , $roleKey , $wholesalePrice , $wholesalePriceKey , $thousandSep , $decimalSep , $aeliaCurrencySwitcherActive = false , $baseCurrency = false , $currencyCode = null ) {

        /*
         * Sanitize and properly format wholesale price.
         * (This also supports comma as decimal separator currency format).
         */
        $wholesalePrice = trim( esc_attr( $wholesalePrice ) );

        if ( $thousandSep )
            $wholesalePrice = str_replace( $thousandSep , '' ,  $wholesalePrice );

        if ( $decimalSep )
            $wholesalePrice = str_replace( $decimalSep , '.' ,  $wholesalePrice );

        if ( !empty( $wholesalePrice ) ) {

            if ( !is_numeric( $wholesalePrice ) )
                $wholesalePrice = '';
            elseif ( $wholesalePrice < 0 )
                $wholesalePrice = 0;
            else
                $wholesalePrice = wc_format_decimal( $wholesalePrice );

        }

        /*
         * If it has valid wholesale price, attached current variation id to parent product (variable)
         * $roleKey . '_variations_with_wholesale_price' post meta. This meta of the parent variable product
         * will be used later to determine if the parent variable product has wholesale price or not.
         */
        if ( $aeliaCurrencySwitcherActive ) {

            $wholesalePrice = wc_clean( apply_filters( 'wwp_filter_before_save_variation_product_' . $currencyCode . '_wholesale_price' , $wholesalePrice , $roleKey , $variationId , $variableId ) );

            /*
             * Only add current variation id to parent variable product $roleKey . '_variations_with_wholesale_price' meta
             * if this is the base currency. You see due to how Aelia Currency Switcher works, base currency is very important.
             * Therefore only base currency wholesale price is used to determine if variation has wholesale price or not.
             */
            if ( $baseCurrency )
                if ( is_numeric( $wholesalePrice ) && $wholesalePrice > 0 )
                    add_post_meta( $variableId , $roleKey . '_variations_with_wholesale_price' , $variationId );

        } else {

            // Deprecated filter. Will be remove in future releases.
            $wholesalePrice = wc_clean( apply_filters( 'wwp_filter_before_save_wholesale_price' , $wholesalePrice , $roleKey , $variationId , 'variation' ) );

            if ( is_numeric( $wholesalePrice ) && $wholesalePrice > 0 )
                add_post_meta( $variableId , $roleKey . '_variations_with_wholesale_price' , $variationId );

        }

        $wholesalePrice = wc_clean( apply_filters( 'wwp_filter_before_save_variation_product_wholesale_price' , $wholesalePrice , $roleKey , $variationId , $variableId ) );

        update_post_meta( $variationId , $wholesalePriceKey , $wholesalePrice );

    }

    /**
     * Add wholesale custom form fields on the quick edit option.
     *
     * @since 1.0.0
     * @since 1.2.0 Add Aelia Currency Switcher Plugin Integration
     *
     * @param $registeredCustomRoles
     */
    public function addCustomWholesaleFieldsOnQuickEditScreen( $registeredCustomRoles ) {
        ?>

        <div class="quick_edit_wholesale_prices" style="float: none; clear: both; display: block;">
            <div style="height: 1px;"></div><!--To Prevent Heading From Bumping Up-->
            <h4><?php _e( 'Wholesale Price', 'woocommerce-wholesale-prices' ); ?></h4>

            <?php if ( WWP_ACS_Integration_Helper::aelia_currency_switcher_active() ) {

                // Get all woocommerce currencies
                $woocommerceCurrencies = get_woocommerce_currencies();

                // Get all active currencies
                $wacsEnabledCurrencies  = WWP_ACS_Integration_Helper::enabled_currencies();

                /*
                 * Here since we don't have access to post id, well just spit out all wholesale price key with currency code.
                 * We will just determine later dynamically via js which one is the base currency.
                 */

                echo '<div class="wholesale-price-per-role-and-country-accordion">';

                foreach ( $registeredCustomRoles as $roleKey => $role ) {

                    echo '<h4>' . $role[ 'roleName' ] . '</h4>';
                    echo "<div class='section-container'>";

                    foreach ( $wacsEnabledCurrencies as $currencyCode ) {

                        $currencySymbol = get_woocommerce_currency_symbol( $currencyCode );
                        $fieldTitle = $woocommerceCurrencies[ $currencyCode ] . ' (' . $currencySymbol . ')';
                        $fieldName = $roleKey . '_' . $currencyCode . '_wholesale_price';

                        $this->_addCustomWholesalePriceFieldOnQuickEditScreen( $fieldTitle , $fieldName , "Auto" );

                    }

                    echo "</div><!--.section-container-->";

                }

                echo '</div><!--.wholesale-price-per-role-and-country-accordion-->';

            } else {

                foreach ( $registeredCustomRoles as $roleKey => $role ) {

                    $currencySymbol = get_woocommerce_currency_symbol();
                    if( array_key_exists( 'currency_symbol' , $role ) && !empty( $role[ 'currency_symbol' ] ) )
                        $currencySymbol = $role['currency_symbol'];

                    $fieldTitle = sprintf( __( '%1$s Price (%2$s)' , 'woocommerce-wholesale-prices' ) , $role[ 'roleName' ] , $currencySymbol );
                    $fieldName  = $roleKey . '_wholesale_price';

                    $this->_addCustomWholesalePriceFieldOnQuickEditScreen( $fieldTitle , $fieldName );

                }

            } ?>

            <div style="clear: both; float: none; display: block;"></div>
        </div>

    <?php

    }

    /**
     * Print custom wholesale price field on quick edit screen.
     *
     * @since 1.2.0
     *
     * @param $fieldTitle
     * @param $fieldName
     * @param string $placeHolder
     */
    private function _addCustomWholesalePriceFieldOnQuickEditScreen( $fieldTitle , $fieldName , $placeHolder = "" ) {
        ?>

        <label class="alignleft" style="width: 100%;">
            <div class="title"><?php echo $fieldTitle; ?></div>
            <input type="text" name="<?php echo $fieldName; ?>" class="text wholesale_price wc_input_price" placeholder="<?php echo $placeHolder; ?>" value="">
        </label>

        <?php
    }

    /**
     * Save wholesale custom fields on the quick edit option.
     *
     * @since 1.0.0
     * @since 1.2.0 Add Aelia Currency Switcher Plugin Integration
     *
     * @param $product
     * @param $registeredCustomRoles
     */
    public function saveCustomWholesaleFieldsOnQuickEditScreen( $product , $registeredCustomRoles ) {

        if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {

            $aeliaCurrencySwitcherActive = WWP_ACS_Integration_Helper::aelia_currency_switcher_active();

            $postId = $product->id;

            $thousandSep = get_option( 'woocommerce_price_thousand_sep' );
            $decimalSep = get_option( 'woocommerce_price_decimal_sep' );

            if ( $aeliaCurrencySwitcherActive ) {

                // Get all active currencies
                $wacsEnabledCurrencies  = WWP_ACS_Integration_Helper::enabled_currencies();

                // Get base currency. Product base currency ( if present ) or shop base currency
                $baseCurrency = WWP_ACS_Integration_Helper::get_product_base_currency( $postId );

                foreach ( $registeredCustomRoles as $roleKey => $role ) {

                    foreach ( $wacsEnabledCurrencies as $currencyCode ) {

                        if ( $currencyCode == $baseCurrency ) {

                            // Base Currency
                            $wholesalePriceKey = $roleKey . '_wholesale_price';
                            $isBaseCurrency = true;

                        } else {

                            $wholesalePriceKey = $roleKey . '_' . $currencyCode . '_wholesale_price';
                            $isBaseCurrency = false;

                        }

                        if ( isset( $_REQUEST[ $wholesalePriceKey ] ) ) {

                            $hasWholesalePriceKey = $roleKey . '_have_wholesale_price';

                            $this->_saveSimpleProductWholesalePrice( $postId , $roleKey , $wholesalePriceKey , $hasWholesalePriceKey , $thousandSep , $decimalSep , $aeliaCurrencySwitcherActive , $isBaseCurrency , $currencyCode );

                        }

                    }

                }

            } else {

                foreach ( $registeredCustomRoles as $roleKey => $role ) {

                    $wholesalePriceKey = $roleKey . '_wholesale_price';

                    if ( isset( $_REQUEST[ $wholesalePriceKey ] ) ) {

                        $hasWholesalePriceKey = $roleKey . '_have_wholesale_price';

                        $this->_saveSimpleProductWholesalePrice( $postId , $roleKey , $wholesalePriceKey , $hasWholesalePriceKey , $thousandSep , $decimalSep );

                    }

                }

            }

        }

    }

    /**
     * Add wholesale custom fields meta data on the product listing columns, this metadata is used to pre-populate the
     * wholesale custom form fields with the values of the meta data saved on the db.
     * This works in conjunction with wwp-quick-edit.js.
     *
     * @since 1.0.0
     * @since 1.2.0 Add Aelia Currency Switcher Plugin Integration
     *
     * @param $column
     * @param $post_id
     * @param $registeredCustomRoles
     */
    public function addCustomWholesaleFieldsMetaDataOnProductListingColumn( $column , $post_id , $registeredCustomRoles ) {

        switch ( $column ) {
            case 'name' : ?>

                <div class="hidden wholesale_prices_inline" id="wholesale_prices_inline_<?php echo $post_id; ?>">

                    <?php if ( WWP_ACS_Integration_Helper::aelia_currency_switcher_active() ) {

                        // Get all active currencies
                        $wacsEnabledCurrencies  = WWP_ACS_Integration_Helper::enabled_currencies();

                        // Get base currency. Product base currency ( if present ) or shop base currency.
                        $baseCurrency = WWP_ACS_Integration_Helper::get_product_base_currency( $post_id ); ?>

                        <span class="hidden product_base_currency" id="product_base_currency_<?php echo $post_id; ?>"><?php echo $baseCurrency; ?></span>

                        <?php
                        foreach ( $registeredCustomRoles as $roleKey => $role ) {

                            foreach ( $wacsEnabledCurrencies as $currencyCode ) {

                                if ( $currencyCode == $baseCurrency ) {

                                    // Base Currency
                                    $wholesalePriceKey = $roleKey . '_wholesale_price';
                                    $wholesalePriceKeyWithCurrencyCode = $roleKey . '_' . $currencyCode . '_wholesale_price';

                                } else {

                                    $wholesalePriceKey = $roleKey . '_' . $currencyCode . '_wholesale_price';
                                    $wholesalePriceKeyWithCurrencyCode = '';

                                } ?>

                                <div id="<?php echo $wholesalePriceKey; ?>" data-currencyCode="<?php echo $currencyCode; ?>" data-wholesalePriceKeyWithCurrency="<?php echo $wholesalePriceKeyWithCurrencyCode; ?>" class="whole_price"><?php echo wc_format_localized_price( get_post_meta( $post_id , $wholesalePriceKey , true ) ); ?></div>

                            <?php }

                        }

                    } else { ?>

                        <?php foreach ( $registeredCustomRoles as $roleKey => $role ) { ?>

                            <div id="<?php echo $roleKey; ?>_wholesale_price" class="whole_price"><?php echo wc_format_localized_price( get_post_meta( $post_id , $roleKey . '_wholesale_price' , true ) ); ?></div>

                        <?php }

                    } ?>

                </div><!--.wholesale_prices_inline-->

                <?php break;

            default :
                break;

        } // switch

    }

}
