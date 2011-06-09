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
                'type' => 'raw',
                'value' => 'CHtml::link($data->product->product_name,"/backend/product/update/id/".$data->review_product_id)',
            ),
            array(
                'header'=>'商品SKU',
                'name'=>'review_product_sku',
            ),
            array(
                'header' => '评论人',
                'name'=>'customer',
                'value'=>'$data->customer==NULL?"Admin":"$data->customer->customer_name"',
                'filter'=>false,
            ),
            array(
                'header'=>'客户Email',
                'name'=>'review_email',
            ),
            array(
                'header' => '评论标题',
                'name' => 'review_subject',
                'filter' => false,
            ),
            array(
                'header'=>'评论内容',
                'name'=>'review_content',
                'filter'=>false,
            ),
            array(
                'header' => '评论时间',
                'name' => 'review_create_at',
                'filter' => false,
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}',
            ),
        )
    ));
    ?>
</div>