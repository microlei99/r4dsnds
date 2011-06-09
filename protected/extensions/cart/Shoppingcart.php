<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Shoppingcart extends CMap
{

    private $_discount = 0.0;
    
    public function init()
    {
        $this->restoreFromSession();
        $this->restoreFromCookie();
    }

    public function put(ICart $item, $option=null, $quantity = 1)
    {
        $key = $this->getKey($item, $option);

        $itemOfCart = $this->itemAt($key);

        if ($itemOfCart['item'] instanceof ICart)
        {
            $quantity += $itemOfCart['item']->getQuantity();
        }
        else
        {
            $itemOfCart['item'] = $item;
            $itemOfCart['option'] = $option == null ? null : $option;
        }

        $this->update($itemOfCart, $quantity);
    }

    public function update($item, $quantity)
    {

        if (!$item['item'] instanceof ICart){
            throw new InvalidArgumentException('product must implement IECartPosition interface');
        }

        $item['item']->attachBehavior("CartBehavior", new CartBehaviour());
        $item['item']->setQuantity($quantity);

        $key = $this->getKey($item['item'], $item['option']);

        if ($item['item']->getQuantity() < 1){
            $item['item']->setQuantity($quantity);
        }
        else{
            parent::add($key, $item);
        }
        
        $this->saveState();
    }

    public function remove($key)
    {
        parent::remove($key);
        $this->saveState();
    }

    public function removeAll()
    {
        foreach ($this->toArray() as $key=>$item)
        {
            parent::remove($key);
        }
        $this->saveState();
    }

    public function getCart()
    {
        return $this->toArray();
    }

    public function getItems()
    {
        return $this->getCount();
    }

	/* only when $withDiscount is true,$this->discount can be used */
	public function getCost($withDiscount=false)
	{
		$price = 0.0;
        foreach ($this->getCart() as $item)
        {
            $price += $item['item']->getSumPrice();
        }

        if($withDiscount)
            $price -= $this->getDiscount();

        return $price;
	}

    public function setDiscount($discount)
    {
        $this->_discount = Product::decoratePrice($discount,false);
    }

    public function getDiscount()
    {
        return $this->_discount;
    }

    public function isEmpty()
    {
        return !(bool)$this->getCount();
    }

    public function getItemsQuantiay()
    {
        $count = 0;
        foreach ($this->toArray() as $key)
        {
            $count += $key['item']->getQuantity();
        }

        return $count;
    }

    protected function getKey($item, $option){
        return $option === null ? $item->getID() . '-0' : $item->getID() . '-' . $option->getID();
    }

    protected function saveState()
    {
        $data = array();
        foreach ($this as $key => $item){
            $data[$key]['qty'] = $item['item']->getQuantity();
        }
        $data = array('cardsnds.co.uk', 5184000, $data);
        $cookie = new CHttpCookie(__CLASS__, '');
        $cookie->expire = time() + 5184000;
        $cookie->value = Yii::app()->getSecurityManager()->hashData(serialize($data));
        Yii::app()->getRequest()->getCookies()->add($cookie->name, $cookie);
        Yii::app()->getUser()->setState(__CLASS__, $this->toArray());
    }

    protected  function restoreFromSession()
    {
        $data = Yii::app()->getUser()->getState(__CLASS__);

        if (is_array($data) || $data instanceof Traversable)
        {
            foreach ($data as $key => $item){
                parent::add($key, $item);
            }
        }
    }

    protected function restoreFromCookie()
    {
        $cookie = Yii::app()->getRequest()->getCookies()->itemAt(__CLASS__);

        if($cookie && !empty($cookie->value) && ($data=Yii::app()->getSecurityManager()->validateData($cookie->value))!==false)
        {
            $data=@unserialize($data);

            if(is_array($data) && isset($data[0],$data[1],$data[2]))
            {
                list($name,$duration,$states) = $data;
                foreach($states as $key=>$row)
                {
                    $id = explode('-',$key);
                    if($item = Product::model()->findByPk($id[0]))
                    {
                        $option = $id[1]==0 ? null : ProductAttribute::model()->findByPk($id[1]);
                        $this->update(array('item'=>$item,'option'=>$option),$row['qty']);
                    }
                }
            }
        }
    }
}

?>
