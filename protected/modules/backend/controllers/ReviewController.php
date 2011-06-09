<?php

class ReviewController extends BackendController
{

    public $menu_active = 2;


    public function actionIndex()
	{

        $model = $this->_load_model();

        if($model->review_product_id)
        {
            $onClick = "location.href='/backend/review/new/pid/{$model->review_product_id}'";
        }
        else
        {
            $onClick = "location.href='/backend/review/new'";
        }

        $this->htmlOption = array('
                    class'=>'icon-head head-products','header'=>"评论列表",
                    'button'=>array(
                        array(
                                'class'=>'scalable save',
                                'id'=>'product-save',
                                'header'=>'添加评论',
                                'click'=>"$onClick",
                        ),
        ));

        if(isset($_GET['ProductReview']))
        {
            $model->attributes = $_GET['ProductReview'];
        }

		$this->render('index',array('model'=>$model));
	}

    public function actionNew()
    {
        $this->htmlOption = array('
                    class'=>'icon-head head-products','header'=>"评论列表",
                    'button'=>array(
                        array(
                                'class'=>'scalable save',
                                'id'=>'product-save',
                                'header'=>'添加评论',
                                'click'=>"$('#review_form').submit()",
                        ),
        ));

        $model = $this->_load_model();

        if(isset($_POST['ProductReview']))
        {
            $model->attributes = $_POST['ProductReview'];
            $model->review_customer_id = 0;
            $model->review_product_sku = $model->product->product_sku;
            if($model->save())
            {
                $this->redirect(array('index','pid'=>$model->review_product_id));
            }
        }

        $this->render('review',array('model'=>$model));

    }

    public function actionUpdate()
    {
        $this->htmlOption = array('
                    class'=>'icon-head head-products','header'=>"评论列表",
                    'button'=>array(
                        array(
                                'class'=>'scalable save',
                                'id'=>'product-save',
                                'header'=>'修改评论',
                                'click'=>"$('#review_form').submit()",
                        ),
        ));
        $model = $this->_load_model();

        if(isset($_POST['ProductReview']))
        {
            $model->attributes = $_POST['ProductReview'];
            if($model->save())
            {
                $this->redirect(array('index','pid'=>$model->review_product_id));
            }
        }

        $this->render('review',array('model'=>$model));
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->_load_model()->delete();
            exit;
        }
    }

    private function _load_model()
    {
        if ($model == null)
        {
            $model = new ProductReview();
            if (isset($_GET['pid']))
            {
                $model->review_product_id = $_GET['pid'];
            }
            else if(isset($_GET['id']))
            {
                $model = ProductReview::model()->findByPk($_GET['id']);
                if ($model == null)
                {
                    throw new CHttpException(404, "The requested page does not exist!");
                }
            }
        }
        return $model;
    }
}