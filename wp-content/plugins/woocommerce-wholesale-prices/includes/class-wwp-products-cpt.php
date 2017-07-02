<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'WWP_Products_CPT' ) ) {

    /**
     * Model that houses the logic of extending WC products cpt.
     *
     * @since 1.3.0
     */
    class WWP_Products_CPT {

        /*
        |--------------------------------------------------------------------------
        | Class Properties
        |--------------------------------------------------------------------------
        */

        /**
         * Property that holds the single main instance of WWP_Products_CPT.
         *
         * @since 1.3.0
         * @access private
         * @var WWP_Products_CPT
         */
        private static $_instance;

        /**
         * Model that houses the logic of retrieving information relating to wholesale role/s of a user.
         *
         * @since 1.3.0
         * @access private
         * @var WWP_Wholesale_Roles
         */
        private $_wwp_wholesale_roles;




        /*
        |--------------------------------------------------------------------------
        | Class Methods
        |--------------------------------------------------------------------------
        */

        /**
         * WWP_Products_CPT constructor.
         *
         * @since 1.3.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Products_CPT model.
         */
        public function __construct( $dependencies ) {

            $this->_wwp_wholesale_roles  = $dependencies[ 'WWP_Wholesale_Roles' ];

        }

        /**
         * Ensure that only one instance of WWP_Products_CPT is loaded or can be loaded (Singleton Pattern).
         *
         * @since 1.3.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Products_CPT model.
         * @return WWP_Products_CPT
         */
        public static function instance( $dependencies ) {

            if ( !self::$_instance instanceof self )
                self::$_instance = new self( $dependencies );

            return self::$_instance;

        }

        /**
         * Add wholesale price column to the product listing page.
         *
         * @since 1.0.1
         * @since 1.3.0 Refactor codebase and move to its own model.
         *
         * @param array $columns Array of columns.
         * @return array Filtered array of columns.
         */
        public function add_wholesale_price_column_to_product_cpt_listing( $columns ) {

            $all_keys    = array_keys( $columns );
            $price_index = array_search( 'price' , $all_keys);

            return array_slice( $columns , 0 , $price_index + 1 , true ) + array( 'wholesale_price' => __( 'Wholesale Price' , 'woocommerce-wholesale-prices' ) ) + array_slice( $columns , $price_index + 1 , NULL , true );

        }

        /**
         * Add wholesale price column data for each product on the product listing page
         *
         * @since 1.0.1
         * @since 1.3.0 Refactor codebase and move to its model.
         *
         * @param string $column  Current column.
         * @param int    $post_id Product Id.
         */
        public function add_wholesale_price_column_value_to_product_cpt_listing( $column , $post_id ) {

            switch ( $column ) {

                case 'wholesale_price': ?>

                    <div class="wholesale_prices" id="wholesale_prices_<?php echo $post_id; ?>">

                        <?php
                        $all_wholesale_roles                   = $this->_wwp_wholesale_roles->getAllRegisteredWholesaleRoles();
                        $product                               = wc_get_product( $post_id );
                        $aelia_currency_switcher_plugin_active = WWP_ACS_Integration_Helper::aelia_currency_switcher_active();
                        $shop_base_currency                    = WWP_ACS_Integration_Helper::shop_base_currency(); // Shop base currency

                        foreach ( $all_wholesale_roles as $roleKey => $role ) {

                            $wholesale_price = "";

                            if ( WWP_Helper_Functions::wwp_get_product_type( $product ) === 'simple' ) {

                                $wholesale_price = get_post_meta( $post_id , $roleKey . '_wholesale_price' , true );

                                if ( $aelia_currency_switcher_plugin_active ) {

                                    if ( $wholesale_price ) {

                                        // get product base currency
                                        $product_base_currency = WWP_ACS_Integration_Helper::get_product_base_currency( $post_id );

                                        // if shop base currency is different from product base currency
                                        if ( $product_base_currency != $shop_base_currency ) {

                                            // convert wholesale price from product base currency to shop base currency
                                            $wholesale_price = WWP_ACS_Integration_Helper::convert( $wholesale_price , $shop_base_currency , $product_base_currency );

                                        }

                                        $wholesale_price = WWP_Helper_Functions::wwp_formatted_price( $wholesale_price );

                                    }

                                } else {

                                    if ( $wholesale_price )
                                        $wholesale_price = WWP_Helper_Functions::wwp_formatted_price( $wholesale_price );

                                }

                            } elseif ( WWP_Helper_Functions::wwp_get_product_type( $product ) === 'variable' ) {

                                $variations                           = $product->get_available_variations();
                                $min_price                            = '';
                                $max_price                            = '';
                                $some_variations_have_wholesale_price = false;

                                foreach( $variations as $variation ) {

                                    $variation                = wc_get_product( $variation[ 'variation_id' ] );
                                    $curr_var_wholesale_price = get_post_meta( WWP_Helper_Functions::wwp_get_product_id( $variation ) , $roleKey . '_wholesale_price' , true );
                                    $curr_var_price           = WWP_Helper_Functions::wwp_get_product_display_price( $variation );

                                    if ( strcasecmp( $curr_var_wholesale_price , '' ) != 0 ) {

                                        $curr_var_price = $curr_var_wholesale_price;

                                        if( !$some_variations_have_wholesale_price )
                                            $some_variations_have_wholesale_price = true;

                                        if ( $aelia_currency_switcher_plugin_active ) {

                                            // get product base currency
                                            $product_base_currency = WWP_ACS_Integration_Helper::get_product_base_currency( WWP_Helper_Functions::wwp_get_product_id( $variation ) );

                                            // if shop base currency is different from product base currency
                                            if ( $product_base_currency != $shop_base_currency ) {

                                                // convert wholesale price from product base currency to shop base currency
                                                $curr_var_price = WWP_ACS_Integration_Helper::convert( $curr_var_price , $shop_base_currency , $product_base_currency );

                                            }

                                        }

                                    }

                                    if( strcasecmp( $min_price , '' ) == 0 || $curr_var_price < $min_price )
                                        $min_price = $curr_var_price;

                                    if( strcasecmp( $max_price , '' ) == 0 || $curr_var_price > $max_price )
                                        $max_price = $curr_var_price;

                                }

                                if ( $some_variations_have_wholesale_price && strcasecmp( $min_price , '' ) != 0 && strcasecmp( $max_price , '' ) != 0 ) {

                                    if ( $min_price != $max_price && $min_price < $max_price )
                                        $wholesale_price = WWP_Helper_Functions::wwp_formatted_price( $min_price ) . ' - ' . WWP_Helper_Functions::wwp_formatted_price( $max_price );
                                    else
                                        $wholesale_price = WWP_Helper_Functions::wwp_formatted_price( $max_price );

                                }

                            } else
                                continue; ?>

                            <div id="<?php echo $roleKey; ?>_wholesale_price" class="wholesale_price">
                                <?php // Print the wholesale price
                                if ( !empty( $wholesale_price ) )
                                    echo '<div class="wholesale_role">' . $role[ 'roleName' ] . '</div>' . $wholesale_price;
                                ?>
                            </div>

                    <?php } // foreach ( $all_wholesale_roles as $roleKey => $role ) ?>

                    </div>
                    <?php

                    break;

                default :
                    break;

            }

        }


        /**
         * Execute model.
         *
         * @since 1.3.0
         * @access public
         */
        public function run() {

            add_filter( 'manage_product_posts_columns'       , array( $this , 'add_wholesale_price_column_to_product_cpt_listing' )       , 99 , 1 );
            add_action( 'manage_product_posts_custom_column' , array( $this , 'add_wholesale_price_column_value_to_product_cpt_listing' ) , 99 , 2 );

        }

    }

}
