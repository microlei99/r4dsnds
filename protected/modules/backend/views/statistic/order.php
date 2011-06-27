<div id="attributeGrid">
    <?php
    $this->widget('TradeGrid', array(
        'dataProvider' => $model->search(),
        'filter'=>$model,
        'htmlOptions' => array(
            'class' => 'hor-scroll',
        ),
        'columns' => array(
            array(
                'header' => '订单编号',
                'name' => 'invoice_id',
                //'value'=>'$data->getInvoice()',
            ),
            array(
                'header'=>'订单状态',
                'name'=>'order_status',
                'value'=>'$data->orderStatus()',
                'filter'=>  Lookup::items('payment_status'),
            ),
            array(
                'header'=>'订单总金额',
                'name'=>'order_grandtotal',
                'value'=>'$data->currency->currency_symbol.$data->order_grandtotal',
                'filter'=>false,
            ),
            array(
                'header'=>'支付类型',
                'name'=>'order_payment_id',
                'value'=>'$data->order_payment_id==1?"paypal":"credit card"',
                'filter'=>false,
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
                'filter'=>false
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