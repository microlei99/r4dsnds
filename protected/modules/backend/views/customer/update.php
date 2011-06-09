<?php $form=$this->beginWidget('CActiveForm', array('id'=>'customer_form','enableAjaxValidation'=>false)); ?>
<div style="display: none;"></div>
<div  id="customer_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">账户信息</h4>
        </div>

        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="customer_email">Email<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'customer_email',array('class'=>'required-entry required-entry input-text', 'id'=>'customer_email'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'customer_email'); ?></span></td>
                            <td><small></small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="customer_group">客户组<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'customer_group',CustomerGroup::items(),array('class'=>'required-entry required-entry input-text','id'=>'customer_group'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'customer_group'); ?></span></td>
                            <td><small></small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="customer_newsletter">邮件订阅<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'customer_newsletter',array(1=>'是',0=>'否'),array('class'=>'required-entry required-entry input-text','id'=>'customer_newsletter'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'customer_newsletter'); ?></span></td>
                            <td><small></small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="customer_role">用户角色<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'customer_role',  Lookup::items('customer_role'),array('class'=>'required-entry required-entry input-text','id'=>'customer_role'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'customers_role'); ?></span></td>
                            <td><small></small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="customer_active">激活<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'customer_active',array(1=>'Yes',0=>'No'),array('class'=>'required-entry required-entry input-text','id'=>'customer_active'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'customer_active'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget();?>
<!-- customer address start-->
<div  id="customer_address_content" style="display:none;" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">地址簿</h4>
        </div>
        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <?php
                $this->widget('TradeGrid', array(
            'dataProvider' => $address->search(),
            'htmlOptions' => array(
                'class' => 'hor-scroll',
            ),
            'columns' => array(
                array(
                    'header' => '编号',
                    'name' => 'address_id',
                    'type' => 'raw',
                ),
                array(
                    'header'=>'性别',
                    'value'=>'CustomerAddress::getGender($data->customer_gender)',
                ),
                array(
                    'header'=>'姓名',
                    'value'=>'$data->customer_firstname." ".$data->customer_lastname',
                ),
                array(
                    'header'=>'国家',
                    'name'=>'address_country',
                    'value'=>'$data->country->name',
                ),
                array(
                   'header'=>'州/省',
                    'name'=>'address_state',
                ),
                array(
                    'header'=>'城市',
                    'name'=>'address_city',
                ),
                array(
                    'header'=>'街道',
                    'name'=>'address_street',
                ),
                array(
                    'header'=>'邮编',
                    'name'=>'address_postcode',
                ),
                array(
                    'header'=>'联系方式',
                    'name'=>'address_phonenumber',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{update}',
                    'updateButtonUrl'=>'Yii::app()->controller->createUrl("customerAddress/update",array("id"=>$data->address_id))',
                )
            )
        ));
                ?>
            </div>
        </div>
    </div>
</div>
<!-- customer address end-->
<!-- customer order start-->
<div  id="customer_order_content" style="display:none;" class="content_col">
    <div id="orderGrid">
<?php
        $this->widget('TradeGrid',array(
            'dataProvider'=>$order->search(),
            'filter'=>$order,
            'htmlOptions'=>array(
                'class'=>'hor-scroll',
            ),
            'columns'=>array(
                array(
                    'header'=>'流水号',
                    'name'=>'invoice_id',
                    'value'=>'$data->invoice_id',
                ),
                array(
                    'header'=>'下单时间',
                    'name'=>'order_create_at',
                    'filter'=>false,
                ),
                array(
                    'header'=>'合计',
                    'type'=>'raw',
                    'name'=>'order_grandtotal',
                    'value'=>'$data->currency->currency_symbol.$data->order_grandtotal',
                    'filter'=>false,
                ),
                array(
                    'header'=>'订单状态',
                    'type'=>'raw',
                    'name'=>'order_status',
                    'value'=>'Lookup::item("payment_status",$data->order_status)',
                    'filter'=>false
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{view}',
                    'viewButtonUrl'=>'Yii::app()->controller->createUrl("order/view",array("id"=>$data->order_id))',
                ),
            )
        ));
?>
    </div>
</div>
<!-- customer order end-->
<!-- customer shoppingcart start-->
<div  id="customer_cart_content" style="display:none;" class="content_col">
    <div id="cartGrid">
<?php
        $this->widget('TradeGrid',array(
            'dataProvider'=>$cart->search(),
            'filter'=>$cart,
            'htmlOptions'=>array(
                'class'=>'hor-scroll',
            ),
            'columns'=>array(
                array(
                    'header'=>'商品名',
                    'name'=>'product.product_name',
                    'type'=>'raw',
                    'value'=>'$data->product->product_name',
                    'filter'=>false,
                ),
                array(
                    'header'=>'数量',
                    'name'=>'product_qty',
                    'filter'=>false,
                ),
                array(
                    'header'=>'单价',
                    'type'=>'raw',
                    'name'=>'product.product_price',
                    'value'=>'"\$".$data->product->product_base_price',
                    'filter'=>false,
                ),
                array(
                    'header'=>'添加时间',
                    'name'=>'cart_addtime',
                    'filter'=>false,
                ),
            )
        ));
?>
    </div>
</div>
<!-- customer shoppingcart end-->