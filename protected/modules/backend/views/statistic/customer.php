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
                'header' => 'Email',
                'name' => 'customer_email',
                'type' => 'raw',
                'value' => 'CHtml::link($data->customer_email,"/backend/customer/update/id/".$data->customer_id)',
            ),
            array(
                'header'=>'注册时间',
                'name'=>'customer_create_at',
                'filter'=>false,
            ),
            array(
                'header'=>'总消费金额',
                'name'=>'customerConsumption',
                'value'=>'"\$".$data->customerConsumption',
                'filter'=>false,
            )
        )
    ));
    ?>
</div>