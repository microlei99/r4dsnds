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
                'name' => 'wholesale_type',
                'value'=>'$data->wholesale_type==1?"By Amount":"By Percent"',
                'filter'=>array(1=>'By Amount',2=>'By Percent')
            ),
            array(
                'header'=>'批发状态',
                'name'=>'wholesale_active',
                'value'=>'$data->wholesale_active==1?"Yes":"No"',
                'filter'=>array(1=>'Yes',0=>'No'),
            ),
            array(
                'header'=>'下限',
                'name'=>'wholesale_product_interval1',
                'filter'=>false,
                
            ),
            array(
                'header'=>'上限',
                'name'=>'wholesale_product_interval2',
                 'filter'=>false,
            ),
            array(
                'header'=>'批发价格',
                'name'=>'wholesale_product_price',
                'value'=>'"$".$data->wholesale_product_price',
                'filter'=>false,
            ),
            array(
                'header'=>'批发折扣',
                'name'=>'wholesale_product_percent',
            ),
            array(
                'header'=>'促销起始时间',
                'name'=>'wholesale_create_at',
                'filter'=>false,
            ),
            
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}',
            ),
        )
    ));
    ?>
</div>