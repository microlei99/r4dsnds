<?php
class SyoIdentity extends CBaseUserIdentity
{
    const ERROR_EMAIL_INVALID = 3;

    public $email;

    public $name;

    public $password;

    public $id;

    public function __construct($email,$password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticate()
    {
        $customer = Customer::model()->findByAttributes(array('customer_email'=>  $this->email));
        if($customer != null)
        {
            if($customer->customer_pwd == hashPwd($this->password))
            {
                $this->setState('role',$customer->lookup->lookup_code);
                $this->setState('email', $customer->customer_email);
                if($customer->customer_default_address!=0){
                    $this->setState('defaultAddress', $customer->customer_default_address);
                }
                
                $this->id = $customer->customer_id;
                $this->name = $customer->customer_name;

                $customer->customer_ip = Yii::app()->request->userHostAddress;
                $customer->customer_login = date('Y-m-j H:i:s');
                $customer->customer_visit_count++;
                $customer->saveAttributes(array(
                    'customer_ip'=>$customer->customer_ip,
                    'customer_login'=>$customer->customer_login,
                    'customer_visit_count'=>$customer->customer_visit_count
                ));
                $this->errorCode=self::ERROR_NONE;
            }
            else
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else
            $this->errorCode = self::ERROR_EMAIL_INVALID;

		return !$this->errorCode;
    }

    public function  getId()
    {
        return $this->id;
    }

    public function  getName()
    {
        return $this->name;
    }
}
?>
