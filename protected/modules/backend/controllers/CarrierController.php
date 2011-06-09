<?php

class CarrierController extends BackendController
{
    public $menu_active = 4;
    
	public function actionIndex()
	{
		$this->htmlOption = array('class' => 'icon-head head-products', 'header' => "货运渠道", 'button' => array(
                array(
                    'class' => 'scalable add',
                    'id' => 'carrier-add',
                    'header' => '添加货运渠道',
                    'click'=>"location.href='/backend/carrier/new'",
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
        $this->sideView = 'sidebar/new';
        $this->layout = 'column2';

        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加货运渠道", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'form-save',
                    'header' => '保存',
                    'click'=>"$('#carrier_form').submit()",
                ),
            ));
        
        $model = new Carrier();

        if ($_POST['Carrier'])
        {
            $model->attributes = $_POST['Carrier'];
            if ($model->save())
            {
                if ($_POST['carrier_zone'])
                {
                    CarrierZone::addment($model->carrier_id, $_POST['carrier_zone']);
                }
                $this->redirect(array('index'));
            }
        }

        if ($_POST['carrier_zone'])
        {
            $zones = $_POST['carrier_zone'];
        }
        
        $this->render('new', array('model' => $model, 'zones' => $zones));
    }

    public function actionUpdate()
    {
        $this->sideView = 'sidebar/new';
        $this->layout = 'column2';
        
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑货运渠道", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'form-save',
                    'header' => '保存',
                    'click'=>"$('#carrier_form').submit()",
                ),
            ));

        $model = $this->_load_model();

        if ($_POST['Carrier'])
        {
            $model->attributes = $_POST['Carrier'];
            if ($model->save())
            {
                if ($_POST['carrier_zone'])
                {
                    CarrierZone::updateHook($model->carrier_id, $_POST['carrier_zone']);
                }
                $this->redirect(array('index'));
            }
        }

        $zones = $_POST['carrier_zone'] ? $_POST['carrier_zone'] : CarrierZone::getZones($model->carrier_id);


        $this->render('new', array('model' => $model, 'zones' => $zones));
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {

            $this->_load_model()->delete();

            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request...');
    }

    private function _load_model()
    {
        if (isset($_GET['id']))
        {
            $model = Carrier::model()->findByPk($_GET['id']);
        }
        if ($model == null)
        {
            throw new CHttpException(404, "The requested page does not exist!");
        }
        return $model;
    }
}