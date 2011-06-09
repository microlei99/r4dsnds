<?php
/**
 * Excel批量上传产品
 * @author microlei99
 */

class ImportProduct
{
    public $errorMessage;

    /*array*/
    public $productsID;

    public function __construct()
    {
        $this->errorMessage = '';
    }
    
    public function verify($items=array())
    {
        foreach($items as $item)
        {
            $message = ''; 
            $product = new Product();
            $product->product_name = $product->product_name_alias = $item[0];
            $product->product_sku = $item[1];
            $product->product_url = $item[2];
            $product->product_weight = $item[3];
            $categoryID = Yii::app()->db->createCommand("SELECT category_id FROM {{product_category}} WHERE category_name=:c_name")
                    ->bindValue(':c_name', $item[4])->queryScalar();
            if ($categoryID){
                $product->product_category_id = $categoryID;
                unset($categoryID);
            }
            else{
                $message .= '分类不存在,';
            }
            
            $product->product_stock_qty = $item[5];
            $product->product_stock_cart_min = 1;
            $product->product_stock_cart_max = -1;
            $product->product_stock_status = Product::IN_STOCK;

            $product->product_base_price = 100;
            $product->product_special_price = floatval($item[6]);
            $product->product_orig_price = $product->product_special_price * 1.2;

            $seo = new Seo();
            $seo->seo_title = $item[7];
            $seo->seo_keyword = $item[8];
            $seo->seo_description = $item[9];
            if (!$seo->validate()){
                $message .= 'SEO信息不能为空,';
            }

            $product->product_short_description = $item[10];
            $product->product_description = $item[11];
            $product->product_status = $product->product_active = 0;
            $validate = $product->validate(array(
                    'product_name', 'product_sku','product_url', 'product_weight', 'product_base_price', 'product_orig_price', 'product_special_price',
                    'product_stock_qty', 'product_stock_cart_min', 'product_stock_cart_max', 'product_stock_status', 'product_status',
                    'product_active', 'product_short_description', 'product_description', 'product_category_id'
                ));

            $message = $message ? substr($message,0,-1) : '';
            if(!$validate)
            {
                $errors = $product->getErrors();
                foreach($product->attributeLabels() as $key => $label)
                {
                    if(array_key_exists($key,$errors)){
                        $message .= implode(',',$errors[$key]);
                    }
                }
            }
            if($message){
                $this->errorMessage .= 'SKU:{'.$product->product_sku.'}错误:{'.$message.'}'."<br>";
            }
        }

        return $this->errorMessage ? false : true;
    }

    public function save($items=array())
    {
        foreach($items as $item)
        {
            $product = new Product();
            $product->product_name = $product->product_name_alias = $item[0];
            $product->product_sku = $item[1];
            $product->product_url = $item[2];
            $product->product_weight = $item[3];
            $categoryID = Yii::app()->db->createCommand("SELECT category_id FROM {{product_category}} WHERE category_name=:c_name")
                    ->bindValue(':c_name', $item[4])->queryScalar();
            $product->product_category_id = $categoryID;
            $product->product_stock_qty = $item[5];
            $product->product_stock_cart_min = 1;
            $product->product_stock_cart_max = -1;
            $product->product_stock_status = Product::IN_STOCK;
            $product->product_base_price = 100;
            $product->product_special_price = floatval($item[6]);
            $product->product_orig_price = $product->product_special_price * 1.2;
            $seo = new Seo();
            $seo->seo_title = $item[7];
            $seo->seo_keyword = $item[8];
            $seo->seo_description = $item[9];
            if($seo->save()){
                $product->product_seo_id = $seo->seo_id;
            }
            $product->product_short_description = $item[10];
            $product->product_description = $item[11];
            $product->product_status = $product->product_active = 0;
            if($product->save()){
                $this->productsID[$product->product_id] = $product->product_sku;
            }
        }
    }

    /*图片是通过ftp软件之间上传到图片目录*/
    public function saveImage()
    {
        $message = '';
        if(is_array($this->productsID))
        {
            foreach($this->productsID as $id => $name)
            {
                $prefix = './media/product/'.$id.'/';
                $patten = $prefix.'*.jpg,'.$prefix.'*.jpeg';

                if($images = glob('{'.$patten.'}',GLOB_BRACE))
                {
                    $flage = true;
                    foreach($images as $image)
                    {
                        if(substr($image,strrpos($image,'/')+1,1)=='_'){
                            $flage = false;
                            break;
                        }
                    }
                    if($flage){
                        $message .= 'ID:{'.$id.'} name:{'.$name.'}文件夹中没有默认图片'."<br>";
                    }
                    else
                    {
                        foreach($images as $image)
                        {
                            $imageObj = new ProductImage();
                            $imageObj->image_alt = $name;
                            $imageObj->image_path = substr($image, 1);
                            $imageObj->image_product_id = $id;
                            $imageObj->image_used = 1;
                            $imageObj->image_default = (substr($image,strrpos($image,'/')+1,1)=='_') ? 1 : 0;
                            $imageObj->save(false);
                            //缩略图
                            $imageName = substr($image, 0, strrpos($image, '.'));
                            $imageExtension = end(explode('.', $image));
                            $imageObj->imageCut($imageName, '.' . $imageExtension);
                        }
                        Yii::app()->db->createCommand("UPDATE {{product}} SET product_active=1 WHERE product_id=:id")
                              ->bindValue(':id',$id)->execute();
                    }
                }
                else
                {
                    $message .= 'ID:{'.$id.'} name:{'.$name.'}文件夹中没有图片'."<br>";
                }
            }
        }
        return $message;
    }
}
?>
