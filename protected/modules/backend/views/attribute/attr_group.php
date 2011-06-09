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
				'header'=>'属性组名称',
				'name'=>'group_name',
			),
            array(
                'header'=>'属性状态',
                'name'=>'group_status',
                'value'=>'$data->group_status==1?"启用":"禁用"',
                'filter'=>array(0=>'禁用',1=>'启用'),
            ),
            array(
                'header'=>'子属性个数',
                'name'=>'group.attribute',
                'value'=>'$data->attributeNum',
                'filter'=>false,
            ),
            array(
                'header'=>'添加子属性',
                'name'=>'attribute',
                'type'=>'raw',
                'value'=>'CHtml::link("添加子属性","/backend/attribute/attr/group/".$data->group_id)',
                'filter'=>false,
            ),
            array(
                'header'=>'默认属性组',
                'name'=>'group_default',
                'type'=>'raw',
                'value'=>'$data->group_default==1?"<img src=\'/assets/default/default/images/fam_bullet_success.gif\'>":""',
                'filter'=>false,
            ),
			array(
				'class' => 'CButtonColumn',
				'template' => '{update} {delete}',
                'updateButtonUrl'=>'Yii::app()->controller->createUrl("attribute/updateattrGroup",array("group"=>$data->group_id))',
                'deleteButtonUrl'=>'Yii::app()->controller->createUrl("attribute/deleteattrGroup",array("group"=>$data->group_id))',
			),
		)
	));
	?>
</div>