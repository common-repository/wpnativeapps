<?php

/**
 * 
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpnativeapps.com/
 * @since             1.0.0
 * @package           WpNativeApps
 *
 * @wordpress-plugin
 * Plugin Name:       WPNativeApps
 * Plugin URI:        https://wpnativeapps.com/
 * Description:       A WordPress plugin that works like magic to turn your website into an iPhone and Android app.
 * Version:           1.0.5
 * Author:            WPNativeApps
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpnativeapps
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
define( 'WP_NATIVE_APPS_VERSION', '1.0.5' );
define( 'WP_NATIVE_APPS_PLUGIN_NAME', 'wpnativeapps' );


/**  Define constant Plugin Directories  */
define( 'WPNA_CONFIG_PATH', WP_CONTENT_DIR . '/WPNA/config.json' );
define( 'WPNA_CONFIG_URL', content_url() . '/WPNA/config.json' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpnativeapps-activator.php
 */
function activate_wp_native_apps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpnativeapps-activator.php';
	Wp_Native_Apps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpnativeapps-deactivator.php
 */
function deactivate_wp_native_apps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpnativeapps-deactivator.php';
	Wp_Native_Apps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_native_apps' );
register_deactivation_hook( __FILE__, 'deactivate_wp_native_apps' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpnativeapps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_native_apps() {

	$plugin = new Wp_Native_Apps();
	$plugin->run();
}
run_wp_native_apps();

if (isset($_GET['hidetoolbar']))
{
    add_filter('show_admin_bar', '__return_false');
}
?>
