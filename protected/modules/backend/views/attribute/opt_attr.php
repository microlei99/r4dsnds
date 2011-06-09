<?php
$form = $this->beginWidget('CActiveForm', array(
     'id' => 'attribute_form',
));
?>
<div style="display: none;"></div>
<div  id="attribute_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">属性信息</h4>
        </div>

        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="attribute_name">属性名称<span class="required">*</span></label></td>
                            <td class="value">
                                <?php
                                echo $form->textField($model, 'attribute_name', array(
                                    'class' => 'required-entry required-entry input-text',
                                    'id' => 'attribute_name',
                                ));
                                ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'attribute_name'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="attribute_status">属性状态<span class="required">*</span></label></td>
                            <td class="value">
                                <?php
                                echo $form->dropDownList($model, 'attribute_status',array(1=>'启用',0=>'禁用'), array(
                                    'class' => 'required-entry required-entry input-text',
                                    'id' => 'attribute_status',
                                ));
                                ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'attribute_status'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>