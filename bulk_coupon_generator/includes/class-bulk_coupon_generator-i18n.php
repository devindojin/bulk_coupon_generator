<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.vlogiclabs.com
 * @since      1.0.0
 *
 * @package    Bulk_coupon_generator
 * @subpackage Bulk_coupon_generator/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Bulk_coupon_generator
 * @subpackage Bulk_coupon_generator/includes
 * @author     Rajnesh <kantravipal@gmail.com>
 */
class Bulk_coupon_generator_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bulk_coupon_generator',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
