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

﻿<!doctype html>


<section class="">
    <div class="container">
        <div class="wrap col-sm-9">
            <h1>Welcome to CloudNet360</h1>
            <p>Congratulations! You are using CloudNet360 for Managing ecommerce in your wordpress site</p>
            <a href="<?php echo $url_api_setting; ?>admin.php?page=api_settings">
                <button type="button" class="button button-primary">Setting</button></a>
            <button class="button btn btn-twitter btn-sm"><i class="fa fa-twitter"></i> Tweet</button>


        </div>
        <div class="wrap col-sm-2">


            <p>Version: 1.0.0</p>
        </div>
        <div class="wrap col-sm-12">
            <div class="welcome-panel">
                <div class="welcome-panel-content">
                    <div class="text-box-row">
                        <div class="col-sm-3 s_grid">

                            <img src="<?php echo plugins_url(); ?>/cloudnet_sync/admin/images/word_icon1.jpg">
                            <h4><a href="<?php echo $url_product; ?>edit.php?post_type=cloudnet_product">My Products</a></h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                        <div class="col-sm-3 s_grid">
                            <img src="<?php echo plugins_url(); ?>/cloudnet_sync/admin/images/word_icon2.jpg"/>
                            <h4><a href="#">My Orders</a></h4>
                            <!--<h4><a href="<?php // echo $url_order;      ?>admin.php?page=orders_slug">My Orders</a></h4>-->
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                        </div>
                        <div class="col-sm-3 s_grid">
                            <img src="<?php echo plugins_url(); ?>/cloudnet_sync/admin/images/word_icon3.jpg"/>
                            <h4><a href="<?php echo $url_api_setting; ?>admin.php?page=api_settings">API Settings</a></h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                        </div>
                        <div class="col-sm-3 s_grid">
                            <img src="<?php echo plugins_url(); ?>/cloudnet_sync/admin/images/word_icon3.jpg"/>
                            <input type="checkbox" id="toggle-event" data-toggle="toggle" data-on="ON" data-off="OFF">
                                                                                 <!--<h4><a href="<?php //echo $url_api_setting;    ?>admin.php?page=api_settings">API Settings</a></h4>-->
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
