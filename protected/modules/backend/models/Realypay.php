<?php

/**
 * This is the model class for table "{{realypay}}".
 *
 * The followings are the available columns in table '{{realypay}}':
 * @property integer $realypay_id
 * @property integer $realypay_siteid
 * @property double $realypay_total
 * @property string $realypay_status
 * @property string $realypay_transactionid
 * @property string $realypay_verifycode
 * @property integer $realypay_customerid
 * @property integer $realypay_orderid
 * @property string $realypay_createat
 * @property string $realypay_returnat
 */
class Realypay extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Realypay the static model class
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
		return '{{realypay}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('realypay_siteid, realypay_total, realypay_status, realypay_transactionid, realypay_verifycode, realypay_customerid, realypay_orderid', 'required'),
			array('realypay_siteid, realypay_customerid, realypay_orderid', 'numerical', 'integerOnly'=>true),
			array('realypay_total', 'numerical'),
			array('realypay_status, realypay_transactionid', 'length', 'max'=>15),
			array('realypay_verifycode', 'length', 'max'=>32),
			array('realypay_returnat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realypay_id, realypay_siteid, realypay_total, realypay_status, realypay_transactionid, realypay_verifycode, realypay_customerid, realypay_orderid, realypay_createat, realypay_returnat', 'safe', 'on'=>'search'),
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
			'realypay_id' => 'Realypay',
			'realypay_siteid' => 'Realypay Siteid',
			'realypay_total' => 'Realypay Total',
			'realypay_status' => 'Realypay Status',
			'realypay_transactionid' => 'Realypay Transactionid',
			'realypay_verifycode' => 'Realypay Verifycode',
			'realypay_customerid' => 'Realypay Customerid',
			'realypay_orderid' => 'Realypay Orderid',
			'realypay_createat' => 'Realypay Createat',
			'realypay_returnat' => 'Realypay Returnat',
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

		$criteria->compare('realypay_id',$this->realypay_id);

		$criteria->compare('realypay_siteid',$this->realypay_siteid);

		$criteria->compare('realypay_total',$this->realypay_total);

		$criteria->compare('realypay_status',$this->realypay_status,true);

		$criteria->compare('realypay_transactionid',$this->realypay_transactionid,true);

		$criteria->compare('realypay_verifycode',$this->realypay_verifycode,true);

		$criteria->compare('realypay_customerid',$this->realypay_customerid);

		$criteria->compare('realypay_orderid',$this->realypay_orderid);

		$criteria->compare('realypay_createat',$this->realypay_createat,true);

		$criteria->compare('realypay_returnat',$this->realypay_returnat,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}