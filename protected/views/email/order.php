<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Message from <?php echo $hostName;?></title>
</head>
<body>
	<table style="font-family:Verdana,sans-serif; font-size:11px; color:#374953; width: 550px;">
		<tr>
			<td align="left">
                <a href="<?php echo $hostUrl;?>" title="<?php echo $hostName;?>"><img alt="<?php echo $hostName;?>" src="<?php echo $hostUrl.'/images/r4dsnds_logo.gif';?>" style="border:none;" ></a>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left">Hello <strong style="color:#DB3484;"><?php echo $name; ?></strong>, thank you for shopping with <strong><?php echo $hostName;?></strong>.</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left" style="background-color:#DB3484; color:#FFF; font-size: 12px; font-weight:bold; padding: 0.5em 1em;">Order details</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left">
				Order ID: <strong><span style="color:#DB3484;"><?php echo '('.Config::item('system', 'order_export_prefix').')'.$order->invoice_id;?></span> placed on <?php echo $order->order_create_at;?></strong>
				<br >Payment: <strong><?php echo $order->payment->payment_name;?></strong>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left">
				<table style="width:100%; font-family:Verdana,sans-serif; font-size:11px; color:#374953;">
					<!-- Title -->
					<tr style="background-color:#B9BABE; text-align:center;">
						<th style="width:15%; padding: 0.6em 0;">Reference</th>
						<th style="width:35%; padding: 0.6em 0;">Product</th>
						<th style="width:15%; padding: 0.6em 0;">Unit price</th>
						<th style="width:15%; padding: 0.6em 0;">Quantity</th>
						<th style="width:20%; padding: 0.6em 0;">Total price</th>
					</tr>
					<!-- Products -->
                    <?php
                        $currency = Currency::getCurrencySymbol($order->order_currency_id);
                        foreach($order->items as $key=>$item):
                    ?>
                    <tr style="background-color: <?php echo ($key % 2 ) ? '#DDE2E6' : '#EBECEE';?>">
                        <td style="padding: 0.6em 0.4em;"><?php echo $item->product->product_sku;?></td>
                        <td style="padding: 0.6em 0.4em;"><strong><?php echo $item->item_product_name;?></strong></td>
                        <td style="padding: 0.6em 0.4em; text-align: right;"><?php echo $currency.$item->item_price;?></td>
                        <td style="padding: 0.6em 0.4em; text-align: center;"><?php echo $currency.$item->item_qty;?></td>
                        <td style="padding: 0.6em 0.4em; text-align: right;"><?php echo $currency.$item->item_total;?></td>
                    </tr>
                    <?php endforeach;?>
					<!-- Footer: prices -->
					<tr style="text-align:right;">
						<td>&nbsp;</td>
						<td colspan="3" style="background-color:#B9BABE; padding:0.6em 0.4em;">Subtotal</td>
						<td style="background-color:#B9BABE; padding:0.6em 0.4em;"><?php echo $currency.$order->order_subtotal;?></td>
					</tr>
					<tr style="text-align:right;">
						<td>&nbsp;</td>
						<td colspan="3" style="background-color:#EBECEE; padding:0.6em 0.4em;">Discounts</td>
						<td style="background-color:#EBECEE; padding:0.6em 0.4em;"><?php echo $currency;?>0</td>
					</tr>
				
					<tr style="text-align:right;">
						<td>&nbsp;</td>
						<td colspan="3" style="background-color:#DDE2E6; padding:0.6em 0.4em;">Tracking number fee</td>
						<td style="background-color:#DDE2E6; padding:0.6em 0.4em;"><?php echo $currency.$order->order_trackingtotal;?></td>
					</tr>
					<tr style="text-align:right; font-weight:bold;">
						<td>&nbsp;</td>
						<td colspan="3" style="background-color:#F1AECF; padding:0.6em 0.4em;">Grand</td>
						<td style="background-color:#F1AECF; padding:0.6em 0.4em;"><?php echo $currency.$order->order_grandtotal;?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left" style="background-color:#DB3484; color:#FFF; font-size: 12px; font-weight:bold; padding: 0.5em 1em;">Shipping</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left">
				Carrier: <strong><?php echo $order->carrier->carrier_name;?></strong>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
				<table style="width:100%; font-family:Verdana,sans-serif; font-size:11px; color:#374953;">
					<tr style="background-color:#B9BABE; text-transform:uppercase;">
						<th style="text-align:left; padding: 0.3em 1em;">Delivery address</th>
					</tr>
					<tr>
						<td style="padding:0.5em 0 0.5em 0.5em; background-color:#EBECEE;">
						
                            <br><span style="color:#DB3484; font-weight:bold;">  <?php echo $address->customer_firstname .' '. $address->customer_lastname;?></span><br />
                            Street : <?php echo $address->address_street; ?><br />
                            City : <?php echo $address->address_city; ?><br />
                            State/Province : <?php echo $address->address_state; ?><br />
                            Country: <?php echo $address->country->name; ?><br />
                            Zip/Postal code : <?php echo $address->address_postcode; ?><br />
                            Phone Number : <?php echo $address->address_phonenumber; ?>
						</td>
					
					</tr>
				</table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left">
				You can review this order from the <a href="<?php echo $hostUrl.'/user/order';?>" style="color:#DB3484; font-weight:bold; text-decoration:none;">"Order history"</a>
                section of your account by clicking <a href="<?php echo $hostUrl.'/user';?>" style="color:#DB3484; font-weight:bold; text-decoration:none;">"My account"</a> on our Website.
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="center" style="font-size:10px; border-top: 1px solid #D9DADE;">
                <a href="<?php echo $hostUrl;?>" style="color:#DB3484; font-weight:bold; text-decoration:none;"><?php echo $hostName;?></a>
			</td>
		</tr>
	</table>
</body>
</html>