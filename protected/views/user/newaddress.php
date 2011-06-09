<?php $form=$this->beginWidget('CActiveForm', array(
                 'id'=>'address-form',
                'htmlOptions'=>array('name'=>'address'))
           );?>
<div class="sunmm_box">
                <h3 style="border-bottom:1px #ddd solid; padding-bottom:6px; margin-bottom:10px;">Your Delivery Address</h3>

                <p class="gray">The fields marked with <strong class="red">*</strong> are mandatory.</p>
                    <table cellspacing="1" cellpadding="3" align="center" style="padding:18px 24px;" >
                        <tr>
                            <td height="36"><strong>First Name: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'customer_firstname',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'customer_firstname',array('style'=>'margin-left:12px;')); ?></strong></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>Last name: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'customer_lastname',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'customer_lastname',array('style'=>'margin-left:12px;')); ?></strong></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>Address: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_street',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_street',array('style'=>'margin-left:12px;')); ?></strong></td>
                        </tr>

                        <tr>
                            <td height="36"><strong>City/Town: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_city',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_city',array('style'=>'margin-left:12px;')); ?></strong></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>State/Province: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_state',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_state',array('style'=>'margin-left:12px;')); ?></strong></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>Country: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->dropDownList($address,'address_country',Country::items(),array('style'=>'width:200px;'));?>
                            </td>
                                <td></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>Post Code: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_postcode',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_postcode',array('style'=>'margin-left:12px;')); ?></strong></td>
                        </tr>

                        <tr>
                            <td height="36"><strong>Phone Number: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_phonenumber',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_phonenumber',array('style'=>'margin-left:12px;')); ?></strong></td>
                        </tr>
                    </table>

            </div>
<div class="sunmm_box" style="background-color:#f8f8f8; padding:6px;">
                    <div class=""><?php echo CHtml::submitButton('Submit',array('class'=>'button button-active','style'=>'margin-left: 200px;')); ?></div>
                    <div class="fix"></div>
                </div>
<?php $this->endWidget();?>