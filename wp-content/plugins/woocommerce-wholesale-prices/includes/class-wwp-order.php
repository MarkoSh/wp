<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'WWP_Order' ) ) {

    /**
     * Model that houses the logic of integrating with WooCommerce orders.
     * Be it be adding additional data/meta to orders or order items, etc..
     *
     * @since 1.3.0
     */
    class WWP_Order {

        /*
        |--------------------------------------------------------------------------
        | Class Properties
        |--------------------------------------------------------------------------
        */

        /**
         * Property that holds the single main instance of WWP_Order.
         *
         * @since 1.3.0
         * @access private
         * @var WWP_Order
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
         * WWP_Order constructor.
         *
         * @since 1.3.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Order model.
         */
        public function __construct( $dependencies ) {

            $this->_wwp_wholesale_roles  = $dependencies[ 'WWP_Wholesale_Roles' ];

        }

        /**
         * Ensure that only one instance of WWP_Order is loaded or can be loaded (Singleton Pattern).
         *
         * @since 1.3.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Order model.
         * @return WWP_Order
         */
        public static function instance( $dependencies ) {

            if ( !self::$_instance instanceof self )
                self::$_instance = new self( $dependencies );

            return self::$_instance;

        }

        /**
         * Add order meta.
         *
         * @since 1.3.0
         * @access public
         *
         * @param int   $order_id    Order id.
         * @param array $posted_data Posted data.
         */
        public function wwp_add_order_meta( $order_id , $posted_data ) {

            $user_wholesale_role = $this->_wwp_wholesale_roles->getUserWholesaleRole();

            if ( !empty( $user_wholesale_role ) ) {

                update_post_meta( $order_id , 'wwp_wholesale_role' , $user_wholesale_role[ 0 ] );

                do_action( '_wwp_add_order_meta' , $order_id , $posted_data , $user_wholesale_role );

            }

        }

        /**
         * Add order item meta for more accurate wholesale reporting in the future.
         * For WC 2.7.x series.
         *
         * @since 1.3.1
         * @access public
         *
         * @param int    $item_id  Order item id.
         * @param Object $item     Order item object.
         * @param int    $order_id Order id.
         */
        public function add_order_item_meta_wc2_7( $item_id , $item , $order_id ) {

            // Important note : Since WC 2.7.x shipping (WC_Order_Item_Shipping) and tax (WC_Order_Item_Tax) will be treated as order item as well. Weird
            if ( is_a( $item , 'WC_Order_Item_Product' ) )
                $this->add_order_item_meta( $item_id , $item->legacy_values );

            do_action( 'wwp_add_order_item_meta' , $item_id , $item , $order_id );

        }

        /**
         * Add order item meta for more accurate wholeslae reporting in the future.
         * For WC 2.7.x series.
         *
         * @since 1.3.1
         * @access public
         *
         * @param int    $item_id          Order item id.
         * @param array  $cart_item_values Order item data.
         * @param string $cart_item_key    Cart item key.
         */
        public function add_order_item_meta_wc2_6( $item_id , $cart_item_values , $cart_item_key ) {

            $this->add_order_item_meta( $item_id , $cart_item_values );

            do_action( 'wwp_add_order_item_meta' , $item_id , $cart_item_values , $cart_item_key );

        }

        /**
         * Attach order item meta for new orders since WWP 1.3.0 for more accurate reporting in the future versions of WWPP.
         * Replaces the wwp_add_order_item_meta function of WWP 1.3.0.
         *
         * @since 1.3.1
         * @access public
         *
         * @param int   $item_id Order item id.
         * @param array $item    Array of order item data.
         */
        public function add_order_item_meta( $item_id , $item ) {

            $user_wholesale_role = $this->_wwp_wholesale_roles->getUserWholesaleRole();

            if ( isset( $item[ 'data' ]->wwp_data ) && isset( $item[ 'data' ]->wwp_data[ 'wholesale_role' ] ) &&
                 !empty( $user_wholesale_role ) && $user_wholesale_role[ 0 ] == $item[ 'data' ]->wwp_data[ 'wholesale_role' ] ) {

                if ( isset( $item[ 'data' ]->wwp_data[ 'wholesale_priced' ] ) )
                    wc_add_order_item_meta( $item_id , '_wwp_wholesale_priced' , $item[ 'data' ]->wwp_data[ 'wholesale_priced' ] );

                if ( isset( $item[ 'data' ]->wwp_data[ 'wholesale_role' ] ) )
                    wc_add_order_item_meta( $item_id , '_wwp_wholesale_role' , $item[ 'data' ]->wwp_data[ 'wholesale_role' ] );

            }

        }


        /**
         * Execute model.
         *
         * @since 1.3.0
         * @access public
         */
        public function run() {

            add_action( 'woocommerce_checkout_order_processed' , array( $this , 'wwp_add_order_meta' ) , 10 , 2 );

            $woocommerce_data = WWP_Helper_Functions::get_woocommerce_data();

            if ( version_compare( $woocommerce_data[ 'Version' ] , '3.0.0' , '>=' ) )
                add_action( 'woocommerce_new_order_item' , array( $this , 'add_order_item_meta_wc2_7' ) , 10 , 3 );
            else
                add_action( 'woocommerce_add_order_item_meta' , array( $this , 'add_order_item_meta_wc2_6' ) , 10 , 3 );

        }

    }

}
