<?php

/**
 * This is the model class for table "{{AttributeValue}}".
 *
 * The followings are the available columns in table '{{AttributeValue}}':
 * @property integer $attribute_value_id
 * @property string $attribute_value
 * @property integer $attribute_id
 */
class AttributeValue extends CActiveRecord
{
    private static  $_items;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Attribute_value the static model class
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
		return '{{attribute_value}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attribute_value, attribute_id', 'required'),
			array('attribute_id', 'numerical', 'integerOnly'=>true),
			array('attribute_value', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('attribute_value_id, attribute_value, attribute_id', 'safe', 'on'=>'search'),
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
			'attribute_value_id' => 'Attribute Value',
			'attribute_value' => 'Attribute Value',
			'attribute_id' => 'Attribute',
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

		$criteria->compare('attribute_value_id',$this->attribute_value_id);

		$criteria->compare('attribute_value',$this->attribute_value,true);

		$criteria->compare('attribute_id',$this->attribute_id);

		return new CActiveDataProvider('AttributeValue', array(
			'criteria'=>$criteria,
		));
	}

    public static function items()
	{
		if(!isset(self::$_items))
            self::loadItems();

		return self::$_items;
	}

    public static function item($id)
	{
		if(!isset(self::$_items))
            self::loadItems();

		return isset(self::$_items[$id]) ? self::$_items[$id] : false;
	}

    /**
     * @param <type> $type
     */
    private static function loadItems()
	{
		self::$_items=array();
		$model = self::model()->findAll();
		foreach($model as $key)
        {
            self::$_items[$key->attribute_id][$key->attribute_value_id]=$key->attribute_value;
        }
	}
}