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
                'header' => '商品名',
                'name' => 'product_name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->product->product_name,"/backend/product/update/id/".$data->product->product_id)',
            ),
            array(
                'header' => '浏览数量',
                'name' => 'product_viewed',
                'filter' => false,
            ),
            array(
                'header' => '购买数量',
                'name' => 'product_buyed',
                'filter' => false,
            ),
            array(
                'header' => '商品评论数量',
                'name' => 'product_reviewed',
                'filter' => false,
            ),
            array(
                'header' => 'wishlist',
                'name' => 'product_wished',
                'filter' => false,
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("statistic/product",array("id"=>$data->product_id))',
            ),
        )
    ));
    ?>
</div>