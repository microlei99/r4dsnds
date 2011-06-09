<div id="right-content" class='grid_9'>

     

    <div id="banner">
        <a href="/r4i-gold-v141-nitendo-firmware-141.html" class="banner-img" title=""><img src="/images/banner/banner1.jpg" alt="r4 gold" width="600" height="220" /></a>
        <a href="/ps3-controller-dualshock-3-wireless-bluetooth-ps3--black.html" class="banner-img" title="" style="display:none"><img src="/images/banner/banner2.jpg" alt="ps3 wireless controller"  /></a>
        <a href="/r4i-sdhc-v141-nintendo-dsi-v14-v141-multimedia-flash-cart.html" class="banner-img" title="" style="display:none"><img src="/images/banner/banner3.jpg" alt=" r4 sdhc"  /></a>
 
        <div class="banner-num" id="bannerNum">
            <a href="javascript:void(0);" class="numselect">1</a>
            <a href="javascript:void(0);">2</a>
            <a href="javascript:void(0);">3</a>
          
        </div>
        <script type="text/javascript">
            $("#banner").viTab({
                tabTime: 2000,
                tabField : '#bannerNum a',
                tabScroll :1,
                tabEvent :1,
                tabCss : 'numselect'
            });
        </script>
    </div>
    <div class="banner-box">
        <a href="/wii-accessories"><img src="/images/c1.jpg" alt="wii accessories" /></a>
        <a href="/ezflash-vi-plus-sdhc-tf-flash-card-with-stylus-and-finger-stylus.html"><img src="/images/c2.jpg" alt="nintendo nds card" /></a>
        <a href="/ps3" class="b-b-last"><img src="/images/c3.jpg" alt="ps3" /></a>
    </div>
    <div class="clear"></div>
    <!-- banner -->

    <div class="product_list index_pproduct clearfix">
        <h2>New Arrivals</h2>
        <ul class="nav2 clearfix">
            <?php foreach(Product::model()->newarrivial(5)->findAll() as $item):?>
            <li>
                <a href="<?php echo $item->getUrl();?>" class="p_l_img">
                    <img src="<?php echo $item->baseimage->getImage('_middle');?>" width="80" height="80" alt="<?php echo $item->baseimage->image_alt;?>" />
                </a>
                <a href="<?php echo $item->getUrl();?>" class="p_l_title"><?php echo $item->product_name;?></a>
                <span class="linegray"><?php echo Product::decoratePrice($item->getPrice('orig')); ?></span>
                <span class="orange"><?php echo Product::decoratePrice($item->getPrice('promotion')); ?></span>
            </li>
           <?php endforeach;?>
        </ul>
    </div>
    <div class="product_list">
        <h2>Featured Products</h2>
        <?php
        $this->renderPartial('//widget/_list_product_widget',array(
            'data'=>Product::model()->viewed(12)->findAll(),
        ));
        ?>
        <div class="clear"></div>
    </div>



</div>