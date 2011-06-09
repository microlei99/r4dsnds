<?php

/**
 * This is the model class for table "{{HotSearch}}".
 *
 * The followings are the available columns in table '{{HotSearch}}':
 * @property integer $search_id
 * @property string $search_code
 */
class HotSearch extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return HotSearch the static model class
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
		return '{{hotsearch}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('search_code', 'required'),
			array('search_code', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('search_id, search_code', 'safe', 'on'=>'search'),
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
			'search_id' => 'Search',
			'search_code' => 'Search Code',
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

		$criteria->compare('search_id',$this->search_id);

		$criteria->compare('search_code',$this->search_code,true);

		return new CActiveDataProvider('HotSearch', array(
			'criteria'=>$criteria,
		));
	}
}