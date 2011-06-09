<?php $this->beginContent('backend.views.layouts.edit'); ?>
 <div class="middle" id="anchor-content">
                <div id="page:main-container">
                    <div class="columns">
                        <div id="page:left" class="side-col">
                           <?php $this->renderPartial($this->sideView); ?>
                        </div>
                        <div id="content" class="main-col">
                            <div class="main-col-inner">
                                <?php if(Yii::app()->user->hasFlash('message')):?>
                                <div id="messages">
                                    <ul class="messages">
                                        <li class="success-msg"><ul><li><span><?php echo Yii::app()->user->getFlash('message');?></span></li></ul></li>
                                    </ul>
                                </div>
                                <?php endif;?>
                                <div class="content-header">
                                    <?php $this->widget('ContentHeader'); ?>
                                </div>
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php $this->endContent(); ?>