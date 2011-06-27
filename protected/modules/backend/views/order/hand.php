<?php
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'hand_form',
    ));
?>
<div  id="product_general_content" class="content_col">
    <div class="box-left">
        <!--Order Information-->
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-account">手工处理订单</h4>
            </div>
            <div class="fieldset">

                <table cellspacing="0" class="form-list">
                    <tbody>

                        <tr>
                            <td class="label"><label for="payment_username">订单号</label></td>
                            <td class="value">
                                <?php
                                echo CHtml::textField('order','',array(
                                          'class'=>'required-entry required-entry input-text'
                                      ));
                                ?>
                            </td>
                            <td class="scope-label"><span class="nobr"><?php if(!$error){echo '成功';}?></span></td>
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