<?php

/**
 * This is the model class for table "{{OrderItem}}".
 *
 * The followings are the available columns in table '{{OrderItem}}':
 * @property integer $item_id
 * @property integer $item_qty
 * @property integer $item_weight
 * @property double $item_price
 * @property double $item_total
 * @property integer $item_attribute_id
 * @property integer $item_product_id
 * @property string $item_product_name
 * @property integer $order_id
 */
class OrderItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OrderItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_qty, item_price, item_attribute_id, item_product_id,item_product_name, order_id', 'required'),
			array('item_qty, item_attribute_id, item_product_id, order_id', 'numerical', 'integerOnly'=>true),
			array('item_price,item_total,item_weight', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('item_id, item_qty, item_price, item_total,item_attribute_id, item_product_id, order_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'product'=>array(self::BELONGS_TO,'Product','item_product_id'),
            'attribute'=>array(self::BELONGS_TO,'ProductAttribute','item_attribute_id'),
            'order'=>array(self::BELONGS_TO,'Order','order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'item_id' => 'Item',
			'item_qty' => 'Item Qty',
			'item_price' => 'Item Price',
			'item_attribute_id' => 'Item Attribute',
			'item_product_id' => 'Item Product',
			'order_id' => 'Order',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('item_id',$this->item_id);

		$criteria->compare('item_qty',$this->item_qty);

		$criteria->compare('item_price',$this->item_price);

        $criteria->compare('item_total',$this->item_total);

		$criteria->compare('item_attribute_id',$this->item_attribute_id);

		$criteria->compare('item_product_id',$this->item_product_id);

        $criteria->compare('item_product_name',$this->item_product_name);

		$criteria->compare('order_id',$this->order_id);

		return new CActiveDataProvider('OrderItem', array(
			'criteria'=>$criteria,
		));
	}

    public function  beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->item_weight = $this->product->product_weight;
        }
        return true;
    }

    public function afterDelete()
    {
        if($this->order_id)
        {
            /*删除订单*/
            if(!$this->count(array('condition'=>'order_id='.$this->order_id)))
            {
                Order::model()->deleteByPk($this->order_id);
            }
        }
    }
}