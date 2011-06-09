<?php

/**
 * This is the model class for table "{{State}}".
 *
 * The followings are the available columns in table '{{State}}':
 * @property integer $state_id
 * @property integer $country_id
 * @property integer $zone_id
 * @property string $name
 * @property string $iso_code
 * @property integer $tax_behavior
 * @property integer $active
 */
class State extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return State the static model class
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
		return '{{state}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, zone_id, name, iso_code, active', 'required'),
			array('country_id, zone_id, tax_behavior, active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('iso_code', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('state_id, country_id, zone_id, name, iso_code, tax_behavior, active', 'safe', 'on'=>'search'),
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
            'zone'=>array(self::BELONGS_TO,'Zone','zone_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'state_id' => 'State',
			'country_id' => 'Country',
			'zone_id' => 'Zone',
			'name' => 'Name',
			'iso_code' => 'Iso Code',
			'tax_behavior' => 'Tax Behavior',
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

		$criteria->compare('state_id',$this->state_id);

		$criteria->compare('country_id',$this->country_id);

		$criteria->compare('zone_id',$this->zone_id);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('iso_code',$this->iso_code,true);

		$criteria->compare('tax_behavior',$this->tax_behavior);

		$criteria->compare('active',$this->active);

		return new CActiveDataProvider('State', array(
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
}