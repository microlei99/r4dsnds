<?php

class GroupController extends BackendController
{
    public $menu_active = 3;
    
	public function actionIndex()
	{

        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"成员组列表",
			'button'=>array(
                        array(
                            'class'=>'scalable save',
                            'id'=>'group-save',
                            'header'=>'增加组',
							'click'=>"location.href='/backend/group/new'",
                        ),
        ));

		$model = new CustomerGroup();

        if(isset($_GET['CustomerGroup']))
        {
            $model->attributes = $_GET['CustomerGroup'];
        }
        
		$this->render('index',array('model'=>$model));
	}

    public function actionNew()
    {
        $this->layout = '/layouts/column2';
        $this->sideView = 'sidebar/group';
        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"增加组",
			'button'=>array(
                        array(
                            'class'=>'scalable save',
                            'id'=>'group-save',
                            'header'=>'保存',
                            'click'=>"$('#group_form').submit()",
                        ),
        ));
        $model = new CustomerGroup();

        if(isset($_POST['CustomerGroup']))
        {
            $model->attributes = $_POST['CustomerGroup'];
            if($model->save())
            {
                $this->redirect(array('index'));
            }


        }

        $this->render('group',array('model'=>$model));
    }


    public function actionUpdate()
    {
        $this->layout = '/layouts/column2';
        $this->sideView = 'sidebar/group';
        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"更新",
			'button'=>array(
                        array(
                            'class'=>'scalable save',
                            'id'=>'group-save',
                            'header'=>'保存',
                            'click'=>"$('#group_form').submit()",
                        ),
        ));
        $model = $this->_load_model();

        if(isset($_POST['CustomerGroup']))
        {
            $model->attributes = $_POST['CustomerGroup'];
            if($model->save())
            {
                $this->redirect(array('index'));
            }


        }

        $this->render('group',array('model'=>$model));
    }

    private function _load_model()
    {
        if($model==null)
        {
            if(isset($_GET['id']))
            {
                $model = CustomerGroup::model()->findByPk($_GET['id']);
            }
            if($model==null)
            {
                throw new CHttpException(404,"The requested page does not exist!");
            }
        }
        return $model;
    }

	// -----------------------------------------------------------
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}