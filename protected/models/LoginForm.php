<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

    public $email;
    public $password;
    public $rememberMe = true;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('email, password', 'required'),
            array('email', 'email'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate', 'skipOnError' => true),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'email' => 'Email',
            'password' => 'Password',
            'rememberMe' => 'Remember me next time',
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new SyoIdentity($this->email, $this->password);
            $this->_identity->authenticate();
            switch ($this->_identity->errorCode) {
                case SyoIdentity::ERROR_EMAIL_INVALID:
                    $this->addError('email', 'Email is incorrect.');
                    break;
                case SyoIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password', 'Password is incorrect.');
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new SyoIdentity($this->email, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === SyoIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 5184000 : 0; // 60 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }

}