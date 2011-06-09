<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- Meta Tags -->
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
        <!-- CSS -->
        <link rel="stylesheet" href="/css/base.css" media="screen" type="text/css" />
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
        <!-- JavaScript -->
    </head>

    <body>
        <div id="container">


            <div id="top" class="clearfix">
                <div class="container_12">
                    <div class="grid_3" style="font-size:11px;">
                        Currency: [<a href="javascript:void(0);" class="orange">$ USD</a>]
                        <div>
                            <a href="">£ GBP</a>
                            <a href="">¥ JPY</a>
                            <a href="">€ EUR</a>
                            <a href="">$ CAD</a>
                        </div>
                    </div>
                    <div class="grid_9 alignright">
                        <?php if(Yii::app()->user->isGuest):?>
                        <a href="/site/login" rel="nofollow" class="red">Log In</a> |
                        <a href="/site/register" class="green">Register Now</a> |
                        <?php else:?>
                        <a href="/user" rel="nofollow" class="red" style=" margin-right:0; padding-right:0;"><?php echo Yii::app()->user->name ?></a>
                        <a href="/site/logout" rel="nofollow" class="green">[Logout]</a> |
                        <?php endif;?>
                        <a href="/user">My Account</a> |
                        <a href="/help">Need Help?</a> |
                        <a href="javascript:void(0);" class="orange chat"><strong>Live Chat</strong> <img src="images/chat-online.gif" alt="Live Chat Online" /></a>
                    </div>
                </div>
            </div>
            <div id="header" class="container_12 clearfix">
                <div class="grid_6">
                    <div id="logo">
                        <h1><a href="/">R4DSNDFS</a></h1>
                        <div class="site-desc">The World Renowned Nintendo DS Card Provider!</div>
                    </div> <!--{ close: logo }-->
                </div>
                <div class="grid_6 alignright">
                    <input type="hidden" id="hidden_search" value="ps3" />
                    <form  action="/site/search" method="post" id="search-form">
                        <div id="search">
                            <input type="text" value="ps3"  maxlength="255" class="global-searchinput" id="global-searchinput" />
                            <input type="submit" value="" title="Search" class="searchsubmit" id="global-searchsubmit" />
                        </div>
                    </form>
                </div>
                <div class="clear"></div>
                <div id="top-menu" class="grid_12 clearfix">
                    <ul>
                        <li class="menu-sel"><a href="/">Home</a></li>
                        <li><a href="">All Products</a></li>
                        <li><a href="">Wholesale</a></li>
                        <li><a href="">Top Seller</a></li>
                        <li><a href="">New Arrival</a></li>
                        <li><a href="">Promotion<span></span></a></li>
                        <li class="nobg"><a href="/help/about" rel="nofollow">About Us</a></li>

                        <li class="menu-sel menu-sel1">
                            <a href="/shoppingcart">
                                Cart(<?php echo $item=Yii::app()->cart->getItemsQuantiay();?> Items)<span></span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="grid_12 clearfix">
                    <div class="top-sub clearfix">
                        <!--<div class="top-mx">-->

                            <?php
                              $this->widget('zii.widgets.CBreadcrumbs', array(
                                  'separator'=>' - ',
                                  'homeLink'=>CHtml::link('Home',Yii::app()->homeUrl),
                                  'htmlOptions'=>array(
                                      'class'=>'top-mx'
                                  ),
                                  'links' => array(
                                      'Checkout'
                                  )
                              ));

                            ?>
                        <!--</div>-->
                        <div class="all-class">
                            <a href="javascript:void(0);" class="green" onmouseover="showMoreLinks('all-classbox','');" onmouseout="hideMoreLinks('all-classbox','');"><strong>See All Categories</strong></a>
                            <div class="all-classbox hidden" id="all-classbox" onmouseover="showMoreLinks('all-classbox','');" onmouseout="hideMoreLinks('all-classbox','');">
                                <?php
                                $cache = $this->beginCache('index_category', array(
                                             'duration' => 604800,
                                             'dependency'=>array(
                                                 'class'=>'CDbCacheDependency',
                                                 'sql'=>'SELECT config_code FROM {{config}} WHERE config_type="cache" AND config_item="index_category_cache"',
                                              )
                                ));

                                if($cache){
                                $roots = ProductCategory::model()->rootLevel()->findAll();
                                foreach ($roots as $index => $root){
                                ?>
                                <div class="p-l-tbox clearfix">
                                    <a href="javascript:void(0);"><span class="p-l-ttitle"><?php echo $root->category_name;?></span></a>
                                    <ul>
                                        <?php foreach ($root->directChildren()->findAll() as $index => $item):?>
                                        <li><a href="<?php echo $item->getUrl();?>" class="<?php echo ($index==0) ? 'orange':'';?>"><?php echo $item->category_name;?></a></li>
                                        <?php endforeach;?>
                                        <li><a href="<?php echo $root->getUrl();?>" class="gray">» more</a></li>
                                    </ul>
                                </div>
                                <?php
                                    }
                                $this->endCache();
                                }
                                ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div id="wrapper" class="container_12 clearfix">
                <?php echo $content;?>
            </div>

            <div class="clear"></div>

            <div class="container_12 A_6">
                <table cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                        <tr>
                            <td>
                                <div  style="padding:12px 18px;">
                                    <h5 style="font-size:14px; color:#333; margin-bottom:10px;">Newsletter</h5>
                                    <form action="" method="">
                                        <p><input type="text" name="" value="Enter Your Email Address" style="font-size:11px; color:#999; padding:3px; width:160px; margin-bottom:8px;" /><br />
                                            <input type="submit" name="" value="submit" class="button button-active" /> </p>

                                    </form>
                                </div>
                            </td>
                            <td><dl class="A_62">
                                    <dt>Company Info</dt>
                                    <dd> <a href="/help/about">About R4dsnds</a><br />
                                        <a href="/help/contact">Contact Us</a><br />
                                        
                                        <a href="/sitemap.xml">Site Map</a></dd>
                                </dl></td>
                            <td><dl id="A6_1" class="A_62">
                                    <dt>Payment &amp; Shipping</dt>
                                    <dd>
                                         
                                        <a href="/help/shipping">Shipping Guide</a></dd>
                                </dl></td>
                            <td><dl id="A6_3" class="A_62">
                                    <dt>Company Policies</dt>
                                    <dd>
                                        <a href="/help/return">Return Policy</a><br />
                                        <a href="/help/privacy">Privacy Policy</a><br />
                                        <a href="/site/promotion">Our Promise</a>  </dd>
                                </dl></td>
                            <td> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="footer">
                <img src="images/footpaymethod.jpg" />
                <p>Copyright &copy;2001-2010  www.R4dsnds.com.  All Rights Reserved.</p>
            </div>
        </div>

    </body>
</html>
<script type="text/javascript">
$(function(){
   $('#search-form').submit(function(){
        if($('#global-searchinput').val()==''){
            return false;
        }
    });

    $('#global-searchinput').focus(function(){
        if($(this).val()==$('#hidden_search').val()){
            $(this).val('');
        }
    });
    $('#global-searchinput').blur(function(){
        if($(this).val()==''){
            $(this).val($('#hidden_search').val());
        }
    });
});
</script>