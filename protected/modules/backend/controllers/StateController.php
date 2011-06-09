<?php

class StateController extends BackendController
{
    public $menu_active = 4;
    public $sideView = 'sidebar/new';
    
	public function actionIndex()
	{
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "州", 'button' => array(
                array(
                    'class' => 'scalable add',
                    'id' => 'states-add',
                    'header' => '添加州',
                    'click'=>"location.href='/backend/state/new'",
                ),
            ));
        $model = new State('search');
        if (isset($_GET['State']))
        {
            $model->attributes = $_GET['State'];
        }
        $this->render('index', array('model' => $model));
	}

    public function actionNew()
    {
        $this->sideView = 'sidebar/new';
        $this->layout = 'column2';
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加州", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'form-save',
                    'header' => '保存',
                    'click'=>"$('#states_form').submit()",
                ),
            ));
        $model = new State();
        if ($_POST['State'])
        {
            $model->attributes = $_POST['State'];
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
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加州", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'form-save',
                    'header' => '保存',
                    'click'=>"$('#states_form').submit()",
                ),
            ));
        $model = $this->_load_model();
        if ($_POST['State'])
        {
            $model->attributes = $_POST['State'];
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
            $model = State::model()->findByPk($_GET['id']);
        }
        if ($model == null)
        {
            throw new CHttpException(404, "The requested page does not exist!");
        }
        return $model;
    }

}