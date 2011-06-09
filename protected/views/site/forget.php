<div class="grid_12">
    <div class=" user-cloum clearfix">
        <div style="float:left; width:640px;">
            <h1><span>Forgotten Your Password</span></h1>
            <p>Forgotten your password? Just enter your email address and as if by magic it'll appear in your inbox.</p>
            <div style="padding:24px; width:600px">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'register-form',
                            'enableAjaxValidation' => TRUE,
                        ));
                ?>
                <table cellspacing="1" cellpadding="3" align="center" style="padding:18px 24px;" >
                    <tr><td width="20%" height="42">
                            <strong>Email address:</strong><span class="red ml_6 fw700">*</span></td>
                        <td width="27%">
                            <?php
                            echo $form->textField($model, 'email', array(
                                'class' => 'input_text1'
                            ));
                            ?>
                        </td>
                        <td width="54%"><strong class="red"><?php echo $form->error($model, 'email', array('style' => 'margin-left:30px;')); ?></strong></td>
                    </tr>

                    <tr><td colspan="3" height="60" style="padding-left:190px">
<?php echo CHtml::submitButton('Retrieve', array('class' => 'button button-active')); ?>

                        </td>
                    </tr>
                </table>
<?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="user-login-other">
            <a href="/site/login">Sign In</a>
            <a href="/site/register">Register &amp; Checkout</a>
        </div>
        <div class="clear"></div>
    </div>
    <!--/user-cloum -->
</div>