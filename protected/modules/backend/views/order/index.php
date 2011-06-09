<div id="attributeGrid">
    <?php
    $this->widget('TradeGrid', array(
        'dataProvider' => $model->search(),
        'filter' => $model,
        'htmlOptions' => array(
            'class' => 'hor-scroll',
        ),
        'columns' => array(
            array(
                'header' => '订单号',
                'name' => 'invoice_id',
                'value'=>'$data->getInvoice()'
            ),
            array(
                'header' => '订单状态',
                'name' => 'order_status',
                'type' => 'raw',
                'value' => 'Lookup::item("payment_status",$data->order_status)',
                'filter' => Lookup::items("payment_status"),
            ),
            array(
                'header'=>'客户姓名',
                'name'=>'customer_name',
                'value'=>'$data->address->customer_name',
            ),
            array(
                'header' => '客户Email',
                'name' => 'customer_email',
                'type' => 'raw',
                'value' => 'CHtml::link($data->customer->customer_email,"/backend/customer/update/id/".$data->customer_id)',
            ),
            array(
                'header'=>'Paypal交易号',
                'name'=>'paypal_txnid',
                'value'=>'$data->paypal->response_txn_id',
            ),
            array(
                'header' => '订单最终金额',
                'name' => 'order_grandtotal',
                'type' => 'raw',
                'value' => '$data->currency->currency_symbol.$data->order_grandtotal',
                'filter' => false,
            ),
            array(
                'header' => '运输方式',
                'name' => 'order_carrier_id',
                'value'=>'$data->carrier->carrier_name',
                'filter'=>false,
            ),
            array(
                'header' => '下单时间',
                'name' => 'order_create_at',
                'filter' => false,
            ),
            array(
                'header' => '支付时间',
                'name' => 'order_payment_at',
                'value'=>'strtotime($data->order_payment_at)==false?"未支付":$data->order_payment_at',
                
                'filter' => false,
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view} {shipping}',
                'buttons'=>array(
                    'view'=>array(
                       'url'=>'Yii::app()->controller->createUrl("order/view",array("id"=>$data->order_id))',
                        'options'=>array("target"=>"_blank"),
                    ),
                    'shipping'=>array(
                        'label' => 'Shipping',
                        'imageUrl'=>'/assets/default/images/fam_lorry.gif',
                        'visible' => '$data->order_status=='.Order::Delived.' OR $data->order_status=='.Order::Shipped,
                    )
                ),
            ),
        )
    ));
    ?>
</div>