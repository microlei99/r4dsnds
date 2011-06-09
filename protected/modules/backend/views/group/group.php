<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'group_form',
        'enableAjaxValidation'=>false,
)); ?>
<div style="display: none;"></div>
<div  id="customer_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">组信息</h4>
        </div>

        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="group_name">组名<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'group_name',array('class'=>'required-entry required-entry input-text','id'=>'group_name'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'group_name'); ?></span></td>
                            <td><small></small></td>
                        </tr>                   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget()?>



