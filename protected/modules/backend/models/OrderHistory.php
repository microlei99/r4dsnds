<?php

/**
 * This is the model class for table "{{OrderHistory}}".
 *
 * The followings are the available columns in table '{{OrderHistory}}':
 * @property integer $history_id
 * @property integer $history_employee_id
 * @property integer $history_order_id
 * @property integer $history_state
 * @property string $history_create
 */
class OrderHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OrderHistory the static model class
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
		return '{{order_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('history_employee_id, history_order_id, history_state', 'required'),
			array('history_employee_id, history_order_id, history_state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('history_id, history_employee_id, history_order_id, history_state, history_create', 'safe', 'on'=>'search'),
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
            'order'=>array(self::BELONGS_TO,'Order','history_order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'history_id' => 'History',
			'history_employee_id' => 'History Employee',
			'history_order_id' => 'History Order',
			'history_state' => 'History State',
			'history_create' => 'History Create',
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

		$criteria->compare('history_id',$this->history_id);

		$criteria->compare('history_employee_id',$this->history_employee_id);

		$criteria->compare('history_order_id',$this->history_order_id);

		$criteria->compare('history_state',$this->history_state);

		$criteria->compare('history_create',$this->history_create,true);

		return new CActiveDataProvider('OrderHistory', array(
			'criteria'=>$criteria,
		));
	}

    public function informEmail($customerID)
    {
        if ($customerID && $customer = Customer::model()->findByPk($customerID))
        {
            switch ($this->history_state)
            {
                case Order::Shipped:
                    $view = 'shipped';
				    $view = 'shipped';
                    $ship= OrderShip::model()->findByAttributes(array('ship_order_id'=>$this->history_order_id)); 
                    $shipArray = array(
                        'code'=>$ship->ship_code,
                        'trackUrl'=>$ship->trackUrl($ship->ship_code,$this->order->carrier->carrier_url)
                        );
                    
                    unset($ship);
                  
                    break;
                case Order::PaymentError:
                    $view = 'payment_error';
                    break;
                case Order::Refund:
                    $view = 'refunded';
                    break;
                case Order::Canceled:
                    $view = 'canceled';
                    break;
            }
            if ($view)
            {
                $invoice = $this->order->invoice_id;
                $subject = "Your Order {$invoice} has been " . Lookup::item('payment_status', $this->history_state);
                $mail = new SyoSendEmail();
                $data = array(
                    'hostUrl' => Yii::app()->request->hostInfo,
                    'hostName' => Yii::app()->request->serverName,
                    'name' => $customer->customer_name,
                    'email' => $customer->customer_email,
                    'view' => $view,
                    'order_name'=>$invoice,
                    'subject' => $subject,
                );
				 if($view=='shipped'){
                    $data=cmap::mergeArray($data, $shipArray);
                }
                $mail->sendmixed($data);
            }
        }
    }
}