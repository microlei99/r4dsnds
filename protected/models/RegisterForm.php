<?php
class RegisterForm extends CFormModel
{
    public $email;

    public $password;

    public $confirmPassword;

    public $newsletter=1;

    public function rules()
    {
        return array(
            array('email,password,confirmPassword,newsletter','required'),
            array('password,confirmPassword', 'length','min'=>6,'max'=>32),
            array('email','email'),
            array('confirmPassword','compare','compareAttribute'=>'password','message'=>'Passwords must match!'),
            array('email','unique','className'=>'backend.models.Customer','attributeName'=>'customer_email','message'=>'The email has already been taken.'),
            array('newsletter', 'boolean'),
        );
    }

    public function  attributeLabels()
    {
        return array(
            'email'=>'Email',
            'password'=>'Password',
            'confirmPassword'=>'Confirm Password',
            'newsletter' => 'Newsletter'
        );
    }

    public function register()
    {
        $model = new Customer();
        $model->customer_email = $this->email;
        $model->customer_pwd = $this->password;
        $model->customer_newsletter = $this->newsletter;
        if($model->save())
        {
            if($this->newsletter = 1)
            {
                $subscription = new Subscription();
                $subscription->email = $this->email;
                $subscription->save();
            }
            return true;
        }
        return false;
    }
}
?>