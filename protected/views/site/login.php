<div class="grid_12">
    <div class=" user-cloum clearfix">
        <div style="float:left; width:640px;">
            <h1><span>Sign In</span></h1>
            <p>Signing in to your account allows you to checkout faster, save products in your shopping bag, access your order history, and build an address book.</p>
            <div style="padding-top:24px; width:600px">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'login-form',
                    ));
                ?>
                    <table width="96%" align="center" cellpadding="3" cellspacing="1">
                        <tr>
                            <td width="15%" height="42"><strong>Useremail:</strong></td>
                            <td width="40%">
                                <?php echo $form->textField($model,'email',array('class'=>'input-text')); ?>
                            </td>
                            <td width="45%"><strong class="red"><?php echo $model->getError('email');?></strong></td>
                        </tr>
                        <tr>
                            <td height="42"><strong>Password:</strong></td>
                            <td>
                                <?php echo $form->passwordField($model,'password',array('class'=>'input-text')); ?>
                            </td>
                            <td><strong class="red"><?php echo $form->error($model,'password');?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="2" height="72" style="padding-left:160px;">
                                <?php echo CHtml::submitButton('Login',array('class'=>'button button-active')); ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr><td colspan="2"></td></tr>
                    </table>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="user-login-other">
            <a href="/site/register">Register &amp; Checkout</a>
            <a href="/site/forget">Forgot your password?</a>
        </div>
        <div class="clear"></div>
    </div>
    <!--/user-cloum -->
</div>