<?php $this->beginContent('//layouts/main'); ?>
<div id="side" class='grid_3'>

    <div class="side_box side-class">
        <h3>See All Categories</h3>
        <div id="side_accordion" >
            <ul class="clearfix">
                <?php
                $cache = $this->beginCache('index_left_category', array(
                        'duration' => 4838400,
                        'dependency' => array(
                            'class' => 'CDbCacheDependency',
                            'sql' => 'SELECT config_code FROM {{config}} WHERE config_type="cache" AND config_item="index_category_cache"',
                        )
                    ));
                if($cache){
                $roots = ProductCategory::model()->rootLevel()->findAll();
                foreach ($roots as $index => $root):
                ?>
                <li>
                     
                    <a href="javascript:void(0);" class="<?php echo $index==0 ? 's-c1 s-c-sel':'s-c1';?>"><?php echo $root->category_name;?></a>
                    <p class="<?php echo $index==0 ? '':'hidden';?>">
                        <a href="<?php echo $root->getUrl();?>" class="orange"><?php echo $root->category_name;?></a>
                        <?php
                        foreach ($root->directChildren()->findAll() as $item){
                            echo '<a href="'.$item->getUrl().'">'.$item->category_name.'</a>';
                        }
                    ?>
                    </p>
                </li>
                <?php
                 endforeach;
                 $this->endCache();
                }
                 ?>
            </ul>
        </div>
    </div>

    <div class="side_box side_deals">
        <h3>Top Deals</h3>
        <div class="side_deals_box clearfix">
            <ul class="nav2">
                <?php
                $this->renderPartial('//widget/_small_product_widget',
                    array('data'=>Product::model()->hotSale(3)->findAll()
                ));
                ?>
            </ul>
            <div class="clear"></div>
        </div>
    </div>

    <div class="side_box side-ad">
        <a href="/ps3-external-HDD-1-5t-110-ps3-games.html"><img src="/images/ad1.jpg" alt="ps3 hdd" /></a>
    </div>

</div>
<?php echo $content; ?>
<?php $this->endContent(); ?>