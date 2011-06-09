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
                'name' => 'state_id',
                'type' => 'raw',
            ),
            array(
                'header' => '名称',
                'name' => 'name',
                'type' => 'raw',
            ),
            array(
                'header' => '区域',
                'name' => 'zone_id',
                'type' => 'raw',
                'value' => '$data->zone->name',
                'filter' => Zone::items(),
            ),
            array(
                'header' => '国家',
                'name' => 'country_id',
                'type' => 'raw',
                'value' => 'Country::item($data->country_id)',
                'filter' => Country::items(true),
            ),
            array(
                'header' => 'ISO code',
                'name' => 'iso_code',
                'type' => 'raw',
            ),
            array(
                'header' => '激活',
                'name' => 'active',
                'value' => '$data->active==1?"Yes":"No"',
                'filter' => array(1=>'Yes',2=>'No'),
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update} {delete}',
            ),
        )
    ));
    ?>
</div>