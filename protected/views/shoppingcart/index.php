<div class="grid_12">
    <div class=" user-cloum clearfix">
        <h1>Shopping Cart</h1>
        <div class="member_main">
            <?php if(Yii::app()->user->hasFlash('cartMessage')):?>
            <div class="error1 pass">
                <ul>
                    <li><?php echo Yii::app()->user->getFlash('cartMessage'); ?></li>
                </ul>
            </div>
            <?php endif;?>
            <?php
             $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'shoppingcart-form',
                    'action'=>Yii::app()->controller->createUrl('shoppingcart/upcart'),
                ));
            ?>
            <table class="table1" width="100%">
                <thead>
                    <tr>
                        <th width="43%">Product</th>
                        <th width="15%">Qty</th>
                        <th width="15%">Unite Price</th>
                        <th width="14%">Your Price</th>
                        <th width="13%" class="thlast">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cart as $key => $item):?>
                    <tr class="carttr">
                        <td style="text-align:left;">
                            <a href="<?php echo $item['url'];?>"><img src="<?php echo $item['simage'];?>" alt="" /></a><br />
                                <a href="<?php echo $item['url'];?>"><?php echo $item['name'];?></a>
                        </td>
                        <td>
                            <input type="hidden" value="<?php echo $item['qty'];?>">
                            <input value="<?php echo $item['qty'];?>" maxlength="3" name="qty[<?php echo $key;?>]" style="width: 30px; text-align: center; padding:2px 4px; color: black;" />
                        </td>
                        <td><span class="linegray"><?php echo $item['orig_price'];?></span></td>
                        <td><span class="orange fw700"><?php echo $symbol.$item['price'];?></span></td>
                        <td><input type="button" id="<?php echo $key;?>" value="Delete" class="button button-simaple" /></td>
                    </tr>
                        <?php endforeach;?>
                </tbody>
            </table>
            <?php $this->endWidget();?>
            <div style="height:33px; margin-bottom:10px;">
                <div class="fl mt_10"><a href="/">&laquo; continue to shopping</a></div>
                <div class="fr">
                    <input class="update_qty" style="border: medium none; margin-top: 10px;" type="image" src="/images/btn_update_qty.gif" alt="update qty">
                </div>
            </div>

            <div class="alignright t_count" style="border-bottom:1px #ccc dotted; padding: 4px;">
                <div style="float:left;  width:30%;margin-top:12px; margin-left:12px; text-align:left; padding:6px 12px 10px; background-color:#ccc; border:1px #aaa solid"><strong style="margin-bottom:10px; display:block;">Enter Promotion Code</strong>
                    <input type="text" name="fname" value="" size="30" style="background-color:#f5f5f5; padding:3px; color:#090 ; width: 200px;" /> <input type="button" name="" value="Check" size="20" style=" background-color: #8AC1DF;font-weight: 700;height: 21px;line-height: 21px;padding:0 6px; border-color: #fff #6a6a6a #6A6A6A #fff; border-style: solid;border-width: 1px;color: #fff; cursor: pointer;font-family: Arial;font-size: 12px;" />
                </div>
                <div style="float:right; margin-top:12px; width:40%;">
                    <div style=" float:right;border-bottom:1px #ccc dotted; padding:5px; font-weight:700; color:#333;">Subtotal: <span class="" style="float:right; width:60px; font-weight:normal"><?php echo $symbol.$priceSummury['subtotal'];?></span></div>
                    <div class="clear"></div>
                    <div style="float:right;border-bottom:1px #ccc dotted; padding:5px;font-weight:700; color:#333;">Promotional Discounts: <span class="" style="float:right; width:60px; font-weight:normal; color:#999; "><?php echo $symbol.$priceSummury['discount'];?></span></div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>

                <div style="border-bottom:1px #ccc dotted; padding:5px 12px 12px; background:#fff; ">

                    <div style=" float:right; margin-left:20px; font-weight:700; padding-top:10px;">Total to Pay: <span class="red" style="font-size:18px;"><?php echo $symbol.$priceSummury['total'];?></span></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div style="float:right; width:50%; text-align:right">
                <input type="button" class="button button-checkstep" id="check_btn">
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <!--/user-cloum -->
</div>
<div class="clear"></div>