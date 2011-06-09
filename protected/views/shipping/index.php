<div class="grid_12">
    <div class="check-step clearfix">
        <p style="text-align:center" class="c-s-sel"><a href="/shipping"><span>1. Address Details</span> </a></p>
        <p style="text-align:center"><a href="/shipping/delivery"><span>2. Delivery </span> </a></p>
        <p style="text-align:center"><a href="/checkout"><span>3. Payment Details</span> </a></p>
    </div>
    <div class="user-cloum clearfix" style="border-width: 0 2px 2px 2px; background:#fff none;">
        <div class="member_main">
            <div class="sunmm_box">
                <p>Please choose a delivery address or enter a new address below. Your personal information is safe with us. If any questions, you can refer to our <a href="/help/shipping" style="text-decoration:underline; color:#c60">Privacy Policy</a>.</p>
            </div>
            <div class="sunmm_box">
                <h3 style="border-bottom:1px #ddd solid; padding-bottom:6px; margin-bottom:10px;">Your Delivery Address</h3>

                <p class="gray">The fields marked with <strong class="red">*</strong> are mandatory.</p>
                <?php
                foreach($addresses as $row)
                {
                    echo '<input type="hidden" id="customer_firstname_'.$row->address_id.'" value="'.$row->customer_firstname.'">';
                    echo '<input type="hidden" id="customer_lastname_'.$row->address_id.'" value="'.$row->customer_lastname.'">';
                    echo '<input type="hidden" id="address_street_'.$row->address_id.'" value="'.$row->address_street.'">';
                    echo '<input type="hidden" id="address_city_'.$row->address_id.'" value="'.$row->address_city.'">';
                    echo '<input type="hidden" id="address_state_'.$row->address_id.'" value="'.$row->address_state.'">';
                    echo '<input type="hidden" id="address_country_'.$row->address_id.'" value="'.$row->address_country.'">';
                    echo '<input type="hidden" id="address_postcode_'.$row->address_id.'" value="'.$row->address_postcode.'">';
                    echo '<input type="hidden" id="address_phonenumber_'.$row->address_id.'" value="'.$row->address_phonenumber.'">';
                }
                $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'address-form',
                        'action' => '/shipping',
                        'htmlOptions' => array('name' => 'address'))
                );
                ?>
                    <table cellspacing="1" cellpadding="3" align="center" style="padding:18px 24px;" >

                        <tr>
                            <td width="26%" height="36"><strong>Choose a delivery address :</strong></td>
                            <td width="38%">
                                <select name="addresslist" id="addresslist">
                                    <?php
                                    foreach($addresses as $row):++$i;?>
                                    <option value="<?php echo $row->address_id;?>" <?php echo ($row->address_id==$defaultAddressID) ? 'selected=selected':'';?>><?php echo 'Address_'.$i;?></option>
                                    <?php endforeach;?>
                                    <option value="-1" <?php echo ($defaultAddressID==0)?'selected=selected':'';?>>New Address</option>
                                </select>
                            </td>
                            <td width="36%"></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>First Name: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'customer_firstname',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'customer_firstname'); ?></strong></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>Last name: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'customer_lastname',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'customer_lastname'); ?></strong></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>Address: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_street',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_street'); ?></strong></td>
                        </tr>

                        <tr>
                            <td height="36"><strong>City/Town: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_city',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_city'); ?></strong></td>
                        </tr>
                        <tr>
                            <td height="36"><strong>State/Province: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_state',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_state'); ?></strong></td>
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
                            <td><strong class="red"><?php echo $form->error($address, 'address_postcode'); ?></strong></td>
                        </tr>

                        <tr>
                            <td height="36"><strong>Phone Number: <span class="red">*</span></strong></td>
                            <td>
                                <?php echo $form->textField($address, 'address_phonenumber',array('class'=>'input_text1','size'=>30,'style'=>'width:200px;')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($address, 'address_phonenumber'); ?></strong></td>
                        </tr>
                    </table>
                <div class="sunmm_box">
                    <div class="fr"><input type="submit" value="" class="button button-checkstep" id="check_btn"></div>
                    <div class="fix"></div>
                </div>
            </div>
             <?php $this->endWidget();?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
$(function(){
   $('#addresslist').change(function(){
       var address = $(this).val();
       var customer_firstname = '';
       var customer_lastname = '';
       var address_street = '';
       var address_city = '';
       var address_state = '';
       var address_country = '';
       var address_postcode = '';
       var address_phonenumber = '';
       if(address!=-1){
           customer_firstname = $('#customer_firstname_'+address).val();
           customer_lastname = $('#customer_lastname_'+address).val();
           address_street = $('#address_street_'+address).val();
           address_city = $('#address_city_'+address).val();
           address_state = $('#address_state_'+address).val();
           address_country = $('#address_country_'+address).val();
           address_postcode = $('#address_postcode_'+address).val();
           address_phonenumber = $('#address_phonenumber_'+address).val();
       }
       $('#CustomerAddress_customer_firstname').val(customer_firstname);
           $('#CustomerAddress_customer_lastname').val(customer_lastname);
           $('#CustomerAddress_address_street').val(address_street);
           $('#CustomerAddress_address_city').val(address_city);
           $('#CustomerAddress_address_state').val(address_state);
           $('#CustomerAddress_address_country').val(address_country);
           $('#CustomerAddress_address_postcode').val(address_postcode);
           $('#CustomerAddress_address_phonenumber').val(address_phonenumber);
   });
});
</script>