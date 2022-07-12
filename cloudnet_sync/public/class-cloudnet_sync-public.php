<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.vll.com
 * @since      1.0.0
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/public
 * @author     vll <vll@gmail.com>
 */
class Cloudnet_sync_Public {

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
         * defined in Cloudnet_sync_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cloudnet_sync_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cloudnet_sync-public.css', array(), $this->version, 'all');
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
         * defined in Cloudnet_sync_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cloudnet_sync_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cloudnet_sync-public.js', array('jquery'), $this->version, false);
    }

    public function cloudnet_products_showcase() {

        $this->cloudnet_page_display();

//           $this->cloudnet_page_list_view();
    }

    public function cloudnet_page_display() {
        $arr = array(
            'post_type' => 'cloudnet_product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'offset' => 0,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $posts = get_posts($arr);

        if (!empty($posts)) {
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cloudnet_product_grid_view.php';
        }
    }

    public function cloudnet_page_list_view() {
        $arr = array(
            'post_type' => 'cloudnet_product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'offset' => 0,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $posts = get_posts($arr);
        if (!empty($posts)) {
            /* --cloudnet_product_list_view -- */
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cloudnet_product_list_view.php';
        }
    }

}
