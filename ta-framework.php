<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeatelier.net
 * @since             1.0.0
 * @package           Ta_Framework
 *
 * @wordpress-plugin
 * Plugin Name:       Ta Framework
 * Plugin URI:        https://https://wp-plugins.themeatelier.net/ta-framework
 * Description:       Ta Framework
 * Version:           1.0.0
 * Author:            ThemeAtelier
 * Author URI:        https://themeatelier.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ta-framework
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
define( 'TA_FRAMEWORK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ta-framework-activator.php
 */
function activate_ta_framework() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ta-framework-activator.php';
	Ta_Framework_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ta-framework-deactivator.php
 */
function deactivate_ta_framework() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ta-framework-deactivator.php';
	Ta_Framework_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ta_framework' );
register_deactivation_hook( __FILE__, 'deactivate_ta_framework' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ta-framework.php';
// require plugin_dir_path( __FILE__ ) . 'admin/ta-framework/samples/admin-options.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ta_framework() {

	$plugin = new Ta_Framework();
	$plugin->run();

}
run_ta_framework();
