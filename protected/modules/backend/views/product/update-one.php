<?php $url = Yii::app()->params['backendPath'];?>
<script type="text/javascript" src="<?php echo $url.'js/select.js';?>"></script>
<?php
$form=$this->beginWidget('CActiveForm', array(
        'id'=>'product_form',
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
<div style="display: none;"></div>
<div  id="product_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">主要信息</h4>
        </div>
        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="product_name">名称<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_name',array('class'=>'required-entry required-entry input-text','id'=>'product_name'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_name'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_name_alias">别名<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_name_alias',array('class'=>'required-entry required-entry input-text','id'=>'product_name_alias'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_name_alias'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"> <label for="product_sku">sku<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_sku',array('class'=>'required-entry required-entry input-text','id'=>'product_sku',)); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_sku'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"> <label for="product_sku">标记为最新产品<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'product_new_arrivals',array(1=>'标记',0=>'不标记'),array('id'=>'product_new_arrivals'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_new_arrivals');?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_active">是否激活<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'product_active',array(1=>'上架',0=>'下架'),array('id'=>'product_active'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_active');?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                                <td class="label"><label for="product_status">状态 <span class="required">*</span></label></td>
                                <td class="value">
                                    <select multiple="multiple" name="Product[product_status][]" id="product_satus" class="required-entry input-text multiselect">
                                    <?php
                                        $intersect = array_intersect(array(1, 2, 4, 8),Product::resolveStatus($model->product_status));
                                        $i=1;
                                        foreach (Lookup::items('product_status') as $item)
                                        {
                                            $sel = in_array($i,$intersect) ? 'selected=selected':'';
                                            echo "<option value='{$i}'{$sel}>{$item}</option>";
                                            $i*=2;
                                        }
                                    ?>
                                    </select>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                        <tr>
                            <td class="label"><label for="product_url">Url（默认以名字为准）</label></td>
                            <td class="value"><?php echo $form->textField($model,'product_url',array('class'=>'required-entry required-entry input-text','id'=>'product_url')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_url'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_description">介绍<span class="required">*</span></label></td>
                            <td class="value">
                                <?php
                                $this->widget('ext.dxheditor.DxhEditor', array(
                                        'model'=>$model,
                                        'attribute'=>'product_description',
                                        'htmlOptions'=>array(
                                                'class'=>'required-entry required-entry textarea',
                                                'id'=>'product_description',
                                                'style'=>'height:300px;'
                                        ),
                                        //'language'=>'en',
                                        'language' => 'zh-cn',
                                        'options'=>array(
                                                'upMultiple'=>5,
                                                'upLinkUrl'=>'{editorRoot}upload.php',
                                                'upLinkExt'=>'zip,rar,7z,txt,doc,xls,ppt,docx,xlsx,pptx',
                                                'upImgUrl'=>'{editorRoot}upload.php',
                                            'tools' => 'full',  //// mini, simple, full
                                        ),
                                ));
                                ?>
                            </td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_description'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_short_description">缩略介绍<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textArea($model,'product_short_description',array('class'=>'required-entry required-entry textarea','id'=>'product_short_description',)); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_short_description'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"> <label for="product_weight">重量<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_weight',array('class'=>'required-entry required-entry input-text','id'=>'product_weight')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_weight'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- price -->
<div style="display:none;" id="product_price_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">价格</h4>
        </div>
        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="product_base_price">成本价<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_base_price',array('class'=>'required-entry input-text','id'=>'product_base_price'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_base_price'); ?></span></td>
                            <td><small></small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="product_orig_price">原价<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_orig_price',array('class'=>'required-entry input-text','id'=>'product_orig_price')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_orig_price'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_special_price">售价<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_special_price',array('class'=>'required-entry input-text','id'=>'product_special_price')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_special_price'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- price end-->
<!-- attributes start -->
<?php if($attributes):?>
<div style="display:none;" id="product_attribute_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">属性</h4>
        </div>
        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="attribute_group_id">属性组</label></td>
                            <td class="value"><input type="text" value="<?php echo $defaultGroup;?>" class="required-entry input-text" disabled="disabled" /></td>
                            <td class="scope-label"></td>
                        </tr>
                        <?php
                            if($attributes):
                            foreach($attributes as $key=>$value):
                        ?>
                        <tr>
                            <td class="label"><label for=""><?php echo $value['attribute'];?><span class="required">*</span></label></td>
                            <td class="value"><input type="text" name="attributes[<?php echo $key;?>][]" class="required-entry input-text" value="<?php echo $value['value'];?>" id="<?php echo 'text_'.$key;?>"></td>
                            <td class="value">
                               <?php
                                    $attrValue = AttributeValue::item($key);
                                    if($attrValue):
                                ?>
                                    <select onchange="cutover(this.value,<?php echo $key;?>)">
                                        <option value="-1">请选择属性值</option>
                                            <?php foreach($attrValue as $i=>$j):?>
                                                <option value="<?php echo $i.','.$j;?>"><?php echo $j;?></option>
                                            <?php endforeach;?>
                                    </select>
                                <? else:?>
                                    <span><?php echo CHtml::link('无属性值存在，单击添加','/backend/attribute/attrValue/attr/'.$key);?></span>
                                <?php endif;?>
                            </td>
                            <td class="scope-label"><span class="nobr"><?php echo $value['error'];?></span></td>
                            <td><small></small></td>
                        </tr>
                        <?php endforeach;endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<!-- attributes end-->

<!-- stock start -->
<div style="display:none;" id="product_inventory_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">商品库存</h4>
        </div>
        <div id="group_3fieldset_group_3" class="fieldset fieldset-wide">
            <div class="hor-scroll" id="inventory_form">
                <table cellspacing="0" class="form-list">
                    <tbody>
						 <tr>
                            <td class="label"><label for="product_stock_qty">库存量</label></td>
                            <td class="value"><?php echo $form->textField($model,'product_stock_qty',array('class'=>'input-text','id'=>'product_stock_qty'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_stock_qty'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="product_stock_cart_min">购物车最小件数</label></td>
                            <td class="value"><?php echo $form->textField($model,'product_stock_cart_min',array('class'=>'input-text','id'=>'product_stock_cart_min'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_stock_cart_min'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="product_stock_cart_max">购物车最大件数</label></td>
                            <td class="value"><?php echo $form->textField($model,'product_stock_cart_max',array('class'=>'input-text','id'=>'product_stock_cart_max'));?>(-1表示无限制)</td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_stock_cart_max'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_stock_status">库存状态</label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'product_stock_status',array(1=>'In Stock',0=>'Out Stock',2=>'Stock Warning'),array('id'=>'product_stock_status',));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_stock_status'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                       </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- stock end-->
<!-- seo start -->
<div style="display:none;" id="product_seo_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">Product SEO</h4>
        </div>
        <div id="group_3fieldset_group_3" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="seo_title">页面标题<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model->seo,'seo_title',array('class'=>'input-text', 'id'=>'seo_title'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'seo_title'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="seo_keyword">产品关键字<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model->seo,'seo_keyword',array('class'=>'input-text','id'=>'seo_keyword',)); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'seo_keyword'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="seo_description">产品描述<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textArea($model->seo,'seo_description',array('class'=>'textarea','cols'=>'15','rows'=>'2','id'=>'seo_description')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'seo_description'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- seo end-->
<!-- category start-->
<div style="display:none;" id="product_category_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">商品分类</h4>
        </div>
        <fieldset id="grop_fields">
            <?php $this->widget('CTreeView',array('data' =>$tree,'htmlOptions'=>array('class'=>"treeview-famfamfam")));?>
            <span class="nobr"><?php echo $form->error($model,'product_category_id'); ?></span>
        </fieldset>
    </div>
</div>
<!-- category end-->
<!-- image start-->
<div style="display:none;" id="product_image_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">商品图片</h4>
        </div>
        <?php
        $this->widget('TradeGrid',array(
                'dataProvider'=>$image->search(),
                'filter'=>$image,
                'htmlOptions'=>array(
                        'class'=>'hor-scroll',
                ),
                'columns'=>array(
                        array(
                                'header'=>'缩略图',
                                'name'=>'image_path',
                                'type'=>'raw',
                                'value'=>'CHtml::image($data->image_path,null,array("width"=>100))',
                                'filter'=>false,
                                'htmlOptions'=>array('style'=>'width:140px','align'=>'center')
                        ),
                        array(
                                'header'=>'默认',
                                'name'=>'image_default',
                                'value'=>'CHtml::radioButton("defaultImage",$data->image_default,array("value"=>$data->image_id))',
                                'type'=>'raw',
                                'filter'=>false,
                        ),
                        array(
                                'header'=>'标签',
                                'name'=>'image_alt',
                                'value'=>'CHtml::textField("image[$data->image_id][alt]",$data->image_alt,array("class"=>"required-entry required-entry input-text","style"=>"height:50px;"))',
                                'type'=>'raw',
                                'filter'=>false,
                        ),
                        array(
                                'class'=>'CButtonColumn',
                                'template'=>'{delete}',
                                'deleteButtonUrl'=>'Yii::app()->controller->createUrl("product/imageDelete",array("id"=>$data->image_id))',
                        ),
                )
        ));
        $this->widget('CSwfUpload', array(
                'jsHandlerUrl' => $url.'swfupload/handlers.js',
                'postParams'=>array('productID'=>$model->product_id),
                'config'=>array(
                        'use_query_string'=>false,
                        'upload_url'=>Yii::app()->controller->createUrl("product/uploadImage"),
                        'file_size_limit'=>'2 MB',
                        'file_types'=>'*.jpg;*.png;*.gif',
                        'file_types_description'=>'Image Files',
                        'file_upload_limit'=>0,
                        'file_queue_error_handler'=>'js:fileQueueError',
                        'file_dialog_complete_handler'=>'js:fileDialogComplete',
                        'upload_progress_handler'=>'js:uploadProgress',
                        'upload_error_handler'=>'js:uploadError',
                        'upload_success_handler'=>'js:uploadSuccess',
                        'upload_complete_handler'=>'js:uploadComplete',
                        'custom_settings'=>array('upload_target'=>'divFileProgressContainer'),
                        'button_image_url'=>$url."swfupload/images/button_image.png",
                        'button_placeholder_id'=>'swfupload',
                        'button_width'=>180,
                        'button_height'=>18,
                        'button_text'=>'<span>'.Yii::t('messageFile', '选择图片').'(Max 2 MB)</span>',
                        'button_text_style'=>'.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
                        'button_text_top_padding'=>0,
                        'button_text_left_padding'=>18,
                        'button_window_mode'=>'js:SWFUpload.WINDOW_MODE.TRANSPARENT',
                        'button_cursor'=>'js:SWFUpload.CURSOR.HAND',
                ),
             ));
        ?>
        <div class="uploader">
            <div id="divFileProgressContainer" class="file-row"></div>
            <div class="flex"><span id="swfupload"></span></div>
            <div id="thumbnails"></div>
        </div>
    </div>
</div>
<!-- end image-->
<?php $this->endWidget(); ?>