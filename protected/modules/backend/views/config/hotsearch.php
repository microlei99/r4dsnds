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
                'header' => '关键词',
                'name' => 'search_code',
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}',
                'updateButtonUrl'=>'Yii::app()->controller->createUrl("config/updatehotsearch",array("id"=>$data->search_id))',
                'deleteButtonUrl'=>'Yii::app()->controller->createUrl("config/deletehotsearch",array("id"=>$data->search_id))'
            ),
        )
    ));
    ?>
</div>