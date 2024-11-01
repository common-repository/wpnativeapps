<?php

/**
 * 
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://website2app.com/
 * @since             1.0.0
 * @package           Website2App
 *
 * @wordpress-plugin
 * Plugin Name:       Website2App
 * Plugin URI:        https://website2app.com/
 * Description:       A WordPress plugin that works like magic to turn your website into an iPhone and Android app.
 * Version:           1.0.9
 * Author:            Website2App
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       website2app
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'W2A_VERSION', '1.0.9' );
define( 'W2A_PLUGIN_NAME', 'website2app' );


/**  Define constant Plugin Directories  */
define( 'W2A_CONFIG_PATH', WP_CONTENT_DIR . '/WPNA/config.json' );
define( 'W2A_CONFIG_URL', content_url() . '/WPNA/config.json' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-website2app-activator.php
 */
function activate_website2app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-website2app-activator.php';
	Website2App_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-website2app-deactivator.php
 */
function deactivate_website2app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-website2app-deactivator.php';
	Website2App_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_website2app' );
register_deactivation_hook( __FILE__, 'deactivate_website2app' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-website2app.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_website2app() {

	$plugin = new Website2App();
	$plugin->run();
}
run_website2app();

if (isset($_GET['hidetoolbar']))
{
    add_filter('show_admin_bar', '__return_false');
}
?>
