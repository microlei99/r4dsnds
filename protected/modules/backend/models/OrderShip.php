<?php

/**
 * This is the model class for table "{{OrderShip}}".
 *
 * The followings are the available columns in table '{{OrderShip}}':
 * @property integer $ship_id
 * @property integer $ship_order_id
 * @property string $ship_start_at
 * @property string $ship_end_at
 * @property string $ship_from
 * @property integer $ship_to
 * @property string $ship_code
 * @property string $ship_create_at
 */
class OrderShip extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OrderShip the static model class
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
		return '{{order_ship}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ship_order_id, ship_start_at, ship_end_at, ship_to', 'required'),
			array('ship_order_id, ship_to', 'numerical', 'integerOnly'=>true),
			array('ship_from, ship_code', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ship_id, ship_order_id, ship_start_at, ship_end_at, ship_from, ship_to, ship_code, ship_create_at', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ship_id' => 'Ship',
			'ship_order_id' => 'Ship Order',
			'ship_start_at' => 'Ship Start At',
			'ship_end_at' => 'Ship End At',
			'ship_from' => 'Ship From',
			'ship_to' => 'Ship To',
			'ship_code' => 'Ship Code',
			'ship_create_at' => 'Ship Create At',
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

		$criteria->compare('ship_id',$this->ship_id);

		$criteria->compare('ship_order_id',$this->ship_order_id);

		$criteria->compare('ship_start_at',$this->ship_start_at,true);

		$criteria->compare('ship_end_at',$this->ship_end_at,true);

		$criteria->compare('ship_from',$this->ship_from,true);

		$criteria->compare('ship_to',$this->ship_to);

		$criteria->compare('ship_code',$this->ship_code,true);

		$criteria->compare('ship_create_at',$this->ship_create_at,true);

		return new CActiveDataProvider('OrderShip', array(
			'criteria'=>$criteria,
		));
	}

    public function trackUrl($shippingNumber,$carrierUrl)
    {
        if (!$shippingNumber || !$carrierUrl)
            return;

        return str_replace('@', $shippingNumber, $carrierUrl);
    }
}