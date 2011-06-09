<?php $form=$this->beginWidget('CActiveForm', array('id'=>'config_form','enableAjaxValidation'=>false)); ?>
<div style="display: none;"></div>
<div  id="email_general_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">Email账户设置</h4>
        </div>
        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="emailHost">Email<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('email[emailHost]', $email['emailHost'],array('class'=>'required-entry required-entry input-text','id'=>'emailHost'));?></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="emailHostPort">Email端口<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('email[emailHostPort]', $email['emailHostPort'],array('class'=>'required-entry required-entry input-text','id'=>'emailHostPort'));?></td>
                        <tr>
                        <tr>
                            <td class="label"><label for="emailSMTPAuth">SMTP验证<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('email[emailSMTPAuth]', $email['emailSMTPAuth'],array('class'=>'required-entry required-entry input-text','id'=>'emailSMTPAuth'));?></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="emailUsername">Email用户名<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('email[emailUsername]', $email['emailUsername'],array('class'=>'required-entry required-entry input-text','id'=>'emailUsername'));?></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="emailPassword">Email密码<span class="required">*</span></label></td>
                            <td class="value"> <?php echo CHtml::textField('email[emailPassword]', $email['emailPassword'],array('class'=>'required-entry required-entry input-text','id'=>'emailPassword'));?></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="emailFromAddress">Email源地址<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('email[emailFromAddress]', $email['emailFromAddress'],array('class'=>'required-entry required-entry input-text','id'=>'emailFromAddress'));?></td>
                        </tr>
						<tr>
                            <td class="label"><label for="emailFromName">Email发信名字<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('email[emailFromName]', $email['emailFromName'],array('class'=>'required-entry required-entry input-text','id'=>'emailFromName'));?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- stock start-->
<div  id="stock_general_content" class="content_col" style="display:none">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">库存设置</h4>
        </div>
        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="stock_out_qty">缺货量<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('stock[stock_out_qty]', $stock['stock_out_qty'],array('class'=>'required-entry required-entry input-text','id'=>'stock_out_qty'));?></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="stock_cart_min">购物车最小数量<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('stock[stock_cart_min]', $stock['stock_cart_min'],array('class'=>'required-entry required-entry input-text','id'=>'stock_cart_min'));?></td>
                        <tr>
                        <tr>
                            <td class="label"><label for="stock_cart_max">购物车最大数量<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('stock[stock_cart_max]', $stock['stock_cart_max'],array('class'=>'required-entry required-entry input-text','id'=>'stock_cart_max'));?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- stock end-->
<!-- ship start-->
<div  id="ship_general_content" class="content_col" style="display:none">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">货运设置</h4>
        </div>
        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="ship_from">始发地<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('ship[ship_from]', $ship['ship_from'],array('class'=>'required-entry required-entry input-text','id'=>'ship_from'));?></td>
                        </tr>
                        <tr>
                            <td class="label"><label for="cycle">货运周期<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('ship[cycle]', $ship['cycle'],array('class'=>'required-entry required-entry input-text','id'=>'cycle'));?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- ship end-->

<!-- common start-->
<div  id="system_general_content" class="content_col" style="display:none">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">系统设置</h4>
        </div>
        <div id="group_fields4" class="fieldset fieldset-wide">
            <div class="hor-scroll">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="order_export_prefix">导出订单前缀<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::textField('system[order_export_prefix]', $system['order_export_prefix'],array('class'=>'required-entry required-entry input-text','id'=>'order_export_prefix'));?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- virtual end-->
<?php $this->endWidget()?>