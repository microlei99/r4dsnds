<?php

class ProductController extends BackendController
{

    public $menu_active = 2;
    public $layout = '/layouts/column2';

    public function filters()
    {
        return array(
            'accessControl-uploadImage',
        );
    }

    public function actionIndex()
    {
        $this->htmlOption = array('
                    class' => 'icon-head head-products', 'header' => "商品列表",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'product-save',
                    'header' => '添加商品',
                    'click' => "location.href='/backend/product/new'",
                ),
            ));
        $model = new Product();
        if (isset($_GET['Product']))
        {
            $model->attributes = $_GET['Product'];
        }

        $this->layout = '/layouts/column1';
        $this->render('index', array('product' => $model));
    }

    public function actionNew()
    {
        $this->sideView = 'sidebar/new_one';
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "增加商品",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#product_form').submit()",
                ),
            ));
        $model = new Product();
        $model->product_active = 0;
        $model->attachBehavior('seo', new SeoBehavior());
        $model->seo = $model->addSeo(false);


        $defauluGroup = AttributeGroup::model()->default()->find();

        $attributes = Attribute::model()->findAllByAttributes(array('attribute_group_id' => $defauluGroup->group_id));

        if (!empty($attributes))
        {
            foreach ($attributes as $key)
            {
                $attr[$key->attribute_id]['attribute'] = $key->attribute_name;
            }
            $model->attachBehavior('attribute', new AttributeBehavior());
        }



        if (isset($_POST['Product']))
        {
            $model->attributes = $_POST['Product'];
            $model->seo->attributes = $_POST['Seo'];

            $error[] = $model->validate();
            $error[] = $model->seo->validate();

            /* 检测属性值是否合法，显示用属性value，存库用属性ID */
            $attributeError = true;
            if (!empty($attributes))
            {
                $attrValidated = $model->validateAttributes($_POST['attributes']);
                $attributeError = $attrValidated['error'];
                unset($attrValidated['error']);
                foreach ($attr as $i => $j)
                {
                    $attr[$i] = array_merge($attr[$i], $attrValidated[$i]);
                }
            }

            /* 数据验证通过 */
            if (array_sum($error) == 2 && $attributeError)
            {
                $model->seo = $model->addSeo(true, $_POST['Seo']);

                $model->product_seo_id = $model->seo->seo_id;
                $model->save(false);

                /* 产品属性 */
                if (!empty($attributes))
                {
                    foreach ($attr as $key => $value)
                    {
                        foreach (explode(',', $value['valueID']) as $j)
                        {
                            $atttmodel = new ProductAttribute();
                            $atttmodel->attribute_id = $key;
                            $atttmodel->attribute_product_id = $model->product_id;
                            $atttmodel->attribute_value_id = $j;
                            $atttmodel->attribute_group_id = $defauluGroup->group_id;
                            $atttmodel->save();
                        }
                    }
                }

                Yii::app()->user->setFlash('message', 'The product has been saved');
            }
        }

        if (isset($_POST['Product']['product_category_id']))
            $tree = $model->constructCategoryTree($_POST['Product']['product_category_id']);
        else
            $tree=$model->constructCategoryTree($model->product_category_id);

        $this->render('new-one', array(
            'model' => $model,
            'tree' => $tree,
            'attributes' => $attr,
            'defaultGroup' => $defauluGroup->group_name
        ));
    }

    public function actionUpdate()
    {
        $this->sideView = 'sidebar/update_one';
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "更新",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'product-save',
                    'header' => '保存',
                    'click' => "if($('#product_image_content input:radio:checked').size()==0){alert('请选择商品默认图片');return false;}
                                      $('#product_form').submit();",
                ),
            ));
        $model = $this->_load_model();
        $model->attachBehavior('seo', new SeoBehavior());

        $image = new ProductImage();
        $image->image_product_id = $model->product_id;

        $defaultGroup = AttributeGroup::model()->default()->find();
        $attributes = ProductAttribute::model()->findAllByAttributes(array('attribute_product_id' => $model->product_id));
        /* 初始化属性 */
        if (!empty($attributes))
        {
            foreach ($attributes as $key)
            {
                $attr[$key->attribute_id]['attribute'] = $key->attr->attribute_name;
                $attr[$key->attribute_id]['value'] .= $key->attrvalue->attribute_value . ',';
            }

            foreach ($attr as $key => $value)
            {
                $attr[$key]['value'] = substr($attr[$key]['value'], 0, -1);
            }

            $model->attachBehavior('attribute', new AttributeBehavior());
        }

        if (isset($_POST['Product']))
        {
            $model->attributes = $_POST['Product'];
            $model->seo->attributes = $_POST['Seo'];


            $error[] = $model->validate();
            $error[] = $model->seo->validate();
            //检测属性值是否合法，显示用属性value，存库用属性ID
            $attributeError = true;
            if (!empty($attributes))
            {
                $attrValidated = $model->validateAttributes($_POST['attributes']);
                $attributeError = $attrValidated['error'];
                unset($attrValidated['error']);
                foreach ($attr as $i => $j)
                {
                    $attr[$i] = array_merge($attr[$i], $attrValidated[$i]);
                }
            }

            if (array_sum($error) == 2 && $attributeError)
            {
                $model->seo = $model->updateSeo($model->seo->seo_id, true, $model->seo->attributes);
                $model->save(false);

                foreach ($_POST['image'] as $imageID => $value)
                {
                    $m = ProductImage::model()->findByPk($imageID);
                    $m->image_alt = $value['alt'];
                    $m->image_used = 1;
                    $m->image_default = $_POST['defaultImage'] == $m->image_id ? 1 : 0;
                    $m->save();
                }
                unset($m);
                if(!$model->baseimage){
                    $model->product_active = 0;
                    $model->saveAttributes(array('product_active'));
                }

                if (!empty($attributes))
                {
                    $comparedAttribute = $model->compareAttributes($attr, $model->product_id);

                    if (isset($comparedAttribute['add']))
                    {
                        foreach ($comparedAttribute['add'] as $attributeID => $value)
                        {
                            foreach ($value as $attributeValue)
                            {
                                $attribute = new ProductAttribute();
                                $attribute->attribute_id = $attributeID;
                                $attribute->attribute_product_id = $model->product_id;
                                $attribute->attribute_value_id = $attributeValue;
                                $attribute->attribute_group_id = $defaultGroup->group_id;
                                $attribute->save();
                            }
                        }
                    }

                    if (isset($comparedAttribute['sub']))
                    {
                        foreach ($comparedAttribute['sub'] as $value)
                        {
                            foreach ($value as $valueID)
                            {
                                ProductAttribute::model()->findByAttributes(array('attribute_value_id' => $valueID))->delete();
                            }
                        }
                    }
                }

                Yii::app()->user->setFlash('message', 'The product has been update');
            }
        }


        if (isset($_POST['Product']['product_category_id']))
            $tree = $model->constructCategoryTree($_POST['Product']['product_category_id']);
        else
            $tree=$model->constructCategoryTree($model->product_category_id);

        $this->render('update-one', array(
            'model' => $model,
            'tree' => $tree,
            'attributes' => $attr,
            'image' => $image,
            'defaultGroup' => $defaultGroup->group_name
        ));
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $this->_load_model()->delete();
        }
    }

    /**
     * Ajax图片上传
     */
    public function actionUploadImage()
    {
        if (isset($_FILES['Filedata']))
        {
            $filedata = $_FILES['Filedata'];

            parse_str($_POST['PHPSESSID'], $temp);
            $productID = $temp['productID'];

            $ext = substr($filedata['name'], -4);

            $filename = randomName(10, 'product_');

            $image = new ProductImage();
            $imagePath = $image->createImageDir($productID) . '/' . $filename;
            $image->image_path = $imagePath . $ext;
            $image->image_product_id = $productID;
            if ($image->save())
            {
                @move_uploaded_file($filedata['tmp_name'], substr($image->image_path, 1));
                $image->imageCut(substr($imagePath, 1), $ext);
            }
            echo 'FILEID:' . $productID;
        }
    }

    public function actionImageDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            if (isset($_GET['id']))
            {
                ProductImage::model()->findByPk($_GET['id'])->delete();
            }
        }
        else
            throw new CHttpException(400, 'Invalid request...');
    }
    

    private function _load_model()
    {
        if ($model == null)
        {
            if (isset($_GET['id']))
            {
                $model = Product::model()->findByPk($_GET['id']);
            }
            if ($model == null)
            {
                throw new CHttpException(404, "The requested page does not exist!");
            }
        }
        return $model;
    }

}