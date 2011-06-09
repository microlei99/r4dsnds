<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->params['backendPath'].'favicon.ico';?>" />

       <!--[if lt IE 8]>
       <link rel="stylesheet" type="text/css" href="/assets/default/default/iestyles.css" media="all" />

       <![endif]-->
        <!--[if lt IE 7]>
        <link rel="stylesheet" type="text/css" href="/assets/default/default/below_ie7.css" media="all" />
        <![endif]-->
        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="/assets/default/default/ie7.css" media="all" />
        <![endif]-->
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

<body id="page-login">
<?php echo $content; ?>
</body>

</html>