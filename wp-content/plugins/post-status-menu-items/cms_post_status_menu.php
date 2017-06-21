<?php
/*
Plugin Name: Post Status Menu Items
Plugin URI: http://mrwweb.com/wordpress-post-status-menu-item-plugin/
Description: Adds post status links (e.g. "Draft (6)") to the Admin submenus.
Version: 1.5.0
Author: Mark Root-Wiley
Author URI: http://mrwweb.com
Text Domain: post-status-menu-items
Domain Path: /languages
*/

/*
Big thanks to http://wordpress.stackexchange.com/a/3831/9844 which sent me own the path to this completed plugin.
Regarding i18n of core terms: http://wordpress.stackexchange.com/questions/77334/can-i-leave-off-plugin-textdomain-for-terms-used-in-core#comment105315_77334
*/

/* ============================================
	VERSIONING, INSTALL, UPGRADE, UNINSTALL
   ============================================ */

define('PSMI_VERSION', '1.5.0');

/**
 * checks version number and updates it if it's unset or different
 */
function psmi_update_version() {
	// Update the Plugin Version if it doesn't exist or is out of sync
	$psmi_options = get_option( 'psmi_options' );
	if( !isset( $psmi_options['ps_version'] )
		|| $psmi_options['ps_version'] != PSMI_VERSION ) {
		$psmi_options['ps_version'] = PSMI_VERSION;
		update_option( 'psmi_options', $psmi_options );
	}
}

/**
 * Run version check on activate, turn on posts post stati
 */
function psmi_activate() {
	psmi_update_version();

	// If Post post_type option isn't set, make it true (the default)
	$psmi_options = get_option( 'psmi_options' );
	if( !isset( $psmi_options['ps_post_types']['post'] ) ) {
		$psmi_options['ps_post_types']['post'] = true;
		update_option( 'psmi_options', $psmi_options );
	}
}

/**
 * Run version check on upgrade. Update settings if version isn't saved.
 */
function psmi_upgrade() {
	// get all options
	$psmi_options = get_option( 'psmi_options' );

	// As of version 1.2.0, all plugin options are saved in one field.
	// This upgrades to that setup if an earlier version is already installed
	if( !isset( $psmi_options['ps_version'] ) ) {

		// get list of post types
		$ps_post_types = ps_get_post_type_list();

		// setup array for post type options
		$psmi_options['ps_post_types'] = array();

		// loop through all post types. set new version of option and delete old
		foreach( $ps_post_types as $ps_type_id => $ps_type_name ) {

			// converts 1 -> true, everything else -> false
			$psmi_options['ps_post_types'][$ps_type_id] = ( get_option( 'ps_show_in_' . $ps_type_id ) == 1 ? true : false );
			delete_option( 'ps_show_in_' . $ps_type_id );

		}

		// put in the new options
		update_option( 'psmi_options', $psmi_options );

	}

	psmi_update_version();

}

/**
 * Delete options on uninstall
 */
function psmi_uninstall() {
	// Delete Plugin Options on Uninstall
	delete_option( 'psmi_options' );
}

/* ============================================
	I18N
   ============================================ */

// any languages files
function psmi_textdomain() {
	load_plugin_textdomain( 'post-status-menu-items', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


/* ============================================
	CORE PLUGIN FUNCTIONS
   ============================================ */

/**
 * appends post statuses to menus if settings warrant such action.
 */
function cms_post_status_menu() {

	if( !current_user_can( 'edit_posts' ) ) {
		return;
	}

	global $submenu;

	// Get list of post types
	$ps_post_types = ps_get_post_type_list();

	// Get options
	$psmi_options = get_option( 'psmi_options' );

	// loop through the post types array we just got
	foreach( $ps_post_types as $ps_type_id => $ps_type_name ) {

		if( ( $ps_type_id === 'page' ) && !current_user_can( 'edit_pages' ) ) {
			continue;
		}

		// check option for whether to show statuses for this post type
		if( isset( $psmi_options['ps_post_types'][$ps_type_id] )
			&& $psmi_options['ps_post_types'][$ps_type_id] ) {

			// an array of all the statuses
			$ps_statuses = get_post_stati( array( 'show_in_admin_status_list' => true ), 'objects' );

			// filter the list of statuses for anything people want to do
			$ps_statuses = apply_filters( 'psmi_statuses', $ps_statuses );

			// Get status counts of all post types
			$ps_status_counts = wp_count_posts( $ps_type_id );

			// Get the correct submenu. Posts are a weird case.
			if( $ps_type_id == 'post' ) {
				$menu = 'edit.php';
			} else {
				$menu = 'edit.php?post_type=' . $ps_type_id;
			}

			// loop through statuses array
			foreach( $ps_statuses as $status ) {

				$ps_status_id = $status->name;
				if ($ps_status_id) {
					$ps_status_count = $ps_status_counts->$ps_status_id;

					// If a status has any posts, show it
					if( $ps_status_count > 0 ) {
						// Get the plural post status label
						$ps_status_label = $status->label;
						$submenu[$menu][] = array(
							sprintf(
								'%1$s (%2$s)',
								esc_attr( $ps_status_label ),
								intval( $ps_status_count )
							),
							'read',
							sprintf(
								'edit.php?post_status=%1$s&post_type=%2$s',
								$ps_status_id,
								$ps_type_id
							)

						);
					}
				}
			}
		}
	}
}

/**
 * remove post statuses excluded by the theme settings
 *
 * @param	array	$statuses	list of all post statuses
 * @return	array				filtered lists of statuses
 */
function ps_remove_excluded_post_statuses( $statuses ) {

	$psmi_options = get_option( 'psmi_options' );

	foreach ( $statuses as $ps_type_id => $ps_type_name ) {
		if( !empty( $psmi_options['ps_post_stati'][$ps_type_id] )
			&& $psmi_options['ps_post_stati'][$ps_type_id] ) {
			unset( $statuses[$ps_type_id] );
		}
	}

	return $statuses;
}

/**
 * list post types intended for use by site admins
 *
 * @return	array		contains non-_builtin post types where show_ui = true
*/
function ps_get_post_type_list() {
	// The post types we'll always display
	$ps_post_types = array(
		'post' => _x( 'Posts', 'the Posts core post type', 'post-status-menu-items' ),
		'page' => _x( 'Pages', 'the Pages core post type', 'post-status-menu-items' )
	);

	// Get all Public but Not Built In Post Types
	$ps_custom_post_types = get_post_types(
		array( 'show_ui' => true, '_builtin' => false ),
		'objects',
		'AND'
	);

	// Build array with the other post types
	foreach( $ps_custom_post_types as $ps_type_id => $ps_type_name ) {
		$ps_post_types[$ps_type_id] = $ps_type_name->labels->name;
	}

	return $ps_post_types;
}

/**
 * Add post statuses to "Right Now" Dashboard Widget, <=WP 3.7.X
 *
 */
function ps_right_now_widget() {

	$ps_options = get_option( 'psmi_options' );
	// stop if we're hiding it.
	if( isset($ps_options['ps_right_now']) && $ps_options['ps_right_now'] ) {
		return;
	}

	// get the statuses
	$ps_statuses = get_post_stati( array( 'show_in_admin_status_list' => true ), 'objects' );

	// filter the list of statuses for anything people want to do
	$ps_statuses = apply_filters( 'psmi_statuses', $ps_statuses );

	// Get status counts of all post types
	$ps_status_counts = wp_count_posts( 'post' );

	echo '</table></div>';
	echo '<div class="table ps_table_post_statuses">';
	echo '<p class="sub">' . _x( 'Posts', 'the Posts core post type', 'post-status-menu-items' ) . '</p><table>';

	// loop through statuses array
	$first = true;
	foreach( $ps_statuses as $status ) {

		$ps_status_id = $status->name;

		$ps_status_count = $ps_status_counts -> $ps_status_id;

		// If a status has any posts, show it
		if( $ps_status_count > 0 ) {
			// Get the plural post status label
			$ps_status_label = $status->label;
			if( $first ) {
				echo '<tr class="first">';
			} else {
				echo '<tr>';
			}
			printf(
				'<td class="first b"><a href="%1$sedit.php?post_status=%2$s">%3$s</a></td>
				<td class="t"><a href="%1$sedit.php?post_status=%2$s">%4$s</a></td>',
				get_admin_url(),
				$ps_status_id,
				intval( $ps_status_count ),
				esc_attr( $ps_status_label )
			);
			echo '</tr>';
			$first = false;
		}
	}
}
add_action( 'right_now_content_table_end', 'ps_right_now_widget' );

/**
 * Add post statuses to "At a Glance" Dashboard Widget, WP 3.8+
 *
 * Uses "Right Now" widget setting when upgrading from 3.7.X to 3.8.0+
 *
 */
function ps_at_a_glance_widget( $items ) {

	$ps_options = get_option( 'psmi_options' );
	// stop if we're hiding it.
	if( isset($ps_options['ps_right_now']) && $ps_options['ps_right_now'] ) {
		return $items;
	}

	// get the statuses
	$ps_statuses = get_post_stati( array( 'show_in_admin_status_list' => true ), 'objects' );

	// filter the list of statuses for anything people want to do
	$ps_statuses = apply_filters( 'psmi_statuses', $ps_statuses );

	// Get status counts of all post types
	$ps_status_counts = wp_count_posts( 'post' );

	// Build a string of all new list items to append to $items
	$glance_status_html = '';
	// loop through statuses array
	foreach( $ps_statuses as $status ) {

		$ps_status_id = $status->name;

		$ps_status_count = $ps_status_counts -> $ps_status_id;

		// If a status has any posts, show it
		if( $ps_status_count > 0 ) {
			// Get the plural post status label
			$ps_status_label = $status->label;
			$glance_status_html .= sprintf(
				'<li class="%2$s-status-post-count"><a href="%1$sedit.php?post_status=%2$s">%3$s %4$s</a></li>',
				get_admin_url(),
				$ps_status_id,
				intval( $ps_status_count ),
				esc_attr( $ps_status_label )
			);

		}
	}

	// escape the first list, output new list, open third list.
	$items[] = '</li></ul><h4>' . _x( 'Posts', 'the Posts core post type', 'post-status-menu-items' ) . '</h4><ul class="ps-post-statuses">' . $glance_status_html . '</ul><ul><li>';

	return $items;
}
add_filter( 'dashboard_glance_items', 'ps_at_a_glance_widget', -10 );



/* ============================================
	PLUGIN SETTINGS
   ============================================ */

/* Plugin Settings Link */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'ps_add_settings_link' );

function ps_add_settings_link( $links ) {
	$ps_links = array(
		'<a href="' . admin_url( 'options-writing.php#psmi-settings' ) . '">Plugin Settings</a>',
	);
	return array_merge( $links, $ps_links );
}

/**
 * adds setting section, adds and registers all settings fields, sets posts to show by default
 */
function ps_settings_api_init() {
	// Add the section to writing settings so we can add our fields to it
	add_settings_section(
		'ps_setting_section',
		sprintf( _x( '%1$sPost Status Menu Items Plugin Settings%2$s', 'plugin settings heading, wrapped in span with ID for settings link', 'post-status-menu-items' ),
			'<span id="psmi-settings">',
			'</span>'
		),
		'ps_setting_section_callback_function',
		'writing'
	);

	register_setting( 'writing', 'psmi_options', 'psmi_sanitize_options' );

	// Post type option
	add_settings_field(
		'psmi_options_post_type',
		__( 'Show statuses in menu for these post types', 'post-status-menu-items' ),
		'psmi_options_post_type_cb',
		'writing',
		'ps_setting_section'
	);

	// Post status option
	add_settings_field(
		'psmi_options_post_stati',
		__( 'Hide these statuses for post type menus ', 'post-status-menu-items' ),
		'psmi_options_post_stati_cb',
		'writing',
		'ps_setting_section'
	);

	// Right Now Dashboard Option
	add_settings_field(
		'psmi_options_right_now',
		__( 'Hide Statuses in "Right Now" / "At a Glance" Dashboard Widget', 'post-status-menu-items' ),
		'psmi_options_right_now_cb',
		'writing',
		'ps_setting_section'
	);
}


/**
 * plugin option settings section callback
 */
function ps_setting_section_callback_function() {}

/**
 * create plugin post type options form elements
 */
function psmi_options_post_type_cb() {
	$psmi_options = get_option( 'psmi_options' );
	$ps_post_types = ps_get_post_type_list();

	// Post Type Options
	foreach( $ps_post_types as $ps_type_id => $ps_type_name ) {
		$option = ( isset( $psmi_options['ps_post_types'][$ps_type_id] ) ? $psmi_options['ps_post_types'][$ps_type_id] : false );
		printf(
			'<input name="psmi_options[ps_post_types][%1$s]" id="psmi_options[ps_post_types][%1$s]" type="checkbox" value="true" %2$s />
			<label for="psmi_options[ps_post_types][%1$s]">' . __( 'Show statuses in the <strong>%3$s</strong> menu.', 'post-status-menu-items' ) . '</label><br />',
			esc_attr( $ps_type_id ),
			checked( $option, true, false ),
			esc_attr( $ps_type_name )
		);
	}
}

/**
 * create plugin post status options form elements
 */
function psmi_options_post_stati_cb() {
	$psmi_options = get_option( 'psmi_options' );
	$ps_statuses = get_post_stati( array( 'show_in_admin_status_list' => true ), 'objects' );

	// Post Type Options
	foreach( $ps_statuses as $status ) {
		$ps_status_id = $status->name;
		$ps_status_label = $status->label;

		$option = ( isset( $psmi_options['ps_post_stati'][$ps_status_id] ) ? $psmi_options['ps_post_stati'][$ps_status_id] : false );

		printf(
			'<input name="psmi_options[ps_post_stati][%1$s]" id="psmi_options[ps_post_stati][%1$s]" type="checkbox" value="true" %2$s />
			<label for="psmi_options[ps_post_stati][%1$s]">' . __( 'Hide <strong>%3$s</strong> status in admin menus.', 'post-status-menu-items' ) . '</label><br />',
			esc_attr( $ps_status_id ),
			checked( $option, true, false ),
			esc_attr( $ps_status_label )
		);
	}
}

/**
 * create plugin right now dashboard options form elements
 */
function psmi_options_right_now_cb() {
	$psmi_options = get_option( 'psmi_options' );
	$option = ( isset( $psmi_options['ps_right_now'] ) ? $psmi_options['ps_right_now'] : false );
	printf(
		'<input name="psmi_options[ps_right_now]" id="psmi_options[ps_right_now]" type="checkbox" value="true" %1$s />
		<label for="psmi_options[ps_right_now]">' . __( 'Hide Posts Statuses list on the Dashboard.', 'post-status-menu-items' ) . '</label><br />',
		checked( $option, true, false )
	);
}

/**
 * sanitize post type plugin options
 *
 * @param	array	$input	list of submitted option values
 * @return	array			sanitized options
 */
function psmi_sanitize_options( $input ) {
	$current_options = get_option( 'psmi_options' );

	$ps_post_types = ps_get_post_type_list();
	$ps_statuses = get_post_stati( array( 'show_in_admin_status_list' => true ), 'objects' );

	// all post types should be true or false
	foreach( $ps_post_types as $id => $label ) {
		$current_options['ps_post_types'][$id] = ( ! empty( $input['ps_post_types'][$id] )  ? true : false );
	}

	// all post statuses should be true or false
	foreach( $ps_statuses as $id => $option_value ) {
		$current_options['ps_post_stati'][$id] = ( ! empty( $input['ps_post_stati'][$id] ) ? true : false );
	}

	$current_options['ps_right_now'] = ( ! empty( $input['ps_right_now'] )  ? true : false );

	return $current_options;
}


/* ============================================
	ADMIN STYLES
   ============================================ */
function ps_admin_styles() {
	$ps_options = get_option( 'psmi_options' );
	// stop if we're hiding it.
	wp_enqueue_style( 'psmi_admin_css', plugins_url( 'css/psmi_admin_styles.css', __FILE__), false, PSMI_VERSION );
}


/* ============================================
	HOOKS
   ============================================ */

// Activation, Upgrade, and Deactivation
register_activation_hook( __FILE__, 'psmi_activate' );
add_action( 'admin_init', 'psmi_upgrade' );
register_uninstall_hook( __FILE__, 'psmi_uninstall' );

// i18n
add_action( 'plugins_loaded', 'psmi_textdomain' );

// styles
add_action( 'admin_enqueue_scripts', 'ps_admin_styles' );

// Plugin Settings
add_filter( 'psmi_statuses', 'ps_remove_excluded_post_statuses' );
add_action('admin_init', 'ps_settings_api_init');

// Adds items to menu
add_action( 'admin_menu', 'cms_post_status_menu' );