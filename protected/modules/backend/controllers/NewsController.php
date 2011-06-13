<?php

class NewsController extends BackendController
{
    public $menu_active = 5;
	public function actionIndex()
	{
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "新闻列表",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '添加',
                    'click' => "location.href='/backend/news/create'",
                ),
            ));
        $model = new News();
		$this->render('index',array('model'=>$model));
	}

    public function actionCreate()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "添加新闻",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#news_form').submit()",
                ),
            ));

        $model = new News();
        $model->news_author = 'administrator';
        $model->category = array();

        if(Yii::app()->getRequest()->isPostRequest)
        {
            if (isset($_POST['News']))
            {
                $model->attributes = $_POST['News'];
                $model->validate();
            }
            
            if (isset($_POST['category']) && is_array($_POST['category'])){
                $model->category['add'] = $_POST['category'];
            }
            else{
                $model->addError('category', '分类不能为空');
            }

            if (!$model->hasErrors())
            {
                if($model->save(false)){
                    $this->redirect(array('index'));
                }
            }
        }

        $tree = $model->constructCategoryTree($model->category);

        $this->render('create',array(
            'model'=>$model,
            'tree'=>$tree,
        ));
    }

    public function actionUpdate()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "新闻更新",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#news_form').submit()",
                ),
            ));
        $model = $this->_loadModel();
        if(Yii::app()->getRequest()->isPostRequest)
        {
            if (isset($_POST['News']))
            {
                $model->attributes = $_POST['News'];
                $model->validate();
            }

            if (isset($_POST['category']) && is_array($_POST['category']))
            {
                $model->category['sub'] = array_diff($model->category,$_POST['category']);
                $model->category['add'] = array_diff($_POST['category'],$model->category);
            }
            else{
                $model->addError('category', '分类不能为空');
            }

            if (!$model->hasErrors())
            {
                if($model->save(false)){
                    $this->redirect(array('index'));
                }
            }
        }
        $tree = $model->constructCategoryTree($model->category);

        $this->render('create',array(
            'model'=>$model,
            'tree'=>$tree,
        ));
    }

    private function _loadModel()
    {
        $model = '';
        if(isset($_GET['id']) && preg_match('/^\d+/',$_GET['id'])){
            $model = News::model()->findByPk($_GET['id']);
        }
        if($model)
        {
            /*分类*/
            $sql = "SELECT news_category_id FROM {{news_category}} WHERE news_id=:nid";
            $res = Yii::app()->db->createCommand($sql)->bindValue(':nid',$model->news_id)->queryAll();
            foreach($res as $item){
                $model->category[] = $item['news_category_id'];
            }
            unset($res,$sql);
        }
        else{
            throw new CHttpException(404,"The requested page does not exist!");
        }
        return $model;
    }
}