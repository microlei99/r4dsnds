<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle);?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!--[if lt IE 8]>
         <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['backendPath'].'iestyles.css';?>" media="all" />
         <![endif]-->
        <!--[if lt IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['backendPath'].'below_ie7.css';?>" media="all" />
        <script type="text/javascript" src="<?php echo Yii::app()->params['backendPath'].'js/ds-sleight.js';?>"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->params['backendPath'].'js/iehover-fix.js';?>"></script>
        <![endif]-->
        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['backendPath'].'ie7.css';?>" media="all" />
        <![endif]-->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->params['backendPath'].'favicon.ico';?>" />
    </head>

    <body id="html-body"class=" adminhtml-dashboard-index">
        <div class="wrapper">
            <noscript>
                <div class="noscript">
                    <div class="noscript-inner">
                        <p><strong>系统检测到你没有开启Javascript</strong></p>
                        <p>你必须开启javascript才能正常使用系统功能</p>
                    </div>
                </div>
            </noscript>

            <div class="header">
                <div class="header-top">
                    <div class="header-right">
                        <p class="super">
                            Logged in as <?php echo Yii::app()->user->getAdminName();?><span class="separator">|</span><?php echo date('Y-m-d') ?><span class="separator">|</span><a href="/backend/default/logout" class="link-logout">Log Out</a>
                        </p>
                    </div>
                </div>

                <div class="clear"></div>
                <!-- menu start --> 
                <div class="nav-bar">
                    <?php $this->renderPartial('/layouts/_backMenu'); ?>
                </div>
                <!-- menu end -->
            </div>
            
            <div class="middle" id="anchor-content">
                <div id="page:main-container">
                    <div id="messages"></div>
                    <div class="content-header">
                        <?php $this->widget('ContentHeader'); ?>
                    </div>
                    <?php echo $content; ?>
                </div>
            </div>
            <div class="footer"></div>
        </div>
        <div id="loading-mask" style="display:none">
            <p class="loader" id="loading_mask_loader"><img src="<?php echo Yii::app()->params['backendPath'].'images/ajax-loader-tr.gif';?>" alt="Loading..."/><br/>Please wait...</p>
        </div>
    </body>
</html>
