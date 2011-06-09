<?php

/**
 * This is the model class for table "{{Cart}}".
 *
 * The followings are the available columns in table '{{Cart}}':
 * @property integer $cart_id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property integer $product_qty
 * @property integer $customer_id
 * @property string $cart_addtime
 */
class Cart extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Cart the static model class
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
		return '{{cart}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, attribute_id,product_qty, customer_id', 'required'),
			array('product_id, attribute_id,product_qty, customer_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cart_id, product_id, attribute_id,product_qty, customer_id, cart_addtime', 'safe', 'on'=>'search'),
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
            'product'=>array(self::BELONGS_TO,'Product','product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cart_id' => 'Cart',
			'product_id' => 'Product',
            'attribute_id' => 'Attribute Id',
			'product_qty' => 'Product Qty',
			'customer_id' => 'Customer',
			'cart_addtime' => 'Cart Addtime',
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

		$criteria->compare('cart_id',$this->cart_id);

		$criteria->compare('product_id',$this->product_id);

        $criteria->compare('attribute_id',$this->attribute_id);

		$criteria->compare('product_qty',$this->product_qty);

		$criteria->compare('customer_id',$this->customer_id);

		$criteria->compare('cart_addtime',$this->cart_addtime,true);

		return new CActiveDataProvider('Cart', array(
			'criteria'=>$criteria,
		));
	}
}