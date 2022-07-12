<?php

/**
 * Provide a public  area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.vll.com
 * @since      1.0.0
 *
 * @package    Cloudnet_sync
 * @subpackage Cloudnet_sync/public/partials
 */
echo '<div id="list" class="view list"><div class = "row list"> <ul class="pro_list">';

foreach ($posts as $value) {
    $post_id = $value->ID;
    $image_path = get_post_meta($post_id, '_imagepath', true);
    if (!empty($image_path)) {
        $image = explode('.', $image_path);
        if (($image[3] == 'jpg') || ($image[3] == 'png') || ($image[3] == 'jpeg') || ($image[3] == 'gif')) {
            echo ' <div class="my-div">
                    <div class="col-img"> 
                          <img src="' . get_post_meta($post_id, '_imagepath', true) . '" alt=""w=360&h=240&fit=fill" class="img-responsive">
                        </div> 
                    <div class="col-content">
                        <div class="cart-info">
                            <h2>' . $value->post_title . '</h2>
                            <p>' . strip_tags($value->post_content) . '</p>
                        </div>
                        <div class="cart-btn">
                            <div class="row">
                            <span class="price">' . 'Price.' . get_post_meta($post_id, '_price', true) . '</span> 
                            <a href="' . get_post_meta($post_id, '_oneclickbuylink', true) . '" rel="nofollow" class="btn">Add to cart</a>
                                </div>
                        </div>
                    </div>
                </div>';
        }
    }
}
echo ' </ul></div></div>';
?>