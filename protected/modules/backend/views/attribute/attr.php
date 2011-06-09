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
				'header'=>'属性名称',
				'name'=>'attribute_name',
			),
            array(
                'header'=>'属性状态',
                'name'=>'attribute_status',
                'value'=>'$data->attribute_status==1?"启用":"禁用"',
                'filter'=>array(0=>'禁用',1=>'启用'),
            ),
            array(
                'header'=>'属性值个数',
                'name'=>'attribute.value',
                'value'=>'$data->attributeValue',
                'filter'=>false,
            ),
            array(
                'header'=>'添加属性值',
                'name'=>'attribute',
                'type'=>'raw',
                'value'=>'CHtml::link("添加属性值","/backend/attribute/attrValue/attr/".$data->attribute_id)',
                'filter'=>false,
            ),
			array(
				'class' => 'CButtonColumn',
				'template' => '{update} {delete}',
                'updateButtonUrl'=>'Yii::app()->controller->createUrl("attribute/updateattr",array("group"=>$data->attributeGroup->group_id,"attr"=>$data->attribute_id))',
                'deleteButtonUrl'=>'Yii::app()->controller->createUrl("attribute/deleteattr",array("attr"=>$data->attribute_id))',
			),
		)
	));
	?>
</div>