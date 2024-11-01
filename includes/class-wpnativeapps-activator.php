<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpnativeapps.com/
 * @since      1.0.0
 *
 * @package    Wp_Native_Apps
 * @subpackage Wp_Native_Apps/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Native_Apps
 * @subpackage Wp_Native_Apps/includes
 * @author     WPNativeApps <wpnativeapps@hustledigital.com.au>
 */
class Wp_Native_Apps_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$wpna_admin = new Wp_Native_Apps_Admin(WP_NATIVE_APPS_PLUGIN_NAME, WP_NATIVE_APPS_VERSION);
		$wpna_admin->initializeConfig();

	}
}
