<?php

class StatisticController extends BackendController
{

    public $menu_active = 7;
    
    public function actionOrder()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "订单统计",
        );

        $model = new Order();
        if(isset($_GET['Order'])){
            $model->attributes = $_GET['Order'];
        }
        $this->render('order',array('model'=>$model));
    }

    public function actionCustomerConsumption()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "客户消费统计",
        );

        $model = new Customer('consumption');
        if(isset($_GET['Customer'])){
            $model->attributes = $_GET['Customer'];
        }
        $this->render('customer',array('model'=>$model));
    }

    public function actionProduct()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "统计",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#statistic_form').submit()",
                ),
            ));

        $model = $this->_load_model();

        if (isset($_POST['ProductStatistic']))
        {
            $model->attributes = $_POST['ProductStatistic'];
            if ($model->save())
            {
                $this->redirect(array('index'));
            }
        }

        $this->render('product', array('model' => $model));
    }

    private function _load_model()
    {
        if ($model == null)
        {
            if (isset($_GET['id']))
            {
                $model = ProductStatistic::model()->findByAttributes(array('product_id' => $_GET['id']));
            }
            if ($model == null)
            {
                throw new CHttpException(404, "The requested page does not exist!");
            }
        }
        return $model;
    }

}