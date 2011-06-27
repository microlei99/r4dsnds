<?php

/**
 * This is the model class for table "{{Customer}}".
 *
 * The followings are the available columns in table '{{Customer}}':
 * @property integer $customer_id
 * @property string $customer_email
 * @property string $customer_name
 * @property string $customer_pwd
 * @property integer $customer_newsletter
 * @property integer $customer_active
 * @property integer $customer_role
 * @property integer $customer_default_address
 * @property integer $customer_group
 * @property string $customer_ip
 * @property string $customer_login
 * @property integer $customer_visit_count
 * @property string $customer_last_update
 * @property string $customer_create_at
 */
class Customer extends CActiveRecord
{
    public $customerConsumption;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Customer the static model class
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
		return '{{customer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_email,customer_name, customer_pwd, customer_newsletter, customer_active, customer_role, customer_default_address, customer_group, customer_create_at', 'required'),
			array('customer_newsletter, customer_active,customer_role, customer_default_address, customer_group, customer_visit_count', 'numerical', 'integerOnly'=>true),
			array('customer_email,customer_name', 'length', 'max'=>96),
			array('customer_pwd', 'length', 'max'=>32),
			array('customer_ip', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('customer_id, customer_email, customer_name,customer_pwd, customer_newsletter, customer_active, customer_role, customer_default_address, customer_group, customer_ip, customer_login, customer_visit_count, customer_last_update, customer_create_at', 'safe', 'on'=>'search'),
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
            'group'=>array(self::BELONGS_TO,'CustomerGroup','customer_group'),
            'address'=>array(self::HAS_MANY,'CustomerAddress','customer_id'),
            'lookup'=>array(self::BELONGS_TO,'Lookup','customer_role'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'customer_id' => 'Customer',
			'customer_email' => 'Customer Email',
			'customer_pwd' => 'Customer Pwd',
			'customer_newsletter' => 'Customer Newsletter',
			'customer_active' => 'Customer Active',
			'customer_role' => 'Customer Role',
			'customer_default_address' => 'Customer Default Address',
			'customer_group' => 'Customer Group',
			'customer_ip' => 'Customer Ip',
			'customer_login' => 'Customer Login',
			'customer_visit_count' => 'Customer Visit Count',
			'customer_last_update' => 'Customer Last Update',
			'customer_create_at' => 'Customer Create At',
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

        if($this->getScenario()=='consumption')
        {
            $criteria->alias = 't1';
            $criteria->join = 'LEFT JOIN {{order}} AS t2 ON t1.customer_id=t2.customer_id';
            $criteria->join .= ' LEFT JOIN {{currency}} AS t3 ON t2.order_currency_id=t3.currency_id';
            $criteria->select = array('customer_email', 'customer_create_at', 'SUM(IF(t2.order_grandtotal=1,t2.order_grandtotal, ROUND(t2.order_grandtotal/t3.currency_rate,1))) AS customerConsumption');
            $criteria->condition = 't2.order_valid=1';
            $criteria->group = 't2.customer_id';
            $criteria->order = 'customerConsumption DESC';
            $criteria->compare('customerConsumption', $this->customerConsumption);
        }
        

		$criteria->compare('customer_id',$this->customer_id);

		$criteria->compare('customer_email',$this->customer_email,true);

        $criteria->compare('customer_name', $this->customer_name,true);

		$criteria->compare('customer_pwd',$this->customer_pwd,true);

		$criteria->compare('customer_newsletter',$this->customer_newsletter);

		$criteria->compare('customer_active',$this->customer_active);

		$criteria->compare('customer_role',$this->customer_role);

		$criteria->compare('customer_default_address',$this->customer_default_address);

		$criteria->compare('customer_group',$this->customer_group);

		$criteria->compare('customer_ip',$this->customer_ip,true);

		$criteria->compare('customer_login',$this->customer_login,true);

		$criteria->compare('customer_visit_count',$this->customer_visit_count);

		$criteria->compare('customer_last_update',$this->customer_last_update,true);

		$criteria->compare('customer_create_at',$this->customer_create_at,true);
        
		return new CActiveDataProvider('Customer', array(
			'criteria'=>$criteria,
		));
	}

    public function beforeValidate()
    {
        if($this->isNewRecord)
        {
            $this->customer_pwd = hashPwd($this->customer_pwd);
            $this->customer_role = Lookup::CUSTOMER_ROLE_USER;
            $this->customer_name = substr($this->customer_email,0,strpos($this->customer_email,'@'));
            $this->customer_active = 1;
            $this->customer_group = CustomerGroup::CUSTOMER_DEFAULT_GROUP;
            $this->customer_default_address = 0;
            $this->customer_last_update = $this->customer_create_at = date('Y-m-j H:i:s');
        }
        return true;
    }

    public function afterSave()
    {
        if($this->isNewRecord)
        {
            //发送邮件
            $mail = new SyoSendEmail();
            $data = array(
                'hostUrl'=>Yii::app()->request->hostInfo,
                'hostName'=>Yii::app()->request->serverName,
                'name'=>$this->customer_name,
                'email'=>$this->customer_email,
                'subject'=>'Welcome to r4dsnds.com',
                'view'=>'register',
            );
            $mail->sendByRegister($data);
        }
        return true;
    }

    public function resetPassword()
	{
        $reset = new ResetPassword();
        $reset->customer_id = $this->customer_id;
        $reset->customer_email = $this->customer_email;
        $reset->password = uniqid();
        $reset->duration = 7;
        $reset->is_active = 1;
        $reset->create_at = date('Y-m-j H:i:s');
        if($reset->save())
        {
            $mail = new SyoSendEmail();
            $data = array(
                'hostUrl' => Yii::app()->request->hostInfo,
                'hostName' => Yii::app()->request->serverName,
                'name' => $this->customer_name,
                'email' => $this->customer_email,
                'password'=>$reset->password,
                'view' => 'pwd',
                'subject' => 'Reset your password',
            );
            $mail->sendByFindPwd($data);
            return true;
        }
        return false;
	}
}