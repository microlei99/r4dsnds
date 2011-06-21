<?php

/**
 * This is the model class for table "{{product_category}}".
 *
 * The followings are the available columns in table '{{product_category}}':
 * @property integer $category_id
 * @property string $category_name
 * @property string $category_url
 * @property integer $category_level
 * @property integer $category_parent_id
 * @property integer $category_seo_id
 * @property string $category_path
 * @property integer $category_order
 * @property string $category_active
 * @property string $category_introduce
 */
class ProductCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductCategory the static model class
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
		return '{{product_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_name, category_url, category_level, category_parent_id, category_path, category_active,category_introduce', 'required'),
			array('category_active,category_level,category_parent_id, category_seo_id,category_order', 'numerical', 'integerOnly'=>true),
			array('category_url', 'length', 'max'=>255),
            array('category_url','match','pattern'=>'/^[A-Za-z0-9\-]+$/','message'=>'只能为数字或字符或横杠"-"'),
            array('category_name,category_url','unique'),
			array('category_name,category_path', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category_id, category_name, category_url, category_level,category_parent_id, category_seo_id, category_path,category_order, category_active,category_introduce', 'safe', 'on'=>'search'),
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
            'seo'=>array(self::BELONGS_TO,'Seo','category_seo_id'),
            'children'=>array(self::HAS_MANY,'ProductCategory','category_parent_id'),
            'parent'=>array(self::BELONGS_TO,'ProductCategory','category_parent_id'),
            'product'=>array(self::HAS_MANY,'Product','product_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => 'Category',
			'category_name' => '分类名称',
			'category_url' => '分类Url',
			'category_level' => 'Category Level',
			'category_parent_id' => 'Category Parent',
			'category_seo_id' => 'Category Seo',
			'category_path' => 'Category Path',
            'category_order' => 'Category Order',
			'category_active' => 'Category Status',
            'category_introduce' => 'Category Introduce',
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

		$criteria=new CDbCriteria;

		$criteria->compare('category_id',$this->category_id);

		$criteria->compare('category_name',$this->category_name,true);

		$criteria->compare('category_url',$this->category_url,true);

		$criteria->compare('category_level',$this->category_level);

		$criteria->compare('category_parent_id',$this->category_parent_id);

		$criteria->compare('category_seo_id',$this->category_seo_id);

		$criteria->compare('category_path',$this->category_path,true);

        $criteria->compare('category_order',$this->category_order);

		$criteria->compare('category_active',$this->category_active,true);

        $criteria->compare('category_introduce',$this->category_introduce,true);

		return new CActiveDataProvider('ProductCategory', array(
			'criteria'=>$criteria,
		));
	}

    public function beforeValidate()
    {
        if($this->category_url=='' && $this->category_name){
            $this->category_url = str_replace(' ','-',strtolower($this->category_name));
        }
        $this->category_url = strtolower($this->category_url);
        return true;
    }

    public function afterSave()
    {
        if($this->isNewRecord)
        {
            $this->category_path = $this->category_path.','.$this->category_id;
            $this->updateByPk($this->category_id,array(
                'category_path'=>$this->category_path,
                'category_order'=>$this->category_order
            ));
        }

        $cache = Config::model()->findByAttributes(array('config_type'=>'cache','config_item'=>'index_category_cache'));
        if($cache)
        {
            $cache->config_code = md5(microtime(true));
            $cache->save();
        }

        $this->cacheNewsCategory();
    }

    public function scopes()
    {
        return array(
            'rootLevel'=>array(
                 'select'=>'category_id,category_url,category_name',
                 'condition'=>'category_level=1 AND category_active=1',
                 'order'=>'category_order',
            ),
            'directChildren'=>array(
                 'select'=>'category_id,category_parent_id,category_url,category_name',
                 'condition'=>'category_active=1 AND category_parent_id=' . $this->category_id,
                 'order'=>'category_order',
            ),
            'relate'=>array(
                'select'=>'category_id,category_parent_id,category_url,category_name',
                'condition'=>'category_active=1 AND category_parent_id='.$this->category_parent_id.' AND category_id!='.$this->category_id,
                'order'=>'category_order',
            )
        );
    }

    public function getUrl($url='')
    {
        if($url==''){
            return isset($this->category_url) ? '/'.$this->category_url :'/';
        }
        return '/'.$url ;
    }

    public function getParents($containerSelf=true)
    {
         $path = array_slice(explode(',',$this->category_path),1);
         $path = $containerSelf ? $path : array_slice($path,0,-1);
         $parents = array();
         foreach($path as $key)
         {
             if($p = ProductCategory::model()->findByPk($key,'category_active=1'))
             {
                 $parents[$key]['name'] = $p->category_name;
                 $parents[$key]['url'] = $p->getUrl();
             }
         }
         return $parents;
    }

    /**
     * 如果categoryID为0，则代表查找parentID下面所有的子类，否则查找相应子类
     * $containerSelf是否包括自己
     * @return array
     */
	public function getSubcategory($categoryID=0,$containerSelf=false)
	{
        $condition = ' AND category_parent_id'.(($containerSelf==false) ? '>':'>=').$this->category_parent_id;
        $tmpChildren = ProductCategory::model()->findAll(array(
            'select'=>'category_id,category_parent_id,category_name,category_url,category_path',
            'condition'=>'category_active=1'.$condition,
            'order'=>'category_order',
        ));

        $children = array();
        if ($categoryID == 0)
        {
            foreach ($tmpChildren as $item)
            {
                if (in_array($this->category_parent_id, explode(',', $item->category_path)))
                {
                    $children[$item->category_id]['name'] = $item->category_name;
                    $children[$item->category_id]['url'] = $this->getUrl($item->category_url);
                }
            }
        }
        else
        {
            foreach ($tmpChildren as $item)
            {
                $path = explode(',', $item->category_path);
                if (in_array($this->category_parent_id, $path) && in_array($categoryID, $path))
                {
                    $children[$item->category_id]['name'] = $item->category_name;
                    $children[$item->category_id]['url'] = $this->getUrl($item->category_url);
                }
            }
        }
		
        unset($tmpChildren);
        return $children;
	}

    /**
     * 查找相关分类，如果分类为第三级分类，则查找该分类的同级分类，如果分类为二级分类，则查找该分类下的子分类
     * @return array
     */
    public function getRalateCategory()
    {
        $relate = array();
        if($this->category_level==1){
            $relate = $this->getSubcategory($this->category_id);
        }
        else
        {
            foreach($this->relate()->findAll() as $item)
            {
                $relate[$item->category_id]['name'] = $item->category_name;
                $relate[$item->category_id]['url'] = $this->getUrl($item->category_url);
            }
        }
        return $relate;
    }

   public function getCategoryList($prefixLength=4)
    {
        $category = ProductCategory::model()->findAllByAttributes(array('category_level'=>1));
        if($category)
        {
            foreach($category as $key)
            {
                $children = $this->_get_child_list($key);
                foreach($children as $i=>$j){
                    $cate[$i] = $j;
                }
            }
        }
        return isset($cate) ? $cate : array();
    }

    public function cacheNewsCategory()
    {
        $filename = Yii::app()->params['newscategoryPath'];
        if (!is_file($filename))
        {
            /* 初始化全部分类 */
            $initNewsCategoryIDS = array();
            $data = Yii::app()->db->createCommand('SELECT category_id FROM {{product_category}}')->queryAll();
            foreach ($data as $key)
             {
                $initNewsCategoryIDS[$key['category_id']]['newsid'] = 0;
                $initNewsCategoryIDS[$key['category_id']]['cached'] = false;
            }
            file_put_contents($filename, "<?php\nreturn " . var_export($initNewsCategoryIDS, true) . ";\n");
            unset($initNewsCategoryIDS);
        }

        $cachedNewsCategoryIDS = require($filename);
        if(!array_key_exists($this->category_id, $cachedNewsCategoryIDS['newsid']))
        {
            $cachedNewsCategoryIDS[$this->category_id]['newsid'] = 0;
            $cachedNewsCategoryIDS[$this->category_id]['cached'] = false;
            file_put_contents($filename, "<?php\nreturn " . var_export($cachedNewsCategoryIDS, true) . ";\n");
        }
    }

   private function _get_child_list($categoryObj,&$children=array())
   {
        $children[$categoryObj->category_id] = str_repeat('_', ($categoryObj->category_level-1)*4).$categoryObj->category_name;
       
       foreach($categoryObj->children as $key)
       {
           if(count($key->children)>0)
           {
               $this->_get_child_list($key,$children);
           }
           else
           {
               $children[$key->category_id] = str_repeat('_', ($key->category_level-1)*4).$key->category_name;
           }
       }
       return $children;
   }
}