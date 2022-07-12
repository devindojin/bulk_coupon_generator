(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
    $(document).ready(function () {
        //On update event for the value updation event  
        $('#redeemMe').on('click', function () {
          

            var cfd = new FormData($('#redeemMe')[0]);
            cfd.append('action', 'bulk_coupon_public_reedem');

            /* ajax send request */
            $.ajax({
                url: ajax.url,
                data: cfd,
                processData: false,
                contentType: false,
                type: 'POST',

            }).success(function (response) {
                /* ajax success */
                console.log(response);

            }).error(function (response) {
                /* ajax error */
                console.log('error:' + response);
            });



        });
    });
})(jQuery);
