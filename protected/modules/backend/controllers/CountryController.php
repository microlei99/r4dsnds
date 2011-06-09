<?php

class CountryController extends BackendController
{
    public $menu_active = 4;
    public $sideView = 'sidebar/new';

	public function actionIndex()
	{
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "国家", 'button' => array(
                array(
                    'class' => 'scalable add',
                    'id' => 'country-add',
                    'header' => '添加国家',
                    'click'=>"location.href='/backend/country/new'",
                ),
        ));
        $model = new Country('search');
        if (isset($_GET['Country']))
        {
            $model->attributes = $_GET['Country'];
        }

        $this->render('index', array('model' => $model));
	}

    public function actionNew()
    {
        $this->sideView = 'sidebar/new';
        $this->layout = 'column2';
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加国家", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'form-save',
                    'header' => '保存',
                    'click'=>"$('#country_form').submit()",
                ),
            ));
        $model = new Country();
        if ($_POST['Country'])
        {
            $model->attributes = $_POST['Country'];
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
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑国家", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'form-save',
                    'header' => '保存',
                    'click'=>"$('#country_form').submit()",
                ),
            ));
        $model = $this->_load_model();
        if ($_POST['Country'])
        {
            $model->attributes = $_POST['Country'];
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
            $model = Country::model()->findByPk($_GET['id']);
        }
        if ($model == null)
        {
            throw new CHttpException(404, "The requested page does not exist!");
        }
        return $model;
    }
}