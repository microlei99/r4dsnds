<div class="grid_12">
    <div class="check-step clearfix">
        <p style="text-align:center"><a href="/shipping"><span>1. Address Details</span> </a></p>
        <p style="text-align:center"><a href="/shipping/delivery"><span>2. Delivery </span> </a></p>
        <p style="text-align:center" class="c-s-sel"><a href="/checkout"><span>3. Payment Details</span> </a></p>
    </div>
    <div class="user-cloum clearfix" style="border-width: 0 2px 2px 2px; background:#fff none;">
        <div class="member_main">
            <div class="sunmm_box">
                <p>You may submit your credit card payment info in this area. You can contact the customer service team if you need further assistance.</p>
                <h3 style="border-bottom:1px #ddd solid;padding-bottom:6px;margin:6px 0">Payment Method</h3>

                <form method="POST" action="/checkout/order" id="checkout">
                    <table align="center" cellpadding="0" cellspacing="1" border="0" class="table1" width="100%">
                        <tbody>
                            <tr>
                                <td width="28%" style="padding:18px 36px;" >
                                    <label>
                                        <input type="radio" id="card_0" value="1" class="inputnone" name="payment" checked="checked" style="vertical-align:middle;" />
                                        <img align="absmiddle" alt="PayPal" src="/images/card_1.gif"  />
                                        <span style="display:inline-block; width:600px; padding-left:30px; vertical-align:middle">
                                            Choose this option to pay for your order using your PayPal account.
                                        </span>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="sunmm_box" style="margin-top:25px;">
                    <div class="fr"><input type="submit" value="" class="button button-checkstep"></div>
                    <div class="fix"></div>
                </div>
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="sunmm_box" style=" border:1px #ddd solid; background-color:#fafafa; padding:12px 16px">
    <h3 style=" padding-bottom:6px; font-size:16px; color:#c30">Address Info<span style="font-size:12px;margin-left:10px;"><a href="user/editAddress/id/<?php echo $address->address_id; ?>" style="color:#0066CC;">[Edit]</a></span></h3>
    
    <ul>
        <li style="padding:6px 10px;">
            <label>
                <span style="font-weight:700;color:#0066CC;padding:6px 10px;">Name:</span>
                <span><?php echo $address->customer_firstname.' '.$address->customer_lastname; ?></span>
            </label>
        </li>
        <li style="padding:6px 10px;">
            <label>
                <span style="font-weight:700;color:#0066CC;padding:6px 10px;">Address:</span>
                <span><?php echo $address->address_street.'  '.$address->address_city.'  '.$address->address_state.' '.Country::item($address->address_country); ?></span>
            </label>
        </li>
        <li style="padding:6px 10px;">
            <label>
                <span style="font-weight:700;color:#0066CC;padding:6px 10px;">Postcode:</span>
                <span><?php echo $address->address_postcode; ?></span>
            </label>
        </li>
        <li style="padding:6px 10px;">
            <label>
                <span style="font-weight:700;color:#0066CC;padding:6px 10px;">Telephone:</span>
                <span><?php echo $address->address_phonenumber;?></span>
            </label>
        </li>
    </ul>
</div>
    <!--/user-cloum -->
    <div class="user-cloum clearfix" style=" border:1px #ccc solid; background-color:#fafafa; padding:12px 16px;margin-top: 10px;">
    <h3 style=" padding-bottom:6px; font-size:16px; color:#c30">Shopping Info</h3>
    <table align="center" cellpadding="0" cellspacing="1" border="0" class="table1">
        <tbody>
            <tr><th width="558" height="36">Product Name</th><th width="139">Quantity</th><th width="191">Price</th></tr>
            <?php foreach($cart as $item):?>
            <tr>
                <td height="42" align="center">
                    <a href="<?php echo $item['url'];?>"><img src="<?php echo $item['simage'];?>" alt="" /></a><br />
                    <a href="<?php echo $item['url'];?>"><?php echo $item['name'];?></a>
                </td>
                <td align="center"><?php echo $item['qty'];?></td>
                <td height="42" align="center"><span class="red "><?php echo Currency::getCurrencySymbol().($item['price']*$item['qty']);?></span></td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="3">
                    <div class="alignright">
                        <strong class="">Shipping: <span class="red"><?php echo Currency::getCurrencySymbol().$priceSummury['delivery'];?></span></strong>
                        <strong style="margin-left:10px; font-size:14px;">Total: <span class="red"><?php echo Currency::getCurrencySymbol().($priceSummury['total']+$priceSummury['delivery']);?></span></strong>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</div>
</div>