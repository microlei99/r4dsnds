<?php

class PaypalController extends PayController
{

    public $ipnData;
    public $ipnResponse;

    public function filters()
    {
        return array(
            'accessControl - ipnValidate',
        );
    }

    public function actionIndex()
    {
        throw new CHttpException(404,"The requested page does not exist!");
    }

    public function actionPay()
    {
        $order = $this->_load_model();

        $this->_set_paypal();

        $this->module->addField('business', $order->payment->payment_username);
        $this->module->addField('cmd', '_cart');
        $this->module->addField('upload', 1);
        $this->module->addField('custom', $order->order_id);
        $this->module->addField('invoice', Order::getPrefix().$order->invoice_id);
        $this->module->addField('return', $this->module->hostUrl . '/user/viewOrder/salt/' . $order->order_salt);
        $this->module->addField('cancel_return', $this->module->hostUrl);
        $this->module->addField('notify_url', $this->module->hostUrl . '/payment/paypal/ipnValidate');
        $this->module->addField('currency_code', $order->currency->currency_code);
        $i = 0;
        foreach ($order->items as $key => $item)
        {
            ++$i;
            $this->module->addField('item_name_' . $i, $item->product->product_name_alias);
            $this->module->addField('amount_' . $i, $item->item_price);
            $this->module->addField('quantity_' . $i, $item->item_qty);
        }
        /* 挂号费 */
        ++$i;
        $this->module->addField('item_name_' . $i, 'tracking number fee');
        $this->module->addField('amount_' . $i, $order->order_trackingtotal);
        $this->module->addField('quantity_' . $i, 1);
        /*         * * */

        $this->module->addField('uid', 1);
        $this->module->addField('cbt', 'Return to shop');
        $this->module->addField('rm', 1);

        $this->module->logPayment(true, 'PAYBEFORE', $this->module->getPaymentData());
        $this->render('index', array('data' => $this->module->getPaymentData()));
    }

    public function actionIpnValidate()
    {
        if (Yii::app()->request->isPostRequest)
        {
            if ($this->_ipnValidate())
            {
                //if($this->ipnData['payment_status']=='Completed')
                //{
                // code here
				$this->ipnData['invoice'] = preg_replace('/^\(.*\)/','',$this->ipnData['invoice']);
                if ($order = Order::model()->findByAttributes(array('invoice_id' => $this->ipnData['invoice'])))
                {
                    $response = new PaypalResponse();
                    $response->response_invoice_id = $this->ipnData['invoice'];
                    $response->response_payer_id = $this->ipnData['payer_id'];
                    $response->response_payment_status = $this->ipnData['payment_status'];
                    $response->response_payment_type = $this->ipnData['payment_type'];
                    $response->response_txn_id = $this->ipnData['txn_id'];
                    $response->response_mc_gross = $this->ipnData['mc_gross'];
                    $response->response_mc_fee = $this->ipnData['mc_fee'];
                    $response->response_real_fee = $this->ipnData['mc_gross'] - $this->ipnData['mc_fee'];
                    $response->response_payer_email = $this->ipnData['payer_email'];
                    $response->response_payer_status = $this->ipnData['payer_status'];
                    $response->response_mc_currency = $this->ipnData['mc_currency'];
                    $response->customer_id = $order->customer_id;
                    $response->order_id = $order->order_id;
                    $response->save();

                    //订单处理
                    if ($this->ipnData['receiver_email'] == $order->payment->payment_username)
                    {
                        if ($this->ipnData['mc_currency'] == $order->currency->currency_code &&
                            fixedPrice($this->ipnData['mc_gross']) == fixedPrice($order->order_grandtotal))
                        {
                            if ($this->ipnData['payment_status'] == 'Completed')
                            {
                                $order->order_status = Order::PaymentAccepted;
                            }
                            else if ($this->ipnData['payment_status'] == 'Pending')
                            {
                                $order->order_status = Order::Pending;
                            }
                            else if ($this->ipnData['payment_status'] == 'Canceled')
                            {
                                $order->order_status = Order::Canceled;
                            }
                            $order->order_payment_at = new CDbExpression("NOW()");
                        }
                        else
                        {
                            $order->order_status = Order::PaymentError;
                        }
                    }
                    else
                    {
                        $order->order_status = Order::PaymentError;
                    }
                    $order->save(false,array('order_status','order_valid','order_payment_at'));
                    if ($order->order_status == Order::PaymentAccepted)
                    {
                        $order->paymentSuccess();
                    }
                }
                //}
            }
        }
        else
        {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    private function _ipnValidate()
    {
        $this->_set_paypal();
        $urlParsed = parse_url($this->module->getPaymentUrl());
        $postString = '';

        foreach ($_POST as $field => $value)
        {
            $this->ipnData[$field] = $value;
            $postString .= $field . '=' . urlencode(stripslashes($value)) . '&';
        }

        $postString .="cmd=_notify-validate"; // append ipn command


        $fp = fsockopen($urlParsed['host'], 80, $errNum, $errStr, 30);
        if (!$fp)
        {
            $this->module->errorMessage = "fsockopen error no. $errno: $errStr";
            $this->module->logPayment(true);
        }
        else
        {
            fputs($fp, "POST {$urlParsed['path']} HTTP/1.1\r\n");
            fputs($fp, "Host: {$urlParsed['host']}\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: " . strlen($postString) . "\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $postString . "\r\n\r\n");
            while (!feof($fp))
            {
                $this->ipnResponse .= fgets($fp, 1024);
            }
            fclose($fp); // close connection

            if (eregi("VERIFIED", $this->ipnResponse))
            {
                $this->module->logPayment(true, 'PAYAFTER', $this->ipnData);
                return true;
            }
            else
            {
                $this->module->errorMessage = "IPN Validation Failed . {$urlParsed['host']} : {$urlParsed['path']}";
                $this->logPayment(true);
                return false;
            }
        }
    }

    private function _set_paypal()
    {
        $this->module->setPaymentGateway('paypal');
        $this->module->enableLog();
        $this->module->logFile = 'protected/runtime/paypal.ipn_results.log';
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
        if ($model === null)
        {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}