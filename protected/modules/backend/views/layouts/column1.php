<?php $this->beginContent('backend.views.layouts.main'); ?>
<?php if (Yii::app()->user->hasFlash('column1_message')): ?>
    <div id="messages">
        <ul class="messages">
            <li class="success-msg"><ul><li><span><?php echo Yii::app()->user->getFlash('column1_message'); ?></span></li></ul></li>
        </ul>    
    </div>
<?php endif; ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>