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
                            <td class="label"><label for="group_name">属性组名称<span class="required">*</span></label></td>
                            <td class="value">
                                <?php
                                echo $form->textField($model, 'group_name', array(
                                    'class' => 'required-entry required-entry input-text',
                                    'id' => 'group_name',
                                ));
                                ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'group_name'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="group_default">默认属性组<span class="required">*</span></label></td>
                            <td class="value">
                                <?php
                                echo $form->dropDownList($model, 'group_default',array(1=>'默认',0=>'非默认'), array(
                                    'class' => 'required-entry required-entry input-text',
                                    'id' => 'group_default',
                                ));
                                ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'group_default'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="group_status">属性组状态<span class="required">*</span></label></td>
                            <td class="value">
                                <?php
                                echo $form->dropDownList($model, 'group_status',array(1=>'启用',0=>'禁用'), array(
                                    'class' => 'required-entry required-entry input-text',
                                    'id' => 'group_status',
                                ));
                                ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'group_status'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>