<?php

/**
 * This is the model class for table "{{Seo}}".
 *
 * The followings are the available columns in table '{{Seo}}':
 * @property integer $seo_id
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_description
 */
class Seo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Seo the static model class
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
		return '{{seo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seo_title, seo_keyword, seo_description', 'required'),
			array('seo_title', 'length', 'max'=>255),
            array('seo_keyword', 'length', 'max'=>600),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('seo_id, seo_title, seo_keyword, seo_description', 'safe', 'on'=>'search'),
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
			'seo_id' => 'Seo',
			'seo_title' => 'Seo Title',
			'seo_keyword' => 'Seo Keyword',
			'seo_description' => 'Seo Description',
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

		$criteria->compare('seo_id',$this->seo_id);

		$criteria->compare('seo_title',$this->seo_title,true);

		$criteria->compare('seo_keyword',$this->seo_keyword,true);

		$criteria->compare('seo_description',$this->seo_description,true);

		return new CActiveDataProvider('Seo', array(
			'criteria'=>$criteria,
		));
	}
}