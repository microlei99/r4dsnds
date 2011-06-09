
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
                'name' => 'zone_id',
            ),
            array(
                'header' => '名称',
                'name' => 'name',
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