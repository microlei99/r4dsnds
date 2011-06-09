<style type="text/css">
    div.addresses {
        background: url("/images/form_bg.jpg") repeat-x scroll left top #D0D1D5;
        border: 1px solid #D0D3D8;
        padding: 0.6em;
        position: relative;
        width: 544px;
    }
    div.addresses ul.item {
        clear: both;
    }
    ul.item li.address_title {
        background-image: url("/images/address_alias_left.gif");
        margin-top: 0;
        color: #374853;
        font-size: 1.2em;
        font-weight: bold;
    }

    ul.alternate_item li.address_title {
        background-image: url("/images/address_alias_right.gif");
        margin-top: 0;
        color: #374853;
        font-size: 1.2em;
        font-weight: bold;
    }
    ul.address{
        background-color:white;
        float: left;
        list-style: none outside none;
        margin-bottom: 1em;
        margin-left: 0.25em;
        padding-bottom: 0.6em;
        position: relative;
        width: 268px
    }

    ul.address li {
        margin-top: 0.6em;
        padding-left: 1.4em;
    }
    li.address_name, li.address_company {
        font-weight: bold;
    }

    li.address_name, li.address_update a, li.address_delete a {
        color: #DD2A81;
    }
    li.address_update, li.address_delete {
        background: url("/images/bullet_myaccount.gif") no-repeat scroll 0 0.5em transparent !important;
        margin-left: 1.4em;
    }
</style>

<h2><?php echo Order::getPrefix().$model->invoice_id; ?></h2>
<h4>Order placed on <?php echo date('Y/n/j',strtotime($model->order_create_at));?></h4>

<div class="addresses">
<ul class="address item">
            <li class="address_title"></li>
            <li class="address_name"><?php echo $address->customer_firstname.' '.$address->customer_lastname;?></li>
            <li class="address_phone_mobile"><?php echo $address->address_phonenumber;?></li>
            <li class="address_city"><?php echo $address->address_postcode;?></li>
            <li class="address_address1"><?php echo $address->address_street;?></li>
            <li class="address_country"><?php echo $address->address_city.' '.$address->address_state,' '.$address->country->name;?></li>
        </ul>
    <div class="sunmm_box" style="width:250px; float: right;">
        <h3>Payment Status</h3>
                <p><?php echo Lookup::item('payment_status', $model->order_status);?></p>
                    <h3>Shipment Method</h3>
                    <p><?php echo $model->carrier->carrier_name;?> </p>
                    <p>Tracking Number:<span style="color:#DD2A81"><?php echo $ship->ship_code;?></span></p> 
                    <p>Tracking Url:<a href="<?php echo $ship->trackUrl($ship->ship_code,$model->carrier->carrier_url); ?>" target="_blank" style="color:#DD2A81">
                                    <?php echo $ship->ship_code; ?></a></p>

                <h3>Payment Method</h3>
                <p><?php echo $model->payment->payment_name;?></p>
            </div>
    <div  style="clear:both;"></div>
</div>
                


            <div class="sunmm_box">
                <h3>Order Item</h3>
                <table align="center" cellpadding="0" cellspacing="1" border="0" class="table1" width="100%">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>YourPrice</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php foreach ($model->items as $row):?>
                        <tr>

                               <td><?php echo $row->item_product_name;?></td>
                               <td><?php echo $row->item_qty;?></td>
                               <td><span class="red fw700"><?php echo $currency . $row->item_price; ?></span></td>
                               <td height="42"><span class="red fw700"><?php echo $currency . ($row->item_price*$row->item_qty); ?></span></td>
                           </tr>
            <?php endforeach;?>
                <tr><td colspan="5">
                        <div class="ar t_count" style="margin-bottom:0; ">

                            <div style="float:right; margin-top:12px; width:40%;">
                                <div style=" float:right;border-bottom:1px #ccc dotted; padding:5px; font-weight:700; color:#333;">
                                    Subtotal: <span style="float:right; width:60px; font-weight:normal"><?php echo $currency . $model->order_subtotal; ?></span>
                                </div>
                                <div class="fix"></div>
                                <div style="float:right;border-bottom:1px #ccc dotted; padding:5px;font-weight:700; color:#333;">
                                    Total Discounts: <span  style="float:right; width:60px; font-weight:normal; color:#999; "><?php echo $currency.($model->order_discount_id==0?0:0);?></span>
                                </div>
                                <div style="float:right;border-bottom:1px #ccc dotted; padding:5px;font-weight:700; color:#333;">
                                    Delivery: <span  style="float:right; width:60px; font-weight:normal; color:#999; "><?php echo $currency.$model->order_trackingtotal;?></span>
                                </div>
                                <div class="fix"></div>

                            </div>
                            <div class="fix"></div>
                            <div style="border-bottom:1px #ccc dotted; padding:5px 12px 12px; background:#fff; ">
                                <div style=" float:right; margin-left:20px; font-weight:700; padding-top:10px;">
                                    Total to pay: <span class="red" style="font-size:18px;"><?php echo $currency.$model->order_grandtotal;?></span></div>
                            <div class="fix"></div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

</div>