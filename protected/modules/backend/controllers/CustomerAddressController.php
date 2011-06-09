<?php

class CustomerAddressController extends BackendController
{
	public function actionUpdate()
    {

        $this->htmlOption=array('class'=>'icon-head head-products','header'=>"修改用户地址信息",'button'=>array(
                  array(
                        'class'=>'scalable save',
                        'id'=>'customer-save',
                        'header'=>'保存',
                        'click'=>"$('#customer_address_form').submit()",
                  ),
        ));

        $model = $this->_load_model();

        if(isset($_POST['CustomerAddress']))
        {
            $model->attributes = $_POST['CustomerAddress'];
            if($model->save())
                $this->redirect(array('customer/update','id'=>$model->customer_id));
        }

        $this->render('update',array('model'=>$model));
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $model = $this->_load_model();
            
        }
    }

    private function _load_model()
    {
        if($model==null)
        {
            if(isset($_GET['id']))
            {
                $model = CustomerAddress::model()->findByPk($_GET['id']);

            }
            if($model==null)
            {
                throw new CHttpException(404,"The requested page does not exist!");
            }
        }
        return $model;
    }
}