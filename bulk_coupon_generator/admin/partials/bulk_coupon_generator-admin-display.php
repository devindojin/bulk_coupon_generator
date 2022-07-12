<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.vlogiclabs.com
 * @since      1.0.0
 *
 * @package    Bulk_coupon_generator
 * @subpackage Bulk_coupon_generator/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <div class="update-nag">Admin Screen to generate coupons and download Ticket Sheet.</div>
    <div class="cardc-coupon">
        <form enctype="multipart/form-data" id="coupon_sub_from">
            <table>
                <thead>
                <th>Amount of Points</th>
                <th>Point Type</th>
                <th>Expires</th>
                <th>How Many</th>
                <th>Ticket Image</th>
                <th></th>
                </thead>
                <tbody>
                    <tr>
                        <td><Input name="amount_of_point" type="number" value="100" id="amount_of_point" required="true"></td>
                        <td><select name="point_type" id="bulk-coupon-selector" required>
                                <option value="XP">XP</option>
                                <option value="Gold">Gold</option>
                                <option value="Magic">Magic</option>
                            </select>
                        </td>
                        <td><Input name="expiry" type="date" id="expiry" required></td>
                        <td><Input name="quantity" type="number" value="3" id="quantity" required></td>
                        <td><Input name="bg_image" type="file" id="bg_image" required></td>
                        <td><input type="button" name="coupon_request" id="coupon_request" class="button button-primary" value="Generate_coupon"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>



