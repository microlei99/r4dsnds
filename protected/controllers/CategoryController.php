<?php

class CategoryController extends Controller
{


    public function actionIndex()
    {
        $this->breadcrumbs = array('Category');
        $this->render('index');
    }

    public function actionView()
    {
        $model = $this->_load_model();
        foreach ($model->getParents() as $key){
            $this->breadcrumbs[$key['name']] = array($key['url']);
        }
       
        //该分类的相关分类
        $categoryIDS[] = $model->category_id;
        if($model->category_level == 1){
            $categoryIDS = array_keys($model->getSubcategory($model->category_id));
        }

        $criteria = new CDbCriteria(array(
                'select' => array(
                    'product_id', 'product_name', 'product_url', 'product_status', 'product_active', 'product_orig_price', 'product_special_price',
                    'product_promotion', 'product_wholesale', 'product_short_description',
                ),
                'condition' => 'product_active=1',
            ));
        $criteria->addInCondition('product_category_id', $categoryIDS);
        $count = Product::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 16;
        $criteria->order = 'product_last_update DESC';
        $pages->applyLimit($criteria);
        $data = Product::model()->findAll($criteria);
        

        $this->_seo($model->seo->attributes);
        $this->render('view', array(
            'model' => $model,
            'data' => $data,
            'pages' => $pages,
            'categoryIDS'=>$categoryIDS,
            'currency' => Currency::getCurrency(),
        ));
    }

    private function _load_model($level=0)
    {
        if (isset($_GET['category'])){
            $model = ProductCategory::model()->findByAttributes(array('category_url' => $_GET['category']));
        }

        if ($model == null){
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }
}