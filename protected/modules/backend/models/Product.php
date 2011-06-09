<?php

/**
 * This is the model class for table "{{Product}}".
 *
 * The followings are the available columns in table '{{Product}}':
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_name_alias
 * @property string $product_sku
 * @property string $product_url
 * @property double $product_weight
 * @property integer $product_base_price
 * @property integer $product_orig_price
 * @property integer $product_special_price
 * @property integer $product_stock_qty
 * @property integer $product_stock_cart_min
 * @property integer $product_stock_cart_max
 * @property integer $product_stock_status
 * @property string $product_status
 * @property integer $product_active
 * @property string $product_short_description
 * @property string $product_description
 * @property integer $product_seo_id
 * @property integer $product_category_id
 * @property integer $product_promotion
 * @property integer $product_wholesale
 * @property integer $product_feature
 * @property integer $product_freeshiping
 * @property string $product_accessory
 * @property string $product_together
 * @property string $product_create_at
 * @property string $product_last_update
 * @property integer $product_new_arrivals
 */
class Product extends CActiveRecord implements ICart
{
    const IN_STOCK = 1;
    const OUT_OF_STOCK = 0;
    const STOCK_WARNING = 2;

    /**
     * Returns the static model of the specified AR class.
     * @return Product the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_name, product_sku, product_url,product_weight,product_base_price,product_orig_price,product_special_price,
                    product_stock_qty,product_stock_cart_min,product_stock_cart_max,product_stock_status,product_status,product_active,product_short_description,
                    product_description, product_category_id', 'required'),
            array('product_seo_id,product_category_id,product_active,product_promotion,product_new_arrivals,product_status,product_stock_qty,product_stock_cart_min,product_stock_cart_max,product_stock_status', 'numerical', 'integerOnly' => true),
            array('product_url', 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/', 'message' => '只能为数字或小写字符或横杠"-"'),
            array('product_url', 'length', 'max' => 100),
            array('product_name,product_sku,product_url', 'unique'),
            array('product_weight,product_base_price,product_orig_price,product_special_price', 'numerical'),
            array('product_stock_qty,product_stock_cart_min', 'numerical', 'min' => 1),
            array('product_stock_cart_max', 'numerical', 'min' => -1),
            array('product_name,product_name_alias, product_url,product_accessory, product_together', 'length', 'max' => 100),
            array('product_sku', 'length', 'max' => 64),
            array('product_short_description', 'length', 'max' => 512),
            array('product_wholesale,product_promotion,product_new_arrivals,product_feature,product_freeshiping', 'boolean'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('product_id, product_name, product_name_alias,product_sku, product_url, product_weight, product_status,product_active, product_seo_id, product_category_id,product_promotion,product_accessory,product_together,
                   product_create_at, product_last_update,product_base_price,product_orig_price,product_special_price,product_stock_qty
                   product_stock_cart_min,product_stock_cart_max,product_stock_status，product_new_arrivals', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'attr' => array(self::HAS_MANY, 'ProductAttribute', 'attribute_product_id'),
            'seo' => array(self::BELONGS_TO, 'Seo', 'product_seo_id'),
            'image' => array(self::HAS_MANY, 'ProductImage', 'image_product_id', 'condition' => 'image_default!=1'),
            'baseimage' => array(self::HAS_ONE, 'ProductImage', 'image_product_id', 'condition' => 'image_default=1'),
            'promotion' => array(self::HAS_ONE, 'Promotion', 'promotion_product_id'),
            'wholesale' => array(self::HAS_MANY, 'Wholesale', 'wholesale_product_id'),
            'review' => array(self::HAS_MANY, 'ProductReview', 'product_id'),
            'category' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
            'statistic' => array(self::HAS_ONE, 'ProductStatistic', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'product_id' => '商品ID',
            'product_name' => '商品名称',
            'product_name_alias' => '商品别名',
            'product_sku' => '商品SKU',
            'product_url' => '商品URL',
            'product_weight' => '商品重量',
            'product_base_price' => '商品原价',
            'product_orig_price' => '商品进价',
            'product_special_price' => '商品卖价',
            'product_stock_qty' => '商品库存量',
            'product_stock_cart_min' => '商品最小库存',
            'product_stock_cart_max' => '商品最大库存',
            'product_stock_status' => '商品库存状态',
            'product_status' => '商品状态',
            'product_active' => 'Product Active',
            'product_short_description' => '商品短描述',
            'product_description' => '商品描述',
            'product_seo_id' => 'Product Seo',
            'product_category_id' => 'Product Category',
            'product_accessory' => 'Product Accessory',
            'product_together' => 'Product Together',
            'product_new_arrivals' => '最新产品',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->order = 'product_id DESC';

        $criteria->compare('product_id', $this->product_id);

        $criteria->compare('product_name', $this->product_name, true);

        $criteria->compare('product_name_alias', $this->product_name_alias, true);

        $criteria->compare('product_sku', $this->product_sku, true);

        $criteria->compare('product_url', $this->product_url, true);

        $criteria->compare('product_weight', $this->product_weight);

        $criteria->compare('product_base_price', $this->product_base_price);

        $criteria->compare('product_orig_price', $this->product_orig_price);

        $criteria->compare('product_special_price', $this->product_special_price);

        $criteria->compare('product_stock_qty', $this->product_stock_qty);

        $criteria->compare('product_stock_cart_min', $this->product_stock_cart_min);

        $criteria->compare('product_stock_cart_max', $this->product_stock_cart_max);

        $criteria->compare('product_stock_status', $this->product_stock_status);

        $criteria->compare('product_status', $this->product_status);

        $criteria->compare('product_active', $this->product_active);

        $criteria->compare('product_short_description', $this->product_short_description, true);

        $criteria->compare('product_description', $this->product_description, true);

        $criteria->compare('product_seo_id', $this->product_seo_id);

        $criteria->compare('product_category_id', $this->product_category_id);

        $criteria->compare('product_promotion', $this->product_promotion);

        $criteria->compare('product_feature', $this->product_feature);

        $criteria->compare('product_wholesale', $this->product_wholesale);

        $criteria->compare('product_freeshiping', $this->product_freeshiping);

        $criteria->compare('product_accessory', $this->product_accessory, true);

        $criteria->compare('product_together', $this->product_together, true);

        $criteria->compare('product_create_at', $this->product_create_at, true);

        $criteria->compare('product_last_update', $this->product_last_update, true);

        $criteria->compare('product_new_arrivals', $this->product_new_arrivals, true);

        return new CActiveDataProvider('Product', array(
            'criteria' => $criteria,
        ));
    }

    public function beforeValidate()
    {
        if ($this->product_url == '' && $this->product_name)
        {
            $this->product_url = str_replace(' ', '-', strtolower($this->product_name));
        }

        $this->product_url = strtolower($this->product_url);

        if (is_array($this->product_status))
        {
            foreach ($this->product_status as $row)
            {
                $res+=$row;
            }
            $this->product_status = $res;
            $res = self::resolveStatus($res);
            $this->product_feature = in_array(1, $res) ? 1 : 0;
            $this->product_promotion = in_array(2, $res) ? 1 : 0;
            $this->product_wholesale = in_array(4, $res) ? 1 : 0;
            $this->product_freeshiping = in_array(8, $res) ? 1 : 0;
        }
        else
        {
            $this->product_status = 0;
            $this->product_feature = $this->product_promotion = $this->product_wholesale = $this->product_freeshiping = 0;
        }
        return true;
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->product_create_at = date('Y-n-j');
        }
        $stock = Config::items('stock');
        if ($this->product_stock_qty < 1 || $this->product_stock_status == self::OUT_OF_STOCK)
        {
            $this->product_stock_status = self::OUT_OF_STOCK;
        }
        else if (($this->product_stock_qty > 0 && $this->product_stock_qty <= $stock['stock_out_qty']) || $this->product_stock_status == self::STOCK_WARNING)
        {
            $this->product_stock_status = self::STOCK_WARNING;
        }
        else
        {
            $this->product_stock_status = self::IN_STOCK;
        }
        $this->product_last_update = date('Y-n-j');

        if ($this->product_name_alias == '')
        {
            $this->product_name_alias = $this->product_name;
        }

        $sql = "SELECT category_name,category_url FROM {{product_category}} ORDER BY CHAR_LENGTH(category_name) DESC,category_name ASC";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $category = array();
        foreach($data as $item){
            $category[$item['category_name']] = $item['category_url'];
        }
        $rt = array();
        $index = 0;
        foreach ($category as $name => $url)
        {
            $sign = 'rt:' . $index;
            $this->product_description = str_ireplace($name, '{{' . $sign . '}}', $this->product_description, $count);
            if ($count > 0)
            {
                $index++;
                $rt[$sign]['url'] = CHtml::Link($name, $url);
                $rt[$sign]['name'] = $name;
            }
        }
        if($rt)
        {
            foreach ($rt as $key => $value)
            {
                $this->product_description = preg_replace('/{{' . $key . '}}/i', $value['url'], $this->product_description, 1);
                $this->product_description = preg_replace('/{{' . $key . '}}/i', $value['name'], $this->product_description);
            }
        }
        return true;
    }

    public function afterSave()
    {
        if ($this->isNewRecord)
        {
            $sql = "INSERT INTO {{product_statistic}} VALUES($this->product_id,0,0,0,0,0)";
            Yii::app()->db->createCommand($sql)->execute();
        }
    }

    public function newarrivial($limit=20)
    {
        $this->getDbCriteria()->mergeWith(array(
            'select' => array('product_id', 'product_name', 'product_url', 'product_status', 'product_active', 'product_base_price', 'product_orig_price', 'product_special_price',
                'product_promotion', 'product_wholesale', 'product_status,product_short_description'),
            'condition' => 'product_active=1 AND product_new_arrivals=1',
            'order' => 'product_last_update DESC',
            'limit' => $limit,
        ));
        return $this;
    }

    public function hotSale($limit=20)
    {
        $this->getDbCriteria()->mergeWith(array(
            'select' => array('product_id', 'product_name', 'product_url', 'product_status', 'product_active', 'product_base_price', 'product_orig_price', 'product_special_price',
                'product_promotion', 'product_wholesale', 'product_status', 'product_short_description'),
            'with' => array('statistic'),
            'condition' => 'product_active=1',
            'order' => 'product_buyed DESC',
            'limit' => $limit,
        ));
        return $this;
    }

    public function viewed($limit=20)
    {
        $this->getDbCriteria()->mergeWith(array(
            'select' => array('product_id', 'product_name', 'product_url', 'product_status', 'product_active', 'product_base_price', 'product_orig_price', 'product_special_price',
                'product_promotion', 'product_wholesale', 'product_status', 'product_short_description'),
            'with' => array('statistic'),
            'condition' => 'product_active=1',
            'order' => 'product_viewed DESC',
            'limit' => $limit,
        ));
        return $this;
    }

    public function promotion($limit=20)
    {
        $this->getDbCriteria()->mergeWith(array(
            'select' => array('product_id', 'product_name', 'product_url', 'product_status', 'product_active', 'product_base_price', 'product_orig_price', 'product_special_price',
                'product_promotion', 'product_wholesale', 'product_status', 'product_short_description'),
            'condition' => 'product_active=1 AND product_promotion=1',
            'order' => 'product_last_update DESC',
            'limit' => $limit,
        ));
        return $this;
    }

    public function wholesale($limit=20)
    {
        $this->getDbCriteria()->mergeWith(array(
            'select' => array('product_id', 'product_name', 'product_url', 'product_status', 'product_active', 'product_base_price', 'product_orig_price', 'product_special_price',
                'product_promotion', 'product_wholesale', 'product_status', 'product_short_description'),
            'condition' => 'product_active=1 AND product_wholesale!=0',
            'order' => 'product_last_update DESC',
            'limit' => $limit,
        ));
        return $this;
    }

    public function getID()
    {
        return $this->product_id;
    }

    public function getUrl()
    {
        if ($this->product_url)
        {
            return '/' . $this->product_url . Yii::app()->params['urlSuffix'];
        }
        return Yii::app()->request->hostInfo;
    }

    public function getWholesale()
    {
        $sql = "SELECT * FROM {{wholesale}} WHERE wholesale_active=1 AND wholesale_product_id=" . $this->product_id . ' ORDER BY wholesale_product_interval1';
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function isWholesaleActive($qty)
    {
        $sql = "SELECT * FROM {{wholesale}}
				 WHERE wholesale_active=1 AND wholesale_product_interval1<='{$qty}' AND wholesale_product_interval2>='{$qty}'
				 AND wholesale_product_id=" . $this->product_id;

        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    /* only when $priceType='wholesale',the $wholesaleID can be used. */

    public function getPrice($priceType='special', $wholesaleID=0)
    {
        $itemPrice = 0.0;

        switch ($priceType)
        {
            case 'base':
                $itemPrice = $this->product_base_price;
                break;
            case 'orig':
                $itemPrice = $this->product_orig_price;
                break;
            case 'special':
                $itemPrice = $this->product_special_price;
                break;
            case 'promotion':
                $promotion = $this->isPromotionActive();
                $itemPrice = $promotion ? $promotion['price'] : $this->product_special_price;
                unset($promotion);
                break;
            case 'wholesale':
                // waiting for develop
                $sql = "SELECT wholesale_type ,wholesale_product_price,wholesale_product_percent
							FROM {{wholesale}} WHERE wholesale_active=1 AND wholesale_id={$wholesaleID}";
                $wholesale = Yii::app()->db->createCommand($sql)->queryRow();
                if ($wholesale)
                {
                    $itemPrice = ($wholesale['wholesale_type'] == 1) ? $wholesale['wholesale_product_price'] : $wholesale['wholesale_product_percent'] / 100 * $this->product_orig_price;
                }
                break;
            default :
                $itemPrice = $this->product_special_price;
        }

        return $itemPrice;
    }

    public function isPromotionActive()
    {
        if ($promotion = $this->promotion)
        {
            if ($promotion->promotion_status == Promotion::PROMOTION_ACTIVE)
            {
                if (strtotime($promotion->promotion_start_at) <= time() && strtotime($promotion->promotion_end_at) >= strtotime("-1 day"))
                {
                    if ($promotion->promotion_type == 1)
                    {
                        $data['price'] = fixedPrice($promotion->promotion_price);
                    }
                    else
                    {
                        $data['price'] = fixedPrice($promotion->promotion_percent / 100 * $this->product_special_price);
                    }
                    $data['start'] = $promotion->promotion_start_at;
                    $data['end'] = $promotion->promotion_end_at;

                    unset($promotion);
                    return $data;
                }
            }
        }
        return false;
    }

    public static function decoratePrice($price, $currencySymbol=true, $currencyID=0)
    {
        $currencyID = ($currencyID == 0) ? Currency::getCurrency() : $currencyID;
        $currency = Currency::model()->active()->findByPk($currencyID);
        if (!$currency)
        {
            $currency = Currency::model()->findByPk(Yii::app()->params['currency']);
        }

        $price *= $currency->currency_rate;
        $price = fixedPrice($price);
        if ($currencySymbol)
        {
            $price = $currency->currency_symbol . $price;
        }
        unset($currency);
        return $price;
    }

    public static function decorateOffsetPrice($price, $currencySymbol=true, $currencyID=0)
    {
        $currencyID = ($currencyID == 0) ? Currency::getCurrency() : $currencyID;
        $currency = Currency::model()->active()->findByPk($currencyID);
        if (!$currency)
        {
            $currency = Currency::model()->findByPk(Yii::app()->params['currency']);
        }

        $price /= $currency->currency_rate;
        $price = fixedPrice($price);
        if ($currencySymbol)
        {
            $price = $currency->currency_symbol . $price;
        }
        unset($currency);
        return $price;
    }

    public static function maintainStatus($productID=0)
    {
        if (!$productID)
            return;

        $sql = "UPDATE {{product}} SET product_status=product_feature*1+product_promotion*2+
                product_wholesale*3+product_freeshiping*4 WHERE product_id=" . $productID;
        Yii::app()->db->createCommand($sql)->execute();
    }

    public static function resolveStatus($status)
    {
        $res = array();
        if (!$status)
        {
            return $res;
        }

        for ($i = 1; $i < 9; $i*=2)
        {
            if ($status & $i)
            {
                $res[] = $i;
            }
        }
        return $res;
    }

    public static function getAllProductSku()
    {
        $product = array();
        $res = Yii::app()->db->createCommand("SELECT product_id,product_sku FROM {{product}} ORDER BY product_sku")->queryAll();
        foreach ($res as $item)
        {
            $product[$item['product_id']] = $item['product_sku'];
        }
        return $product;
    }

    public function constructCategoryTree($category_ID=null)
    {
        $roots = ProductCategory::model()->rootLevel()->findAll();
        $tree = array();
        foreach ($roots as $row)
        {
            $tree[] = $this->PackageTree($row, $category_ID);
        }
        return $tree;
    }

    private function PackageTree($category, $def_ID)
    {
        if ($category->category_id == $def_ID)
        {
            $checked = 'checked="checked"';
            $expanded = true;
        }
        else
        {
            $expanded = false;
            $checked;
        }

        if ($category->children)
        {
            foreach ($category->children as $key => $row)
            {
                $childArr[] = $this->PackageTree($row, $def_ID);
                if ($childArr[$key]['expanded'])
                {//延展上溯至父类
                    $expanded = true;
                }
            }
            $node = array(
                'text' => $category->category_name . "<input  name=Product[product_category_id] {$checked} type='radio' value={$category['category_id']}>",
                'expanded' => $expanded,
                'hasChildren' => true,
                'children' => $childArr,
            );
        }
        else
        {
            $node = array(
                'text' => $category->category_name . "<input  name=Product[product_category_id] {$checked} type='radio' value={$category['category_id']}>",
                'expanded' => $expanded);
        }
        return $node;
    }

}