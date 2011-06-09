<?php

/**
 * This is the model class for table "{{Lookup}}".
 *
 * The followings are the available columns in table '{{Lookup}}':
 * @property integer $lookup_id
 * @property string $lookup_item
 * @property string $lookup_code
 */
class Lookup extends CActiveRecord
{
    const CUSTOMER_ROLE_ADMIN = 11;
    const CUSTOMER_ROLE_USER = 12;
    const CUSTOMER_ROLE_SUPER = 13;
    
    private static $_items;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lookup the static model class
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
		return '{{lookup}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lookup_item, lookup_code', 'required'),
			array('lookup_item, lookup_code', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lookup_id, lookup_item, lookup_code', 'safe', 'on'=>'search'),
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
			'lookup_id' => 'Lookup',
			'lookup_item' => 'Lookup Item',
			'lookup_code' => 'Lookup Code',
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

		$criteria->compare('lookup_id',$this->lookup_id);

		$criteria->compare('lookup_item',$this->lookup_item,true);

		$criteria->compare('lookup_code',$this->lookup_code,true);

		return new CActiveDataProvider('Lookup', array(
			'criteria'=>$criteria,
		));
	}

    public static function item($item,$id)
    {
        if(!isset(self::$_items[$item]))
			self::loadItems($item);
		return isset(self::$_items[$id]) ? self::$_items[$id] : self::$_items;
    }

    public static function items($item)
	{
		if(!isset(self::$_items[$item]))
			self::loadItems($item);
		return self::$_items;
	}

    private static function loadItems($item)
	{
		$model = self::model()->findAll(array('condition'=>'lookup_item=:item','params'=>array(':item'=>$item)));
		foreach($model as $key)
			self::$_items[$key->lookup_id] = $key->lookup_code;
	}
}