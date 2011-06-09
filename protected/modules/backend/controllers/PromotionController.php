<?php

class PromotionController extends BackendController
{
    public $menu_active = 2;
    
	public function actionIndex()
	{
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "促销列表",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '添加促销商品',
                    'click' => "location.href='/backend/promotion/new'",
                ),
         ));
        
        $model = new Promotion();

        if(isset($_GET['Promotion']))
        {
            $model->attributes = $_GET['Promotion'];
            $model->product_name = $_GET['Promotion']['product_name'];
            $model->product_sku = $_GET['Promotion']['product_sku'];
        }
        $this->render('index',array('model'=>$model));
	}

    public function actionOpen()
    {
        $product = $this->_load_model();
        
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "开启促销",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#promotion_form').submit()",
                ),
            ));

        $promotion = Promotion::model()->findByAttributes(array('promotion_product_id'=>$product->product_id));
        if(!$promotion)
        {
            $promotion = new Promotion();
            $promotion->promotion_product_id = $product->product_id;
            $promotion->promotion_status = Promotion::PROMOTION_ACTIVE;
        }

        if(isset($_POST['Promotion']))
        {
            $promotion->attributes = $_POST['Promotion'];
            
            if($promotion->save())
            {
                $this->redirect(array('index'));
                
            }
        }
        $this->render('promotion',array('product'=>$product,'promotion'=>$promotion));
    }

    public function actionClose()
    {
        $product = $this->_load_model();

        $promotion = Promotion::model()->findByAttributes(array('promotion_product_id'=>$product->product_id));

        $promotion->promotion_status = Promotion::PROMOTION_CLOSED;

        if($promotion->save())
        {
            $this->redirect(array('product/index'));
        }
    }

    public function actionNew()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "添加促销商品",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#promotion_form').submit()",
                ),
            ));

        $promotion = new Promotion();
        $promotion->promotion_status = Promotion::PROMOTION_ACTIVE;

        if(isset($_POST['Promotion']))
        {
            $promotion->attributes  = $_POST['Promotion'];
            $promotion->promotion_product_id = $_POST['product_id'];
            if($promotion->save())
            {
                 $this->redirect(array('index'));
            }
            
        }


        $this->render('new',array('promotion'=>$promotion));
    }

    public function actionUpdate()
    {
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "更新促销",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#promotion_form').submit()",
                ),
            ));
        $promotion = $this->_load_model();
        $product = Product::model()->findByPk($promotion->promotion_product_id);
        if(isset($_POST['Promotion']))
        {
            $promotion->attributes = $_POST['Promotion'];
            if($promotion->save())
            {
                $this->redirect(array('index'));
            }
        }
        $this->render('promotion',array('product'=>$product,'promotion'=>$promotion));
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
            if(isset($_GET['pid']))
            {
                $model = Product::model()->findByPk($_GET['pid']);
            }
            elseif(isset($_GET['id']))
            {
                $model = Promotion::model()->findByPk($_GET['id']);
            }
            if($model==null)
            {
                throw new CHttpException(404,"The requested page does not exist!");
            }
        }
        return $model;
    }
}