<?php

/**
 * The admin settings handler of the plugin.
 *
 *
 * @since      1.1.0
 * @package    LiteSpeed_Cache
 * @subpackage LiteSpeed_Cache/admin
 * @author     LiteSpeed Technologies <info@litespeedtech.com>
 */
class LiteSpeed_Cache_Admin_Settings
{
	private static $_instance;

	/**
	 * Checks the admin selected option for cache tag prefixes.
	 *
	 * Prefixes are only allowed to be alphanumeric. On failure, will
	 * return error message.
	 *
	 * @since 1.0.9
	 * @access private
	 * @param array $input The configuration selected by the admin when
	 *     clicking save.
	 * @param array $options The current configuration options.
	 * @return mixed True on success, error message otherwise.
	 */
	private function validate_tag_prefix($input, &$options)
	{
		$id = LiteSpeed_Cache_Config::OPID_TAG_PREFIX;
		if (!isset($input[$id])) {
			return true;
		}
		$prefix = $input[$id];
		if ($prefix !== '' && !ctype_alnum($prefix)) {
			return __('Invalid Tag Prefix input.', 'litespeed-cache') . ' '
					. __('Input should only contain letters and numbers.', 'litespeed-cache');
		}
		if ($options[$id] !== $prefix) {
			$options[$id] = $prefix;
			LiteSpeed_Cache::get_instance()->purge_all();
		}

		return true;
	}

	/**
	 * Helper function to validate TTL settings. Will check if it's set,
	 * is an integer, and is greater than 0 and less than INT_MAX.
	 *
	 * @since 1.0.12
	 * @access public
	 * @param array $input Input array
	 * @param string $id Option ID
	 * @param number $min Minimum number
	 * @param number $max Maximum number
	 * @return bool True if valid, false otherwise.
	 */
	public function validate_ttl($input, $id, $min = false, $max = 2147483647)
	{
		if (!isset($input[$id])) {
			return false;
		}

		$val = $input[$id];

		$ival = intval($val);
		$sval = strval($val);

		if($min && $ival < $min) {
			return false;
		}

		return ctype_digit($sval) && $ival >= 0 && $ival < $max;
	}

	/**
	 * Validates the general settings.
	 *
	 * @since 1.0.12
	 * @access private
	 * @param array $input The input options.
	 * @param array $options The current options.
	 * @param array $errors The errors list.
	 */
	private function validate_general(&$input, &$options, &$errors)
	{
		$num_err = LiteSpeed_Cache_Admin_Display::get_error(LiteSpeed_Cache_Admin_Error::E_SETTING_NUMERIC);
		$max_ttl = 2147483647;

		// enabled setting
		$id = LiteSpeed_Cache_Config::OPID_ENABLED_RADIO;
		if(!isset($input[$id])){
			$enabled = 0;
		}else{
			$options[$id] = self::is_checked_radio($input[$id]);

			if($options[$id] !== LiteSpeed_Cache_Config::VAL_NOTSET){
				$enabled = $options[$id];
			}else{
				if (is_multisite()) {
					$enabled =  $options[LiteSpeed_Cache_Config::NETWORK_OPID_ENABLED];
				}
				else{
					$enabled = LiteSpeed_Cache_Config::VAL_ON;
				}
			}
		}

		// $enabled temporary variable
		$id = LiteSpeed_Cache_Config::OPID_ENABLED;
		if ($enabled !== $options[$id]) {
			$options[$id] = $enabled;
			$ret = LiteSpeed_Cache_Config::wp_cache_var_setter($enabled);
			if ($ret !== true) {
				$errors[] = $ret;
			}
			if (!$enabled) {
				LiteSpeed_Cache::get_instance()->purge_all();
			}
			elseif ($options[LiteSpeed_Cache_Config::OPID_CACHE_FAVICON]) {
				$options[LiteSpeed_Cache_Config::OPID_CACHE_FAVICON] = false;
			}
			$input[$id] = 'changed';
		}
		else {
			$input[$id] = $enabled;
		}

		$id = LiteSpeed_Cache_Config::OPID_PUBLIC_TTL;
		if (!$this->validate_ttl($input, $id, 30)) {
			$errors[] = sprintf($num_err,
					__('Default Public Cache', 'litespeed-cache'), 30, $max_ttl);
		}
		else {
			$options[$id] = $input[$id];
		}

		$id = LiteSpeed_Cache_Config::OPID_FRONT_PAGE_TTL;
		if (!$this->validate_ttl($input, $id, 30)) {
			$errors[] = sprintf($num_err, __('Default Front Page', 'litespeed-cache'), 30, $max_ttl);
		}
		else {
			$options[$id] = $input[$id];
		}

		$id = LiteSpeed_Cache_Config::OPID_FEED_TTL;
		if (!$this->validate_ttl($input, $id)) {
			$errors[] = sprintf($num_err, __('Feed', 'litespeed-cache'), 0, $max_ttl);
		}
		elseif ($input[$id] < 30) {
			$options[$id] = 0;
		}
		else {
			$options[$id] = intval($input[$id]);
		}

		$id = LiteSpeed_Cache_Config::OPID_404_TTL;
		if (!$this->validate_ttl($input, $id)) {
			$errors[] = sprintf($num_err, __('404', 'litespeed-cache'), 0, $max_ttl);
		}
		elseif ($input[$id] < 30) {
			$options[$id] = 0;
		}
		else {
			$options[$id] = intval($input[$id]);
		}

		$id = LiteSpeed_Cache_Config::OPID_403_TTL;
		if (!$this->validate_ttl($input, $id)) {
			$errors[] = sprintf($num_err, __('403', 'litespeed-cache'), 0, $max_ttl);
		}
		elseif ($input[$id] < 30) {
			$options[$id] = 0;
		}
		else {
			$options[$id] = intval($input[$id]);
		}

		$id = LiteSpeed_Cache_Config::OPID_500_TTL;
		if (!$this->validate_ttl($input, $id)) {
			$errors[] = sprintf($num_err, __('500', 'litespeed-cache'), 0, $max_ttl);
		}
		elseif ($input[$id] < 30) {
			$options[$id] = 0;
		}
		else {
			$options[$id] = intval($input[$id]);
		}

		$id = LiteSpeed_Cache_Config::OPID_PURGE_ON_UPGRADE;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);

		$id = LiteSpeed_Cache_Config::OPID_CACHE_COMMENTERS;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);

		$id = LiteSpeed_Cache_Config::OPID_CACHE_LOGIN;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);
		if(!$options[$id]){
			LiteSpeed_Cache_Tags::add_purge_tag(LiteSpeed_Cache_Tags::TYPE_LOGIN);
		}
	}

	/**
	 * Validates the purge rules settings.
	 *
	 * @since 1.0.12
	 * @access private
	 * @param array $input The input options.
	 * @param array $options The current options.
	 * @param array $errors The errors list.
	 */
	private function validate_purge($input, &$options, &$errors)
	{

		// get purge options
		$pvals = array(
			LiteSpeed_Cache_Config::PURGE_ALL_PAGES,
			LiteSpeed_Cache_Config::PURGE_FRONT_PAGE,
			LiteSpeed_Cache_Config::PURGE_HOME_PAGE,
			LiteSpeed_Cache_Config::PURGE_PAGES,
			LiteSpeed_Cache_Config::PURGE_PAGES_WITH_RECENT_POSTS,
			LiteSpeed_Cache_Config::PURGE_AUTHOR,
			LiteSpeed_Cache_Config::PURGE_YEAR,
			LiteSpeed_Cache_Config::PURGE_MONTH,
			LiteSpeed_Cache_Config::PURGE_DATE,
			LiteSpeed_Cache_Config::PURGE_TERM,
			LiteSpeed_Cache_Config::PURGE_POST_TYPE,
		);
		$input_purge_options = array();
		foreach ($pvals as $pval) {
			$input_name = 'purge_' . $pval;
			if ( isset($input[$input_name]) && self::is_checked($input[$input_name]) ) {
				$input_purge_options[] = $pval;
			}
		}
		sort($input_purge_options);
		$purge_by_post = implode('.', $input_purge_options);
		if ($purge_by_post !== $options[LiteSpeed_Cache_Config::OPID_PURGE_BY_POST]) {
			$options[LiteSpeed_Cache_Config::OPID_PURGE_BY_POST] = $purge_by_post;
		}
	}

	/**
	 * Validates the exclude settings.
	 *
	 * @since 1.0.12
	 * @access private
	 * @param array $input The input options.
	 * @param array $options The current options.
	 * @param array $errors The errors list.
	 */
	private function validate_exclude($input, &$options, &$errors)
	{
		$id = LiteSpeed_Cache_Config::OPID_EXCLUDES_URI;
		if (isset($input[$id])) {
			$uri_arr = array_map('trim', explode("\n", $input[$id]));
			$options[$id] = implode("\n", array_filter($uri_arr));
		}

		$id = LiteSpeed_Cache_Config::OPID_EXCLUDES_CAT;
		$options[$id] = '';
		if (isset($input[$id])) {
			$cat_ids = array();
			$cats = explode("\n", $input[$id]);
			foreach ($cats as $cat) {
				$cat_name = trim($cat);
				if ($cat_name == '') {
					continue;
				}
				$cat_id = get_cat_ID($cat_name);
				if ($cat_id == 0) {
					$errors[] = LiteSpeed_Cache_Admin_Display::get_error(LiteSpeed_Cache_Admin_Error::E_SETTING_CAT, $cat_name);
				}
				else {
					$cat_ids[] = $cat_id;
				}
			}
			if (!empty($cat_ids)) {
				$options[$id] = implode(',', $cat_ids);
			}
		}

		$id = LiteSpeed_Cache_Config::OPID_EXCLUDES_TAG;
		$options[$id] = '';
		if (isset($input[$id])) {
			$tag_ids = array();
			$tags = explode("\n", $input[$id]);
			foreach ($tags as $tag) {
				$tag_name = trim($tag);
				if ($tag_name == '') {
					continue;
				}
				$term = get_term_by('name', $tag_name, 'post_tag');
				if ($term == 0) {
					$errors[] = LiteSpeed_Cache_Admin_Display::get_error(LiteSpeed_Cache_Admin_Error::E_SETTING_TAG, $tag_name);
				}
				else {
					$tag_ids[] = $term->term_id;
				}
			}
			if (!empty($tag_ids)) {
				$options[$id] = implode(',', $tag_ids);
			}
		}
	}

	/**
	 * Validates the single site specific settings.
	 *
	 * @since 1.0.12
	 * @access private
	 * @param array $input The input options.
	 * @param array $options The current options.
	 * @param array $errors The errors list.
	 */
	private function validate_singlesite($input, &$options, &$errors)
	{
		$rules = LiteSpeed_Cache_Admin_Rules::get_instance();

		$id = LiteSpeed_Cache_Config::OPID_ENABLED;
		if ($input[$id] !== 'changed') {
			$diff = $rules->check_input_for_rewrite($options, $input, $errors);
		}
		elseif ($options[$id]) {
			$reset = LiteSpeed_Cache_Config::get_rule_reset_options();
			$added_and_changed = $rules->check_input_for_rewrite($reset, $input, $errors);
			// Merge to include the newly disabled options
			$diff = array_merge($reset, $added_and_changed);
		}
		else {
			$rules->clear_rules();
			$diff = $rules->check_input_for_rewrite($options, $input, $errors);
		}

		if (!empty($diff)
			 && ($options[$id] == false
			 	|| $rules->validate_common_rewrites($diff, $errors) !== false))//todo: check if need to use ===
		{
			$options = array_merge($options, $diff);
		}

		$out = $this->validate_tag_prefix($input, $options);
		if (is_string($out)) {
			$errors[] = $out;
		}

		$id = LiteSpeed_Cache_Config::OPID_CHECK_ADVANCEDCACHE;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);
	}

	/**
	 * Validates the debug settings.
	 *
	 * @since 1.0.12
	 * @access private
	 * @param array $input The input options.
	 * @param array $options The current options.
	 * @param array $errors The errors list.
	 */
	private function validate_debug($input, &$options, &$errors)
	{
		$id = LiteSpeed_Cache_Config::OPID_ADMIN_IPS;
		if (isset($input[$id])) {
			$admin_ips = array_map('trim', explode("\n", trim($input[$id]))) ;
			$admin_ips = array_filter($admin_ips) ;
			$has_err = false;
			if ($admin_ips) {
				foreach ($admin_ips as $ip) {
					if (!WP_Http::is_ip_address($ip)) {
						$has_err = true;
						break;
					}
				}
			}
			$admin_ips = implode("\n", $admin_ips) ;

			if ($has_err) {
				$errors[] = LiteSpeed_Cache_Admin_Display::get_error(LiteSpeed_Cache_Admin_Error::E_SETTING_ADMIN_IP_INV);
			}
			elseif ($admin_ips != $options[$id]) {
				$options[$id] = $admin_ips;
			}
		}

		$id = LiteSpeed_Cache_Config::OPID_TEST_IPS;
		if (isset($input[$id])) {
			// this feature has not implemented yet
			$test_ips = array_map('trim', explode("\n", trim($input[$id]))) ;
			$test_ips = array_filter($test_ips) ;
			$has_err = false;
			if ($test_ips) {
				foreach ($test_ips as $ip) {
					if (!WP_Http::is_ip_address($ip)) {
						$has_err = true;
						break;
					}
				}
			}
			$test_ips = implode("\n", $test_ips) ;

			if ($has_err) {
				$errors[] = LiteSpeed_Cache_Admin_Display::get_error(LiteSpeed_Cache_Admin_Error::E_SETTING_TEST_IP_INV);
			}
			elseif ($test_ips != $options[$id]) {
				$options[$id] = $test_ips;
			}
		}

		$id = LiteSpeed_Cache_Config::OPID_DEBUG;
		$debug_level = self::is_checked_radio($input[$id]);
		if ( $debug_level != $options[$id] ){
			$options[$id] = $debug_level;
		}
	}

	/**
	 * Validates the crawler settings.
	 *
	 * @since 1.0.12
	 * @access private
	 * @param array $input The input options.
	 * @param array $options The current options.
	 * @param array $errors The errors list.
	 */
	private function validate_crawler($input, &$options, &$errors)
	{
		$num_err = LiteSpeed_Cache_Admin_Display::get_error(LiteSpeed_Cache_Admin_Error::E_SETTING_NUMERIC);

		$id = LiteSpeed_Cache_Config::CRWL_POSTS;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);

		$id = LiteSpeed_Cache_Config::CRWL_PAGES;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);

		$id = LiteSpeed_Cache_Config::CRWL_CATS;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);

		$id = LiteSpeed_Cache_Config::CRWL_TAGS;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);

		$id = LiteSpeed_Cache_Config::CRWL_EXCLUDES_CPT;
		if (isset($input[$id])) {
			$arr = array_map('trim', explode("\n", $input[$id]));
			$arr = array_filter($arr);
			$ori = array_diff(get_post_types( '', 'names' ), array('post', 'page'));
			$options[$id] = implode("\n", array_intersect($arr, $ori));
		}

		$id = LiteSpeed_Cache_Config::CRWL_ORDER_LINKS;
		if(!isset($input[$id]) || !in_array($input[$id], array(
			LiteSpeed_Cache_Config::CRWL_DATE_DESC,
			LiteSpeed_Cache_Config::CRWL_DATE_ASC,
			LiteSpeed_Cache_Config::CRWL_ALPHA_DESC,
			LiteSpeed_Cache_Config::CRWL_ALPHA_ASC,
		))){
			$input[$id] = LiteSpeed_Cache_Config::CRWL_DATE_DESC;
		}
		$options[$id] = $input[$id];

		$id = LiteSpeed_Cache_Config::CRWL_USLEEP;
		if (!$this->validate_ttl($input, $id, 0, 30000)) {
			$errors[] = sprintf($num_err, __('Delay', 'litespeed-cache'), 0, 30000);
		}
		else {
			$options[$id] = $input[$id];
		}

		$id = LiteSpeed_Cache_Config::CRWL_RUN_DURATION;
		if (!$this->validate_ttl($input, $id)) {
			$errors[] = sprintf($num_err, __('Run Duration', 'litespeed-cache'), 0, 2147483647);
		}
		else {
			$options[$id] = $input[$id];
		}

		$id = LiteSpeed_Cache_Config::CRWL_RUN_INTERVAL;
		if (!$this->validate_ttl($input, $id, 60)) {
			$errors[] = sprintf($num_err, __('Cron Interval', 'litespeed-cache'), 60, 2147483647);
		}
		else {
			$options[$id] = $input[$id];
		}

		$id = LiteSpeed_Cache_Config::CRWL_CRAWL_INTERVAL;
		if (!$this->validate_ttl($input, $id)) {
			$errors[] = sprintf($num_err, __('Whole Interval', 'litespeed-cache'), 0, 2147483647);
		}
		else {
			$options[$id] = $input[$id];
		}

		$id = LiteSpeed_Cache_Config::CRWL_THREADS;
		if (!$this->validate_ttl($input, $id, 1)) {
			$errors[] = sprintf($num_err, __('Threads', 'litespeed-cache'), 1, 16);
		}
		else {
			$options[$id] = $input[$id];
		}

		$id = LiteSpeed_Cache_Config::CRWL_LOAD_LIMIT;
		$options[$id] = $input[$id];

		$id = LiteSpeed_Cache_Config::CRWL_DOMAIN_IP;
		if ( !empty($input[$id]) && ! WP_Http::is_ip_address($input[$id]) ) {
			$errors[] = LiteSpeed_Cache_Admin_Display::get_error(LiteSpeed_Cache_Admin_Error::E_SETTING_SITE_IP, $input[$id]);
		}
		else {
			$options[$id] = $input[$id];
		}

		$id = LiteSpeed_Cache_Config::CRWL_CUSTOM_SITEMAP;
		if ( !empty($input[$id]) && ($err = $this->validate_custom_sitemap($input[$id])) !== true ) {
			$errors[] = LiteSpeed_Cache_Admin_Display::get_error($err, $input[$id]) ;
		}
		else {
			$options[$id] = $input[$id];
		}

	}

	/**
	 * Validates the custom sitemap settings.
	 *
	 * @since 1.1.1
	 * @access private
	 * @param string $url The sitemap url
	 */
	private function validate_custom_sitemap($url)
	{
		return LiteSpeed_Cache_Crawler::get_instance()->parse_custom_sitemap($url, false) ;
	}

	/**
	 * Validates the third party settings.
	 *
	 * @since 1.0.12
	 * @access private
	 * @param array $input The input options.
	 * @param array $options The current options.
	 */
	private function validate_thirdparty($input, $options)
	{
		$tp_default_options = LiteSpeed_Cache_Config::get_instance()->get_thirdparty_options();
		if (empty($tp_default_options)) {
			return $options;
		}
		$tp_input = array_intersect_key($input, $tp_default_options);
		if (empty($tp_input)) {
			return $options;
		}
		$tp_options = apply_filters('litespeed_cache_save_options', array_intersect_key($options, $tp_default_options), $tp_input);
		if ((!empty($tp_options)) && is_array($tp_options)) {
			$options = array_merge($options, $tp_options);
		}
		return $options;
	}

	/**
	 * Callback function that will validate any changes made in the settings
	 * page.
	 *
	 * NOTE: Anytime that validate_plugin_settings is called, `convert_options_to_input` must be done first if not from option page
	 *
	 * @since 1.0.0
	 * @access public
	 * @param array $input The configuration selected by the admin when
	 *     clicking save.
	 * @return array The updated configuration options.
	 */
	public function validate_plugin_settings($input)
	{
		if (LiteSpeed_Cache_Log::get_enabled()) {
			LiteSpeed_Cache_Log::push('settings->validate_plugin_settings called') ;
		}
		$options = LiteSpeed_Cache_Config::get_instance()->get_options();
		$errors = array();

		if (LiteSpeed_Cache_Admin_Display::get_instance()->get_disable_all()) {
			add_settings_error(LiteSpeed_Cache_Config::OPTION_NAME,
				LiteSpeed_Cache_Config::OPTION_NAME,
				__('\'Use primary site settings\' set by Network Administrator.', 'litespeed-cache'));

			return $options;
		}

		$this->validate_general($input, $options, $errors);

		$this->validate_purge($input, $options, $errors);

		$this->validate_exclude($input, $options, $errors);

		$this->validate_debug($input, $options, $errors);

		if (!is_multisite()) {
			$this->validate_singlesite($input, $options, $errors);
		}

		if (!is_network_admin()) {
			$this->validate_crawler($input, $options, $errors);
		}

		if (!empty($errors)) {
			add_settings_error(LiteSpeed_Cache_Config::OPTION_NAME, LiteSpeed_Cache_Config::OPTION_NAME, implode('<br />', $errors));

			return $options;
		}

		$cron_changed = false ;
		if ( LiteSpeed_Cache_Router::is_cli() ) {
			$id = LiteSpeed_Cache_Config::CRWL_CRON_ACTIVE ;
			$cron_val = $options[$id] ;
			// assign crawler_cron_active to $options if exists in $input separately for CLI
			// This has to be specified cos crawler cron activation is not set in admin setting page
			$options[$id] = isset($input[$id]) && self::is_checked($input[$id]) ;
			if ( $cron_val != $options[$id] ) {
				$cron_changed = true ;
			}
		}

		// check if need to enable crawler cron
		if ( $input[LiteSpeed_Cache_Config::OPID_ENABLED] === 'changed' || $cron_changed ) {
			LiteSpeed_Cache_Config::get_instance()->cron_update($options) ;
		}

		$options = $this->validate_thirdparty($input, $options);

		return $options;
	}

	/**
	 * Parses any changes made by the network admin on the network settings.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function validate_network_settings()
	{
		$input = array_map("LiteSpeed_Cache_Admin::cleanup_text", $_POST[LiteSpeed_Cache_Config::OPTION_NAME]);
		$options = LiteSpeed_Cache_Config::get_instance()->get_site_options();
		$errors = array();

		$id = LiteSpeed_Cache_Config::NETWORK_OPID_ENABLED;
		$network_enabled = isset($input[$id]) && self::is_checked($input[$id]);
		if ($options[$id] != $network_enabled) {
			$options[$id] = $network_enabled;
			if ($network_enabled) {
				$ret = LiteSpeed_Cache_Config::wp_cache_var_setter(true);
				if ($ret !== true) {
					$errors[] = $ret;
				}
			}
			else {
				LiteSpeed_Cache::get_instance()->purge_all();
			}
			$input[$id] = 'changed';
			$reset = LiteSpeed_Cache_Config::get_rule_reset_options();
		}

		$id = LiteSpeed_Cache_Config::NETWORK_OPID_USE_PRIMARY;
		$orig_primary = $options[$id];
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);
		if ($orig_primary != $options[$id]) {
			LiteSpeed_Cache::get_instance()->purge_all();
		}

		$id = LiteSpeed_Cache_Config::OPID_PURGE_ON_UPGRADE;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);

		$id = LiteSpeed_Cache_Config::OPID_CHECK_ADVANCEDCACHE;
		$options[$id] = isset($input[$id]) && self::is_checked($input[$id]);

		$out = $this->validate_tag_prefix($input, $options);
		if (is_string($out)) {
			$errors[] = $out;
		}

		$rules = LiteSpeed_Cache_Admin_Rules::get_instance();

		if ($input[LiteSpeed_Cache_Config::NETWORK_OPID_ENABLED] !== 'changed') {
			$diff = $rules->check_input_for_rewrite($options, $input, $errors);
		}
		elseif ($network_enabled) {
			$added_and_changed = $rules->check_input_for_rewrite($reset, $input, $errors);
			// Merge to include the newly disabled options
			$diff = array_merge($reset, $added_and_changed);
		}
		else {
			$rules->validate_common_rewrites($reset, $errors);
			$diff = $rules->check_input_for_rewrite($options, $input, $errors);
		}

		if (!empty($diff) && ($network_enabled === false || $rules->validate_common_rewrites($diff, $errors) !== false)
		) {
			$options = array_merge($options, $diff);
		}

		if (!empty($errors)) {
			LiteSpeed_Cache_Admin_Display::add_notice(LiteSpeed_Cache_Admin_Display::NOTICE_RED, $errors);
			return;
		}
		LiteSpeed_Cache_Admin_Display::add_notice(LiteSpeed_Cache_Admin_Display::NOTICE_GREEN, __('File saved.', 'litespeed-cache'));
		update_site_option(LiteSpeed_Cache_Config::OPTION_NAME, $options);
		return $options;
	}

	/**
	 * Filter the value for checkbox (enabled/disabled)
	 *
	 * @since  1.1.0
	 * @access public
	 * @param int $val The checkbox value
	 * @return bool Filtered value
	 */
	public static function is_checked($val)
	{
		$val = intval($val);

		if($val === LiteSpeed_Cache_Config::VAL_ON){
			return true;
		}

		return false;
	}

	/**
	 * Filter the value for radio (enabled/disabled/notset)
	 *
	 * @since  1.1.0
	 * @access public
	 * @param int $val The radio value
	 * @return int Filtered value
	 */
	public static function is_checked_radio($val)
	{
		$val = intval($val);

		if($val === LiteSpeed_Cache_Config::VAL_ON){
			return LiteSpeed_Cache_Config::VAL_ON;
		}

		if($val === LiteSpeed_Cache_Config::VAL_NOTSET){
			return LiteSpeed_Cache_Config::VAL_NOTSET;
		}

		return LiteSpeed_Cache_Config::VAL_OFF;
	}

	/**
	 * Get the current instance object.
	 *
	 * @since 1.1.0
	 * @access public
	 * @return Current class instance.
	 */
	public static function get_instance()
	{
		$cls = get_called_class();
		if (!isset(self::$_instance)) {
			self::$_instance = new $cls();
		}

		return self::$_instance;
	}
}
