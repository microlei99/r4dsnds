<?php foreach($data as $item):?>
<li>
    <a href="<?php echo $item->getUrl();?>" class="p_l_img"><img src="<?php echo $item->baseimage->getImage('_small');?>" alt="<?php echo $item->baseimage->image_alt;?>" /></a>
    <div>
        <a href="<?php echo $item->getUrl();?>" class="p_l_title"><?php echo $item->product_name;?></a>
        <span class="p_l_desc"><?php echo $item->product_short_description;?></span>
        <span class="linegray"><?php echo Product::decoratePrice($item->getPrice('orig')); ?></span>
        <span class="orange"><?php echo Product::decoratePrice($item->getPrice('promotion')); ?></span>
    </div>
</li>
<?php endforeach;?>