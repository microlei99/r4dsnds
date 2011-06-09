<?php

class UserController extends Controller {

   
    public $layout = 'ucenter';

    public function filters() {
        return array(
            'accessControl-resetPassword',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        Yii::app()->user->setState('edit','');
        $this->render('index', array('model' => $model));
    }

    public function actionChangePassword() {
        $model = new ChangepwdForm();
        $model->setScenario('change');

        if (isset($_POST['ChangepwdForm'])) {
            $model->attributes = $_POST['ChangepwdForm'];

            if ($model->validate() && $model->change()) {
                Yii::app()->user->setFlash('password', 'Change Password Successfully');
                $this->redirect(array('changePassword'));
            }
        }

        $this->render('password', array('model' => $model));
    }

    public function actionResetPassword() {
        $model = new ChangepwdForm();

        if (isset($_POST['ChangepwdForm'])) {
            $model->attributes = $_POST['ChangepwdForm'];

            if ($model->validate() && $model->reset()) {
                //Yii::app()->user->logout();
                Yii::app()->user->setFlash('password', 'Reset Password Successfully');
                $this->redirect(array('resetPassword'));
            }
        }

        $this->render('resetpassword', array('model' => $model));
    }

    public function actionAddress() {
        $addresses = CustomerAddress::model()->findAllByAttributes(array('customer_id' => Yii::app()->user->getId()));

        $this->render('address', array(
            'addresses' => $addresses,
        ));
    }

    public function actionNewAddress() {
        $newAddress = new CustomerAddress();
        $newAddress->customer_id = Yii::app()->user->getId();

        if (isset($_POST['CustomerAddress'])) {
            $newAddress->attributes = $_POST['CustomerAddress'];
            if ($newAddress->save()) {
                $this->redirect(array('address'));
            }
        }

        $this->render('newAddress', array(
            'address' => $newAddress,
            'title' => 'Add New Address',
        ));
    }

    public function actionDeleteAddress() {
        $model = $this->_load_address();
        $customer = Customer::model()->findByPk(Yii::app()->user->getId());
        if ($model->customer_id == $customer->customer_id) {
            if ($model->address_id == $customer->customer_default_address) {
                $customer->customer_default_address = 0;
                $customer->saveAttributes(array('customer_default_address'));
            }
            if (Yii::app()->user->getState('defaultAddress') == $model->address_id) {
                Yii::app()->user->setState('defaultAddress', null);
                Yii::app()->user->setFlash('shipMessage', null);
            }
            $model->delete();
        }
        $this->redirect(array('address'));
    }

    public function actionEditAddress() {
        $model = $this->_load_address();

        if (isset($_POST['CustomerAddress'])) {
            $model->attributes = $_POST['CustomerAddress'];
            if ($model->save()) {
                $message = 'Edit Delivery Address Successfully';
                Yii::app()->user->setFlash('shipMessage', $message);
                $edit=Yii::app()->user->getState('edit');
                if (isset($_POST['refer']) && $_POST['refer'] != '')
                    $this->redirect('/checkout');
                else if($edit){
                     unset ($edit);
                     $this->redirect('/checkout');
                }   
                else {
                    $this->redirect(array('address'));
                }
            }
        }

        $this->render('newAddress', array(
            'address' => $model,
            'title' => 'Edit Address',
        ));
    }

    public function actionOrder() {
        $customer = $this->_load_model();

        $criteria = new CDbCriteria(array(
                    'condition' => 'customer_id=:cid  AND order_status!=' . Order::AwaitingPayment,
                    //'condition'=>'customer_id=:cid',
                    'params' => array(':cid' => $customer->customer_id),
                ));

        $order = Order::model()->findAll($criteria);

        $scripts = array(
            '/script/jquery-1.4.2.min.js',
            '/script/ucenter.js',
        );

        $this->_registerJsScripts($scripts);
        $this->render('order', array('orders' => $order));
    }

    public function actionViewOrder()
    {
        if (isset($_GET['salt']))
        {
            $model = Order::model()->findByAttributes(array('order_salt' => $_GET['salt'], 'customer_id' => Yii::app()->user->getId()));
            if ($model)
            {
                if ($model == null){
                    throw new CHttpException(404, "The requested page does not exist!");
                }
                if (!$ship = OrderShip::model()->findByAttributes(array('ship_order_id' => $model->order_id))){
                    $ship = new OrderShip();
                }
                $this->render('vieworder', array(
                    'model' => $model,
                    'currency' => Currency::getCurrencySymbol($model->order_currency_id),
                    'address' => $model->address,
                    'ship'=>$ship,
                ));
                exit;
            }
        }
        $this->redirect(array('order'));
    }
    
  

    private function _load_model() {
        $model = Customer::model()->findByPk(Yii::app()->user->getId());
        if ($model == null) {
            throw new CHttpException(404, "The requested page does not exist!");
        }
        return $model;
    }

    private function _load_address() {
        $model = null;
        if (isset($_GET['id'])) {
            $model = CustomerAddress::model()->findByAttributes(array(
                        'address_id' => $_GET['id'],
                        'customer_id' => Yii::app()->user->getId(),
                    ));
        }
        if ($model === null) {
            throw new CHttpException(404, "The requested page does not exist!");
        }
        return $model;
    }

}