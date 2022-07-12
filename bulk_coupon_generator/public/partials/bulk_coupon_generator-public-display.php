<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       www.vlogiclabs.com
 * @since      1.0.0
 *
 * @package    Bulk_coupon_generator
 * @subpackage Bulk_coupon_generator/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<div>
    <div class="full_width">
        <p class="lbl"><?php _e('Ticket Code', 'my_plugin_text_domain')?> </p>
        <div class="dv-flex">
            <form name="redeemMe" id ="redeemMe" method="POST">
                <input class="code" value="Y89HM02H3L1"> <a class="rdm_ticket">Redeem  Ticket</a>
            </form>
        </div>
    </div>
    <div class="full_width">
        <br>
        <div class="dv-flex txt-baseline">
            <span>Ticket Worked!</span><span class="desc">100 XP</span><span class="desc">20 Gold</span><span class="desc">0 Magic</span> was succesfully  added to your account.
        </div>
    </div>
</div>
