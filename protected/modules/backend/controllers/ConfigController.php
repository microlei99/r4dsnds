<?php

class ConfigController extends BackendController
{
    public $menu_active = 6;
    
	public function actionSethotsearch()
	{
		$this->htmlOption = array('class' => 'icon-head head-products', 'header' => "搜索热词", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'config-save',
                    'header' => '添加',
                    'click' => "location.href='/backend/config/newhotsearch'",
                ),
        ));
		$model = new HotSearch();

        if(isset($_GET['HotSearch']))
        {
            $model->attributes = $_GET['HotSearch'];
        }
        
		$this->render('hotsearch',array('model'=>$model));
	}

    public function actionNewhotsearch()
    {
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加搜索热词", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'config-save',
                    'header' => '保存',
                    'click' => "$('#hotsearch_form').submit()",
                ),
        ));
        $model = new HotSearch();
        if(isset($_POST['HotSearch']))
        {
            $model->attributes = $_POST['HotSearch'];
            if($model->save())
            {
                $this->redirect(array('sethotsearch'));
            }
        }
        $this->render('opt_hotsearch',array('model'=>$model));
    }

    public function actionUpdatehotsearch()
    {
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "更新搜索热词", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'config-save',
                    'header' => '保存',
                    'click' => "$('#hotsearch_form').submit()",
                ),
        ));
        $model = $this->_load_model('hotsearch');
        if(isset($_POST['HotSearch']))
        {
            $model->attributes = $_POST['HotSearch'];
            if($model->save())
            {
                $this->redirect(array('sethotsearch'));
            }
        }
        $this->render('opt_hotsearch',array('model'=>$model));
    }

    public function actionDeletehotsearch()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->_load_model('hotsearch')->delete();
        }
    }

    private function _load_model($type)
    {
        switch ($type)
        {
            case 'hotsearch':
                $model = HotSearch::model()->findByPk($_GET['id']);
                break;
        }
            
        if ($model == null) {
            throw new CHttpException(404, "The requested page does not exist!");
        }
        
        return $model;
    }
}