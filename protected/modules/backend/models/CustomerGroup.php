<?php

/**
 * This is the model class for table "{{CustomerGroup}}".
 *
 * The followings are the available columns in table '{{CustomerGroup}}':
 * @property integer $group_id
 * @property string $group_name
 */
class CustomerGroup extends CActiveRecord
{
    private static $_items;

    const CUSTOMER_DEFAULT_GROUP = 1;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return CustomerGroup the static model class
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
		return '{{customer_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_name', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('group_id, group_name', 'safe', 'on'=>'search'),
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
            'customer'=>array(self::STAT,'Customer','customer_group'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => 'Group',
			'group_name' => 'Group Name',
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

		$criteria->compare('group_id',$this->group_id);

		$criteria->compare('group_name',$this->group_name,true);

		return new CActiveDataProvider('CustomerGroup', array(
			'criteria'=>$criteria,
		));
	}

    public static function items()
	{
		if(!isset(self::$_items))
			self::loadItems();
		return self::$_items;
	}

	private static function loadItems()
	{
		self::$_items=array();
		$models=self::model()->findAll();
		foreach($models as $model)
			self::$_items[$model->group_id]=$model->group_name;
	}
}