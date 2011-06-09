<div class="grid_12">
    <div class="check-step clearfix">
        <p style="text-align:center"><a href="/shipping"><span>1. Address Details</span> </a></p>
        <p style="text-align:center" class="c-s-sel"><a href="/shipping/delivery"><span>2. Delivery </span> </a></p>
        <p style="text-align:center"><a href="/checkout"><span>3. Payment Details</span> </a></p>
    </div>
<div class="user-cloum clearfix" style="border-width: 0 2px 2px 2px; background:#fff none;">
    <div class="member_main">
    <div class="sunmm_box">
        <h1 style="border-bottom:1px #ddd solid; padding-bottom:6px; margin-bottom:10px;color:#0066CC;">Delivery Method</h1>
        <?php if(Yii::app()->user->hasFlash('deliveryMessage')):?>
            <div class="error1 pass">
                <ul>
                    <li><?php echo Yii::app()->user->getFlash('deliveryMessage'); ?></li>
                </ul>
            </div>
            <?php endif;?>
        <form action="/shipping/setDelivery" method="POST">
            <table cellspacing="1" cellpadding="3" align="center" class="table1" style="padding:18px 24px;" >
               <thead>
                        <tr>
                            <th width="7%"></th>
                            <th width="25%">Shipping Method</th>
                            <th width="43%">Shipping Infromation</th>
                            <th width="25%">Shipping Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($deliveries as $key => $delivery):?>
                        <tr>
                    <td><input type="radio" <?php echo ($select==$key)?'checked=checked':'';?> value="<?php echo $key;?>" name="carrier"></td>
                    <td><?php echo $delivery['name'];?></td>
                    <td><?php echo $delivery['description'];?></td>
                    <td><span class='orange fw700'><?php echo $delivery['price'];?></span></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
            </table>
            <div class="sunmm_box" style="margin-top:25px;">
                    <div class="fr"><input type="submit" value="" class="button button-checkstep" id="check_btn"></div>
                    <div class="fix"></div>
                </div>
        </form>
    </div>
    </div>
</div>
</div>