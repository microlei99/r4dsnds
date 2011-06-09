<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- Meta Tags -->
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
        <!-- CSS -->
        <link rel="stylesheet" href="/css/base.css" media="screen" type="text/css" />
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
        <meta name="robots" content="index, follow" />
        <meta keywords="<?php echo CHtml::encode($this->keywords); ?>" />
        <meta description="<?php echo CHtml::encode($this->description); ?>" />
         <meta name="author" content="r4dsnds.com" />
	<meta name="robots" content="noodp,noydir" />
	<meta name="robots" content="index, follow"/>
	<meta name="GOOGLEBOT" content="INDEX, FOLLOW"/>
        <!-- JavaScript -->
        <?php  foreach($this->scripts as $script):?>
        <script type="text/javascript" src="<?php echo $script;?>"></script>
        <?php endforeach;?>
    </head>

    <body>
        <div id="container">
            <div id="top" class="clearfix">
                <div class="container_12">
                    <div class="grid_3" style="font-size:11px;">
                        <label>Currency:</label>
                        <?php
                        $currency = Currency::getCurrencySymbol(0,true);
                        ?>
                        <select style="width:80px;height:17px;" onchange="location.href='/currency/'+$(this).val()">
                            <option <?php echo $currency=='USD'?"selected=selected":"";?> value="USD">$ USD</option>
                            <option <?php echo $currency=='GBP'?"selected=selected":"";?> value="GBP">£ GBP</option>
                            <option <?php echo $currency=='EUR'?"selected=selected":"";?> value="EUR">€ EUR</option>
                        </select>
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
                       <!--<div class="top_other fr">
                    <a rel="nofollow" href="javascript:void(window.open(' http://www.cardsnds.com/livezilla/chat.php','','width=590,height=610,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))"><img src=" http://www.cardsnds.com/livezilla/image.php?id=04&amp;type=inlay" width="132" height="28" border="0" alt="LiveZilla Live Help"></a>
                    <div id="livezilla_tracking" style="display:none"></div>
                    <script type="text/javascript">
                        var script = document.createElement("script");script.type="text/javascript";var src = " http://www.cardsnds.com/livezilla/server.php?request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);
                    </script>
                    <noscript><img src=" http://www.cardsnds.com/livezilla/server.php?request=track&amp;output=nojcrpt" width="0" height="0" style="visibility:hidden;" alt="" /></noscript>

                </div>-->
                    </div>
                </div>
            </div>
            <div id="header" class="container_12 clearfix">
                <div class="grid_6">
                    <div id="logo">
                        <h1><a href="/">R4DSNDS</a></h1>
                        <div class="site-desc">The World Renowned Nintendo DS Card Provider!</div>
                    </div> <!--{ close: logo }-->
                </div>
                <div class="grid_6 alignright">
                    <input type="hidden" id="hidden_search" value="ps3" />
                    <form  action="/site/search" method="post" id="search-form">
                        <div id="search">
                            <input type="text" value="ps3" name="search"  maxlength="255" class="global-searchinput" id="global-searchinput" />
                            <input type="submit" value="" title="Search" class="searchsubmit" id="global-searchsubmit" />
                        </div>
                    </form>
                </div>
                <div class="clear"></div>
                <div id="top-menu" class="grid_12 clearfix">
                    <ul>
                        <li class="menu-sel"><a href="/">Home</a></li>
                        <li> <a href="/wholesale">Wholesale</a></li>
                        <li><a href="/category">Category</a></li>
                        <li><a href="/site/hot">Top Seller</a></li>
                        <li><a href="/site/newarrival">New Arrival</a></li>
                        <li><a href="/site/promotion">Promotion<span></span></a></li>
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
                                  'links' => $this->breadcrumbs
                              ));

                            ?>
                        <!--</div>-->
                        <div class="all-class">
                            <a href="javascript:void(0);" class="green" onmouseover="showMoreLinks('all-classbox','');" onmouseout="hideMoreLinks('all-classbox','');"><strong>See All Categories</strong></a>
                            <div class="all-classbox hidden" id="all-classbox" onmouseover="showMoreLinks('all-classbox','');" onmouseout="hideMoreLinks('all-classbox','');">
                                <?php
                                $cache = $this->beginCache('index_category', array(
                                             'duration' =>4838400,
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
                <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                        <tr>
                            <td><dl class="A_62">
                                    <dt>Why Us ?</dt>
                                    <dd>
                                        <p>So many companies to choose from,why us? R4DSNDS.COM tries to integrate the industry resource to provide our customer all the accessories for the most popular Video Game consoles: Nintendo Wii, Microsoft XBox 360, Sony PSP, Sony PlayStation 3, Nintendo DS, Nintendo GBA, and more, at the most preferential price, reliable quality and considerate service... </p>
                                    </dd>
                                </dl>
                            </td>
                            <td><dl id="A6_1" class="A_62">
                                    <dt>High Quality + Great Discount</dt>
                                    <dd>
                                        <p>Fueled by consistently strong growths in personal and portable electronics game devices and an ever increasing demand for the highest quality, R4dsnds.com tries to integrate the industry resource to provide our customer high quality NDSL, Flash card, Micro SD card and so on at great discounted price. Best quality makes us always the first choice for the customer... </p>
                                    </dd>
                                </dl>
                            </td>
                            <td><dl id="A6_3" class="A_62">
                                    <dt>3 Month Guarantee</dt>
                                    <dd>
                                        <p>All our product comes with 3 months warranty. We are so sure that our products will work for you that we offer you the possibility of a total refund (minus the expenses of shipment) if you are unsatisfied with the results after 3 months of treatment (90 days). We offer you 3 months because we believe that 90 days is more than enough to see results.</p><br/>
                                    </dd>
                                </dl>
                            </td>
                            <td><dl id="A6_4" class="A_62">
                                    <dt>Professional Service</dt>
                                    <dd>
                                        <p>Customers of r4dsnds.com have toll-free access to highly trained and award winning Customer Service,10 hours a day, seven days a week. Our Customer Service can provide solutions for a variety of questions you might have during your selection process. ! </p>
                                    </dd>
                                </dl>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="footer">
                <div class="footer_link">
                    <a rel="nofollow" href="/help/about">About Us</a>
                    <a rel="nofollow" href="/help/shipping">Shipping & Tracking</a>
                    <a rel="nofollow" href="/help/return">Return & Exchanges</a>
                    <a rel="nofollow" href="/help/privacy">Privacy Policy</a>
                    <a rel="nofollow" href="/help/terms">Terms & Conditions</a>
                    <a rel="nofollow" href="/help/contact">Contact Us</a>
                    <a rel="nofollow" href="/sitemap.xml">Sitemap</a>
                    <a class="back_top" rel="nofollow" href="#top">TOP</a>
                </div>
                <ul class="nav4">
                    <li><a href="/r4-ds">R4 DS</a></li>
                    <li><a href="/r4i-gold">R4i Gold</a></li>
                    <li><a href="/r4-sdhc">R4  SDHC</a></li>
                    <li><a href="/r4-platinum">R4 Platinum</a></li>
                    <li><a href="/r4-iii-upgrade">R4 III Upgrade</a></li>
                    <li><a href="/r4-rts">R4 Rts</a></li>
                    <li><a href="/r4-ultra">R4 Ultra</a></li>
                    <li><a href="/ps3-usercheat">PS3 Usercheat</a></li>
                    <li><a href="/wii-accessories">Wii Accessories</a></li>
                    <li><a href="/ndsl-console-classic">NDSL Classic</a></li>
                </ul>
                <img src="/images/footpaymethod.jpg" />
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

    $('#subscription_form').submit(function(){
        var email = $('#subscription_email').val();
        if(email=='Enter Email Address'){
            return false;
        }
        if(email==''){
            alert('Subscription email is empty');
            return false;
        }else{
            var pattern = /^([a-z0-9A-Z]+[-|\.]?)+[a-z0-9A-Z]@([a-z0-9A-Z]+(-[a-z0-9A-Z]+)?\.)+[a-zA-Z]{2,}$/;
            if(pattern.test(email)){

            }else{
                $('#subscription_email').val('');
                $('#subscription_email').focus();
                alert('Subscription email is invalid');
                return false;
            }
        }
    });
});
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22186660-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? ' https://ssl' : ' http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>