
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
                'header' => '编号',
                'name' => 'country_id',
                'filter'=>false,
            ),
            array(
                'header' => '名称',
                'name' => 'name',
            ),
            array(
                'header' => '区域',
                'name' => 'zone_id',
                'type' => 'raw',
                'value' => 'Zone::items($data->zone_id)',
                'filter' => Zone::items(),
            ),
            array(
                'header' => 'ISO code',
                'name' => 'ISO_code',
            ),
            array(
                'header' => '包含州',
                'name' => 'contain_states',
                'value' => '$data->contain_states==1?"Yes":"No"',
                'filter' => array(1=>'Yes',2=>'No'),
                'type' => 'raw',
            ),
            array(
                'header' => '激活',
                'name' => 'active',
                'value' => '$data->active==1?"Yes":"No"',
                'filter' => array(1=>'Yes',0=>'No'),
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update} {delete}',
            ),
        )
    ));
    ?>
</div>