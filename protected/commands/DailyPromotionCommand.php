<?php
  class DailyPromotionCommand extends CConsoleCommand
  {
	  public function run($args)
	  {
	       $sql = "SELECT promotion_id,promotion_product_id,promotion_status,TIMESTAMPDIFF(DAY,CURDATE(),promotion_end_at) AS diff FROM {{promotion}}";
		   $promotions = Yii::app()->db->createCommand($sql)->queryAll();
	 	   foreach ($promotions as $row => $promotion)
           {
			    if ($promotion['diff'] < 0)
                {
                    $sign = Promotion::PROMOTION_CLOSED;
                    Yii::app()->db->createCommand("UPDATE {{promotion}} SET promotion_status={$sign} WHERE promotion_id={$promotion['promotion_id']}")->execute();
				    Yii::app()->db->createCommand("UPDATE {{product}} SET product_promotion=0 WHERE product_id={$promotion['promotion_product_id']}")->execute();
                    Product::maintainStatus($promotion['promotion_product_id']);
			    }
		   }
	  }
  }
?>
