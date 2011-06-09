<div  id="customer_general_content" class="content_col">
    <div class="box-left entry-edit">
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-account">客户信息</h4>
            </div>
            <div class="order-totals">
                <div class="hor-scroll">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"><label>客户ID</label></td>
                                <td>
                                    <strong><?php echo $model->customer_id; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><label>客户姓名</label></td>
                                <td>
                                    <strong><?php echo $model->customer_name; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><label>Email</label></td>
                                <td><a href="mailto:<?php echo $model->customer_email; ?>"><strong><?php echo $model->customer_email; ?></strong></a></td>
                            </tr>
                            <tr>
                                <td class="label"><label>注册时间:</label></td>
                                <td><strong><?php echo $model->customer_create_at; ?></strong></td>
                            </tr>
                            <tr>
                                <td class="label"><label>有效订单数:</label></td>
                                <td><strong><?php echo Order::getCustomerValidOrders($model->customer_id); ?></strong></td>
                            </tr>
                            <tr>
                                <td class="label"><label>总计金额:</label></td>
                                <td><strong>$<?php echo Order::getCustomerTotalAmount($model->customer_id); ?></strong></td>
                            </tr>
                            <tr>
                                <td class="label"><label>客户组</label></td>
                                <td><strong><?php echo $model->group->group_name; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
     <h3>客户订单(<?php echo $order->getItemCount()?>)</h3>
    <div id="ordertGrid">
        <?php
            $this->widget('TradeGrid', array(
                'dataProvider' => $order,
                //'filter' => $order->model,
                'htmlOptions' => array(
                    'class' => 'hor-scroll',
                ),
                'columns' => array(
                    array(
                        'header' => '编号',
                        'name' => 'order_id',
                        'type' => 'raw',
                        'filter'=>FALSE,
                    ),
                    array(
                        'header' => '状态',
                        'name' => 'order_status',
                        'value' => 'Lookup::item("payment_status",$data->order_status)',
                        'type' => 'raw',
                        'filter'=>FALSE,
                    ),
                    array(
                        'header' => '金额',
                        'name' => 'order_grand',
                        'value' => 'Currency::getCurrencySymbol($data->order_currency_id) . $data->order_grandtotal',
                        'type' => 'raw',
                        'filter'=>FALSE,
                    ),
                    array(
                        'header' => '下单时间',
                        'name' => 'order_create_at',
                        'type' => 'raw',
                        'filter'=>FALSE,
                    ),
                    array(
                        'header' => '货运方式',
                        'name' => 'order_carrier_id',
                        'type' => 'raw',
                        'value' => '$data->carrier->carrier_name',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}',
                        'viewButtonUrl'=>'Yii::app()->controller->createUrl("order/view",array("id"=>$data->order_id))',
                      
                    )
                )
            ));
        ?>
    </div>
    <div class="clear"></div>
    <h3>客户地址(<?php echo $address->getItemCount();?>)</h3>
<div id="addressGrid">
    <?php
        $this->widget('TradeGrid', array(
            'dataProvider' => $address,
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
     <div class="clear"></div>
</div>