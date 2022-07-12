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
echo '<div class = "row product_container_grid">';
$i = 1;
foreach ($posts as $value) {
    $post_id = $value->ID;
    $image_path = get_post_meta($post_id, '_imagepath', true);
    if (!empty($image_path)) {
        $image = explode('.', $image_path);
        if (($image[3] == 'jpg') || ($image[3] == 'png') || ($image[3] == 'jpeg') || ($image[3] == 'gif')) {
            echo'<div class="col-md-4 product-div">
                             <div class="thumbnail product-information">
                               <div class="thumbnail_images"><img src="' . get_post_meta($post_id, '_imagepath', true) . '" alt="" class="thumb_img"></div>
                                   <h5>' . $value->post_title . '</h5>
                                      <h4>' . 'Price.' . get_post_meta($post_id, '_price', true) . '</h4>
                                <div class="thumbnail-de">
                                       <div class="thumb-description"> 
                                        <div class="thumbnail_hover_images"><img src="' . get_post_meta($post_id, '_imagepath', true) . '" alt=""  width=25% height="25%" ></div>
                                        <div class="product-text"><h3>' . $value->post_title . '</h3>
                                        ' . strip_tags($value->post_content) . '  
                                        <p>' . (get_post_meta($post_id, '_shortdesc', true)) . '</p></div>
                                        <div class="products-price"><p>' . 'Price.' . get_post_meta($post_id, '_price', true) . '</p>
                                            <span class="a-button-inner"><a href="' . get_post_meta($post_id, '_oneclickbuylink', true) . '" rel="nofollow"   id="a-autoid-10-announce" class="a-button-text">Add to cart</a></span>                             
                                        </div>
                                     </div>
                                  </div>
                            </div>
                          
                    </div>';
            if ($i % 3 == 0) {
                echo'</div><div class = "row product_container_grid">';
            }
        } else {
            echo '<div class="col-md-4 product-div">
                              <div class="thumbnail  product-information">
                                <div class="thumbnail_images"><img src="' . plugin_dir_url(__FILE__) . 'no-image-slide.png" class="thumb_img"></div>
                                <h5>' . $value->post_title . '</h5>
                                 <h4>' . 'Price.' . get_post_meta($post_id, '_price', true) . '</h4>
                                <div class="thumbnail-de">
                                  <div class="thumb-description"> 
                                  <div class="thumbnail_hover_images"><img src="' . plugin_dir_url(__FILE__) . 'no-image-slide.png" width=25% height="25%"></div>
                                   <div class="product-text"> <h3>' . $value->post_title . '</h3>
                                   <div>' . strip_tags($value->post_content) . '</div>  
                                   <p>' . base64_decode(get_post_meta($post_id, '_shortdesc', true)) . '</p>
                                  </div>
                              <div class="products-price"><p>' . 'Price.' . get_post_meta($post_id, '_price', true) . '</p>
                                 <span class="a-button-inner"><a href="' . get_post_meta($post_id, '_oneclickbuylink', true) . '" rel="nofollow"   id="a-autoid-10-announce" class="a-button-text">Add to cart</a></span>
                                 </div></div>
                               </div> </div></div>
                             ';
            if ($i % 3 == 0) {
                echo'</div><div class = "row product_container_grid">';
            }
        }
        $i++;
    }
}
