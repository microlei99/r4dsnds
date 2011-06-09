<?php

class CategoryController extends BackendController
{

    public $menu_active = 2;
    public $layout = '/layouts/column2';
    public $sideView = 'sidebar/index';

    public function actionIndex()
    {
        /* 检查是否存在分类,若不存在则跳到创建分类 */
        $pcategory = ProductCategory::model()->find(array(
                'select' => 'category_id',
                'condition' => 'category_level=1',
                'limit' => 1,
            ));
        if ($pcategory == 0)
            $this->redirect(array('createRootCategory'));
        else
            $this->redirect(array('update', 'id' => $pcategory->category_id));
    }

    public function actionCreateSubCategory()
    {
        $this->htmlOption = array('
                    class' => 'icon-head head-products', 'header' => "创建根分类",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#category_form').submit()",
                ),
            ));

        $model = new ProductCategory();
        $model->attachBehavior('seo', new SeoBehavior());
        $model->seo = $model->addSeo(false);

        if (isset($_POST['ProductCategory']) && isset($_POST['Seo']))
        {
            $model->attributes = $_POST['ProductCategory'];
            $model->seo = $model->addSeo(true, $_POST['Seo']);
            if (empty($model->seo->errors))
            {
                $model->category_seo_id = $model->seo->seo_id;

                /* 是否添加子分类 */
                if ($_POST['ProductCategory']['category_parent_id'] && $_POST['ProductCategory']['category_parent_id'] != null)
                {
                    /* 父类的ID号当做当前类的祖先号 */
                    $model->category_parent_id = $_POST['ProductCategory']['category_parent_id'];

                    $parent = ProductCategory::model()->findByPk($model->category_parent_id);
                    $model->category_level = $parent->category_level + 1;
                    $model->category_path = $parent->category_path;
                }
                else
                {
                    $model->category_parent_id = 0;
                    $model->category_path = '0';
                    $model->category_level = 1;
                }

                if ($model->save())
                    $this->redirect(array('update', 'id' => $model->category_id));
            }
        }

        session_start();
        $model->category_parent_id = $_SESSION['select_category'];

        $this->render('index', array('model' => $model));
    }

    public function actionUpdate()
    {
        if (!isset($_GET['id']))
            $this->redirect(array('index'));

        $model = $this->loadModel();
        $this->htmlOption = array(
            'class' => 'icon-head head-products', 'header' => "管理分类",
            'button' => array(
                array(
                    'class' => 'scalable delete',
                    'id' => 'category-delete',
                    'header' => '删除',
                    'click' => "var id=$('#category_id').val();
                                        if(confirm('确实要删除！！')){
                                            location.href='/backend/category/delete/id/'+id;
                                        }",
                ),
                array(
                    'class' => 'scalable save',
                    'id' => 'category-sort',
                    'header' => '分类排序',
                    'click' => "location.href='/backend/category/sort/parentID/'+$model->category_parent_id",
                ),
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存编辑',
                    'click' => "$('#category_form').submit()",
                ),
            ));

        $model->attachBehavior('seo', new SeoBehavior());
        $model->seo = $model->updateSeo($model->category_seo_id);

        if (isset($_POST['ProductCategory']) && isset($_POST['Seo']))
        {
            $model->attributes = $_POST['ProductCategory'];
            $model->seo = $model->updateSeo($model->category_seo_id, true, $_POST['Seo']);
            if (empty($model->seo->errors))
            {
                if ($model->save())
                {
                    Yii::app()->user->setFlash('message', 'The category has been saved');
                }
            }
        }

        $product = new Product();
        $product->product_category_id = $model->category_id;

        if (isset($_GET['Product']))
            $product->attributes = $_GET['Product'];

        $this->render('index', array('model' => $model, 'product' => $product));
    }

    public function actionCreateRootCategory()
    {

        $this->htmlOption = array('
                    class' => 'icon-head head-products', 'header' => "创建根分类",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#category_form').submit()",
                ),
            ));
        $model = new ProductCategory();
        $model->attachBehavior('seo', new SeoBehavior());
        $model->seo = $model->addSeo(false);

        if (isset($_POST['ProductCategory']) && isset($_POST['Seo']))
        {
            $model->attributes = $_POST['ProductCategory'];
            $model->seo = $model->addSeo(true, $_POST['Seo']);

            if ($model->seo->seo_id != null)
            {
                $model->category_seo_id = $model->seo->seo_id;
                $model->category_parent_id = 0;
                $model->category_path = '0';
                $model->category_level = 1;

                if ($model->save())
                    $this->redirect(array('update'));
            }
        }
        $this->render('index', array('model' => $model));
    }

    public function actionDelete()
    {
        $this->loadModel()->delete();
        $this->redirect(array('update'));
    }

    public function actionSort()
    {
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "分类排序");

        if (Yii::app()->request->isPostRequest && isset($_POST['order']))
        {
            $order = explode(',', $_POST['order']);
            foreach ($order as $key)
            {
                $cate = ProductCategory::model()->findByPk($key);
                $cate->category_order = ++$i;
                $cate->saveAttributes(array('category_order'));
            }
        }
        else
        {
            $condition = isset($_GET['parentID']) ? $_GET['parentID'] : 0;

            $data = new CActiveDataProvider('ProductCategory', array(
                    'pagination' => false,
                    'criteria' => array(
                        'condition' => 'category_parent_id=' . $condition,
                        'order' => 'category_order ASC,category_name ASC'
                    )
                ));
            $this->render('sort', array('data' => $data));
        }
    }

    public function actionAjaxtree()
    {
        if (!Yii::app()->request->isAjaxRequest)
            exit();

        $parent = isset($_GET['root']) ? ($_GET['root'] == 'source' ? 0 : $_GET['root']) : 0;
        $req = Yii::app()->db->createCommand(
                "SELECT m1.category_id as id, m1.category_name AS text, m2.category_id IS NOT NULL AS hasChildren "
                . "FROM {{product_category}} AS m1 LEFT JOIN {{product_category}} AS m2 ON m1.category_id=m2.category_parent_id "
                . "WHERE m1.category_parent_id = $parent "
                . "GROUP BY m1.category_id ORDER BY m1.category_id DESC"
        );
        $children = $req->queryAll();
        session_start();
        $selected = $_SESSION['select_category'];
        $imgUrl = Yii::app()->params['backendPath'] . 'images/fam_bullet_success.gif';
        if (isset($selected))
        {
            foreach ($children as $i => $item)
            {
                if ($item['id'] == $selected)
                    $children[$i]['text'] = "<a href='/backend/category/update/id/{$selected}'>{$item['text']}</a>&nbsp;&nbsp;&nbsp;" . '<img src=' . $imgUrl . ' title="选中" />';
                else
                    $children[$i]['text'] = "<a href='/backend/category/update/id/{$item['id']}'>{$item['text']}</a>&nbsp;&nbsp;&nbsp;";
            }
        }
        else
        {
            foreach ($children as $i => $item)
            {
                $del_btn = CHtml::HtmlButton('Delete', array(
                        'submit' => array("delete", 'id' => $item['id']),
                        'confirm' => "确定要删除?",
                    ));
                if ($item['id'] == 1)
                    $children[$i]['text'] = "<a href='/backend/category/update/id/1'>{$item['text']}</a>" . '<img src=' . $imgUrl . ' title="选中" />&nbsp;';
                else
                    $children[$i]['text'] = "<a href='/backend/category/update/id/{$item['id']}'>{$item['text']}</a>&nbsp;";
            }
        }

        echo str_replace('"hasChildren":"0"', '"hasChildren":false', CTreeView::saveDataAsJson($children));
    }

    protected function loadModel($pk=1)
    {
        if (isset($_GET['id']))
            $pk = $_GET['id'];

        session_start();
        $_SESSION['select_category'] = $pk;

        if ($model == null)
        {
            if (isset($pk))
                $model = ProductCategory::model()->findByPk($pk);
            if ($model == null)
                throw new CHttpException(404, "The requested page does not exist!");
        }
        return $model;
    }

}

?>