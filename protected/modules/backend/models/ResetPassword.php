<?php

/**
 * This is the model class for table "{{ResetPassword}}".
 *
 * The followings are the available columns in table '{{ResetPassword}}':
 * @property integer $id
 * @property integer $customer_id
 * @property string $customer_email
 * @property string $password
 * @property integer $duration
 * @property integer $is_active
 * @property string $create_at
 */
class ResetPassword extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ResetPassword the static model class
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
		return '{{reset_password}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, customer_email, password, duration,is_active', 'required'),
			array('customer_id, duration,is_active', 'numerical', 'integerOnly'=>true),
			array('customer_email', 'length', 'max'=>96),
			array('password', 'length', 'max'=>13),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, customer_id, customer_email, password, duration,is_active, create_at', 'safe', 'on'=>'search'),
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
			'id' => 'Id',
			'customer_id' => 'Customer',
			'customer_email' => 'Customer Email',
			'password' => 'Password',
			'duration' => 'Duration',
			'create_at' => 'Create At',
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

		$criteria->compare('id',$this->id);

		$criteria->compare('customer_id',$this->customer_id);

		$criteria->compare('customer_email',$this->customer_email,true);

		$criteria->compare('password',$this->password,true);

		$criteria->compare('duration',$this->duration);

        $criteria->compare('is_active', $this->is_active);

		$criteria->compare('create_at',$this->create_at,true);

		return new CActiveDataProvider('ResetPassword', array(
			'criteria'=>$criteria,
		));
	}
}