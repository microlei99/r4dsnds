<p>拖动即可编辑顺序</p>
<?php
   
    $items = CHtml::listData($data->getData(), 'category_id', 'category_name');

    $this->widget('zii.widgets.jui.CJuiSortable', array(
        'id' => 'orderList',
        'items' => $items,
        'htmlOptions'=>array(
            'style'=>'display:block;
            color:#67767E;border-color:#F9F9F9 #D1CFCF #F9F9F9 #F9F9F9;border-style:solid;border-width:1px;font-size:0.9em;
'
        ),
    ));
    // Add a Submit button to send data to the controller
    echo CHtml::ajaxButton('提交更改', '', array(
        'type' => 'POST',
        'beforeSend'=>'function(id) {$("#loading-mask").show();}',
        'complete'=>'function(id,data){$("#loading-mask").hide();}',
        'data' => array(
            // Turn the Javascript array into a PHP-friendly string
            'order' => 'js:$("ul#orderList").sortable("toArray").toString()',
        )
    ));
?>
