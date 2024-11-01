<?php

/**
 * Fired during plugin activation
 *
 * @link       https://website2app.com/
 * @since      1.0.0
 *
 * @package    Website2App
 * @subpackage Website2App/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Website2App
 * @subpackage Website2App/includes
 * @author     Website2App <website2app@hustledigital.com.au>
 */
class Website2App_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$w2a_admin = new Website2App_Admin(W2A_PLUGIN_NAME, W2A_VERSION);
		$w2a_admin->initializeConfig();

	}
}
