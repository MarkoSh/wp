<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'WWP_Bootstrap' ) ) {

    /**
     * Model that houses the logic of bootstrapping the plugin.
     *
     * @since 1.3.0
     */
    class WWP_Bootstrap {
        
        /*
        |--------------------------------------------------------------------------
        | Class Properties
        |--------------------------------------------------------------------------
        */

        /**
         * Property that holds the single main instance of WWP_Bootstrap.
         *
         * @since 1.3.0
         * @access private
         * @var WWP_Bootstrap
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

        /**
         * Current WWP version.
         *
         * @since 1.3.1
         * @access private
         * @var int
         */
        private $_wwp_current_version;




        /*
        |--------------------------------------------------------------------------
        | Class Methods
        |--------------------------------------------------------------------------
        */

        /**
         * WWP_Bootstrap constructor.
         *
         * @since 1.3.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Bootstrap model.
         */
        public function __construct( $dependencies ) {

            $this->_wwp_wholesale_roles = $dependencies[ 'WWP_Wholesale_Roles' ];
            $this->_wwp_current_version = $dependencies[ 'WWP_CURRENT_VERSION' ];
            
        }

        /**
         * Ensure that only one instance of WWP_Bootstrap is loaded or can be loaded (Singleton Pattern).
         *
         * @since 1.3.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Bootstrap model.
         * @return WWP_Bootstrap
         */
        public static function instance( $dependencies ) {

            if ( !self::$_instance instanceof self )
                self::$_instance = new self( $dependencies );

            return self::$_instance;

        }




        /*
        |------------------------------------------------------------------------------------------------------------------
        | Internationalization and Localization
        |------------------------------------------------------------------------------------------------------------------
        */

        /**
         * Load plugin text domain.
         *
         * @since 1.2.0
         * @since 1.3.0 Refactor codebase and move to its dedicated model.
         * @access public
         */
        public function load_plugin_text_domain() {

            load_plugin_textdomain( 'woocommerce-wholesale-prices' , false , WWP_PLUGIN_BASE_PATH . 'languages/' );

        }




        /*
         |------------------------------------------------------------------------------------------------------------------
         | Bootstrap/Shutdown Functions
         |------------------------------------------------------------------------------------------------------------------
         */

        /**
         * Plugin activation hook callback.
         *
         * @since 1.0.0
         * @since 1.2.9 Renamed from 'init' to 'activate'. Also add option to indicate that activation code has been successfully triggered. Flush rewrite rules.
         * @since 1.3.0 Add multi-site support
         * @access public
         *
         * @param boolean $network_wide Flag that determines if the plugin is activated in a multi-site environment.
         */
        public function activate( $network_wide ) {

            global $wpdb;

            if ( is_multisite() ) {

                if ( $network_wide ) {

                    // get ids of all sites
                    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

                    foreach ( $blog_ids as $blog_id ) {

                        switch_to_blog( $blog_id );
                        $this->_activate( $blog_id );

                    }

                    restore_current_blog();

                } else
                    $this->_activate( $wpdb->blogid ); // activated on a single site, in a multi-site

            } else
                $this->_activate( $wpdb->blogid ); // activated on a single site
            
        }

        /**
         * Plugin activation codebase.
         *
         * @since 1.3.0
         * @since 1.3.1 Save plugin version.
         * @access private
         *
         * @param int $blog_id Site id.
         */
        private function _activate( $blog_id ) {

            // Add plugin custom roles and capabilities
            $this->_wwp_wholesale_roles->addCustomRole( 'wholesale_customer' , __( 'Wholesale Customer' , 'woocommerce-wholesale-prices' ) );
            $this->_wwp_wholesale_roles->registerCustomRole( 'wholesale_customer' , __( 'Wholesale Customer' , 'woocommerce-wholesale-prices' ) ,
                                                            array(
                                                                'desc'  =>  __( 'This is the main wholesale user role.' , 'woocommerce-wholesale-prices' ),
                                                                'main'  =>  true
                                                            ) );
            $this->_wwp_wholesale_roles->addCustomCapability( 'wholesale_customer' , 'have_wholesale_price' );

            flush_rewrite_rules();
            
            update_option( 'wwp_option_activation_code_triggered' , 'yes' );

            update_option( 'wwp_option_installed_version' , $this->_wwp_current_version );

        }

        /**
         * Plugin deactivation hook callback.
         *
         * @since 1.0.0
         * @since 1.2.9 Renamed from 'terminate' to 'deactivate'. Flush rewrite rules.
         * @since 1.3.0 Add multi-site support.
         * @access public
         * 
         * @param boolean $network_wide Flag that determines if the plugin is activated in a multi-site environment.
         */
        public function deactivate( $network_wide ) {

            global $wpdb;

            // check if it is a multisite network
            if ( is_multisite() ) {

                // check if the plugin has been activated on the network or on a single site
                if ( $network_wide ) {

                    // get ids of all sites
                    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

                    foreach ( $blog_ids as $blog_id ) {

                        switch_to_blog( $blog_id );
                        $this->_deactivate( $wpdb->blogid );

                    }

                    restore_current_blog();

                } else
                    $this->_deactivate( $wpdb->blogid ); // activated on a single site, in a multi-site

            } else
                $this->_deactivate( $wpdb->blogid ); // activated on a single site

        }

        /**
         * Plugin deactivation codebase.
         *
         * @since 1.3.0
         * @access public
         *
         * @param int $blog_id Site id.
         */
        private function _deactivate( $blog_id ) {

            // Remove plugin custom roles and capabilities
            $this->_wwp_wholesale_roles->removeCustomCapability( 'wholesale_customer' , 'have_wholesale_price' );
            $this->_wwp_wholesale_roles->removeCustomRole( 'wholesale_customer' );
            $this->_wwp_wholesale_roles->unregisterCustomRole( 'wholesale_customer' );

            flush_rewrite_rules();

        }

        /**
         * Method to initialize a newly created site in a multi site set up.
         *
         * @since 1.3.0
         * @access public
         *
         * @param int    $blog_id Blog ID.
         * @param int    $user_id User ID.
         * @param string $domain  Site domain.
         * @param string $path    Site path.
         * @param int    $site_id Site ID. Only relevant on multi-network installs.
         * @param array  $meta    Meta data. Used to set initial site options.
         */
        public function new_mu_site_init( $blog_id , $user_id , $domain , $path , $site_id , $meta ) {

            if ( is_plugin_active_for_network( 'woocommerce-wholesale-prices/woocommerce-wholesale-prices.plugin.php' ) ) {

                switch_to_blog( $blog_id );
                $this->_activate( $blog_id );
                restore_current_blog();

            }

        }

        /**
         * Plugin initializaton.
         * 
         * @since 1.2.9
         * @since 1.3.0 Add multi-site support.
         * @since 1.3.1 Check if plugin installed version is same as plugin current version.
         */
        public function initialize() {

            // Check if activation has been triggered, if not trigger it
            // Activation codes are not triggered if plugin dependencies are not present and this plugin is activated.
            if ( version_compare( get_option( 'wwp_option_installed_version' , false ) , $this->_wwp_current_version , '!=' ) || get_option( 'wwp_option_activation_code_triggered' , false ) !== 'yes' ) {

                if ( ! function_exists( 'is_plugin_active_for_network' ) )
                    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

                $network_wide = is_plugin_active_for_network( 'woocommerce-wholesale-prices/woocommerce-wholesale-prices.plugin.php' );
                $this->activate( $network_wide );

            }

        }




        /*
         |------------------------------------------------------------------------------------------------------------------
         | Plugin Custom Action Links
         |------------------------------------------------------------------------------------------------------------------
         */

        /**
         * Add plugin listing custom action link ( settings ).
         *
         * @since 1.0.1
         * @since 1.4.0 Refactor codebase and move to its proper model.
         * @access public
         *
         * @param array  $links Array of links.
         * @param string $file  Plugin basename.
         * @return array Filtered array of links.
         */
        public function add_plugin_listing_custom_action_links( $links , $file ) {

            if ( $file == plugin_basename( WWP_PLUGIN_PATH . 'woocommerce-wholesale-prices.bootstrap.php' ) ) {

                $settings_link = '<a href="admin.php?page=wc-settings&tab=wwp_settings">' . __( 'Settings' , 'woocommerce-wholesale-prices' ) . '</a>';
                array_unshift( $links , $settings_link );

            }

            return $links;

        }




        /*
         |------------------------------------------------------------------------------------------------------------------
         | Execute Model
         |------------------------------------------------------------------------------------------------------------------
         */

        /**
         * Execute model.
         *
         * @since 1.3.0
         * @access public
         */
        public function run() {

            // Load Plugin Text Domain
            add_action( 'plugins_loaded' , array( $this , 'load_plugin_text_domain' ) );

            register_activation_hook( WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-prices' . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-prices.bootstrap.php' , array( $this , 'activate' ) );
            register_deactivation_hook( WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-prices' . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-prices.bootstrap.php' , array( $this , 'deactivate' ) );

            // Execute plugin initialization ( plugin activation ) on every newly created site in a multi site set up
            add_action( 'wpmu_new_blog' , array( $this , 'new_mu_site_init' ) , 10 , 6 );

            // Initialize Plugin
            add_action( 'init' , array( $this , 'initialize' ) );

            // Settings
            add_filter( 'plugin_action_links' , array( $this , 'add_plugin_listing_custom_action_links' ) , 10 , 2 );

        }

    }

}
