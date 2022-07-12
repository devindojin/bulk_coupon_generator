<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.vlogiclabs.com
 * @since      1.0.0
 *
 * @package    Bulk_coupon_generator
 * @subpackage Bulk_coupon_generator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bulk_coupon_generator
 * @subpackage Bulk_coupon_generator/admin
 * @author     Rajnesh <kantravipal@gmail.com>
 */
class Bulk_coupon_generator_Admin {

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

    CONST MIN_LENGTH = 12;

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
        global $wpdb;
    }

    /**
     * Register the stylesheets for the admin area.
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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bulk_coupon_generator-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
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
        
        wp_localize_script($this->plugin_name, 'plugin_dir', array('plugin_dir_url' => plugin_dir_url(__FILE__), 'plugin_dir_path' => plugin_dir_path(__FILE__)));
        wp_localize_script($this->plugin_name, 'ajax', array('url' => admin_url('admin-ajax.php')));
        wp_localize_script($this->plugin_name, 'image', array('url' => admin_url('image.php')));
        wp_localize_script($this->plugin_name, 'file', array('url' => admin_url('file.php')));

        wp_localize_script($this->plugin_name, 'plugin_dir', array('plugin_dir_url' => plugin_dir_url(__FILE__), 'plugin_dir_path' => plugin_dir_path(__FILE__)));
        wp_localize_script($this->plugin_name, 'ajax', array('url' => admin_url('admin-ajax.php')));
        wp_localize_script($this->plugin_name, 'image', array('url' => admin_url('image.php')));
        wp_localize_script($this->plugin_name, 'file', array('url' => admin_url('file.php')));
        wp_localize_script($this->plugin_name, 'media', array('url' => admin_url('media.php')));
    }

    /* Admin coupon genration section */

    public function bulk_coupon_generator_admin_menu() {
//    add_menu_page('memorial_package_menu', 'Add User Package','', 'setpackage','setpackage');
        add_menu_page('Genrate Bulk Coupon', 'Genrate Bulk Coupon', 'manage_options', 'bulk_coupon_generator', array($this, 'bulk_coupon_generator_adminPage'), 'dashicons-admin-page');
//    add_submenu_page('my-menu', 'Submenu Page Title', 'Whatever You Want', 'manage_options', 'my-menu' );
//    add_submenu_page('my-menu', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );
    }

    public function bulk_coupon_generator_adminPage() {

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/bulk_coupon_generator-admin-display.php';
    }

    public function bulk_coupon_list_output($data) {

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/bulk_coupon_generator-admin-display.php';
    }

    public function bulk_coupon_request_check() {
        global $wpdb;
        $coupons = array();
        $response = array();
        if (!empty($_POST)) {

            $am_point = $_POST['amount_of_point'];
            $point_ty = $_POST['point_type'];
            $expires = $_POST['expiry'];
            $quantity = $_POST['quantity'];
            $imageurl = '';
            $coupons = $this->generate_coupons($quantity, '', '', '', true, true, false, '', '');
            $coupons_data = implode(",", $coupons);
            if (!empty($am_point) && !empty($point_ty) && !empty($expires) && !empty($quantity) && !empty($_FILES['bg_image'])) {

                if (isset($_FILES['bg_image'])) {
                    $attachment_id = $this->bulk_coupon_any_image_upload($_FILES['bg_image']);
                    $image_attributes = wp_get_attachment_image_src($attachment_id);
                    $imageurl = trim($image_attributes[0]);
                }

                $_POST['image_url'] = $imageurl;
                $_POST['coupons'] = $coupons_data;
                $data = $_POST;
                print_r($data);
                die;
                $res = $this->bulk_coupon_request_submit($data);
                if ($res) {
                    //Create image 
                    //Create PDF using library tcpdf and send in ajax response
                    
                    
                    
                    
                    $response['massage'] = $this->bulk_coupon_success('Coupon Generated!');
                }





                required('');
            } else {
                $response['massage'] = $this->bulk_coupon_error('All filed are required.');
                ;
            }
        }
        echo json_encode(array('data' => $response));
    }

    public function bulk_coupon_request_submit($data = array()) {
        global $wpdb;
        $response = false;

        $result = $wpdb->insert(
                'wp_bulk_coupon_code', array(
            'point' => $data['amount_of_point'],
            'point_type' => $data['point_type'],
            'expires' => $data['expiry'],
            'qty' => $data['quantity'],
            'coupons' => $data['coupons'],
            'ticket_image_url' => $data['image_url'],
                ), array(
            '%d',
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
        ));

        if ($result) {
            $response = true;
        }
        if (is_wp_error($result)) {
            $response = false;
        }
        return $response;
    }

    // Comman fucntion to upload any image any time :) 
    public function bulk_coupon_any_image_upload($img) {
        // Check if it gets the id

        $files = $img;
        $all_attachment_id = array();

        if ($files['name']) {
            $file = array(
                'name' => $files['name'],
                'type' => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error' => $files['error'],
                'size' => $files['size']
            );

            $_FILES = array("my_file_upload" => $file);

            foreach ($_FILES as $file => $array) {

                $file_handler = $file;

                $set_thu = false;
                // check to make sure its a successful upload
                if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK)
                    __return_false();

                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                require_once(ABSPATH . "wp-admin" . '/includes/media.php');

                $attach_id = media_handle_upload($file_handler, $post_id);
            }
        }
        return $attach_id;
    }

    //List data
    public function bulk_coupon_render_list_page() {


        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

        $myListTable = new My_Example_List_Table();
        echo '<div class="wrap"><h2>My List Table Test</h2>';
        $myListTable->prepare_items();
        $myListTable->display();
        echo '</div>';
    }

    public function bulk_coupon_success($success_msg) {
        $msg = '';
        if (!empty($success_msg)) {
            $msg = '<div id = "message" class = "updated notice is-dismissible"><p>' . _e($success_msg, 'my_plugin_textdomain') . '</strong>.</p><button type = "button" class = "notice-dismiss"><span class = "screen-reader-text">Dismiss this notice.</span></button></div>';
        }
        return $msg;
    }

    public function bulk_coupon_error($error) {
        $msg = '';
        if (!empty($error)) {
            $msg = '<div id = "message" class = "updated notice is-dismissible"><p>' . _e($error, 'my_plugin_textdomain') . '</strong>.</p><button type = "button" class = "notice-dismiss"><span class = "screen-reader-text">Dismiss this notice.</span></button></div>';
        }
        return $msg;
    }

    /**
     * MASK FORMAT [XXX-XXX]
     * 'X' this is random symbols
     * '-' this is separator
     *
     * @param array $options
     * @return string
     * @throws Exception
     */
    public function generate($options = []) {

        $length = (isset($options['length']) ? filter_var($options['length'], FILTER_VALIDATE_INT, ['options' => ['default' => self::MIN_LENGTH, 'min_range' => 1]]) : self::MIN_LENGTH );
        $prefix = (isset($options['prefix']) ? self::cleanString(filter_var($options['prefix'], FILTER_SANITIZE_STRING)) : '' );
        $suffix = (isset($options['suffix']) ? self::cleanString(filter_var($options['suffix'], FILTER_SANITIZE_STRING)) : '' );
        $useLetters = (isset($options['letters']) ? filter_var($options['letters'], FILTER_VALIDATE_BOOLEAN) : true );
        $useNumbers = (isset($options['numbers']) ? filter_var($options['numbers'], FILTER_VALIDATE_BOOLEAN) : false );
        $useSymbols = (isset($options['symbols']) ? filter_var($options['symbols'], FILTER_VALIDATE_BOOLEAN) : false );
        $useMixedCase = (isset($options['mixed_case']) ? filter_var($options['mixed_case'], FILTER_VALIDATE_BOOLEAN) : false );
        $mask = (isset($options['mask']) ? filter_var($options['mask'], FILTER_SANITIZE_STRING) : false );

        $uppercase = ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
        $lowercase = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'];
        $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $symbols = ['`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '=', '+', '\\', '|', '/', '[', ']', '{', '}', '"', "'", ';', ':', '<', '>', ',', '.', '?'];

        $characters = [];
        $coupon = '';

        if ($useLetters) {
            if ($useMixedCase) {
                $characters = array_merge($characters, $lowercase, $uppercase);
            } else {
                $characters = array_merge($characters, $uppercase);
            }
        }

        if ($useNumbers) {
            $characters = array_merge($characters, $numbers);
        }

        if ($useSymbols) {
            $characters = array_merge($characters, $symbols);
        }

        if ($mask) {
            for ($i = 0; $i < strlen($mask); $i++) {
                if ($mask[$i] === 'X') {
                    $coupon .= $characters[mt_rand(0, count($characters) - 1)];
                } else {
                    $coupon .= $mask[$i];
                }
            }
        } else {
            for ($i = 0; $i < $length; $i++) {
                $coupon .= $characters[mt_rand(0, count($characters) - 1)];
            }
        }

        return $prefix . $coupon . $suffix;
    }

    /**
     * @param int $maxNumberOfCoupons
     * @param array $options
     * @return array
     */
    public function generate_coupons($maxNumberOfCoupons = 1, $options = []) {
        $coupons = [];
        for ($i = 0; $i < $maxNumberOfCoupons; $i++) {
            $temp = self::generate($options);
            $coupons[] = $temp;
        }
        return $coupons;
    }

    /**
     * @param int $maxNumberOfCoupons
     * @param $filename
     * @param array $options
     */
    public function generate_coupons_to_xls($maxNumberOfCoupons = 1, $filename, $options = []) {
        $filename = (empty(trim($filename)) ? 'coupons' : trim($filename));

        header('Content-Type: application/vnd.ms-excel');

        echo 'Coupon Codes' . "\t\n";
        for ($i = 0; $i < $maxNumberOfCoupons; $i++) {
            $temp = self::generate($options);
            echo $temp . "\t\n";
        }

        header('Content-disposition: attachment; filename=' . $filename . '.xls');
    }

    /**
     * Strip all characters but letters and numbers
     * @param $string
     * @param array $options
     * @return string
     * @throws Exception
     */
    public function cleanString($string, $options = []) {
        $toUpper = (isset($options['uppercase']) ? filter_var($options['uppercase'], FILTER_VALIDATE_BOOLEAN) : false);
        $toLower = (isset($options['lowercase']) ? filter_var($options['lowercase'], FILTER_VALIDATE_BOOLEAN) : false);

        $striped = preg_replace('/[^a-zA-Z0-9]/', '', trim($string));

        // make uppercase
        if ($toLower && $toUpper) {
            throw new Exception('You cannot set both options (uppercase|lowercase) to "true"!');
        } else if ($toLower) {
            return strtolower($striped);
        } else if ($toUpper) {
            return strtoupper($striped);
        } else {
            return $striped;
        }
    }

}
