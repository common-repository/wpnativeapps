<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://website2app.com/
 * @since      1.0.0
 *
 * @package    Website2App
 * @subpackage Website2App/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Website2App
 * @subpackage Website2App/includes
 * @author     Website2App <website2app@hustledigital.com.au>
 */
class Website2App_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( 'Website2AppConfigMessage');

	}

}
