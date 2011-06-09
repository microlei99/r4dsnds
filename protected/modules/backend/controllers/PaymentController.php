<?php

class PaymentController extends BackendController
{
    public $menu_active = 6;
    
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'expression' => 'Yii::app()->user->getAdmin()==1',
            ),
            array('deny',
                'users' => array('*'),
                'message' => 'Access Denied.',
            ),
        );
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionPaypal()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products', 'header' => "Paypal设置",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'header'=>'保存',
                    'click' => "$('#paypal_form').submit()",
                ),
            ));

        $model = Payment::model()->findByAttributes(array('payment_name'=>'paypal'));

        if(isset($_POST['Payment']))
        {
            $model->attributes = $_POST['Payment'];
            if($model->save())
            {
                Yii::app()->user->setFlash('column1_message','设置成功');
            }

        }

        $this->render('paypal',array('model'=>$model));
    }
}