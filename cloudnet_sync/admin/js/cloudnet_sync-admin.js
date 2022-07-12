jQuery(document).ready(function () {

//***************save api in api_setting page ************/
    $('#save_cloud_api').on('click', function () {
        var merchant_id = jQuery('#merchant_id').val();
        var api_signature = jQuery('#api_signature').val();
        jQuery.ajax({
            type: 'POST',
            url: ajax.ajax_url,
            data: {'merchant_id': merchant_id, 'api_signature': api_signature, 'action': 'cloudnet_api_add_option'},
            success: function (response) {
//                alert(response);
                console.log(response);
            }
        });
    });
//***************save api in api_setting page ************/
//***************show dashboard page ************/
    jQuery("#api_synchronization").on("click", function () {
        confirm_old_data_delete();
    });













});
//***************sync api products ************/
function progressbar() {
    jQuery.ajax({
        type: 'POST',
        url: ajax.ajax_url,
        data: {'action': 'cloudnet_get_data_from_api'},
        xhr: function () {
            var xhr = $.ajaxSettings.xhr();
            xhr.upload.onprogress = function (e) {
                var per = Math.floor(e.loaded / e.total * 100) + '%';
                $("#myBar").css("width", per);
                $("#myBar").html(per);
                console.log(Math.floor(e.loaded / e.total * 100) + '%');
            };
            return xhr;
        },
        success: function (response) {
            jQuery('.response_section').html('<p>Synching Completed.</p>');
            console.log(response);
        }
    });
}

//***************sync api categroy************/  

function confirm_old_data_delete() {
    swal({
        title: "Are you sure to provide with Sync?",
        text: "Your will lost all your previously synced products.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
            .then(function (isConfirm) {
                if (isConfirm) {
                    jQuery.ajax({
                        type: 'POST',
                        url: ajax.ajax_url,
                        data: {'action': 'cloudnet_delete_data'},
                        success: function (response) {
                            progressbar();

                        }
                    });
                    swal("All your previously synced products are deleted", {
                        icon: "success",
                    });

                } else {
                    swal("Your imaginary file is safe!");
                }
            });
//    swal({
//        title: "Are you sure to provide with Sync?",
//        text: "Your will lost all your previously synced products.",
//        icon: "warning",
//        showCancelButtons: true,
//        confirmButtonClass: "btn-danger",
//        confirmButtonText: "Yes, delete it!",
//        cancelButtonText: "No, cancel plx!",
//        closeOnConfirm: false,
//        closeOnCancel: false
//    }).then(function (isConfirm) {
//        if (isConfirm) {

//        }
//    });
//  return false;
}
function delete_previous_posts() {

}