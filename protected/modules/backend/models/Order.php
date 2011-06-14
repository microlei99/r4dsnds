<?php

/**
 * This is the model class for table "{{Order}}".
 *
 * The followings are the available columns in table '{{Order}}':
 * @property integer $order_id
 * @property integer $invoice_id
 * @property integer $customer_id
 * @property string $order_subtotal
 * @property string $order_trackingtotal
 * @property string $order_grandtotal
 * @property integer $order_currency_id
 * @property integer $order_payment_id
 * @property integer $order_carrier_id
 * @property integer $order_address_id
 * @property integer $order_ship_id
 * @property integer $order_discount_id
 * @property integer $order_status
 * @property integer $order_export
 * @property integer $order_valid
 * @property integer $order_qty
 * @property string $order_ip
 * @property string $order_salt
 * @property string $order_comment
 * @property string $order_create_at
 * @property string $order_payment_at
 */
class Order extends CActiveRecord
{
    const AwaitingPayment=1;
    const PaymentAccepted=2;
    const Shipped=3;
    const Delived=4;
    const Refund=5;
    const PaymentError=6;
	const Canceled=7;
    const Pending = 8;
    const PreparationProgress = 9;
    const Fraud = 10;

    public $customer_name;
    public $customer_email;
    public $paypal_txnid;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Order the static model class
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
		return '{{order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, order_subtotal, order_trackingtotal, order_grandtotal, order_currency_id, order_payment_id, order_carrier_id, order_address_id, order_ship_id, order_discount_id, order_status, order_valid,order_qty, order_ip', 'required'),
			array('invoice_id, customer_id, order_currency_id, order_payment_id, order_carrier_id, order_address_id, order_ship_id, order_discount_id, order_status,order_valid, order_qty', 'numerical', 'integerOnly'=>true),
			array('order_subtotal, order_trackingtotal, order_grandtotal', 'length', 'max'=>6),
			array('order_ip', 'length', 'max'=>15),
			array('order_salt', 'length', 'max'=>32),
			array('order_comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('customer_email,paypal_txnid,customer_name,order_id, invoice_id, customer_id, order_subtotal, order_trackingtotal,order_grandtotal, order_currency_id, order_payment_id, order_carrier_id, order_address_id, order_ship_id, order_discount_id, order_status, order_valid,order_export,order_qty, order_ip, order_salt, order_comment, order_create_at,order_payment_at', 'safe', 'on'=>'search'),
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
            'payment'=>array(self::BELONGS_TO,'Payment','order_payment_id'),
            'currency'=>array(self::BELONGS_TO,'Currency','order_currency_id'),
            'items'=>array(self::HAS_MANY,'OrderItem','order_id'),
            'customer'=>array(self::BELONGS_TO,'Customer','customer_id'),
            'carrier'=>array(self::BELONGS_TO,'Carrier','order_carrier_id'),
            'address'=>array(self::BELONGS_TO,'CustomerAddress','order_address_id'),
            'paypal'=>array(self::HAS_ONE,'PaypalResponse','order_id'),
            'ship'=>array(self::HAS_ONE,'OrderShip','ship_order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'Order',
			'invoice_id' => 'Invoice',
			'customer_id' => 'Customer',
			'order_subtotal' => 'Order Subtotal',
            'order_trackingtotal'=>'Order TrackingTotal',
			'order_grandtotal' => 'Order Grandtotal',
			'order_currency_id' => 'Order Currency',
			'order_payment_id' => 'Order Payment',
			'order_carrier_id' => 'Order Carrier',
			'order_address_id' => 'Order Address',
			'order_ship_id' => 'Order Ship',
			'order_discount_id' => 'Order Discount',
			'order_status' => 'Order Status',
			'order_qty' => 'Order Qty',
			'order_ip' => 'Order Ip',
			'order_salt' => 'Order Salt',
			'order_comment' => 'Order Comment',
			'order_create_at' => 'Order Create At',
            'order_payment_at'=>'Order Payment At'
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

		$criteria=new CDbCriteria(array(
            'with'=>array('address','paypal','customer'),
            'order'=>'t.order_id DESC',
        ));

        $criteria->compare('address.customer_name',$this->customer_name,true);

        $criteria->compare('response_txn_id',$this->paypal_txnid,true);

        $criteria->compare('customer_email', $this->customer_email,true);

		$criteria->compare('order_id',$this->order_id);

		$criteria->compare('invoice_id',$this->invoice_id);

		$criteria->compare('t.customer_id',$this->customer_id);   //order.customer_id and customer_address.customer_id in where clause is ambiguous,so add the prefix t

		$criteria->compare('order_subtotal',$this->order_subtotal,true);

        $criteria->compare('order_trackingtotal', $this->order_trackingtotal,true);

		$criteria->compare('order_grandtotal',$this->order_grandtotal,true);

		$criteria->compare('order_currency_id',$this->order_currency_id);

		$criteria->compare('order_payment_id',$this->order_payment_id);

		$criteria->compare('order_carrier_id',$this->order_carrier_id);

		$criteria->compare('order_address_id',$this->order_address_id);

		$criteria->compare('order_ship_id',$this->order_ship_id);

		$criteria->compare('order_discount_id',$this->order_discount_id);

		$criteria->compare('order_status',$this->order_status);

        $criteria->compare('order_valid', $this->order_valid);

        $criteria->compare('order_export',$this->order_export);

		$criteria->compare('order_qty',$this->order_qty);

		$criteria->compare('order_ip',$this->order_ip,true);

		$criteria->compare('order_salt',$this->order_salt,true);

		$criteria->compare('order_comment',$this->order_comment,true);

		$criteria->compare('order_create_at',$this->order_create_at,true);

        $criteria->compare('order_payment_at',$this->order_create_at,true);

        $criteria->addCondition('order_status!='.self::AwaitingPayment);

		return new CActiveDataProvider('Order', array(
			'criteria'=>$criteria,
		));
	}

    public function  beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->order_export = 0;
        }

        if($this->order_status==self::PaymentAccepted
            || $this->order_status==self::Shipped
            || $this->order_status==self::Delived
            || $this->order_status== self::PreparationProgress)
        {
            $this->order_valid = 1;
        }
        else{
            $this->order_valid = 0;
        }
        return true;
    }

    public function paymentSuccess()
    {
        if ($this->order_status == self::PaymentAccepted)
        {
            /* 删除购物车商品 */
            foreach ($this->items as $item)
            {
                Cart::model()->deleteAllByAttributes(array(
                    'product_id'=>$item->item_product_id,
                    'customer_id'=>$this->customer_id,
                    'attribute_id'=>$item->item_attribute_id,
                ));
                $model = Product::model()->findByPk($item->item_product_id);
                $model->product_stock_qty-=$item->item_qty;
                $model->save(true,array('product_stock_qty'));
                ProductStatistic::Statistic($item->item_product_id,array('buyed'=>$item->item_qty));
            }

            $customer = Customer::model()->findByPk($this->customer_id);
            if($customer->customer_default_address==0){
                $customer->customer_default_address = $this->order_address_id;
                $customer->saveAttributes(array('customer_default_address'));
            }

            /* email */
            $mail = new SyoSendEmail();
            $data = array(
                'hostUrl'=>Yii::app()->request->hostInfo,
                'hostName'=>Yii::app()->request->serverName,
                'name'=>$customer->customer_name,
                'email'=>$customer->customer_email,
                'view'=>'order',
                'subject'=>'Thank you for your order',
                'order'=>$this,
                'address'=>$this->address,
                'items'=>$this->items,
            );
            $mail->sendByOrder($data);
        }
    }

    public function getInvoice()
    {
        $prefix = Config::item('system','order_export_prefix');
        if($this->customer->group->group_name=='Warning')
        {
            $prefix = '(警告)';
        }

        return '('.$prefix.')'.$this->invoice_id;
    }

    public function getPrefix(){
        return '('.Config::item('system', 'order_export_prefix').')';
    }




    public function getWeightTotal()
    {
        $req = Yii::app()->db->createCommand(
                'SELECT sum(m1.item_qty*m1.item_weight) FROM {{order_item}} as m1 '
                . " WHERE m1.order_id={$this->order_id}"
        );
        return $req->queryScalar();
    }

    public static function getCustomerValidOrders($customerID=0)
    {
        $condition = '';
        if($customerID){
            $condition = "t1.customer_id={$customerID} AND ";
        }
        $sql =  "SELECT  count(t1.order_id) FROM {{order}} AS t1
                     WHERE $condition t1.order_valid=1";

        $res = Yii::app()->db->createCommand($sql)->queryScalar();

        return $res;
    }

    public static function getCustomerTotalAmount($customerID=0)
    {
        $condition = '';
        if($customerID){
            $condition = "AND t1.customer_id={$customerID}";
        }
        $sql = "SELECT SUM(t1.order_grandtotal/t2.currency_rate) AS total FROM {{order}} AS t1,{{currency}} AS t2
                    WHERE t1.order_currency_id=t2.currency_id $condition AND t1.order_valid=1";

        $res = Yii::app()->db->createCommand($sql)->queryScalar();

        return round(floatval($res),1);
    }

    public static function getLifeTimeTotal()
    {
        $sql = "SELECT SUM(t1.order_grandtotal/t2.currency_rate) AS total FROM {{order}} AS t1,{{currency}} AS t2
                    WHERE t1.order_currency_id=t2.currency_id AND t1.order_valid=1";

        $res = Yii::app()->db->createCommand($sql)->queryScalar();

        return round(floatval($res),1);
    }

    public static function getOrderAvg()
    {
       $sql = "SELECT AVG(t1.order_grandtotal/t2.currency_rate) AS total FROM {{order}} AS t1,{{currency}} AS t2
                    WHERE t1.order_currency_id=t2.currency_id AND t1.order_valid=1";

        $res = Yii::app()->db->createCommand($sql)->queryScalar();

        return round(floatval($res),1);
    }

    public static function getStatisticSale($saleID)
    {
        $sql = "SELECT SUM(t1.order_grandtotal/t2.currency_rate) AS total FROM {{order}} AS t1,{{currency}} AS t2
                    WHERE t1.order_currency_id=t2.currency_id AND t1.order_valid=1";

        $curdate = date('Y-m-d');
        if($saleID==1){

            $sql .= " AND DATEDIFF('{$curdate}',order_create_at)<=1";
        }
        else if($saleID==2){
            $sql .= " AND DATEDIFF('{$curdate}',order_create_at)<=7";
        }
        else if($saleID==3){
            $sql .= " AND DATEDIFF('{$curdate}',order_create_at)<=30";
        }
        else if($saleID==4){
            $sql .= " AND DATEDIFF('{$curdate}',order_create_at)<=90";
        }
        else if($saleID==5){
            $sql .= " AND DATEDIFF('{$curdate}',order_create_at)<=180";
        }

        $res = Yii::app()->db->createCommand($sql)->queryScalar();

        return round(floatval($res),1);
    }
}