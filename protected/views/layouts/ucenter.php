<?php $this->beginContent('//layouts/main');;?>
<div class="grid_12">
    <div class=" user-cloum clearfix">
        <h1 style="margin-bottom:0;">User Center</h1>
        <div style=" background-color:#edfaff;padding:6px 12px;">Welcome 
            <strong><?php echo Yii::app()->user->name;?></strong>, <span>[<?php echo Yii::app()->user->getState('email');?>]</span><a href="/site/logout" class="orange ml_6" title="login out" style=" font-size:11px;">&nbsp;&raquo;&nbsp; Login out<span></span></a></div>
        <div class="member_main">
            <div class="side_box mmainin_menu">
                <div class="mmenuin">
                    <h3>My Orders</h3>
                    <ul>
                       <li><a href="/user/order">Current Orders</a></li>
                    </ul>
                    <div class="mmenuin-bottom"></div>
                </div>
                <div class="mmenuin mmenuined">
                    <h3>My Account</h3>
                    <ul>
                        <li><a href="/user/address">My Addresses</a></li>
                        <li><a href="/user/changePassword">Change Password</a></li>
                    </ul>
                    <div class="mmenuin-bottom"></div>
                </div>
            </div>
            <div class="mmainin_content ">
                <?php echo $content;?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <!--/user-cloum -->
</div>
<?php $this->endContent();?>