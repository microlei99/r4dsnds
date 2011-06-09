
<div id="zoneGrid">
    <?php
    $this->widget('TradeGrid', array(
        'dataProvider' => $model->search(),
        'filter' => $model,
        'htmlOptions' => array(
            'class' => 'hor-scroll',
        ),
        'columns' => array(
            array(
                'header' => '名称',
                'name' => 'carrier_name',
            ),
            array(
                'header'=>'Tracking url',
                'name'=>'carrier_url',
                'htmlOptions'=>array('style'=>'width:600px;')
            ),
            array(
                'header' => '激活',
                'name' => 'carrier_active',
                'value' => '$data->carrier_active==1?"Yes":"No"',
                'filter' => array(1=>'Yes',0=>'No'),
            ),
            array(
                'header' => '货运费用',
                'name' => 'carrier_fee',
                'value' => '"$".$data->carrier_fee',
                'filter'=>false,
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update} {delete}',
            ),
        )
    ));
    ?>
</div>