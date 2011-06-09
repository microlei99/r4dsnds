<?php
class SyoUser extends CWebUser
{
    public function afterLogin()
    {
        $this->_syn_cart();
    }

    public function setAdmin($value)
    {
        $this->setState('__admin', $value);
    }

    public function getAdmin()
    {
        return $this->getState('__admin');
    }

    public function getAdminName()
    {
        return $this->getState('__adminName');
    }

    public function setAdminName($value)
    {
        $this->setState('__adminName', $value);
    }

    public function getIsAdmin()
    {
        return $this->getState('__admin');
    }

    public function admin($identity)
    {
        $id = $identity->getId();
        $name = $identity->getName();
        $this->setAdmin($id);
        $this->setAdminName($name);
    }

    public function adminout()
    {
        $this->setAdmin(NULL);
        $this->setAdminName(NULL);
    }

    public function getId()
    {
        return $this->getState('__id',0);
    }


    public function _syn_cart()
    {

        if(!is_object(Yii::app()->user))
                return;

        $customerID = Yii::app()->user->getId();
        $dbcart = Cart::model()->findAllByAttributes(array('customer_id'=>$customerID));
        if($dbcart)
        {
			$dbcartArray = array();
			$shoppingcartArray = array();
			$dbtocart  = array();
			$carttodb = $updatedbtocart = array();

            foreach($dbcart as $item){
                $dbcartArray[$item->product_id.'-'.$item->attribute_id] = $item->product_qty;
            }


            foreach(Yii::app()->cart->getCart() as $item){
				$optionID = $item['options'] == null ? 0 : $item['options']->getID();
                $shoppingcartArray[$item['item']->getID().'-'.$optionID] = $item['item']->getQuantity();
            }


			//同步购物车
			foreach($dbcartArray as $key =>$qty)
			{
				if(!isset($shoppingcartArray[$key]))
                {
					//以数据库中数据为准，向购物车中添加数据
					$dbtocart[$key] = $qty;
				}
				else
				{
					//如果数据库中的数据已在购物车中存在，但是数量不同，则以数据库中数据为准
					if($shoppingcartArray[$key] != $qty){
						$updatedbtocart[$key] = $qty;
					}
				}
			}

			foreach($dbtocart as $key=>$qty)
			{
				$id = array_map('intval',explode('-',$key));
				$item = Product::model()->findByPk($id[0]);
				$options = $id[1]==0 ? null : ProductAttribute::model()->findByPk($id[1]);
				Yii::app()->cart->put($item,$options,$qty);
			}

			foreach($updatedbtocart as $key=>$qty)
			{
				$id = array_map('intval',explode('-',$key));
				$itemOfCart['item'] = Product::model()->findByPk($id[0]);
				$itemOfCart['options'] = $id[1]==0 ? null : ProductAttribute::model()->findByPk($id[1]);
				Yii::app()->cart->update($itemOfCart,$qty);
			}
        }
        unset($dbcart,$dbcartArray,$shoppingcartArray);
    }
}
?>
