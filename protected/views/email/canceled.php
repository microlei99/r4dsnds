<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Message from <?php echo $hostName; ?></title>
    </head>
    <body>
        <table style="font-family:Verdana,sans-serif; font-size:11px; color:#374953; width: 550px;">
            <tr>
                <td align="left">

                    <a href="<?php echo $hostUrl; ?>" title="<?php echo $hostName; ?>"><img alt="<?php echo $hostName; ?>" src="<?php echo $hostUrl.'/images/r4dsnds_logo.gif';?>" style="border:none;" ></a>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="left">Hi <strong style="color:#DB3484;"><?php echo $name; ?></strong>,</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="left" style="background-color:#DB3484; color:#FFF; font-size: 12px; font-weight:bold; padding: 0.5em 1em;">
                    Your order <?php echo $order_name ?> history</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="left">
                    <b>Your order has been cancelled.</b>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="center" style="font-size:10px; border-top: 1px solid #D9DADE;">
                    <a href="<?php echo $hostUrl; ?>" style="color:#DB3484; font-weight:bold; text-decoration:none;"><?php echo $hostName; ?></a>
                </td>
            </tr>
        </table>
    </body>
</html>

