<?php
$dataCount = count($data);
foreach($data as $index =>$item)
{
    if ($index == 0){
        echo "<ul class='nav2'>";
    }
    else if (($index) % 4 == 0 && $index > 3){
        echo "<ul class='nav2'>";
    }
    $last = $end = '';
    if(($index+1) % 4 == 0 || ($index+1)==$dataCount){
        $end = '</ul>';
        $last = 'n_llast';
    }

?>
<li class="<?php echo $last;?>" style="height: 295px;">
    <a href="<?php echo $item->getUrl();?>" class="p_l_img">
        <img src="<?php echo $item->baseimage->getImage('_list');?>" width="160" height="140" alt="<?php echo $item->baseimage->image_alt;?>" />
    </a>
    <div>
        <a href="<?php echo $item->getUrl();?>" class="p_l_title"><?php echo $item->product_name;?></a>
        <span class="p_l_desc"><?php echo $item->product_short_description;?></span>
        <span>Retail:</span>
        <span class="orange"><?php echo Product::decoratePrice($item->getPrice('promotion')); ?></span>
        <?php
          if($item->product_wholesale){
              $sql = "SELECT wholesale_product_price FROM {{wholesale}} WHERE wholesale_product_id={$item->product_id} ORDER BY wholesale_product_price LIMIT 1";
              $price = Yii::app()->db->createCommand($sql)->queryScalar();
              echo '<div class="p_l_whole">Wholesale:<span class="orange">'.Product::decoratePrice($price).'</span></div>';
          }
        ?>
    </div>
</li>
<?php
echo $end;
}
?>
