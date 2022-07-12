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

<section class="">
    <div class="container-fluid">

        <div class="wrap col-sm-12">
            <div class="welcome-panel">
                <div class="welcome-panel-content">
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="text-box-row">
                                <label>Price</label>
                                <?php $price= get_post_meta($post_id,'_price',true);?>
                                <input type="text" name="price" disabled id="price" class="form-control" value="<?php if(!empty($price)) echo $price;?>"/>
                               
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="welcome-panel">
        <div class="welcome-panel-content">
          <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                      <div class="text-box-row">
                    <div class="col-sm-3"><label>Short Description</label></div>   
                   
                    <?php
                    $content = base64_decode(get_post_meta($post_id,'_shortdesc',true));
                        $editor_id = 'mycustomeditor';
                        
                        wp_editor( $content, $editor_id );
?>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>