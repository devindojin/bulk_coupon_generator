<?php
/* * *****************************
 * Plugin Name: sendchimp
 * Plugin URI: http://sendchimp.web.id/
 * Description: This plugin allows sendchimp notifications.
 * Version: 0.6.0
 * *****************************
 */

/* --------------------------------- */
add_action('wp_ajax_sendchimp_Triggered', 'sendchimp_Triggered');
add_action('wp_ajax_nopriv_sendchimp_Triggered', 'sendchimp_Triggered');




add_action('wp_enqueue_scripts', 'enqueue_scripts');

function enqueue_scripts() {
    wp_localize_script('some_handle', 'ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_shortcode('Sendchimp_Triggered', 'sendchimp_Triggered');

function sendchimp_Triggered() {

    $gallery_array = array();
    if (isset($_POST['subscribe'])) {

        if (!empty($_FILES)) {

            if ($_FILES['MMERGE13_mydogselfi']['error'] == 0) {

                $filetmp = $_FILES['MMERGE13_mydogselfi']['tmp_name'];

                //clean filename and extract extension
                $filename = $_FILES['MMERGE13_mydogselfi']['name'];

                // get file info
                // @fixme: wp checks the file extension....
                $filetype = wp_check_filetype(basename($filename), null);
                $filetitle = preg_replace('/\.[^.]+$/', '', basename($filename));

                $filename = uniqid() . '.' . $filetype['ext'];
                $upload_dir = wp_upload_dir();

                /**
                 * Check if the filename already exist in the directory and rename the
                 * file if necessary
                 */
                $i = 0;
                while (file_exists($upload_dir['path'] . '/' . $filename)) {
                    $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
                    $i++;
                }

                $filedest = $upload_dir['path'] . '/' . $filename;
                /**
                 * Check write permissions
                 */
                if (!is_writeable($upload_dir['path'])) {
                    $this->msg_e('Unable to write to directory %s. Is this directory writable by the server?');
                    return;
                }
                /**
                 * Save temporary file to uploads dir
                 */
                if (!@move_uploaded_file($filetmp, $filedest)) {
                    $this->msg_e("Error, the file $filetmp could not moved to : $filedest ");
                    // continue;
                }
                $attachment = array(
                    'post_mime_type' => $filetype['type'],
                    'post_title' => $filetitle,
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment($attachment, $filedest);
                require_once( ABSPATH . "wp-admin" . '/includes/image.php');
                $attach_data = wp_generate_attachment_metadata($attach_id, $filedest);
                wp_update_attachment_metadata($attach_id, $attach_data);
                array_push($gallery_array, $attach_id);
            }
        }
        
        
        
        
    }

    if (!empty($gallery_array[0])) {
        $url = wp_get_attachment_url($gallery_array[0]);
        
        
        
        
        
        
        
        
        
        ?>
<!--        <script>
            var formData = new FormData(jQuery('form')[0]);


            console.log(formData);


        //            jQuery.post("ajax/test.html", function (data) {
        //                jQuery(".result").html(data);
        //            });
        //            jQuery.post({
        //                type: 'POST',
        //                url: 'sendchimp.php',
        //                data: formData,
        //                success: function (response) {
        //                    console.log(response);
        //                }
        //            });
        </script>-->

        <?php
    }




//    print_r($gallery_array);
    ?>

    <!-- Begin MailChimp Signup Form -->
    <!--<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">-->
    <style type="text/css">
        #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
        /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
    </style>








    <div id="mc_embed_signup">
        <!--https://pawapproved.us17.list-manage.com/subscribe/post?u=fba2cc8ed87649447f6bc9b7c&amp;id=5923e56beb-->
        <form  method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate enctype="multipart/form-data">
            <div id="mc_embed_signup_scroll">
                <h2>Subscribe to our mailing list</h2>
                <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
                <div class="mc-field-group">
                    <label for="mce-YOURNAME">Your Name  <span class="asterisk">*</span>
                    </label>
                    <input type="text" value="" name="YOURNAME" class="required" id="mce-YOURNAME">
                    <input type="text" value="https://pawapproved.us17.list-manage.com/subscribe/post?u=fba2cc8ed87649447f6bc9b7c&amp;id=5923e56beb" name="action" class="required" id="mce-YOURNAME">
                </div>
                <div class="mc-field-group">
                    <label for="mce-HOUSENUMB">House number or name  <span class="asterisk">*</span>
                    </label>
                    <input type="text" value="" name="HOUSENUMB" class="required" id="mce-HOUSENUMB">
                </div>
                <div class="mc-field-group">
                    <label for="mce-STREETNAM">Street name  <span class="asterisk">*</span>
                    </label>
                    <input type="text" value="" name="STREETNAM" class="required" id="mce-STREETNAM">
                </div>
                <div class="mc-field-group">
                    <label for="mce-SUBURB">Suburb  <span class="asterisk">*</span>
                    </label>
                    <input type="text" value="" name="SUBURB" class="required" id="mce-SUBURB">
                </div>
                <div class="mc-field-group">
                    <label for="mce-CITYTOWN">City/Town  <span class="asterisk">*</span>
                    </label>
                    <input type="text" value="" name="CITYTOWN" class="required" id="mce-CITYTOWN">
                </div>
                <div class="mc-field-group">
                    <label for="mce-POSTCODE">Postcode  <span class="asterisk">*</span>
                    </label>
                    <input type="text" value="" name="POSTCODE" class="required" id="mce-POSTCODE">
                </div>
                <div class="mc-field-group">
                    <label for="mce-EMAIL">Your Email  <span class="asterisk">*</span>
                    </label>
                    <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                </div>
                <div class="mc-field-group">
                    <label for="mce-USERNAME">User Name  <span class="asterisk">*</span>
                    </label>
                    <input type="text" value="" name="USERNAME" class="required" id="mce-USERNAME">
                </div>
                <div class="mc-field-group">
                    <label for="mce-DOGNAME">Name of Dog  <span class="asterisk">*</span>
                    </label>
                    <input type="text" value="" name="DOGNAME" class="required" id="mce-DOGNAME">
                </div>
                <div class="mc-field-group">
                    <label for="mce-YOURBREED">Breed  <span class="asterisk">*</span>
                    </label>
                    <select name="YOURBREED" class="required" id="mce-YOURBREED">
                        <option value=""></option>
                        <option value="Airedale Terrier">Airedale Terrier</option>
                        <option value="Affenpinscher">Affenpinscher</option>
                        <option value="Afghan Hound">Afghan Hound</option>
                        <option value="Airedale Terrier">Airedale Terrier</option>
                        <option value="Akita">Akita</option>
                        <option value="Alaskan Malamute">Alaskan Malamute</option>
                        <option value="Alaskan Husky">Alaskan Husky</option>
                        <option value="American Foxhound">American Foxhound</option>
                        <option value="American Staffordshire Terrier">American Staffordshire Terrier</option>
                        <option value="Basset Hound">Basset Hound</option>
                        <option value="Beagle">Beagle</option>
                        <option value="Bearded Collie">Bearded Collie</option>
                        <option value="Bernese Mountain Dog">Bernese Mountain Dog</option>
                        <option value="Bichon Frise">Bichon Frise</option>
                        <option value="Black and Tan Coonhound">Black and Tan Coonhound</option>
                        <option value="Bloodhound">Bloodhound</option>
                        <option value="Border Collie">Border Collie</option>
                        <option value="Border Terrier">Border Terrier</option>
                        <option value="Boston Terrier">Boston Terrier</option>
                        <option value="Boxer">Boxer</option>
                        <option value="Bull Terrier">Bull Terrier</option>
                        <option value="Bulldog">Bulldog</option>
                        <option value="Bullmastiff">Bullmastiff</option>
                        <option value="Cardigan Welsh Corgi">Cardigan Welsh Corgi</option>
                        <option value="Cavalier King Charles Spaniel">Cavalier King Charles Spaniel</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Cocker Spaniel">Cocker Spaniel</option>
                        <option value="Collie">Collie</option>
                        <option value="Dachshunds">Dachshunds</option>
                        <option value="Dalmatian">Dalmatian</option>
                        <option value="Doberman Pinscher">Doberman Pinscher</option>
                        <option value="English Cocker Spaniel">English Cocker Spaniel</option>
                        <option value="English Foxhound">English Foxhound</option>
                        <option value="English Setter">English Setter</option>
                        <option value="English Springer Spaniel">English Springer Spaniel</option>
                        <option value="Flat-Coated Retriever">Flat-Coated Retriever</option>
                        <option value="French Bulldog">French Bulldog</option>
                        <option value="German Pinscher">German Pinscher</option>
                        <option value="German Shepherd Dog">German Shepherd Dog</option>
                        <option value="Giant Schnauzer">Giant Schnauzer</option>
                        <option value="Golden Retriever">Golden Retriever</option>
                        <option value="Great Dane">Great Dane</option>
                        <option value="Greyhound">Greyhound</option>
                        <option value="Irish Setter">Irish Setter</option>
                        <option value="Irish Terrier">Irish Terrier</option>
                        <option value="Irish Wolfhound">Irish Wolfhound</option>
                        <option value="Labrador Retriever">Labrador Retriever</option>
                        <option value="Maltese">Maltese</option>
                        <option value="Mastiff">Mastiff</option>
                        <option value="Miniature Pinscher">Miniature Pinscher</option>
                        <option value="Miniature Schnauzer">Miniature Schnauzer</option>
                        <option value="Newfoundland">Newfoundland</option>
                        <option value="Old English Sheepdog">Old English Sheepdog</option>
                        <option value="Old English Sheepdog">Old English Sheepdog</option>
                        <option value="Pembroke Welsh Corgi">Pembroke Welsh Corgi</option>
                        <option value="Pointer">Pointer</option>
                        <option value="Polish Lowland Sheepdog">Polish Lowland Sheepdog</option>
                        <option value="Pomeranian">Pomeranian</option>
                        <option value="Poodle">Poodle</option>
                        <option value="Pug">Pug</option>
                        <option value="Rhodesian Ridgeback">Rhodesian Ridgeback</option>
                        <option value="Rottweiler">Rottweiler</option>
                        <option value="Schnauzer">Schnauzer</option>
                        <option value="St. Bernard">St. Bernard</option>
                        <option value="Scottish Terrier">Scottish Terrier</option>
                        <option value="Shih Tzu">Shih Tzu</option>
                        <option value="Siberian Husky">Siberian Husky</option>
                        <option value="Staffordshire Bull Terrier">Staffordshire Bull Terrier</option>
                        <option value="Vizsla">Vizsla</option>
                        <option value="Weimaraner">Weimaraner</option>
                        <option value="Welsh Terrier">Welsh Terrier</option>
                        <option value="West Highland White Terrier">West Highland White Terrier</option>
                        <option value="Whippet">Whippet</option>
                        <option value="Yorkshire Terrier">Yorkshire Terrier</option>
                        <option value="Other">Other</option>

                    </select>
                </div>
                <div class="mc-field-group">
                    <label for="mce-OTHERBREE">Other Breed </label>
                    <input type="text" value="" name="OTHERBREE" class="" id="mce-OTHERBREE">
                </div>
                <div class="mc-field-group size1of2">
                    <label for="mce-DOGAGE">Age  <span class="asterisk">*</span>
                    </label>
                    <input type="number" name="DOGAGE" class="required" value="" id="mce-DOGAGE">
                </div>
                <div class="mc-field-group input-group">
                    <strong>Sex  <span class="asterisk">*</span>
                    </strong>
                    <ul><li><input type="radio" value="Male, unneutered" name="DOGGENDER" id="mce-DOGGENDER-0"><label for="mce-DOGGENDER-0">Male, unneutered</label></li>
                        <li><input type="radio" value="Male, neutered" name="DOGGENDER" id="mce-DOGGENDER-1"><label for="mce-DOGGENDER-1">Male, neutered</label></li>
                        <li><input type="radio" value="Female, unsprayed" name="DOGGENDER" id="mce-DOGGENDER-2"><label for="mce-DOGGENDER-2">Female, unsprayed</label></li>
                        <li><input type="radio" value="Female, sprayed" name="DOGGENDER" id="mce-DOGGENDER-3"><label for="mce-DOGGENDER-3">Female, sprayed</label></li>
                    </ul>
                </div>
                <div class="mc-field-group">
                    <label for="mce-MMERGE13">attachment </label>
                    <input type="url" value="" name="MMERGE13" class=" url" id="mce-MMERGE13">
                    <input type="file" name="MMERGE13_mydogselfi" class=" url" id="mce-MMERGE13_mydogselfi">
                </div>
                <div class="mc-field-group input-group">
                    <strong>OUR TEMS </strong>
                    <ul><li><input type="checkbox" value="1" name="group[9417][1]" id="mce-group[9417]-9417-0"><label for="mce-group[9417]-9417-0">I agree that I have provided Paw Approved with my details in order to take part in research projects</label></li>
                        <li><input type="checkbox" value="2" name="group[9417][2]" id="mce-group[9417]-9417-1"><label for="mce-group[9417]-9417-1">I understand that in order for Paw Approved to select appropriate research topics for me they will u</label></li>
                        <li><input type="checkbox" value="4" name="group[9417][4]" id="mce-group[9417]-9417-2"><label for="mce-group[9417]-9417-2">I want to hear all the exciting news Paw Approved has and want to receive regular updates by email</label></li>
                    </ul>
                </div>
                <div id="mce-responses" class="clear">
                    <div class="response" id="mce-error-response" style="display:none"></div>
                    <div class="response" id="mce-success-response" style="display:none"></div>
                </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_fba2cc8ed87649447f6bc9b7c_5923e56beb" tabindex="-1" value=""></div>
                <div class="clear">
                    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                </div>
            </div>
        </form>
    </div>
    <!--<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array(); fnames[12] = 'YOURNAME'; ftypes[12] = 'text'; fnames[1] = 'HOUSENUMB'; ftypes[1] = 'text'; fnames[2] = 'STREETNAM'; ftypes[2] = 'text'; fnames[3] = 'SUBURB'; ftypes[3] = 'text'; fnames[4] = 'CITYTOWN'; ftypes[4] = 'text'; fnames[5] = 'POSTCODE'; ftypes[5] = 'text'; fnames[0] = 'EMAIL'; ftypes[0] = 'email'; fnames[6] = 'USERNAME'; ftypes[6] = 'text'; fnames[7] = 'DOGNAME'; ftypes[7] = 'text'; fnames[8] = 'YOURBREED'; ftypes[8] = 'dropdown'; fnames[9] = 'OTHERBREE'; ftypes[9] = 'text'; fnames[10] = 'DOGAGE'; ftypes[10] = 'number'; fnames[11] = 'DOGGENDER'; ftypes[11] = 'radio'; fnames[13] = 'MMERGE13'; ftypes[13] = 'imageurl'; }(jQuery)); var $mcj = jQuery.noConflict(true);</script>-->


    <?php
}

/* -------------------------------------------------------------------------------- */

    