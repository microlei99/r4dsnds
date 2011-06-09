<div class="sunmm_box">
    <h3 style="border-bottom:1px #ddd solid; padding-bottom:6px; margin-bottom:10px;margin-top:12px;">Change Password</h3>
    <?php if(Yii::app()->user->hasFlash('password')):?>
            <div class="error1 pass">
                <ul>
                    <li><?php echo Yii::app()->user->getFlash('password'); ?></li>
                </ul>
            </div>
            <?php endif;?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'register-form',
            'enableAjaxValidation' => true,
        ));
    ?>
    <table cellspacing="1" cellpadding="3" align="center" style="padding:18px 24px;" >


        <tr>
            <td width="25%" height="42" align="center"><strong>Old Password:</strong></td>
            <td width="27%"><?php echo $form->passwordField($model, 'oldpassword', array(
                    'class' => 'input_text1')); ?></td>
            <td width="48%">
                <strong class="red"><?php echo $form->error($model, 'oldpassword',array('style'=>'margin-left:12px;')); ?></strong>
            </td>
        </tr>
        <tr>
            <td height="42" align="center"><strong>New Password:</strong></td>
            <td><?php echo $form->passwordField($model, 'password', array(
                    'class' => 'input_text1')); ?></td>
            <td>
                <strong class="red"><?php echo $form->error($model, 'password',array('style'=>'margin-left:12px;')); ?></strong>
            </td>
        </tr>
        <tr>
            <td height="42" align="center"><strong>Confirm Password:</strong></td>
            <td><?php
                echo $form->passwordField($model, 'confirmpassword', array(
                    'class' => 'input_text1')); ?></td>
            <td>
                <strong class="red"> <?php echo $form->error($model, 'confirmpassword',array('style'=>'margin-left:12px;')); ?></strong>
            </td>
        </tr>

        <tr><td colspan="3" height="60" style="padding-left:190px">
                <?php echo CHtml::submitButton('Save', array('class' => 'button button-active')); ?>

            </td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>