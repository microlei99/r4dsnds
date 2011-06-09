<?php

/**
 * This is the model class for table "{{AttributeGroup}}".
 *
 * The followings are the available columns in table '{{AttributeGroup}}':
 * @property integer $group_id
 * @property string $group_name
 * @property string $group_default
 * @property string $group_status
 */
class AttributeGroup extends CActiveRecord
{
    private static  $_items;
	/**
	 * Returns the static model of the specified AR class.
	 * @return AttributeGroup the static model class
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
		return '{{attribute_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_name, group_default, group_status', 'required'),
			array('group_name', 'length', 'max'=>32),
			array('group_default, group_status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('group_id, group_name, group_default, group_status', 'safe', 'on'=>'search'),
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
            'attributeNum'=>array(self::STAT,'Attribute','attribute_group_id'),
            'attribute'=>array(self::HAS_MANY,'Attribute','attribute_group_id')
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
			'group_default' => 'Group Default',
			'group_status' => 'Group Status',
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

		$criteria->compare('group_default',$this->group_default,true);

		$criteria->compare('group_status',$this->group_status,true);

		return new CActiveDataProvider('AttributeGroup', array(
			'criteria'=>$criteria,
		));
	}

    public function Scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'group_status=1',
            ),
            'default'=>array(
                'condition'=>'group_default=1',
            )
        );
    }

    public function  afterSave()
    {
        if($this->group_default)
            Yii::app()->db->createCommand("UPDATE {{attribute_group}} SET group_default=0 WHERE group_id!={$this->group_id}")->execute();
    }
    public function  beforeDelete()
    {
        $model = Attribute::model()->findAllByAttributes(array('attribute_group_id'=>$this->group_id));
        if($model)
        {
            foreach($model as $key)
            {
                $key->delete();
            }
        }
        return true;
    }

    public static function items()
	{
		if(!isset(self::$_items))
            self::loadItems();

		return self::$_items;
	}

    /**
     * @param <type> $type
     */
    private static function loadItems()
	{
		self::$_items=array();
		$model = self::model()->active()->findAll();
		foreach($model as $key)
        {
            self::$_items[$key->group_id]['name']=$key->group_name;
            self::$_items[$key->group_id]['default']=$key->group_default;
        }
	}
}