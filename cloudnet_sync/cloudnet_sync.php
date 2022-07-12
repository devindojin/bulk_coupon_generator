<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.vll.com
 * @since             1.0.0
 * @package           Cloudnet_sync
 *
 * @wordpress-plugin
 * Plugin Name:       CloudNet Sync
 * Plugin URI:        www.google.com
 * Description:       This plugin is made for synching data from CloudNet360 marchent account to wordpress admin.Site admin can display his CloudNet360 account products to Wordpress site using this plugin.
 * Version:           1.0.0
 * Author:            vll
 * Author URI:        www.vll.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cloudnet_sync
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PLUGIN_NAME_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cloudnet_sync-activator.php
 */
function activate_cloudnet_sync() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-cloudnet_sync-activator.php';
    Cloudnet_sync_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cloudnet_sync-deactivator.php
 */
function deactivate_cloudnet_sync() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-cloudnet_sync-deactivator.php';
    Cloudnet_sync_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_cloudnet_sync');
register_deactivation_hook(__FILE__, 'deactivate_cloudnet_sync');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-cloudnet_sync.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
/* * Add wp List table in wordpress */

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

function run_cloudnet_sync() {

    $plugin = new Cloudnet_sync();
    $plugin->run();
}

run_cloudnet_sync();
