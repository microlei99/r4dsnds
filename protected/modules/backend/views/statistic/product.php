<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'statistic_form',
        'enableAjaxValidation'=>false,
)); ?>
<div style="display: none;"></div>
<div  id="stat_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">统计信息</h4>
        </div>

        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label">商品名称</td>
                            <td class="value"><?php echo  CHtml::link($model->product->product_name,'/backend/product/update/id/'.$model->product->product_id);?></td>
                            <td class="scope-label"></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_viewed">浏览数量<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_viewed',array('class'=>'required-entry required-entry input-text','id'=>'product_viewed'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_viewed'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_buyed">购买数量<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_buyed',array('class'=>'required-entry required-entry input-text','id'=>'product_buyed'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_buyed'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_reviewed">商品评论数量<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_reviewed',array('class'=>'required-entry required-entry input-text','id'=>'product_reviewed'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_reviewed'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="product_wished">wishlist<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'product_wished',array('class'=>'required-entry required-entry input-text','id'=>'product_wished'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'product_wished'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget()?>



