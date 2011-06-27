<div id="productGrid">
    <?php
    $this->widget('TradeGrid', array(
        'dataProvider' => $product->search(),
        'filter' => $product,
        'htmlOptions' => array(
            'class' => 'hor-scroll',
        ),
        'columns' => array(
            array(
                'header' => '编号',
                'value' => '$row+1',
            ),
            array(
                'header' => '名称',
                'name' => 'product_name',
                'htmlOptions'=>array('width'=>'250px'),
            ),
           
            array(
                'header' => 'SKU',
                'name' => 'product_sku',
            ),
            array(
                'header'=>'是否标记最新',
                'name'=>'product_new_arrivals',
                'value'=>'$data->product_new_arrivals==1 ? "是":"否"',
                'filter'=>array(1=>'是',0=>'否'),
            ),
            array(
                'header'=>'状态',
                'name'=>'product_active',
                'value'=>'$data->product_active==1?"YES":"NO"',
                'filter'=>array(1=>'YES',0=>'NO'),
            ),
            array(
                'header' => '所属分类',
                'name' => 'product_category_id',
                'value' => '$data->category->category_name',
                'filter' => ProductCategory::model()->getCategoryList(),
            ),
            array(
                'header' => '促销',
                'name' => 'product_promotion',
                'type' => 'raw',
                'value' => '$data->promotion->promotion_status!=2 ? CHtml::link("开启促销","/backend/promotion/open/pid/".$data->product_id):CHtml::link("关闭促销","/backend/promotion/close/pid/".$data->product_id)',
                'filter' => array(1=>'Yes',0=>'No'),
            ),
            array(
                'header' =>'批发',
                'name' => 'product_wholesale',
                'type' => 'raw',
                'value' => 'count($data->wholesale) ? CHtml::link("查看批发信息","/backend/wholesale/index/pid/".$data->product_id):CHtml::link("开启批发","/backend/wholesale/new/pid/".$data->product_id)',
                'filter' => array(1=>'Yes',0=>'No'),
            ),
            array(
                'header'=>'Feature',
                'name'=>'product_feature',
                'value'=>'$data->product_feature==1?"Yes":"No"',
                'filter'=>array(1=>'Yes',2=>'No'),
            ),
            array(
                'header'=>'Free Shipping',
                'name'=>'product_freeshiping',
                'value'=>'$data->product_freeshiping==1?"Yes":"No"',
                'filter'=>array(1=>'Yes',2=>'No'),
            ),
            /*array(
                'header' => '评论',
                'type' => 'raw',
                'value'=>'CHtml::link("评论","/backend/review/index/pid/".$data->product_id)',
            ),*/
            array(
                'header' => '最后更新时间',
                'type' => 'raw',
                'name' => 'product_last_update',
                'filter' => false,
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update} {delete}',
            ),
        )
    ));
    ?>
</div>