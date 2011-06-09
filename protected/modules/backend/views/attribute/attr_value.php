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
				'header'=>'属性值名称',
				'name'=>'attribute_value',
			),
			array(
				'class' => 'CButtonColumn',
				'template' => '{update}{delete}',
                'updateButtonUrl'=>'Yii::app()->controller->createUrl("attribute/updateattrValue",array("id"=>$data->attribute_value_id))',
                'deleteButtonUrl'=>'Yii::app()->controller->createUrl("attribute/deleteattrValue",array("id"=>$data->attribute_value_id))',
			),
		)
	));
	?>
</div>