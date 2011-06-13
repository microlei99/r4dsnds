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
                'header' => '新闻编号',
                'name' => 'news_id',
                'filter'=>false,
            ),
            array(
                'header' => '新闻标题',
                'name' => 'news_title',
            ),

            array(
                'header'=>'Url',
                'name'=>'news_url',
            ),
            array(
                'header'=>'阅读次数',
                'name'=>'news_readtimes',
                'filter'=>false,
            ),
            array(
                'header'=>'添加日期',
                'name'=>'news_createat',
                'filter'=>false,
            ),
            array(
                'header'=>'最后更新日期',
                'name'=>'news_updateat',
                'filter'=>false,
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}{update}',
            ),
        )
    ));
    ?>
</div>