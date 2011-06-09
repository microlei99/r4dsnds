<div class="login-container">
        <div class="login-box">
             <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'admin-form',
        )); ?>
                <div class="login-form">
                    <input type="hidden" value="f0kVNT6Fzvp1GalN" name="form_key">
                    <h2>Log in to Admin Panel</h2>
                    <div id="messages">
                                            </div>
                    <div class="input-box input-left"><label for="email">Email:</label><br>
                        <?php echo $form->textField($model,'email',array('class'=>'required-entry input-text')); ?>

                    </div>
                    <div class="input-box input-right"><label for="login">Password:</label><br>
                       <?php echo $form->passwordField($model,'password',array('class'=>'required-entry input-text')); ?></div>
                    <div class="clear"></div>
                    <div class="form-buttons">
                         <?php echo CHtml::submitButton('Login',array('class'=>'form-button')); ?>

                    </div>
                </div>
              
       <?php $this->endWidget();?>
            <div class="bottom"></div>

        </div>
    </div>