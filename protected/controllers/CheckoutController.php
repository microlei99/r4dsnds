<?php

class CheckoutController extends Controller
{

    public $layout = 'column1';

    public function actionIndex()
    {
        if (!Yii::app()->user->getState('cart'))
        {
            Yii::app()->user->setFlash('cartMessage', 'You have no product in your shopping bag.');
            $this->redirect('/shoppingcart');
        }

        if(!Yii::app()->user->getState('defaultAddress'))
        {
            Yii::app()->user->setFlash('shipMessage', 'Please select the delivery address.');
            $this->redirect('/shipping');
        }

		if(!Yii::app()->user->getState('carrier'))
		{
            Yii::app()->user->setFlash('deliveryMessage', 'Please select the delivery method.');
			$this->redirect('/shipping/delivery');
		}

        $this->breadcrumbs = array('Checkout');
        Yii::app()->user->setState('edit','This Ok');
        $this->render('index',array(
            'cart'=>Yii::app()->user->getState('cart'),
            'address'=>CustomerAddress::model()->findByPk(Yii::app()->user->getState('defaultAddress')),
            'priceSummury'=>Yii::app()->user->getState('priceSummury'),
        ));
    }

	public function actionOrder()
	{
		if (!Yii::app()->user->getState('cart'))
        {
            Yii::app()->user->setFlash('cartMessage', 'You have no product in your shopping bag.');
            $this->redirect('/shoppingcart');
        }

        if(!Yii::app()->user->getState('defaultAddress'))
        {
            Yii::app()->user->setFlash('shipMessage', 'Please select the delivery address.');
            $this->redirect('/shipping');
        }

        if(!Yii::app()->user->getState('carrier'))
        {
            $this->redirect('/shipping/delivery');
        }

		if (!isset($_POST['payment']) || !$payment = Payment::model()->findByPk($_POST['payment'])){
            $this->redirect('/checkout');
        }

		$priceSummury = Yii::app()->user->getState('priceSummury');
		$order = new Order();
		$order->customer_id = Yii::app()->user->getId();
		//$order->invoice_id
		$order->order_subtotal = $priceSummury['total'];
		$order->order_trackingtotal = $priceSummury['delivery'];
		$order->order_grandtotal = $order->order_subtotal+$order->order_trackingtotal;
		$order->order_currency_id = Currency::getCurrency();
		$order->order_payment_id = $payment->payment_id;
		$order->order_carrier_id = Yii::app()->user->getState('carrier');
		$order->order_address_id = Yii::app()->user->getState('defaultAddress');
		$order->order_ship_id = 0;
		/******二版增加discount*****/
		$order->order_discount_id = 0;
		$order->order_status = Order::AwaitingPayment;
        $order->order_valid = 0;
		$order->order_qty = 0;
		$order->order_ip = Yii::app()->request->userHostAddress;

		if($order->save())
		{
            $qty = 0;
            foreach (Yii::app()->user->getState('cart') as $key => $item)
			{
				$id = array_map('intval', explode('-', $key));
				$orderItem = new OrderItem();
				$orderItem->order_id = $order->order_id;
				$orderItem->item_product_id = $id[0];
				$orderItem->item_attribute_id = $id[1];
				$orderItem->item_product_name = $item['name'];
				$orderItem->item_qty = $item['qty'];
				$orderItem->item_price = $item['price'];
                $orderItem->item_total = $item['qty']*$item['price'];
				$orderItem->save();
                $qty+=$item['qty'];
			}
			$timestamp = getdate();
            
			$order->invoice_id = intval($timestamp['year'].$timestamp['mon'].$timestamp['mday'].$timestamp['seconds'])+$order->order_id;
			$order->order_salt = md5($order->customer_id.$order->invoice_id);
            $order->order_qty = $qty;
			$order->saveAttributes(array('invoice_id','order_salt','order_qty'));
		}

		Yii::app()->cart->removeAll();
		if($payment->payment_name=='paypal'){
			$this->redirect('/payment/paypal/pay/order/'.$order->order_salt);
		}
        elseif($payment->payment_name=='credit card'){
            $this->redirect('/payment/creditCard/pay/order/'.$order->order_salt);
        }
        else{
            $this->redirect('/checkout');
        }
	}

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
}