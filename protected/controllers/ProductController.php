<?php

class ProductController extends Controller
{
    public $layout = 'column2';
    
	public function actionView()
	{
        $model = $this->_load_model();
        foreach ($model->category->getParents() as $key){
            $this->breadcrumbs[$key['name']] = array($key['url']);
        }

        ProductStatistic::Statistic($model->product_id,array('viewed'=>1));

        $images = ProductImage::model()->findAllByAttributes(array(
            'image_product_id'=>$model->product_id,
            'image_used'=>1
        ));

        $this->_registerJsScript('/script/product.js');
        $this->_seo($model->seo->attributes);
		$this->render('view',array(
            'model'=>$model,
            'images'=>$images,
            'wholesale' => $model->getWholesale(),
			'currency'=>  Currency::getCurrency(),
        ));
	}

    private function _load_model()
    {
        if(isset($_GET['product']))
        {
            $model = Product::model()->findByAttributes(array('product_url'=>$_GET['product']));
        }
       
        if($model==null)
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }
        
        return $model;
    }
}