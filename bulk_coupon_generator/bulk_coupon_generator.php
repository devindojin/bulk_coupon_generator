<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.vlogiclabs.com
 * @since             1.0.0
 * @package           Bulk_coupon_generator
 *
 * @wordpress-plugin
 * Plugin Name:       Bulk Coupon Generator
 * Plugin URI:        https://github.com/showonmydev
 * Description:       This plugin can generate coupon codes and pdf for discounts.
 * Version:           1.0.0
 * Author:            Rajnesh
 * Author URI:        www.vlogiclabs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bulk_coupon_generator
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/* * ****Inlcude /******** */
if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PLUGIN_NAME_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bulk_coupon_generator-activator.php
 */
function activate_bulk_coupon_generator() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-bulk_coupon_generator-activator.php';
    Bulk_coupon_generator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bulk_coupon_generator-deactivator.php
 */
function deactivate_bulk_coupon_generator() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-bulk_coupon_generator-deactivator.php';
    Bulk_coupon_generator_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_bulk_coupon_generator');
register_deactivation_hook(__FILE__, 'deactivate_bulk_coupon_generator');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-bulk_coupon_generator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bulk_coupon_generator() {

    $plugin = new Bulk_coupon_generator();
    $plugin->run();
}

run_bulk_coupon_generator();
