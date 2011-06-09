<?php

/**
 * This is the model class for table "{{Zone}}".
 *
 * The followings are the available columns in table '{{Zone}}':
 * @property integer $zone_id
 * @property string $name
 * @property integer $active
 */
class Zone extends CActiveRecord
{
    private static $_items;

    /**
	 * Returns the static model of the specified AR class.
	 * @return Zone the static model class
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
		return '{{zone}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, active', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('zone_id, name, active', 'safe', 'on'=>'search'),
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
			'zone_id' => 'Zone',
			'name' => 'Name',
			'active' => 'Active',
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

		$criteria->compare('zone_id',$this->zone_id);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('active',$this->active);

		return new CActiveDataProvider('Zone', array(
			'criteria'=>$criteria,
		));
	}

    public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'active=1'
            )
        );
    }

    public static function items($zoneID=0)
    {
        if(!isset(self::$_items))
        {
            self::_load_items();
        }

		return $zoneID==0 ? self::$_items : self::$_items[$zoneID];
    }

    private static function _load_items()
	{
		self::$_items = array();
		$models = self::model()->active()->findAll();
		foreach($models as $model)
        {
            self::$_items[$model->zone_id]=$model->name;
        }
	}
}