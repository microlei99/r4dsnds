<?php
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'creditcard_form',
    ));
?>
<div  id="product_general_content" class="content_col">
    <div class="box-left">
        <!--Order Information-->
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-account">信用卡账号设置</h4>
            </div>
            <div class="fieldset">

                <table cellspacing="0" class="form-list">
                    <tbody>

                        <tr>
                            <td class="label"><label for="realypay_siteid">站点ID号</label></td>
                            <td class="value">
                                <input type="text" name="realypay[realypay_siteid]" id="realypay_siteid" class="required-entry required-entry input-text" value="<?php echo $realypay['realypay_siteid'];?>" >
                            </td>
                            <td class="scope-label"><span class="nobr"></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="realypay_key">站点密钥<span class="required">*</span></label></td>
                            <td class="value">
                                <input type="text" name="realypay[realypay_key]" id="realypay_key" class="required-entry required-entry input-text" value="<?php echo $realypay['realypay_key'];?>">
                            </td>
                            <td class="scope-label"><span class="nobr"><?php //echo $form->error($model,'payment_test'); ?></span></td>
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