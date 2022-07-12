<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.vlogiclabs.com
 * @since      1.0.0
 *
 * @package    Bulk_coupon_generator
 * @subpackage Bulk_coupon_generator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bulk_coupon_generator
 * @subpackage Bulk_coupon_generator/public
 * @author     Rajnesh <kantravipal@gmail.com>
 */
class Bulk_coupon_generator_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Bulk_coupon_generator_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bulk_coupon_generator_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bulk_coupon_generator-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Bulk_coupon_generator_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bulk_coupon_generator_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bulk_coupon_generator-public.js', array('jquery'), $this->version, false);

        wp_localize_script($this->plugin_name, 'plugin_dir', array('plugin_dir_url' => plugin_dir_url(__FILE__), 'plugin_dir_path' => plugin_dir_path(__FILE__)));
        wp_localize_script($this->plugin_name, 'ajax', array('url' => admin_url('admin-ajax.php')));
        wp_localize_script($this->plugin_name, 'image', array('url' => admin_url('image.php')));
        wp_localize_script($this->plugin_name, 'file', array('url' => admin_url('file.php')));
        wp_localize_script($this->plugin_name, 'media', array('url' => admin_url('media.php')));
    }

    //send data to redeem 
    public function bulk_coupon_public_reedem() {

//
    }

    //send data to redeem 
    public function bulk_coupon_reedem_form() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/bulk_coupon_generator-public-display.php';
    }

}
