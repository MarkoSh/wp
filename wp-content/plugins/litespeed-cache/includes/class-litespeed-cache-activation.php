<?php

/**
 * The plugin activation class.
 *
 * @since      1.1.0
 * @package    LiteSpeed_Cache
 * @subpackage LiteSpeed_Cache/includes
 * @author     LiteSpeed Technologies <info@litespeedtech.com>
 */
class LiteSpeed_Cache_Activation
{
	const NETWORK_TRANSIENT_COUNT = 'lscwp_network_count' ;


	/**
	 * The activation hook callback.
	 *
	 * Attempts to set up the advanced cache file. If it fails for any reason,
	 * the plugin will not activate.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function register_activation()
	{
		$count = 0 ;
		if ( !defined('LSCWP_LOG_TAG') ) {
			define('LSCWP_LOG_TAG', 'LSCACHE_WP_activate_' . get_current_blog_id()) ;
		}
		self::try_copy_advanced_cache() ;
		LiteSpeed_Cache_Config::wp_cache_var_setter(true) ;

		if ( is_multisite() ) {
			$count = self::get_network_count() ;
			if ( $count !== false ) {
				$count = intval($count) + 1 ;
				set_site_transient(self::NETWORK_TRANSIENT_COUNT, $count, DAY_IN_SECONDS) ;
			}
		}
		do_action('litespeed_cache_detect_thirdparty') ;
		LiteSpeed_Cache_Config::get_instance()->plugin_activation($count) ;
		LiteSpeed_Cache_Admin_Report::get_instance()->generate_environment_report() ;

		if (defined('LSCWP_PLUGIN_NAME')) {
			set_transient(LiteSpeed_Cache::WHM_TRANSIENT, LiteSpeed_Cache::WHM_TRANSIENT_VAL) ;
		}

		// Register crawler cron task
		LiteSpeed_Cache_Config::get_instance()->cron_update() ;
	}

	/**
	 * Uninstall plugin
	 * @since 1.1.0
	 */
	public static function uninstall_litespeed_cache()
	{
		LiteSpeed_Cache_Config::get_instance()->cron_clear() ;
		LiteSpeed_Cache_Admin_Rules::get_instance()->clear_rules() ;
		delete_option(LiteSpeed_Cache_Config::OPTION_NAME) ;
		if ( is_multisite() ) {
			delete_site_option(LiteSpeed_Cache_Config::OPTION_NAME) ;
		}
	}

	/**
	 * Get the blog ids for the network. Accepts function arguments.
	 *
	 * Will use wp_get_sites for WP versions less than 4.6
	 *
	 * @since 1.0.12
	 * @access public
	 * @param array $args Arguments to pass into get_sites/wp_get_sites.
	 * @return array The array of blog ids.
	 */
	public static function get_network_ids($args = array())
	{
		global $wp_version ;
		if ( version_compare($wp_version, '4.6', '<') ) {
			$blogs = wp_get_sites($args) ;
			if ( !empty($blogs) ) {
				foreach ( $blogs as $key => $blog ) {
					$blogs[$key] = $blog['blog_id'] ;
				}
			}
		}
		else {
			$args['fields'] = 'ids' ;
			$blogs = get_sites($args) ;
		}
		return $blogs ;
	}

	/**
	 * Gets the count of active litespeed cache plugins on multisite.
	 *
	 * @since 1.0.12
	 * @access private
	 * @return mixed The count on success, false on failure.
	 */
	private static function get_network_count()
	{
		$count = get_site_transient(self::NETWORK_TRANSIENT_COUNT) ;
		if ( $count !== false ) {
			return intval($count) ;
		}
		// need to update
		$default = array() ;
		$count = 0 ;

		$sites = self::get_network_ids(array('deleted' => 0)) ;
		if ( empty($sites) ) {
			return false ;
		}

		foreach ( $sites as $site ) {
			$plugins = get_blog_option($site->blog_id, 'active_plugins', $default) ;
			if ( in_array(LSWCP_BASENAME, $plugins, true) ) {
				$count++ ;
			}
		}
		if ( is_plugin_active_for_network(LSWCP_BASENAME) ) {
			$count++ ;
		}
		return $count ;
	}

	/**
	 * Is this deactivate call the last active installation on the multisite
	 * network?
	 *
	 * @since 1.0.12
	 * @access private
	 * @return bool True if yes, false otherwise.
	 */
	private static function is_deactivate_last()
	{
		$count = self::get_network_count() ;
		if ( $count === false ) {
			return false ;
		}
		if ( $count !== 1 ) {
			// Not deactivating the last one.
			$count-- ;
			set_site_transient(self::NETWORK_TRANSIENT_COUNT, $count, DAY_IN_SECONDS) ;
			return false ;
		}

		delete_site_transient(self::NETWORK_TRANSIENT_COUNT) ;
		return true ;
	}

	/**
	 * The deactivation hook callback.
	 *
	 * Initializes all clean up functionalities.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function register_deactivation()
	{
		LiteSpeed_Cache_Config::get_instance()->cron_clear() ;
		if (!defined('LSCWP_LOG_TAG')) {
			define('LSCWP_LOG_TAG', 'LSCACHE_WP_deactivate_' . get_current_blog_id()) ;
		}
		LiteSpeed_Cache::get_instance()->purge_all() ;

		if ( is_multisite() ) {
			if ( is_network_admin() ) {
				$options = get_site_option(LiteSpeed_Cache_Config::OPTION_NAME) ;
				if ( isset($options)
					&& is_array($options) ) {
					$opt_str = serialize($options) ;
					update_site_option(LiteSpeed_Cache_Config::OPTION_NAME, $opt_str) ;
				}
			}
			if ( !self::is_deactivate_last() ) {
				if ( is_network_admin()
						&& isset($opt_str)
						&& $options[LiteSpeed_Cache_Config::NETWORK_OPID_ENABLED] ) {
					$reset = LiteSpeed_Cache_Config::get_rule_reset_options() ;
					$errors = array() ;
					LiteSpeed_Cache_Admin_Rules::get_instance()->validate_common_rewrites($reset, $errors) ;
				}
				return ;
			}
		}

		$adv_cache_path = LSWCP_CONTENT_DIR . '/advanced-cache.php' ;
		if ( file_exists($adv_cache_path) && is_writable($adv_cache_path) ) {
			unlink($adv_cache_path)  ;
		}
		else {
			error_log('Failed to remove advanced-cache.php, file does not exist or is not writable!')  ;
		}

		if ( !LiteSpeed_Cache_Config::wp_cache_var_setter(false) ) {
			error_log('In wp-config.php: WP_CACHE could not be set to false during deactivation!')  ;
		}
		LiteSpeed_Cache_Admin_Rules::get_instance()->clear_rules() ;
		// delete in case it's not deleted prior to deactivation.
		self::dismiss_whm() ;
	}

	/**
	 * Try to copy our advanced-cache.php file to the wordpress directory.
	 *
	 * @since 1.0.11
	 * @access public
	 * @return boolean True on success, false on failure.
	 */
	public static function try_copy_advanced_cache()
	{
		$adv_cache_path = LSWCP_CONTENT_DIR . '/advanced-cache.php' ;
		if (file_exists($adv_cache_path)
				&& (filesize($adv_cache_path) !== 0
					|| !is_writable($adv_cache_path)) ) {
			return false ;
		}

		copy(LSWCP_DIR . 'includes/advanced-cache.php', $adv_cache_path) ;
		include($adv_cache_path) ;
		$ret = defined('LSCACHE_ADV_CACHE') ;
		return $ret ;
	}

	/**
	 * Delete whm transient msg tag
	 *
	 * @since 1.1.1
	 * @access public
	 */
	public static function dismiss_whm()
	{
		delete_transient(LiteSpeed_Cache::WHM_TRANSIENT) ;
	}


}
