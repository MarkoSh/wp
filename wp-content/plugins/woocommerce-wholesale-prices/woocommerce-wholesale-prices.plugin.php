<?php
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once ( 'includes/class-wwp-aelia-currency-switcher-integration-helper.php' );
require_once ( 'includes/class-wwp-wholesale-roles.php' );
require_once ( 'includes/class-wwp-wholesale-prices.php' );

require_once ( 'includes/class-wwp-bootstrap.php' );
require_once ( 'includes/class-wwp-script-loader.php' );
require_once ( 'includes/admin-custom-fields/products/class-wwp-admin-custom-fields-simple-product.php' );
require_once ( 'includes/admin-custom-fields/products/class-wwp-admin-custom-fields-variable-product.php' );
require_once ( 'includes/class-wwp-products-cpt.php' );
require_once ( 'includes/class-wwp-order.php' );
require_once ( 'includes/class-wwp-duplicate-product.php' );

/**
 * This is the main plugin class. It's purpose generally is for "ALL PLUGIN RELATED STUFF ONLY".
 * This file or class may also serve as a controller to some degree but most if not all business logic is distributed
 * across include files.
 *
 * Class WooCommerceWholeSalePrices
 */
class WooCommerceWholeSalePrices {

    /*
     |------------------------------------------------------------------------------------------------------------------
     | Class Members
     |------------------------------------------------------------------------------------------------------------------
     */

    private static $_instance;

    public $wwp_wholesale_roles;
    private $_wwp_wholesale_prices;

    public $wwp_bootstrap;
    public $wwp_script_loader;
    public $wwp_admin_custom_fields_simple_product;
    public $wwp_admin_custom_fields_variable_product;
    public $wwp_products_cpt;
    public $wwp_order;
    public $wwp_duplicate_product;

    const VERSION = '1.4.5';




    /*
    |--------------------------------------------------------------------------
    | Class Methods
    |--------------------------------------------------------------------------
    */

    /**
     * WooCommerceWholeSalePrices constructor.
     *
     * @since 1.0.0
     * @since 1.14.0
     * @access public
     */
    public function __construct() {

        $this->wwp_wholesale_roles  = WWP_Wholesale_Roles::getInstance();
        $this->_wwp_wholesale_prices = WWP_Wholesale_Prices::getInstance();

        $this->wwp_bootstrap                            = WWP_Bootstrap::instance( array( 'WWP_Wholesale_Roles' => $this->wwp_wholesale_roles , 'WWP_CURRENT_VERSION' => self::VERSION ) );
        $this->wwp_script_loader                        = WWP_Script_Loader::instance( array( 'WWP_Wholesale_Roles' => $this->wwp_wholesale_roles , 'WWP_Wholesale_Prices' => $this->_wwp_wholesale_prices , 'WWP_CURRENT_VERSION' => self::VERSION ) );
        $this->wwp_admin_custom_fields_simple_product   = WWP_Admin_Custom_Fields_Simple_Product::instance( array( 'WWP_Wholesale_Roles' => $this->wwp_wholesale_roles ) );
        $this->wwp_admin_custom_fields_variable_product = WWP_Admin_Custom_Fields_Variable_Product::instance( array( 'WWP_Wholesale_Roles' => $this->wwp_wholesale_roles ) );
        $this->wwp_products_cpt                         = WWP_Products_CPT::instance( array( 'WWP_Wholesale_Roles' => $this->wwp_wholesale_roles ) );
        $this->wwp_order                                = WWP_Order::instance( array( 'WWP_Wholesale_Roles' => $this->wwp_wholesale_roles ) );
        $this->wwp_duplicate_product                    = WWP_Duplicate_Product::instance( array( 'WWP_Wholesale_Roles' => $this->wwp_wholesale_roles ) );

    }

    /**
     * Singleton Pattern.
     * Ensure that only one instance of WooCommerceWholeSalePrices is loaded or can be loaded (Singleton Pattern).
     *
     * @since 1.0.0
     * @since 1.14.0
     * @access public
     *
     * @return WooCommerceWholeSalePrices
     */
    public static function instance() {

        if( !self::$_instance instanceof self )
            self::$_instance = new self;

        return self::$_instance;

    }

    // DEPRECATED
    public static function getInstance() {
        return self::instance();
    }

    // DEPRECATED
    public function activatePluginSettings() {

        $this->activate_plugin_settings();

    }




    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Plugin Settings
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * Activate plugin settings.
     *
     * @since 1.0.0
     * @since 1.14.0 Refactor codebase.
     * @access public
     */
    public function activate_plugin_settings() {

        add_filter( "woocommerce_get_settings_pages" , array( $this , 'initialize_plugin_settings' ) );

    }

    /**
     * Initialize plugin settings.
     *
     * @since 1.0.0
     * @since 1.14.0 Refactor codebase.
     * @access public
     *
     * @param array $settings Array of WC settings.
     * @return array Filtered array of wc settings.
     */
    public function initialize_plugin_settings( $settings ) {

        $settings[] = include( WWP_INCLUDES_PATH . "class-wwp-settings.php" );

        return $settings;

    }

    /**
     * Default prices settings content (For upsell purposes).
     *
     * @since 1.0.1
     * @since 1.14.0 Refactor codebase.
     * @access public
     *
     * @param array  $settings        Settings options.
     * @param string $current_section Current settings section.
     * @return array Filtered settings options.
     */
    public function plugin_settings_section_content( $settings , $current_section ) {

        if ( $current_section == '' ) {

            // Filters Section
            $wwpGeneralSettings = apply_filters( 'wwp_settings_general_section_settings' , $this->_get_general_section_settings() ) ;
            $settings = array_merge( $settings , $wwpGeneralSettings );

        }

        return $settings;

    }

    /**
     * Default prices settings content (For upsell purposes).
     *
     * @since 1.0.1
     * @since 1.14.0 Refactor codebase.
     * @access public
     */
    private function _get_general_section_settings() {

        return array(

            array(
                'name'  =>  __( 'Wholesale Prices Settings' , 'woocommerce-wholesale-prices' ),
                'type'  =>  'title',
                'desc'  =>  '',
                'id'    =>  'wwp_settings_section_title'
            ),
            array(
                'name'  =>  '',
                'type'  =>  'upsell_banner',
                'desc'  =>  '',
                'id'    =>  'wwp_settings_section_general_upsell_banner',
            ),
            array(
                'type'  =>  'sectionend',
                'id'    =>  'wwp_settings_sectionend'
            )

        );

    }




    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Woocommerce Integration (Price)
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * Filter callback that alters the product price, it embeds the wholesale price of a product for a wholesale user.
     *
     * @param $price
     * @param $product
     *
     * @return mixed|string
     * @since 1.0.0
     */
    public function wholesalePriceHTMLFilter( $price , $product ) {

        return $this->_wwp_wholesale_prices->wholesalePriceHTMLFilter( $price , $product , $this->wwp_wholesale_roles->getUserWholesaleRole() );

    }

    /**
     * Apply wholesale price whenever "get_html_price" function gets called inside a variation product.
     * Variation product is the actual variation of a variable product.
     * Variable product is the parent product which contains variations.
     *
     * @param $price
     * @param $variation
     * @return mixed
     *
     * @since 1.0.3
     */
    public function wholesaleSingleVariationPriceHTMLFilter ( $price , $variation ) {

        return $this->_wwp_wholesale_prices->wholesaleSingleVariationPriceHTMLFilter( $price , $variation , $this->wwp_wholesale_roles->getUserWholesaleRole() );

    }

    /**
     * Apply product wholesale price upon adding to cart.
     *
     * @param $cart_object
     *
     * @since 1.0.0
     */
    public function applyProductWholesalePrice( $cart_object ) {

        $this->_wwp_wholesale_prices->applyProductWholesalePrice( $cart_object , $this->wwp_wholesale_roles->getUserWholesaleRole() );

    }

    /**
     * Apply wholesale price on WC Cart Widget.
     *
     * @param $product_price
     * @param $cart_item
     * @param $cart_item_key
     * @return mixed
     *
     * @since 1.0.0
     */
    public function applyProductWholesalePriceOnDefaultWCCartWidget ( $product_price , $cart_item , $cart_item_key ) {

        return $this->_wwp_wholesale_prices->applyProductWholesalePriceOnDefaultWCCartWidget( $product_price , $cart_item , $cart_item_key , $this->wwp_wholesale_roles->getUserWholesaleRole() );

    }

    /**
     * Add notice to WC Widget if the user (wholesale user) fails to avail the wholesale price requirements.
     * Only applies to wholesale users.
     *
     * @since 1.0.0
     */
    public function beforeWCWidget () {

        $this->_wwp_wholesale_prices->beforeWCWidget( $this->wwp_wholesale_roles->getUserWholesaleRole() );

    }




    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Deprecated Functions
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * Returns an array that contains the wholesale role of the user. Usually 1 item only.
     *
     * @since 1.2.0
     * @since 1.4.0 Deprecated.
     *
     * @return array
     */
    public function getUserWholesaleRole() {

        return $this->wwp_wholesale_roles->getUserWholesaleRole();

    }

    /**
     * Returns an array of all registered wholesale roles.
     *
     * @since 1.2.0
     * @since 1.4.0 Deprecated.
     *
     * @return mixed
     */
    public function getAllWholesaleRoles() {

        return $this->wwp_wholesale_roles->getAllRegisteredWholesaleRoles();

    }




    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Execution WWPP
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * Execute WWP. Triggers the execution codes of the plugin models.
     *
     * @since 1.3.0
     * @access public
     */
    public function run() {

        $this->wwp_wholesale_roles->run();
        $this->wwp_bootstrap->run();
        $this->wwp_script_loader->run();
        $this->wwp_admin_custom_fields_simple_product->run();
        $this->wwp_admin_custom_fields_variable_product->run();
        $this->wwp_products_cpt->run();
        $this->wwp_order->run();
        $this->wwp_duplicate_product->run();

        // Load default prices settings content if premium add on isn't present
        if ( !WWP_Helper_Functions::is_plugin_active( 'woocommerce-wholesale-prices-premium/woocommerce-wholesale-prices-premium.bootstrap.php' ) ) {

            $this->activate_plugin_settings();
            add_filter( 'wwp_settings_section_content' , array( $this, 'plugin_settings_section_content' ), 10, 2 );

        }

    }

}
