<?php

class ZoneController extends BackendController
{
    public $menu_active = 4;
    public $sideView = 'sidebar/new';
    
	public function actionIndex()
	{
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "区域", 'button' => array(
                array(
                    'class' => 'scalable add',
                    'id' => 'zone-add',
                    'header' => '添加区域',
                    'click'=>"location.href='/backend/zone/new'",
                ),
            ));
        $model = new Zone('search');
        if (isset($_GET['Zone']))
        {
            $model->attributes = $_GET['Zone'];
        }

        $this->render('index', array('model' => $model));
	}

    public function actionNew()
    {
        $this->sideView = 'sidebar/new';
        $this->layout = 'column2';
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加区域", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'form-save',
                    'header' => '保存',
                    'click'=>"$('#zone_form').submit()",
                ),
            ));
        $model = new Zone();
        if ($_POST['Zone'])
        {
            $model->attributes = $_POST['Zone'];
            if ($model->save())
            {
                $this->redirect(array('index'));
            }
        }
        $this->render('new', array('model' => $model));
    }

    public function actionUpdate()
    {
        $this->sideView = 'sidebar/new';
        $this->layout = 'column2';
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加区域", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'form-save',
                    'header' => '保存',
                    'click'=>"$('#zone_form').submit()",
                ),
            ));
        $model = $this->_load_model();
        if ($_POST['Zone'])
        {   
            $model->attributes = $_POST['Zone'];
            if ($model->save())
            {
                $this->redirect(array('index'));
            }
        }
        
        $this->render('new', array('model' => $model));
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $this->_load_model()->delete();
        }
        else
            throw new CHttpException(400, 'Invalid request...');
    }

    private function _load_model()
    {
        if (isset($_GET['id']))
        {
            $model = Zone::model()->findByPk($_GET['id']);
        }
        if ($model == null)
        {
            throw new CHttpException(404, "The requested page does not exist!");
        }
        return $model;
    }
}