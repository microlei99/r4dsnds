<?php

class CreditCardController extends PayController
{
    public $postReturnField = array();

    public function filters()
    {
        return array(
            'accessControl - paymentValidate',
        );
    }

    public function actionIndex()
    {
        throw new CHttpException(404,"The requested page does not exist!");
    }

    public function actionPay()
    {
        $order = $this->_load_model();
        $this->_set_creditcard();
        $realypay = Config::items($this->module->payment);

        /*customer info*/
        $sql = 'SELECT t1.customer_name,t1.address_street,t1.address_city,t1.address_state,t2.name AS address_country,
                       t1.address_postcode,t1.address_phonenumber,t3.customer_email
                       FROM {{customer_address}} AS t1,{{country}} AS t2 ,{{customer}} AS t3
                       WHERE t1.address_country=t2.country_id AND t1.address_id=:aid AND t1.customer_id=t3.customer_id
                       AND t1.customer_id=:cid';
        $customerInfo = Yii::app()->db->createCommand($sql)
                                  ->bindValue('aid',$order->order_address_id)->bindValue('cid',$order->customer_id)
                                  ->queryRow();
        if($customerInfo)
        {
            $this->module->addField('customername',$customerInfo['customer_name']);
            $this->module->addField('country',$customerInfo['address_country']);
            $this->module->addField('state',$customerInfo['address_state']);
            $this->module->addField('city',$customerInfo['address_city']);
            $this->module->addField('address',$customerInfo['address_street']);
            $this->module->addField('postcode',$customerInfo['address_postcode']);
            $this->module->addField('tel',$customerInfo['address_phonenumber']);
            $this->module->addField('email',$customerInfo['customer_email']);
            /*billing information*/
            $this->module->addField('billcustomername',$customerInfo['customer_name']);
            $this->module->addField('billcountry',$customerInfo['address_country']);
            $this->module->addField('billstate',$customerInfo['address_state']);
            $this->module->addField('billcity',$customerInfo['address_city']);
            $this->module->addField('billaddress',$customerInfo['address_street']);
            $this->module->addField('billpostcode',$customerInfo['address_postcode']);
            $this->module->addField('billphone',$customerInfo['address_phonenumber']);
            /*product info*/
            $i = 0;
            foreach ($order->items as $key => $item)
            {
                ++$i;
                $this->module->addField('product_no['.$i.']', $item->product->product_id);
                $this->module->addField('product_name['.$i.']', $item->product->product_name_alias);
                $this->module->addField('price_unit['.$i.']', $item->item_price);
                $this->module->addField('quantity['.$i.']', $item->item_qty);
            }

            /*realypay siteid*/
            $this->module->addField('siteid',$realypay['realypay_siteid']);
            /*order number*/
            $this->module->addField('order_sn',Order::getPrefix().$order->invoice_id);
            /*shiping fee*/
            $this->module->addField('ShippingFee',$order->order_trackingtotal);
            /*currency*/
            $this->module->addField('currency',$order->currency->currency_code);
            /*return url,user can see the order detail*/
            $this->module->addField('BackUrl',$this->module->hostUrl . '/user/viewOrder/salt/' . $order->order_salt);
            /*payment detail return url*/
            $this->module->addField('returnUrl',$this->module->hostUrl.'/payment/creditCard/paymentValidate');
            /*verifyCode,this code can verify the data which post to the payment gateway is changed*/
            $verifyCode = md5($realypay['realypay_siteid'].(Order::getPrefix().$order->invoice_id).number_format($order->order_grandtotal,2).decryptKey($realypay['realypay_key']));
            $this->module->addField('verifyCode',$verifyCode);
            $this->module->logPayment(true,'PAYBEFORE',$this->module->getPaymentData());
            /*insert into realypay talbe*/
            $sql = 'SELECT realypay_id  FROM {{realypay}} WHERE realypay_orderid='.$order->order_id;
            if(!Yii::app()->db->createCommand($sql)->queryRow())
            {
                $sql = 'INSERT INTO {{realypay}} (`realypay_siteid`,`realypay_total`,`realypay_status`,`realypay_transactionid`,`realypay_verifycode`,`realypay_customerid`,`realypay_orderid`)
                    VALUES(:siteid,:total,:status,:transactionid,:verifycode,:cid,:oid)';
                Yii::app()->db->createCommand($sql)->execute(array(
                    ':siteid' => $realypay['realypay_siteid'],
                    ':total' => $order->order_grandtotal,
                    ':status' => 'unpaid',
                    ':transactionid' => '',
                    ':verifycode' => $verifyCode,
                    ':cid' => $order->customer_id,
                    ':oid' => $order->order_id
                ));
            }
            $this->render('index', array('data' => $this->module->getPaymentData()));
        }
        else{
             throw new CHttpException(404, 'The requested page does not exist.');
        }

    }

    public function actionPaymentValidate()
    {
        if(Yii::app()->getRequest()->isPostRequest)
        {
                        
			$this->_set_creditcard();
            if(($verifiedCode=$this->_validate()) || $verifiedCode==='0')
            {//when in test mode,it's return 0 not the 'test'
                $order = Order::model()->findByAttributes(array(
                    'invoice_id'=>preg_replace('/^\(.*\)(.*)/','${1}',$this->postReturnField['orderSN']),
                ));
                if ($order)
                {
                    if ($verifiedCode == 'approved' || $verifiedCode=='0'){//payment success
                        $order->order_status = Order::PaymentAccepted;
                    }
                    else if ($verifiedCode == 'refund'){
                        $order->order_status = Order::Refund;
                    }
                    else if ($verifiedCode == 'fraud'){
                        $order->order_status = Order::Fraud;
                    }
                    else if ($verifiedCode == 'pending'){
                        $order->order_status = Order::Pending;
                    }
                    else if ($verifiedCode == 'canceled'){
                        $order->order_status = Order::Canceled;
                    }
                    else if ($verifiedCode == 'unpaid'){
                        $order->order_status = Order::AwaitingPayment;
                    }
                    else if ($verifiedCode == 'error' || $verifiedCode == 'declined' || $verifiedCode == 'chargeback'){
                        $order->order_status = Order::PaymentError;
                    }
                    //else if ($verifiedCode == '0'){//风险卡交易
                        //$order->order_status = Order::Risk;
                    //}
                    $order->order_payment_at = new CDbExpression("NOW()");
                    $order->save(false, array('order_status', 'order_valid', 'order_payment_at'));
                    if ($order->order_status == Order::PaymentAccepted || $order->order_status==Order::Risk){
                        $order->paymentSuccess();
                    }
                }
            }
        }
        else{
            $this->redirect('/');
        }
    }

    /**
     * @return false if invalide,otherwise payment status will return
     */
    private function _validate()
    {
		$error = true;
        //$postReturnField = array('siteid','order_sn','total','verifyCode','verified','transactionid');
        if(is_array($_POST) && !empty($_POST) && isset($_POST['siteid'],$_POST['order_sn'],$_POST['total'],$_POST['verifyCode'],$_POST['verified'],$_POST['transactionid']))
        {
            $postReturnField['siteID'] = $_POST['siteid'];
            $postReturnField['orderSN'] = $_POST['order_sn'];
            $postReturnField['total'] = $_POST['total'];
            $postReturnField['verifyCode'] = $_POST['verifyCode'];
            $postReturnField['verified'] = $_POST['verified'];
            $postReturnField['transactionID'] = $_POST['transactionid'];

            $this->postReturnField = $postReturnField;
            //if(($this->postReturnField=array_filter($postReturnField)) && count($this->postReturnField)==6)
            //{
                $sql = 'SELECT * FROM {{realypay}} WHERE realypay_verifycode=:vcode';
                $realypayInfo = Yii::app()->db->createCommand($sql)->bindValue(':vcode', $this->postReturnField['verifyCode'])->queryRow();
                if ($realypayInfo)
                {
                    if ($this->postReturnField['siteID'] == $realypayInfo['realypay_siteid'] && fixedPrice($this->postReturnField['total']) == fixedPrice($realypayInfo['realypay_total']))
                    {
                        if (strlen($this->postReturnField['transactionID']) == 13) //realypay system number
                        {
                            $sql = "UPDATE {{realypay}} SET realypay_transactionid=:tid,realypay_status=:status,realypay_returnat=NOW() WHERE realypay_id=:pid";
                            Yii::app()->db->createCommand($sql)->execute(array(
                                ':tid' => $this->postReturnField['transactionID'],
                                ':status' => $this->postReturnField['verified'],
                                ':pid' => $realypayInfo['realypay_id']
                            ));
                            $error = false;
                            $this->module->logPayment(true, 'PAYAFTER', $this->postReturnField);
                        }
                    }
                    else
                    {
                        $this->module->errorMessage = 'return siteid or total money is incorrect';
                        $this->module->logPayment(false);
                    }
                }
                else
                {
                    $this->module->errorMessage = 'post return message from realypay is invalid';
                    $this->module->logPayment(false);
                }
            //}
        }
        return $error ? false : $this->postReturnField['verified'];
    }

    private function _set_creditcard()
    {
        $this->module->setPaymentGateway('credit card');
        $this->module->enableLog();
        $this->module->logFile = 'protected/runtime/realypay.results.log';
    }

    private function _load_model()
    {
        $model = null;
        if (isset($_GET['order']) && strlen($_GET['order'])==32)
        {
            $model = Order::model()->find(array(
                    'condition' => 'order_salt=:salt AND customer_id=:uid',
                    'params' => array(':salt' => $_GET['order'], ':uid' => Yii::app()->user->getId()),
                ));
        }
        if ($model === null){
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}