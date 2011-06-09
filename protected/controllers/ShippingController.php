<?php

class ShippingController extends Controller
{
    public $layout = 'column1';
    
	public function actionIndex()
	{
        if(!Yii::app()->user->getState('cart'))
        {
            Yii::app()->user->setFlash('cartMessage', 'You have no product in your shopping bag.');
            $this->redirect('/shoppingcart');
            exit;
        }

        $this->breadcrumbs = array('Address');

        //Address
        $defaultAddressID = Yii::app()->user->getState('defaultAddress');
        if($defaultAddressID == 0 || !CustomerAddress::model()->exists('address_id='.$defaultAddressID))
        {
            $address = new CustomerAddress();
            $address->customer_id = Yii::app()->user->getId();
            $address->address_country = 21; //USA
        }
        else{
            $address= CustomerAddress::model()->findByPk($defaultAddressID);
        }
        $addresses = CustomerAddress::model()->findAll(array(
            'condition'=>'customer_id='.Yii::app()->user->getId(),
        ));

        if(isset($_POST['CustomerAddress']) && isset($_POST['addresslist']))
        {
            $redirect = true;
            Yii::app()->user->setState('defaultAddress',$_POST['addresslist']);
            if($_POST['addresslist'] == -1)
            {
                $address->attributes = $_POST['CustomerAddress'];
                if ($address->save()){
                    Yii::app()->user->setState('defaultAddress',$address->address_id);
                }
                else{
                    $redirect = false;
                }
            }
            if($redirect){
                $this->redirect(array('delivery'));
            }
        }


		$this->render('index',array(
            'defaultAddressID'=> $defaultAddressID,
            'addresses' => $addresses,
            'address' => $address,
        ));
	}

    public function actionDelivery()
    {
		
		if(!Yii::app()->user->getState('cart'))
        {
            Yii::app()->user->setFlash('cartMessage', 'You have no product in your shopping bag.');
            $this->redirect('/shoppingcart');
        }

        if(!Yii::app()->user->getState('defaultAddress'))
        {
            Yii::app()->user->setFlash('shipMessage', 'Please select the delivery address.');
            $this->redirect('/shipping');
        }

        $this->breadcrumbs = array('Delivery');

		$deliveryMethod = array();
		$deliveries = Carrier::model()->active()->findAll();
		foreach($deliveries as $delivery)
		{
		    $deliveryMethod[$delivery->carrier_id]['name'] = $delivery->carrier_name;
			$deliveryMethod[$delivery->carrier_id]['description'] = $delivery->carrier_description;
			$deliveryMethod[$delivery->carrier_id]['price'] = Product::decoratePrice($delivery->carrier_fee);
		}

        $this->render('delivery',array(
			'deliveries'=>$deliveryMethod,
			'select'=>Yii::app()->user->getState('carrier'),
		));
    }

	public function actionSetDelivery()
	{
		if(Yii::app()->user->getState('cart'))
        {
            if(Yii::app()->user->getState('defaultAddress'))
            {
                $carrierID = intval($_POST['carrier']);
                if ($carrierID && $carrier = Carrier::model()->findByPk($carrierID))
                {
                    $priceSummury = Yii::app()->user->getState('priceSummury');
                    $priceSummury['delivery'] = Product::decoratePrice($carrier->carrier_fee, false);
                    Yii::app()->user->setState('priceSummury', $priceSummury);
                    Yii::app()->user->setState('carrier', $carrierID);
                    $this->redirect('/checkout');
                }
                else{
                    Yii::app()->user->setFlash('deliveryMessage', 'Please select the delivery method.');
                    $this->redirect('/shipping/delivery');
                }
            }
            else
            {
                Yii::app()->user->setFlash('shipMessage', 'Please select the delivery address.');
                $this->redirect('/shipping');
            }
        }
        Yii::app()->user->setFlash('cartMessage', 'You have no product in your shopping bag.');
		$this->redirect('/shoppingcart');
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