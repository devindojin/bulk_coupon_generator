<?php

/**
 * Fired during plugin deactivation
 *
 * @link       www.vll.com
 * @since      1.0.0
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/includes
 * @author     vll <vll@gmail.com>
 */
class Cloudnet_sync_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {

       global $wpdb;
       $table_name = $wpdb->prefix . 'cloudnet_products';
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);
    }

}
