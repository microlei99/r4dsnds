<?php
$form = $this->beginWidget('CActiveForm', array(
     'id' => 'product_form',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
<div style="display: none;"></div>
<div  id="template_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">模板信息</h4>
        </div>

        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <?php if($message):?>
                        <tr><td colspan="4" style="width:600px;"><span class="required"><?php echo $message;?></span></td></tr>
                        <?php endif;?>
                        <tr>
                           <td class="label">选择要上传的文件<span class="required">*</span></td>
                            <td class="value"><?php echo CHtml::fileField('uploadFile'); ?></td>
                            <td class="scope-label"><span class="nobr"></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                           <td class="label"></td>
                            <td class="value"><?php echo CHtml::submitButton('submit',array('style'=>"margin-left: 10px;"))?></td>
                            <td class="scope-label"><span class="nobr"></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="hor-scroll">
                <span>图片上传完毕后，点击<a href="/backend/tool/generateImage" target="_blank">生成图片</a></span>
            </div>

        </div>
    </div>
</div>
<?php $this->endWidget() ?>