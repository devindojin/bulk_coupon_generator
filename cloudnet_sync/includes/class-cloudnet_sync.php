<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.vll.com
 * @since      1.0.0
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/includes
 * @author     vll <vll@gmail.com>
 */
class Cloudnet_sync {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Cloudnet_sync_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if (defined('PLUGIN_NAME_VERSION')) {
            $this->version = PLUGIN_NAME_VERSION;
        } else {
            $this->version = '12.0.0';
        }
        $this->plugin_name = 'cloudnet_sync';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Cloudnet_sync_Loader. Orchestrates the hooks of the plugin.
     * - Cloudnet_sync_i18n. Defines internationalization functionality.
     * - Cloudnet_sync_Admin. Defines all hooks for the admin area.
     * - Cloudnet_sync_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cloudnet_sync-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cloudnet_sync-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cloudnet_sync-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-cloudnet_sync-public.php';

        $this->loader = new Cloudnet_sync_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Cloudnet_sync_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Cloudnet_sync_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Cloudnet_sync_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        $this->loader->add_action('admin_menu', $plugin_admin, 'personalised_cloudnet_menu');

        $this->loader->add_action('init', $plugin_admin, 'create_cloudnet_myproducts_post_type');


        $this->loader->add_action('admin', $plugin_admin, 'cloudnet_add_new_product_page');

        $this->loader->add_action('wp_ajax_cloudnet_api_add_option', $plugin_admin, 'cloudnet_api_add_option');
        $this->loader->add_action('wp_ajax_nopriv_cloudnet_api_add_option', $plugin_admin, 'cloudnet_api_add_option');

        $this->loader->add_action('add_meta_boxes', $plugin_admin, 'cloudnet_meta_box_add');

        $this->loader->add_action('wp_ajax_cloudnet_get_data_from_api', $plugin_admin, 'cloudnet_get_data_from_api');
        $this->loader->add_action('wp_ajax_nopriv_cloudnet_get_data_from_api', $plugin_admin, 'cloudnet_get_data_from_api');
        
        $this->loader->add_action('wp_ajax_cloudnet_delete_data', $plugin_admin, 'cloudnet_delete_data');
        $this->loader->add_action('wp_ajax_nopriv_cloudnet_delete_data', $plugin_admin, 'cloudnet_delete_data');

        $this->loader->add_action('restrict_manage_posts', $plugin_admin, 'cloudnet_filter_post_type_by_taxonomy');
        $this->loader->add_filter('parse_query', $plugin_admin, 'cloudnet_convert_id_to_term_in_query');

        /* ----------------------------New cat function for cat input---------------------------- */
        $this->loader->add_action('wp_ajax_get_data_from_category_api', $plugin_admin, 'get_data_from_category_api');
        $this->loader->add_action('wp_ajax_nopriv_get_data_from_category_api', $plugin_admin, 'get_data_from_category_api');
        $this->loader->add_filter('admin', $plugin_admin, 'cloudnet_cat_api_add_option');
        /* ----------------------------New cat function for cat input---------------------------- */
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Cloudnet_sync_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        /* --------------------------Shortcode for display -------------- */
        add_shortcode('cloudnet_products_showcase', array($plugin_public, 'cloudnet_products_showcase'));
        
        add_shortcode('cloudnet_product_grid_view', array($plugin_public, 'cloudnet_page_display'));
        add_shortcode('cloudnet_product_list_view', array($plugin_public, '     '));
        
        
        $this->loader->add_action('wp_ajax_cloudnet_products_showcase', $plugin_admin, 'cloudnet_products_showcase');
        $this->loader->add_action('wp_ajax_nopriv_cloudnet_products_showcase', $plugin_admin, 'cloudnet_products_showcase');
        /* --------------------------Shortcode for display -------------- */
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run(
    ) {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Cloudnet_sync_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
