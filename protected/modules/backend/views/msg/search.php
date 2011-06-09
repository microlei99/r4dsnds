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
                'header' => '搜索关键词',
                'name' => 'search_query',
            ),
            array(
                'header' => '搜索次数',
                'name' => 'search_times',
            ),
            array(
                'header' => '搜索结果',
                'name' => 'search_result',
                'type' => 'raw',
            ),
            array(
                'header' => '搜索人数',
                'name' => 'search_user',
            ),
            array(
                'header' => '最后搜索时间',
                'name' => 'search_update_at',
                'filter' => false,
            ),
        )
    ));
    ?>
</div>