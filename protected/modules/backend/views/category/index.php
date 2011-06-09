<ul class="tabs-horiz" id="product_tabs">
    <li>
        <a class="tab-item-link active" title="General Information" id="category_general" href="#">
            <span><span title="The information in this tab has been changed." class="changed"></span><span title="This tab contains invalid data. Please solve the problem before saving." class="error"></span>基本信息</span>
        </a>
    </li>
    <?php if(isset($product)):?>
    <li>
        <a class="tab-item-link" title="Category Products" id="category_product" href="#">
            <span><span title="The information in this tab has been changed." class="changed"></span><span title="This tab contains invalid data. Please solve the problem before saving." class="error"></span>分类下商品</span>
        </a>
    </li>
    <?php endif;?>
</ul>

<?php $form=$this->beginWidget('CActiveForm', array('id'=>'category_form')); ?>
<div id="category_tab_content">
    <div class="content_col" id="category_general_content">
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-edit-form fieldset-legend">基本信息</h4>
                <div class="form-buttons"></div>
            </div>
            <div id="group_3fieldset_group_3" class="fieldset fieldset-wide">
                <div class="hor-scroll">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"><label for="category_name">名称<span class="required">*</span></label></td>
                                <td class="value"><?php echo $form->textField($model,'category_name',array('class'=>'required-entry required-entry input-text','id'=>'category_name',));?></td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'category_name'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="category_active">是否激活<span class="required">*</span></label></td>
                                <td class="value"><?php echo $form->dropDownList($model,'category_active',array(1=>'上架',0=>'下架'));?></td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="category_url">URL（默认以名字为准）</label></td>
                                <td class="value"><?php echo $form->textField($model,'category_url',array('class'=>'required-entry required-entry input-text','id'=>'category_url'));?></td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'category_url'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                            <td class="label"><label for="category_introduce">介绍<span class="required">*</span></label></td>
                            <td class="value">
                                <?php
                                 $this->widget('ext.dxheditor.DxhEditor', array(
                                        'model'=>$model,
                                        'attribute'=>'category_introduce',
                                        'htmlOptions'=>array(
                                                'class'=>'required-entry required-entry textarea',
                                                'id'=>'category_introduce',
                                                'style'=>'height:200px;'
                                        ),
                                        //'language'=>'en',
                                        'language' => 'zh-cn',
                                        'options'=>array(
                                                'upMultiple'=>5,
                                                'upLinkUrl'=>'{editorRoot}upload.php',
                                                'upLinkExt'=>'zip,rar,7z,txt,doc,xls,ppt,docx,xlsx,pptx',
                                                'upImgUrl'=>'{editorRoot}upload.php',
                                            'tools' => 'simple',  //// mini, simple, full
                                        ),
                                ));
                                ?>
                            </td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'category_introduce'); ?></span></td>
                            <td><small></small></td>
                        </tr>

                            <tr>
                                <td class="label"><label for="seo_title">页面标题<span class="required">*</span></label></td>
                                <td class="value"><?php echo $form->textField($model->seo,'seo_title',array('class'=>'input-text','id'=>'seo_title'));?></td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'seo_title'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="seo_keyword">关键字<span class="required">*</span></label></td>
                                <td class="value"><?php echo $form->textField($model->seo,'seo_keyword',array('class'=>'input-text','id'=>'seo_keyword'));?></td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'seo_keyword'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="seo_description">描述<span class="required">*</span></label></td>
                                <td class="value"><?php echo $form->textArea($model->seo,'seo_description',array('class'=>'textarea','cols'=>'15','rows'=>'2','id'=>'seo_description','style'=>'height:100px;')); ?></td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'seo_description'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($product)):?>
<!-- product start-->
    <div style="display:none"class="content_col" id="category_product_content">
        <div id="catalog_category_products">
<?php 
$this->widget('TradeGrid', array(
    'dataProvider' => $product->search(),
    'filter' => $product,
    'htmlOptions' => array(
        'class' => 'hor-scroll',
    ),
    'columns' => array(
        array(
            'header' => '名称',
            'name' => 'product_name',
            'type' => 'raw',
        ),
        array(
            'header' => 'SKU',
            'name' => 'product_sku',
        ),
        array(
            'header' => '促销',
            'name' => 'product.promotion',
            'type' => 'raw',
            'value' => '$data->promotion==NULL ? CHtml::link("开启","/backend/promotion/set/id/".$data->product_id):CHtml::link("关闭","/backend/promotion/set/id/".$data->product_id)',
            'filter' => false,
        ),
        array(
            'header' => '最后更新时间',
            'type' => 'raw',
            'name' => 'product_last_update',
            'filter' => false,
        ),
        array(
            'header' => '统计',
            'name' => 'stat',
            'type' => 'raw',
            'value' => 'CHtml::link("统计","/backend/stat/product/id/".$data->product_id)',
            'filter' => false,
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("product/update",array("id"=>$data->product_id))',
        ),
    )
));
?>
        </div>
    </div>
<!-- product end-->
<?php endif;?>
</div>
<?php
    echo  $form->hiddenField($model,'category_parent_id',array('id'=>'category_parent_id'));
    echo  $form->hiddenField($model,'category_id',array('id'=>'category_id'));
    $this->endWidget();
?>
<script type="text/javascript">
    $('#add_root_category_button').click(function(){
        location.href='/backend/category/createRootCategory';
    });
    $('#add_subcategory_button').click(function(){
         location.href='/backend/category/createSubCategory';
    });
</script>