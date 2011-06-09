<?php

class CustomerController extends BackendController
{
    public $menu_active = 3;

	public function actionIndex()
	{
        
        $this->htmlOption=array('class'=>'icon-head head-products','header'=>"客户列表");

        $model = new Customer();

        if(isset($_GET['Customer']))
        {
            $model->attributes = $_GET['Customer'];
        }

		$this->render('index',array('model'=>$model));
	}

    public function actionUpdate()
    {

        $this->htmlOption=array('class'=>'icon-head head-products','header'=>"查看用户信息",'button'=>array(
                  array(
                        'class'=>'scalable save',
                        'id'=>'customer-save',
                        'header'=>'保存',
                        'click'=>"$('#customer_form').submit()",
                  ),
        ));
        $this->sideView ='sidebar/update';
        $this->layout = '/layouts/column2';

        $model = $this->_load_model();

        if(isset($_POST['Customer']))
        {
            $model->attributes = $_POST['Customer'];
            if($model->save())
                $this->redirect(array('index'));
        }

        $address = new CustomerAddress();
        $address->customer_id = $model->customer_id;

        /*订单*/
        $order = new Order();
        $order->customer_id = $model->customer_id;

        if(isset($_GET['Order']))
        {
            $order = new Order();
            $order->attributes = $_GET['Order'];
        }

        $cart = new Cart();
        $cart->customer_id = $model->customer_id;

        $this->render('update',array('model'=>$model,'order'=>$order,'cart'=>$cart,'address'=>$address));
    }

    public function actionView()
    {
        $this->htmlOption=array('class'=>'icon-head head-products','header'=>"查看该用户统计信息");
        
        $model = $this->_load_model();

        $order = new CActiveDataProvider('Order', array(
                    'criteria' => array(
                        'condition'=>'customer_id='.$model->customer_id,
                    ),
                ));

        $address = new CActiveDataProvider('CustomerAddress', array(
            'criteria'=>array(
                'condition'=>'customer_id='.$model->customer_id,
            )
        ));

        $this->render('view',array('model'=>$model,'order'=>$order,'address'=>$address));
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->_load_model()->delete();
        }
    }

    private function _load_model()
    {
        if($model==null)
        {
            if(isset($_GET['id']))
            {
                $model = Customer::model()->findByPk($_GET['id']);

            }
            if($model==null)
            {
                throw new CHttpException(404,"The requested page does not exist!");
            }
        }
        return $model;
    }
}