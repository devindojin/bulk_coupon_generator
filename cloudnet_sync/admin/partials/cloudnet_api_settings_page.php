<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.vll.com
 * @since      1.0.0
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/admin/partials
 */
?>

<div class="wrap">
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    <div id="postexcerpt" class="postbox">
                        <!--<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">API Settings</span><span class="toggle-indicator" aria-hidden="true"></span></button>-->
                        <h2 class="hndle ui-sortable-handle"><span>API Settings</span></h2>
                        <div class="inside">
                            <label class="screen-reader-text" for="excerpt">API Settings</label>
                            <form id="cloud_api_data" method="post" name="">
                                <h5><strong>MERCHANT ID</strong></h5>
                                <p>Login to CloudNet360, Form Dashboard >><br>
                                    Cart Settings >> Advanced Integration >><br>
                                    API Integration Tab
                                </p>
                                <input class="form-control" type="text" name="merchant_id" value="<?php echo get_option('cloudnet_mar_api_key'); ?>" id="merchant_id">
                                <h5><strong>API Signature</strong></h5>
                                <p>Login to CloudNet360, Form Dashboard >><br>
                                    Cart Settings >> Advanced Integration >><br>
                                    API Integration Tab
                                </p>
                                <textarea class="form-control" rows="1" cols="100" name="api_signature" id="api_signature"><?php echo trim(get_option('cloudnet_mar_api_signature')); ?></textarea> 
                                <br>
                                <input type="button" name="save" id="save_cloud_api" class="button button-primary button-large" value="Save">
                            </form>
                        </div>
                    </div>
                </div>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div></div>
        </div><!-- /post-body -->
        <div id="post-body" class="metabox-holder columns-2">
            <div id="" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    <div id="postexcerpt" class="postbox">
                        <h2 class="hndle ui-sortable-handle"><span>API Synchronization</span></h2>
                        <div class="inside">
                            <label class="screen-reader-text" for="excerpt">Start Synchronization</label>
                            <input type="button" name="api_synchronization" id="api_synchronization" class="button button-primary button-large" value="Start Synchronization">
                            <div id="myProgress" style="float:right; display: none">
                                <div id="myBar">1%</div>
                            </div>
                            <div class="response_section">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div></div>
        </div><!-- /post-body -->
    </div>
</div>

