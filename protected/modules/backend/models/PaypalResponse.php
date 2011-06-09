<?php

/**
 * This is the model class for table "{{PaypalResponse}}".
 *
 * The followings are the available columns in table '{{PaypalResponse}}':
 * @property integer $response_id
 * @property integer $response_invoice_id
 * @property string $response_payer_id
 * @property string $response_payment_status
 * @property string $response_payment_type
 * @property string $response_txn_id
 * @property double $response_mc_gross
 * @property double $response_mc_fee
 * @property double $response_real_fee
 * @property string $response_payer_email
 * @property string $response_payer_status
 * @property string $response_mc_currency
 * @property integer $customer_id
 * @property integer $order_id
 * @property string $response_create_at
 */
class PaypalResponse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PaypalResponse the static model class
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
		return '{{paypal_response}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('response_invoice_id, response_payer_id, response_payment_status, response_payment_type, response_txn_id,response_mc_gross, response_mc_fee, response_real_fee, response_payer_email, response_payer_status, response_mc_currency, customer_id,order_id', 'required'),
			array('response_invoice_id, customer_id,order_id', 'numerical', 'integerOnly'=>true),
			array('response_mc_fee, response_real_fee,response_mc_gross', 'numerical'),
			array('response_payer_id', 'length', 'max'=>13),
			array('response_payment_status, response_payment_type, response_payer_status', 'length', 'max'=>20),
			array('response_txn_id', 'length', 'max'=>17),
			array('response_payer_email', 'length', 'max'=>127),
			array('response_mc_currency', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('response_id, response_invoice_id, response_payer_id, response_payment_status, response_payment_type, response_txn_id,response_mc_gross, response_mc_fee, response_real_fee, response_payer_email, response_payer_status, response_mc_currency, customer_id,order_id, response_create_at', 'safe', 'on'=>'search'),
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
			'response_id' => 'Response',
			'response_invoice_id' => 'Response Invoice',
			'response_payer_id' => 'Response Payer',
			'response_payment_status' => 'Resonse Payment Status',
			'response_payment_type' => 'Response Payment Type',
			'response_txn_id' => 'Response Txn',
			'response_mc_fee' => 'Response Mc Fee',
			'response_real_fee' => 'Response Real Fee',
			'response_payer_email' => 'Response Payer Email',
			'response_payer_status' => 'Response Payer Status',
			'response_mc_currency' => 'Response Mc Currency',
			'customer_id' => 'Customer',
			'response_create_at' => 'Response Create At',
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

		$criteria->compare('response_id',$this->response_id);

		$criteria->compare('response_invoice_id',$this->response_invoice_id);

		$criteria->compare('response_payer_id',$this->response_payer_id,true);

		$criteria->compare('response_payment_status',$this->response_payment_status,true);

		$criteria->compare('response_payment_type',$this->response_payment_type,true);

		$criteria->compare('response_txn_id',$this->response_txn_id,true);

        $criteria->compare('response_mc_gross', $this->response_mc_gross);

		$criteria->compare('response_mc_fee',$this->response_mc_fee);

		$criteria->compare('response_real_fee',$this->response_real_fee);

		$criteria->compare('response_payer_email',$this->response_payer_email,true);

		$criteria->compare('response_payer_status',$this->response_payer_status,true);

		$criteria->compare('response_mc_currency',$this->response_mc_currency,true);

		$criteria->compare('customer_id',$this->customer_id);

        $criteria->compare('order_id',$this->order_id);

		$criteria->compare('response_create_at',$this->response_create_at,true);

		return new CActiveDataProvider('PaypalResponse', array(
			'criteria'=>$criteria,
		));
	}
}