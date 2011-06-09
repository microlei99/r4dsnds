<?php

/**
 * This is the model class for table "{{Config}}".
 *
 * The followings are the available columns in table '{{Config}}':
 * @property integer $config_id
 * @property string $config_type
 * @property string $config_item
 * @property string $config_code
 */
class Config extends CActiveRecord
{
    private static $_items;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Config the static model class
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
		return '{{config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('config_type, config_item, config_code', 'required'),
			array('config_type', 'length', 'max'=>20),
			array('config_item', 'length', 'max'=>32),
			array('config_code', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('config_id, config_type, config_item, config_code', 'safe', 'on'=>'search'),
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
			'config_id' => 'Config',
			'config_type' => 'Config Type',
			'config_item' => 'Config Item',
			'config_code' => 'Config Code',
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

		$criteria->compare('config_id',$this->config_id);

		$criteria->compare('config_type',$this->config_type,true);

		$criteria->compare('config_item',$this->config_item,true);

		$criteria->compare('config_code',$this->config_code,true);

		return new CActiveDataProvider('Config', array(
			'criteria'=>$criteria,
		));
	}

    public static function items($type)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return self::$_items[$type];
	}

    public static function item($type,$item)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return isset(self::$_items[$type][$item]) ? self::$_items[$type][$item] : false;
	}

    private static function loadItems($type)
	{
		self::$_items[$type]=array();
		$models=self::model()->findAll(array('condition'=>'config_type=:type','params'=>array(':type'=>$type)));
		foreach($models as $model)
			self::$_items[$type][$model->config_item]=$model->config_code;
	}
}