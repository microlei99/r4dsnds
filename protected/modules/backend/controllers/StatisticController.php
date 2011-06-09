<?php

class StatisticController extends BackendController
{

    public $menu_active = 2;
    
    public function actionIndex()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "商品统计"
        );
        
        $model = new ProductStatistic();

        if (isset($_GET['ProductStatistic']))
        {
            $model->product_name = $_GET['ProductStatistic']['product_name'];
        }

        $this->render('index', array('model' => $model));
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