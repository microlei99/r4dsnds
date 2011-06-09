<?php
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'paypal_form',
    ));
?>
<div  id="product_general_content" class="content_col">
    <div class="box-left">
        <!--Order Information-->
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-account">账号设置</h4>
            </div>
            <div class="fieldset">

                <table cellspacing="0" class="form-list">
                    <tbody>

                        <tr>
                            <td class="label"><label for="payment_username">账号</label></td>
                            <td class="value">
                                <?php echo $form->textField($model,'payment_username',array('class'=>'required-entry required-entry input-text', 'id'=>'payment_username'));?>
                            </td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'payment_username'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="payment_test">测试模式<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'payment_test',array(1=>'Yes',0=>'No'),array('class'=>'required-entry required-entry input-select','id'=>'payment_test'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'payment_test'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php $this->endWidget() ?>