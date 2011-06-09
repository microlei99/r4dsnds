<?php

class PaymentModule extends CWebModule
{
    public $payment = 'paypal';

    public $enableLog = false;
    
	public $logFile = 'payment.log';

    public $errorMessage;

    public $paymentData = array();

    public $hostUrl;
    
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'payment.models.*',
			'payment.components.*',
		));
	}

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here

            //var_dump($this->module);exit;
            $this->hostUrl = 'http://www.r4dsnds.com';

            return true;
        }
        else
            return false;
    }

    public function addField($name,$value)
	{
        $this->paymentData[$name] = $value;
	}

    public function getPaymentUrl()
    {
        switch($this->getPayment()->payment_name)
        {
            case 'paypal':
                $url = ($this->isTestMode() == 1) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
                break;
            default:
                $url = ($this->isTestMode() == 1) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
        }
        return $url;
    }

    public function getPaymentServer()
    {
        switch($this->getPayment()->payment_name)
        {
            case 'paypal':
                $server = ($this->isTestMode() == 1) ? 'www.sandbox.paypal.com' : 'www.paypal.com';
                break;
            default:
                $server = ($this->isTestMode() == 1) ? 'www.sandbox.paypal.com' : 'www.paypal.com';
        }
        return $server;
    }

    public function getPayment()
    {
        return Payment::model()->findByAttributes(array('payment_name'=>$this->payment));
    }

    public function setPaymentGateway($gateway)
    {
        $this->payment = $gateway;
    }

    public function getPaymentGateway()
    {
        return $this->payment;
    }

    public function enableLog()
    {
        $this->enableLog = true;
    }

    public function disableLog()
    {
        $this->enableLog = false;
    }

    public function getPaymentData()
    {
        return $this->paymentData;
    }

    public function isTestMode()
    {
        return $this->getPayment()->payment_test;
    }

    public function logPayment($success=false, $logtype='PAYBEFORE', $log=array())
    {
        if (!$this->enableLog)
            return false;

        $message = "\r\n" . '[' . date('Y-m-j H:i:s') . ']' . '  PAYMENT GATEWAY:' . $this->payment;
        $message .= '  RESULT : ' . ($success == true ? 'success' : 'failed') . "\r\n";
        if ($success)
        {
            switch ($logtype)
            {
                case 'PAYBEFORE':
                    $message .= "PAY BEFORE Post Paramater:\n";
                    break;
                case 'PAYAFTER':
                    $message .= 'PAY AFTER Returned Paramater' . "\n";
                    break;
            }

            foreach ($log as $key => $val)
            {
                $message .= $key . ' : ' . $val . "\n";
            }
        }
        else
            $message .= 'Error Message : ' . $this->errorMessage;

        file_put_contents($this->logFile, $message, FILE_APPEND);
        return true;
    }
}