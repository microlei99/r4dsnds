<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'review_form',
        'enableAjaxValidation'=>false,
)); ?>
<div style="display: none;"></div>
<div  id="stat_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">评论信息</h4>
        </div>

        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="review_product_id">评论产品<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'review_product_id',  Product::getAllProductSku(),array('id'=>'review_product_id'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'review_product_id'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="review_email">评论Email<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'review_email',array('class'=>'required-entry required-entry input-text','id'=>'review_email'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'review_email'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="review_subject">评论标题<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'review_subject',array('class'=>'required-entry required-entry input-text','id'=>'review_subject'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'review_subject'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="review_content">评论内容<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textArea($model,'review_content',array('class'=>'required-entry required-entry input-text','id'=>'review_content'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'review_content'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget()?>



