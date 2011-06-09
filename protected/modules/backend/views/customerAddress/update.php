<?php $form=$this->beginWidget('CActiveForm', array('id'=>'customer_address_form','enableAjaxValidation'=>false)); ?>
<div style="display: none;"></div>
<div  id="customer_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">修改地址信息</h4>
        </div>

        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        
                        <tr>
                            <td class="label"><label for="customer_firstname">姓<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'customer_firstname',array('class'=>'required-entry required-entry input-text','id'=>'customer_firstname'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'customer_firstname'); ?></span></td>
                            <td><small></small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="customer_lastname">名<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'customer_lastname',array('class'=>'required-entry required-entry input-text','id'=>'customer_lastname'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'customer_lastname'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="address_country">国家<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($model,'address_country',  Country::items(),array('class'=>'required-entry required-entry input-text','id'=>'address_country'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'address_country'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="address_state">州/省<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'address_state',array('class'=>'required-entry required-entry input-text','id'=>'address_state'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'address_state'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="address_city">城市<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'address_city',array('class'=>'required-entry required-entry input-text','id'=>'address_city'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'address_city'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="address_street">街道<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'address_street',array('class'=>'required-entry required-entry input-text','id'=>'address_street'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'address_street'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="address_postcode">邮编<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'address_postcode',array('class'=>'required-entry required-entry input-text','id'=>'address_postcode'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'address_postcode'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="address_phonenumber">联系方式<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($model,'address_phonenumber',array('class'=>'required-entry required-entry input-text','id'=>'address_phonenumber'));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'address_phonenumber'); ?></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget();?>
