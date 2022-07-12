<?php

/**
 * Fired during plugin activation
 *
 * @link       www.vll.com
 * @since      1.0.0
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/includes
 * @author     vll <vll@gmail.com>
 */
class Cloudnet_sync_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        global $wpdb;
        $version = get_option('my_plugin_version', '1.0');
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'cloudnet_products';

        $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    sku varchar(10) NOT NULL,
                    product_no smallint(5) NOT NULL,
                    product_link_id varchar(100) NOT NULL,
                    UNIQUE KEY sku (sku),
                    PRIMARY KEY  (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);

        if (version_compare($version, '2.0') < 0) {
            $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    sku varchar(10) NOT NULL,
                    product_no smallint(5) NOT NULL,
                    product_link_id varchar(100) NOT NULL,
                    UNIQUE KEY sku (sku),
                    PRIMARY KEY  (id)
                    ) $charset_collate;";
            dbDelta($sql);
            update_option('my_plugin_version', '2.0');
        }
    }

}
