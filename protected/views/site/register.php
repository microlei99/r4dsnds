<div class="grid_12">
    <div class=" user-cloum clearfix">
        <div style="float:left; width:640px;">
            <h1><span>Register &amp; Checkout</span></h1>
            <p>Creating an account allows you to checkout faster, save products in your shopping bag, access your order history, and build an address book.</p>
            <div style="padding-top:24px; width:650px">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'register-form',
                ));
                ?>
                <?php echo CHtml::hiddenField('key', $key);?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="1">
                        <tr>
                            <td width="26%" height="42" align="center"><strong>Enter E–mail address:</strong></td>
                            <td width="30%">
                            <?php
                            echo $form->textField($model, 'email', array(
                                     'class' => 'input-text'
                                ));
                           ?>
                            </td>
                            <td width="44%">
                                <strong class="red"><?php echo $model->getError('email');?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td height="42" align="center"><strong>Create Password: </strong></td>
                            <td>
                            <?php
                            echo $form->passwordField($model, 'password', array(
                                     'class' => 'input-text'
                                ));
                            ?>
                            </td>
                            <td>
                                <strong class="red"><?php echo $model->getError('password');?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td height="42" align="center"><strong>Confirm Password: </strong></td>
                            <td>
                            <?php
                            echo $form->passwordField($model, 'confirmPassword', array(
                                     'class' => 'input-text'));
                            ?>
                            </td>
                            <td>
                                <strong class="red"><?php echo $model->getError('confirmPassword');?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding:6px 0">
                                <label for="remember"><?php echo $form->checkBox($model, 'newsletter', array('style' => 'margin-right:6px;', 'id' => 'remember')); ?>
                                    I'd like to recive email from <a href="/">R4dsnds.com</a> to get more information.
                                </label>
                                <p style="margin:6px 0 12px; color:#666">
                                    By clicking on 'Register' below you are agreeing to the Cardsnds &nbsp;<a href="/help/privacy">Privacy Protection</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" height="72" style="padding-left:160px;">
                                <?php echo CHtml::submitButton('Register', array('class' => 'button button-active')); ?>
                            </td>
                            <td></td>
                        </tr>

                        <tr><td colspan="2"></td></tr>
                    </table>
               <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="user-login-other">
            <a href="/site/login">Sign In</a>
            <a href="/site/forget">Forgot your password?</a>
        </div>
        <div class="clear"></div>
    </div>
    <!--/user-cloum -->
</div>