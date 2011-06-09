<?php

class ShippingController extends Controller
{
    public function actionIndex()
    {
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "货运渠道", 'button' => array(
                array(
                    'class' => 'scalable add',
                    'id' => 'carrier-add',
                    'header' => '添加渠道',
                    'click'=>"$('#carrier-form').submit()",
                ),
            ));

        $model = new Carrier();

        if (isset($_GET['Carrier']))
        {
            $model->attributes = $_GET['Carrier'];
        }

        $this->render('index', array('model' => $model));
    }

    public function actionNew()
    {
        
    }
}