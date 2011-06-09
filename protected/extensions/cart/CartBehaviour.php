<?php

class CartBehaviour extends CActiveRecordBehavior
{

    private $_quantity = 0;

    public function init()
    {

    }

    /**
     * Returns total price for all units of the position
     * @param bool $withDiscount
     * @return float
     *
     */
    public function getSumPrice()
    {
        if ($wholesale = $this->owner->isWholesaleActive($this->getQuantity()))
        {
            $price = $this->owner->getPrice('wholesale', $wholesale['wholesale_id']);
        }
        else
        {
            $price = $this->owner->getPrice('promotion');
        }
        return fixedPrice(Product::decoratePrice($price,false) * $this->getQuantity());
    }

    /**
     * Returns quantity.
     * @return int
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * Updates quantity.
     *
     * @param int quantity
     */
    public function setQuantity($newVal)
    {
        $this->_quantity = $newVal;
    }

    public function addDiscountPrice($price)
    {
        $this->discountPrice += $price;
    }

}
