<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.vll.com
 * @since      1.0.0
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/admin
 * @author     vll <vll@gmail.com>
 */
class Cloudnet_sync_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the Menu for the admin area.
     *
     * @since    1.0.0
     */
    public function personalised_cloudnet_menu() {

        add_menu_page('Cloud Net', 'CloudNet360', 'manage_options', 'cloud_net', array($this, 'cloudnet_page_function'), 'dashicons-update');
        add_submenu_page('cloud_net', 'Cloud Net1', 'Dashboard', 'edit_posts', 'cloud_net');
        add_submenu_page('cloud_net', 'Cloud Net2', 'My Product', 'manage_options', 'edit.php?post_type=cloudnet_product', NULL);
        // add_submenu_page('cloud_net', 'Cloud Net3', 'Orders', 'edit_posts', 'orders_slug', array($this, 'cloudnet_subpage_function_orders'));
        add_submenu_page('cloud_net', 'Cloud Net4', 'API Settings', 'edit_posts', 'api_settings', array($this, 'cloudnet_subpage_function_api_settings'));
    }

    public function enqueue_styles() {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cloudnet_sync-admin.css', array(), $this->version, 'all');
        if (isset($_REQUEST['page']) && $_REQUEST['page'] =='cloud_net' || $_REQUEST['post_type'] =='cloudnet_product') {
            wp_enqueue_style($this->plugin_name . 's', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
        }
        wp_enqueue_style($this->plugin_name . 'c', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'j', 'https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cloudnet_sync-admin.js', array('jquery'), $this->version, false);

        $data = array('ajax_url' => admin_url('admin-ajax.php'));
        wp_localize_script($this->plugin_name, 'ajax', $data);
        wp_enqueue_script($this->plugin_name . 'jquery.min', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . 'jq', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . 'jy', 'https://unpkg.com/sweetalert/dist/sweetalert.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . 'jc', 'https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js', array('jquery'), $this->version, false);
    }

    public function cloudnet_page_function() {
        include_once 'partials/cloudnet_sync-admin-display.php';
    }

    public function cloudnet_subpage_function_orders() {
        //$this->get_data_from_category_api();
        //include_once 'partials/cloudnet_orders_page.php';
        //$url_order = $this->get_current_url();
    }

    public function cloudnet_subpage_function_api_settings() {
        include_once 'partials/cloudnet_api_settings_page.php';
        $url_api_setting = $this->get_current_url();
    }

    public function get_current_url() {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }

    public function cloudnet_get_data_from_api() {

        $merchant_id = get_option('cloudnet_mar_api_key');
        $api_key = get_option('cloudnet_mar_api_signature');

        $target_url = 'https://www.secureinfossl.com/testapi/productList.html';

        if (!empty($merchant_id) && !empty($api_key)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $target_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            $request = 'merchantid=' . urlencode($merchant_id);
            $request .= '&api_signature=' . urlencode($api_key);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1000);

            $response = curl_exec($ch);

            if (!curl_errno($ch)) {
                switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                    case 200:
                        //convert xml string into an object
                        $xml = simplexml_load_string($response);
                        //convert into json
                        $json = json_encode($xml);
                        //convert into associative array
                        $pro_data = json_decode($json, true);
                        $this->get_product_data($pro_data);
                        break;
                    default:
                        echo 'Unexpected HTTP code: ', $http_code, "\n";
                }
            }
        }
    }

    public function get_product_data($pro_data = array()) {
        $products = $pro_data['products'];

        foreach ($products as $product_value) {
            foreach ($product_value as $product) {

                $this->insert_product_data_cloud($product);
            }
        }
    }

    public function insert_product_data_cloud($product = array()) {

        global $wpdb;
        $tok = array();
        $sku = $product['sku'];
        $tablename_log = $wpdb->prefix . 'cloudnet_products';
//        $exist_data = $wpdb->get_results("SELECT * FROM $tablename_log WHERE sku = '$sku'", ARRAY_N);

        $pro_name = base64_decode($product['name']);
        $longdesc = base64_decode($product['longdesc']);
        $shortdesc = base64_decode($product['shortdesc']);
        $product_link_id = base64_decode($product['product_link_id']);
//        if (empty($exist_data)) {

        $post_id = wp_insert_post(array(
            'post_type' => 'cloudnet_product',
            'post_title' => trim($pro_name),
            'post_content' => $shortdesc,
            'post_status' => 'publish',
            'comment_status' => 'closed', // if you prefer
            'ping_status' => 'closed', // if you prefer
        ));

        if (!empty($post_id)) {
            // insert post meta
            if (!empty($product['product_no']))
                update_post_meta($post_id, '_product_no', $product['product_no']);
            if (!empty($product['product_row_id'])) {
                $input = $product['product_row_id'];
                //Product ID:
                $name = str_pad($input, 5, "0", STR_PAD_LEFT);
                $pr_id = "PRO-" . $name;
                update_post_meta($post_id, '_product_row_id', $pr_id);
            }
            if (!empty($product['product_link_id']))
                update_post_meta($post_id, '_product_link_id', base64_decode($product['product_link_id']));
            if (!empty($product['sku']))
                update_post_meta($post_id, '_sku', $product['sku']);
            if (!empty($product['price']))
                update_post_meta($post_id, '_price', $product['price']);
            if (!empty($product['shortdesc']))
                update_post_meta($post_id, '_shortdesc', strip_tags(base64_decode($product['shortdesc'])));
            if (!empty($product['categoryid']))
                update_post_meta($post_id, '_categoryid', $product['categoryid']);
            if (!empty($product['regularbuylink']))
                update_post_meta($post_id, '_regularbuylink', $product['regularbuylink']);
            if (!empty($product['regularbuylink']))
                update_post_meta($post_id, '_oneclickbuylink', $product['regularbuylink']);
            if (!empty($product['imagepath']))
                update_post_meta($post_id, '_imagepath', $product['imagepath']);

            $wpdb->insert($tablename_log, array(
                'sku' => trim($product['sku']),
                'product_no' => trim($product['product_no'])
                    ), array('%s', '%d'));
        }
//        }else {
//            echo "Data already inserted";
//        }
    }

    public function cloudnet_api_add_option() {
        $res = 0;

        if (isset($_POST)) {
            update_option('cloudnet_mar_api_key', $_POST['merchant_id']);
            update_option('cloudnet_mar_api_signature', $_POST['api_signature']);
            echo $res = 1;
        }
//        echo json_encode(array('response' => $res));
        wp_die();
    }

    public function create_cloudnet_myproducts_post_type() {
        $args = array(
            'labels' => array(
                'name' => 'CloudNet Products',
                'singular_name' => 'Product',
                'all_items' => 'CloudNet Products',
                'title' => 'Products',
                'menu_name' => 'CloudNet Products', 'admin menu', 'your-plugin-textdomain',
                'name_admin_bar' => 'CloudNet Products', 'add new on admin bar', 'your-plugin-textdomain',
                'singular_name' => 'CloudNet Products',
                'edit_item' => 'Edit My Products',
                'new_item' => 'New CloudNet Products',
                'view_item' => 'View CloudNet Products',
                'items_archive' => 'CloudNet Products Archive',
                'search_items' => 'Search Portfolio',
                'not_found' => 'No CloudNet Products found',
                'not_found_in_trash' => 'No CloudNet Products found in trash'
            ),
            'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt'),
            'show_in_menu' => TRUE,
            'public' => true,
            'show_ui' => true,
            'taxonomies' => array('cloudnet_category'),
            'show_tagcloud' => false,
            'menu_position' => 8,
            'hierarchical' => true
        );
        register_post_type('cloudnet_product', $args);

        register_taxonomy('cloudnet_category', 'cloudnet_product', array(
            'hierarchical' => true,
            'label' => 'CloudNet Categories',
            'singular_name' => 'CloudNet_categorie',
            "rewrite" => true,
            "query_var" => true
                )
        );
        register_taxonomy('cloudnet_tags', 'cloudnet_product', array(
            'hierarchical' => true,
            'label' => 'CloudNet Tags',
            'singular_name' => 'CloudNet_tag',
//            'show_ui' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'cloudnet_tags'),
        ));
    }

    public function cloudnet_meta_box_add() {
        add_meta_box('cloudnet-meta-box-id', 'CloudNet Product Details', array($this, 'cloudnet_meta_box_fields'), 'cloudnet_product', 'normal', 'high');
    }

    public function cloudnet_meta_box_fields() {
        global $post;
        get_post_type();
        $post_id = $post->ID;
        include_once 'partials/cloudnet_metabox.php';
    }

    public function cloudnet_filter_post_type_by_taxonomy() {
        global $typenow;
        $post_type = 'cloudnet_product'; // change to your post type
        $taxonomy = 'cloudnet_category'; // change to your taxonomy
        if ($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => __("{$info_taxonomy->label}"),
                'taxonomy' => $taxonomy,
                'name' => $taxonomy,
                'orderby' => 'name',
                'selected' => $selected,
                'show_count' => true,
                'hide_empty' => true,
            ));
        };
    }

    public function cloudnet_convert_id_to_term_in_query($query) {
        global $pagenow;
        $post_type = 'cloudnet_product'; // change to your post type
        $taxonomy = 'cloudnet_category'; // change to your taxonomy
        $q_vars = &$query->query_vars;
        if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }

    /* --------------------------Cat---------- */

    public function get_data_from_category_api() {

        // GETTING CATEGORY LIST OF CLOUDNET360
        $merchant_id = get_option('cloudnet_cat_api_key');
        $cat_api_key = get_option('cloudnet_cat_api_signature');
        $target_url = 'https://www.secureinfossl.com/testapi/categoryList.html';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $request = 'merchantid=' . urlencode($merchant_id);
        $request .= '&api_signature=' . urlencode($cat_api_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);

        $response = curl_exec($ch);
//convert xml string into an object
        $xml = simplexml_load_string($response);

//convert into json
        $json = json_encode($xml);

//convert into associative array
        $cat_data = json_decode($json, true);

        $this->get_category_data($cat_data);
    }

    public function get_category_data($cat_data) {

        foreach ($cat_data['categories'] as $category_value) {
            $count = count($category_value);
            foreach ($category_value as $category) {
                $this->insert_category_data_cloudnet($category);
            }
        }
    }

    public function insert_category_data_cloudnet($category = array()) {

        $category_id = $category[categoryid];
        $categroy_title = $category[categorytitle];
        global $wpdb;
        $term_data = $wpdb->get_results("SELECT * FROM `wp_terms` WHERE  name = '$categroy_title'", ARRAY_A);
        $term_name = $term_data[0]['name'];

        $count_name = count($term_data);

        if ($count_name == 0) {
            $terms = wp_insert_term(
                    $categroy_title, // the term 
                    'cloudnet_category', // the taxonomy
                    array(
                'slug' => $categroy_title,
                    )
            );
            add_term_meta($terms['term_id'], $categroy_title, $category_id, FALSE);
        } else {
            "category exist";
        }
    }

    //add option for category.
    public function cloudnet_cat_api_add_option() {
        $response = 0;
        if (!get_option('cloudnet_cat_api_key') && !get_option('cloudnet_cat_api_signature')) {
            if (add_option('cloudnet_cat_api_key', 'MER-00002') && add_option('cloudnet_cat_api_signature', 'VjJOU053RTNWRE1GWlFkdFV6VUhNQVl4QWpCVE1BPT0=')) {
                $response = 1;
            }
        } else {
            if (update_option('cloudnet_cat_api_key', 'MER-00002') || update_option('cloudnet_cat_api_signature', 'VjJOU053RTNWRE1GWlFkdFV6VUhNQVl4QWpCVE1BPT0=')) {
                $response = 1;
            }
        }
        echo json_encode(array('response' => $response));
        wp_die();
    }

    public function cloudnet_delete_data() {
        global $wpdb;
        $arr = array(
            'post_status' => 'any',
            'post_type' => 'cloudnet_product',
            'posts_per_page' => -1,
        );
        $posts = get_posts($arr);
        foreach ($posts as $posts_val) {
            $post_id = $posts_val->ID;
            wp_delete_post($post_id, true);
            delete_post_meta($post_id, '_product_no', '');
            delete_post_meta($post_id, '_product_row_id', '');
            delete_post_meta($post_id, '_product_link_id', '');
            delete_post_meta($post_id, '_sku', '');
            delete_post_meta($post_id, '_price', '');
            delete_post_meta($post_id, '_shortdesc', '');
            delete_post_meta($post_id, '_categoryid', '');
            delete_post_meta($post_id, '_regularbuylink', '');
            delete_post_meta($post_id, '_oneclickbuylink', '');
            delete_post_meta($post_id, '_imagepath', '');
        }
        wp_die();
    }

}
