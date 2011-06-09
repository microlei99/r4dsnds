<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ChangepwdForm extends CFormModel {

    public $oldpassword;
    public $password;
    public $confirmpassword;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('oldpassword,password, confirmpassword', 'required'),
            array('oldpassword,password,confirmpassword', 'length', 'min' => 6, 'max' => 32),
            array('confirmpassword', 'compare', 'compareAttribute' => 'password'),
            array('oldpassword', 'authenticate', 'on' => 'change'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'oldpassword' => 'Old Password',
            'password' => 'New Password',
            'confirmpassword' => 'Confirm Password',
        );
    }

    public function authenticate($attribute, $params) {
        $customer = Customer::model()->findByPk(Yii::app()->user->getId());
        if ($customer) {
            if ($customer->customer_pwd != hashPwd($this->oldpassword)) {
                $this->addError('oldpassword', 'old password is incorrect');
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function change() {
        $customer = Customer::model()->findByPk(Yii::app()->user->getId());
        if ($customer) {
            $customer->customer_pwd = hashPwd($this->password);
            return $customer->save(false, array('customer_pwd'));
        }
    }

    public function reset() {
        $reset = ResetPassword::model()->findByAttributes(array('password' => $this->oldpassword));
        if ($reset) {
            if (strtotime($reset->create_at) <= strtotime("+1 week")) {
                $new = hashPwd($this->password);
                $sql = "UPDATE {{customer}} SET customer_pwd='$new' WHERE customer_id=" . $reset->customer_id;
                Yii::app()->db->createCommand($sql)->execute();
            }
            $reset->is_active = 0;
            return $reset->save();
        }
        $this->addError('oldpassword', 'reset password is incorrect');
    }

}