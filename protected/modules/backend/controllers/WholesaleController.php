<?php

class WholesaleController extends BackendController
{

    public $menu_active = 2;

	public function actionIndex()
	{
        $onClick = "location.href='/backend/wholesale/new'";
        $model = new Wholesale();
        
        if(isset($_GET['pid']))
        {
            $model->wholesale_product_id = $_GET['pid'];
            $onClick = "location.href='/backend/wholesale/new/pid/{$_GET['pid']}'";
        }

        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "批发列表",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'product-save',
                    'header' => '添加批发商品',
                    'click' => "$onClick",
                ),
            ));

        

        if(isset($_GET['Wholesale']))
        {
            $model->attributes = $_GET['Wholesale'];
            $model->product_name = $_GET['Wholesale']['product_name'];
            $model->product_sku = $_GET['Wholesale']['product_sku'];
        }
        
        $this->render('index',array('model'=>$model));
	}

    public function actionNew()
    {

        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "添加商品批发",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#wholesale_form').submit()",
                ),
            ));

        $model = new Wholesale();
        if(isset($_GET['pid']))
        {
            if(Product::model()->exists(array('product'=>$_GET['pid'])))
            {
                $model->wholesale_product_id = $_GET['pid'];
            }
            else
            {
                throw new CHttpException(404, "The Product does not exist!");
            }
            
        }

        

        if(isset($_POST['Wholesale']))
        {
            $model->attributes = $_POST['Wholesale'];

            $model->wholesale_product_id = $_POST['product_id'];

            
            if($model->save())
            {
                $this->redirect(array('index'));

            }
        }

        $this->render('wholesale',array('wholesale'=>$model));
    }

    public function actionUpdate()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "修改批发规则",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#wholesale_form').submit()",
                ),
            ));

        $model = $this->_load_model();

        if(isset($_POST['Wholesale']))
        {
            $model->attributes = $_POST['Wholesale'];

            $model->wholesale_product_id = $_POST['product_id'];


            if($model->save())
            {
                $this->redirect(array('index'));

            }
        }


        $this->render('wholesale',array('product'=>$product,'wholesale'=>$model));
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->_load_model()->delete();
        }
    }

    private function _load_model()
    {
        if($model==null)
        {
            if(isset($_GET['id']))
            {
                $model = Wholesale::model()->findByPk($_GET['id']);
                if ($model == null)
                {
                    throw new CHttpException(404, "The requested page does not exist!");
                }
            }
        }
        return $model;
    }

}