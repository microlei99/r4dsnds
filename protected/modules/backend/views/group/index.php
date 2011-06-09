<div id="attributeGrid">
<?php
    $this->widget('TradeGrid',array(
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'htmlOptions'=>array(
                    'class'=>'hor-scroll',
            ),
            'columns'=>array(
                    array(
                            'header'=>'组名',
                            'name'=>'group_name',
                            'type'=>'raw',
                            'value'=>'CHtml::link($data->group_name,"/backend/group/update/id/" . $data->group_id)',
                    ),
                    array(
                            'header'=>'组内人数',
                            'name'=>'stat.customer',
                            'value'=>'$data->customer',
                    ),
                    array(
                            'class'=>'CButtonColumn',
                            'template'=>'{update}',
                    ),
            )
    ));
    ?>
</div>
