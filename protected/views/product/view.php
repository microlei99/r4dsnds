<div class="grid_13">
    <div class="product_box" style="width:705px;">
        <h1><?php echo $model->product_name; ?></h1>
        <div class="product_action" style="border-top-width: 20px; margin-top: 0px; top: 42px;">
            <?php
            $prevProduct = Product::model()->find(array(
                    'select' => 'product_url',
                    'condition' => 'product_id<' . $model->product_id,
                    'order' => 'product_id DESC',
                    'limit' => 1
                ));
            $nextProduct = Product::model()->find(array(
                    'select' => 'product_url',
                    'condition' => 'product_id>' . $model->product_id,
                    'limit' => 1
                ));
            ?>
            <a href="<?php echo $prevProduct ? $prevProduct->getUrl() : '#';?>">&laquo; Prev</a> |
            <a href="<?php echo $nextProduct ? $nextProduct->getUrl() : "#";?>">Next &raquo;</a>
        </div>
        <div class="fl">
            <?php
            $imageList =  '';
            foreach ($images as $image){
                $imageList .= '<a href="#" class="'.($image->image_default==1?'p_b_ilsel':'').'">
                                  <img src="' . $image->getImage('_small') . '" alt="' . $image->image_alt . '" width="56" height="56" />
                              </a>';
                if($image->image_default==1){
                    echo '<img src="'.$image->getImage('_product').'" alt="'.$image->image_alt.'" width="245" height="245" id="base_img" />';
                    echo '<span class="p_imgt" id="base_img_lable">'.$image->image_alt,'</span>';
                }
            }
            ?>
            <div class="p_b_imglist">
                <?php echo $imageList;?>
            </div>
            <div class="clear"></div>

        </div>
        <div class="fr">
            <div></div>
            <input type="hidden" value="<?php echo $model->product_stock_qty;?>" id="total_stock">
			<input type="hidden" value="<?php echo $model->product_stock_cart_min;?>" id="min_buy">
                <input type="hidden" id="product_id" value="<?php echo $model->product_id;?>">
            <ul>
                <li><span class="p_b_t">Model:</span><span class="gray"><?php echo $model->product_sku;?></span></li>
                <li><span class="p_b_t">Regular Price:</span> <span class="linegray"><?php echo Product::decoratePrice($model->getPrice('orig'),true,$currency);?></span></li>

                <?php if($promotion = $model->isPromotionActive()):?>
                <li class="p_b_specialp">
                    <span class="orange f16 fw700"><?php echo Product::decoratePrice($promotion['price'],true,$currency); ?></span>
                    <span class="p_b_date">Exprise: <?php echo date('M ,j', strtotime($promotion['end'])).'th'; ?></span>
                </li>
                <?php else:?>
                <li><span class="p_b_t">Now Price:</span> <span class="orange"><?php echo Product::decoratePrice($model->getPrice('special'),true,$currency);?></span></li>
                <?php endif;?>
                <li><span class="p_b_t">Weight:</span><span class="gray"><?php echo $model->product_weight;?>g</span></li>
                <li>
                    <span class="p_b_t">STATUS:</span>
                    <?php
                    if ($model->product_stock_status != Product::OUT_OF_STOCK){
                        echo CHtml::tag('span', array('class' => ''),'In Stock', true);
                    }else{
                        echo CHtml::tag('span', array('class' => 'red','style'=>'font-weight:700'), 'Out of Stock', true);
                    }
                    ?>
                </li>
                <li>
                    <span class="p_b_t">Shipping:</span>
                    <img src="/images/fshipping_small.gif" alt="free shipping" />
                    <span class="fw700 green">Free Shipping</span> <a href="/help/shipping" target="_blank" class="gray">(Details)</a></li>

                <li>
                    <span class="p_b_t">Quantity:</span>
                    <input type="hidden" value="<?php echo $model->product_stock_cart_min;?>">
                    <input type="text" value="<?php echo $model->product_stock_cart_min;?>" class="w10" maxlength="3" id="qtybox"  />
					<?php if($model->product_stock_cart_min>1):?>
					<span style="margin-left:5px;">TIP:item min order <?php echo $model->product_stock_cart_min;?> pcs</span>
					<?php endif;?>
                </li>

                <li class="p_b_info p_b_last">Please <a href="/help/contact">contact us</a> for <span class="fw700">wholesale orders ( 1000+ pcs )</span> at incredibly low prices </li>
                <?php if($wholesale = $model->getWholesale()):?>
                <li class="p_b_whole p_b_last">
                                <div class="p_b_wholeinner">
                                    <div class="w_title">
                                        <p>Qty: <br />Rate:</p>
                                    </div>
                                    <div class="w_con">
                            <?php
                            $last = array_slice($wholesale,-1,1);
                            foreach ($wholesale as $row)
                            {
                                if($row['wholesale_product_interval2']==$last[0]['wholesale_product_interval2']){
                                    $interval2 = '+';
                                }
                                else{
                                    $interval2 = '-' . $row['wholesale_product_interval2'];
                                }
                                echo '<p><span>' . $row['wholesale_product_interval1'] . $interval2 . '</span>' .
                                Product::decoratePrice($model->getPrice('wholesale', $row['wholesale_id']), true, $currency);
                                '</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </li>

                <li class="p_buttons p_b_last">
				<!--<div  style=" float:left; width:180px">
                        
                        <div class="addthis_toolbox addthis_default_style">
                            <a href="http://addthis.com/bookmark.php?v=250&amp;username=xa-4c6b987639489b5c" class="addthis_button_compact">Share</a>
                            <span class="addthis_separator">|</span>
                            <a class="addthis_button_facebook"></a>
                            <a class="addthis_button_myspace"></a>
                            <a class="addthis_button_google"></a>
                            <a class="addthis_button_twitter"></a>
                        </div>
                        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c6b987639489b5c"></script>
                    </div>-->
                    <?php
                    if ($model->product_stock_status != Product::OUT_OF_STOCK){
                        echo '<input type="button" value="Add to Cart" id="addtocart" class="button button-cart" style="float:right" />';
                    }else{
                        echo '<input type="button" value="Out Of Stock" class="button button-cart" style="float:right" />';
                    }

                    ?>
                </li>
            </ul>

        </div>
        <div class="clear"></div>
    </div>

    <div class="product_info">
        <h2>Product Desc</h2>
        <div class="i_d_box">
            <span style="font-size: larger;"><span style="font-family: Comic Sans MS;"><b><span style="color: rgb(0, 125, 215);"><?php echo $model->product_name;?></span></b></span></span>
            <p><?php echo $model->product_description;?></p>
        </div>
    </div>
    <div class="product_list">
        <h2 style="background:#eee;height:40px;line-height:38px;font-size:14px;border:0;overflow:hidden;color:#111;padding:0 0 0 12px;">Relate Products</h2>
            <?php
            $this->renderPartial('//widget/_list_product_widget',array(
            'data'=>Product::model()->findAll(array(
                'select'=>array('product_id','product_name','product_url','product_status','product_active','product_base_price','product_orig_price','product_special_price',
                            'product_promotion','product_wholesale','product_status','product_short_description'),
                'condition'=>'product_active=1 AND product_category_id='.$model->product_category_id.' AND product_id!='.$model->product_id,
                'order'=>'product_last_update',
                'limit'=>8,
            ))
        ));
            ?>
    </div>
</div>