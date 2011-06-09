<div id="productGrid">
    <?php
    $this->widget('TradeGrid', array(
        'dataProvider' => $model->search(),
        'filter' => $model,
        'htmlOptions' => array(
            'class' => 'hor-scroll',
        ),
        'columns' => array(
            array(
                'header' => '商品名称',
                'name' => 'product_name',
                'value'=>'$data->product->product_name',
            ),
            array(
                'header' => '商品SKU',
                'name' => 'product_sku',
                'value'=>'$data->product->product_sku',
            ),
            array(
                'header' => '促销类型',
                'name' => 'promotion_type',
                'value'=>'$data->promotion_type==1?"By Amount":"By Percent"',
                'filter'=>array('1'=>'By Amount',2=>'By Percent')
            ),
            array(
                'header'=>'促销价格',
                'name'=>'promotion_price',
                'value'=>'"$".$data->promotion_price',
                'filter'=>false,
            ),
            array(
                'header'=>'折扣',
                'name'=>'promotion_percent',
            ),
            array(
                'header'=>'促销起始时间',
                'name'=>'promotion_start_at',
                'filter'=>false,
            ),
            array(
                'header'=>'促销结束时间',
                'name'=>'promotion_end_at',
                'filter'=>false,
            ),
            array(
                'header'=>'促销状态',
                'name'=>'promotion_status',
                'value'=>'$data->promotion_status==2?"开启":($data->promotion_status==1?"过期":"关闭")',
                'filter'=>array(1=>'过期',2=>'正常',3=>'关闭'),
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}',
            ),
        )
    ));
    ?>
</div>