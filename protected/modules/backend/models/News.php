<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property integer $news_id
 * @property string $news_title
 * @property string $news_content
 * @property string $news_url
 * @property string $news_author
 * @property integer $news_readtimes
 * @property string $news_createat
 * @property string $news_updateat
 */
class News extends CActiveRecord
{
    /**
     * @var array $category
     */
    public $category;
    
    public $news_createat;
    public $news_updateat;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return News the static model class
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
		return '{{news}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('news_title, news_content, news_url,news_author', 'required'),
			array('news_id, news_readtimes', 'numerical', 'integerOnly'=>true),
			array('news_title, news_url', 'length', 'max'=>255),
            array('news_url','unique'),
            array('news_url','match','pattern'=>'/^[a-zA-Z0-9\-]+$/','message' => '只能为数字或小写字符或"-"'),
			array('news_author', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('news_id, news_title, news_content, news_author, news_readtimes, news_createat', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'news_id' => 'News',
			'news_title' => '标题',
			'news_content' => '内容',
            'news_url'=>'Url',
			'news_author' => '作者',
			'news_readtimes' => 'News Readtimes',
			'news_createat' => 'News Createat',
            'category'=>'分类',
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

		$criteria->compare('news_id',$this->news_id);

		$criteria->compare('news_title',$this->news_title,true);

		$criteria->compare('news_content',$this->news_content,true);

		$criteria->compare('news_author',$this->news_author,true);

		$criteria->compare('news_readtimes',$this->news_readtimes);

		$criteria->compare('news_createat',$this->news_createat,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    protected function beforeValidate()
    {
        if ($this->news_url=='' && $this->news_title){
            $this->news_url = $this->news_title;
        }
        $this->news_url = str_replace(' ', '-', strtolower($this->news_url));
        return true;
    }

    protected function beforeSave()
    {
        if($this->getIsNewRecord())
        {
            $this->news_readtimes = 0;
            $this->news_createat = new CDbExpression('CURRENT_DATE()');
        }
        $this->news_updateat = new CDbExpression('CURRENT_TIMESTAMP()');

        /*$sql = "SELECT category_name,category_url FROM {{product_category}} ORDER BY CHAR_LENGTH(category_name) DESC,category_name ASC";
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
            $this->news_content = str_ireplace($name, '{{' . $sign . '}}', $this->news_content, $count);
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
                $this->news_content = preg_replace('/{{' . $key . '}}/i', $value['url'], $this->news_content, 1);
                $this->news_content = preg_replace('/{{' . $key . '}}/i', $value['name'], $this->news_content);
            }
        }*/
        
        return true;
    }

    protected function afterSave()
    {
        /*新闻分类*/
        if($this->category['add'])
        {
            $cid = 0;
            $sql = "INSERT INTO {{news_category}} VALUES({$this->news_id},:cid)";
            $request = Yii::app()->db->createCommand($sql);
            foreach ($this->category['add'] as $cid){
                $request->bindValue(':cid', $cid)->execute();
            }
        }
        else if($this->category['sub'])
        {
            $sql = "DELETE FROM {{news_category}} WHERE news_category_id=:cid";
            $request = Yii::app()->db->createCommand($sql);
            foreach ($this->category['sub'] as $cid){
                $request->bindValue(':cid', $cid)->execute();
            }
        }

        $this->cacheNewsCategory();
        $this->cacheNews();
        
        /*新闻缓存*/
        //$this->attachEventHandler('onCacheNews',array($this,'cacheNews'));
        //$this->onCacheNews(new CEvent($this));
        //$this->doCacheNews();
    }

    /*protected function onCacheNews($event)
    {
        $this->raiseEvent('onCacheNews', $event);
    }*/

   /* public function doCacheNews()
    {
        $cache = new CFileCache();
        $cache->init();
        $cache->cachePath = 'protected/runtime/cache/news/';
        $cache->cacheFileSuffix = Yii::app()->params['urlSuffix'];
        $cache->set(md5($this->news_url), $this->news_content);
    }*/

    public static function getNewsUrl($url)
    {
        return '/news/'.$url.Yii::app()->params['urlSuffix'];
    }

    public static function getNewsByCategory($categoryIDS)
    {
        $sql = 'SELECT t1.news_title,t1.news_url,t1.news_updateat,news_content FROM {{news}} AS t1,{{news_category}} AS t2
                       WHERE t1.news_id=t2.news_id AND t2.news_category_id IN (' . implode(',', $categoryIDS) . ')
                       ORDER BY t1.news_updateat LIMIT 8';
        $news = Yii::app()->db->createCommand($sql)->queryAll();
        return $news;
    }

    public function cacheNewsCategory()
    {
        $filename = Yii::app()->params['newscategoryPath'];
        if(is_file($filename))
        {
            $cachedNewsCategoryIDS = require($filename);
            $newsCategory = array();
            $data = Yii::app()->db->createCommand('SELECT * FROM {{news_category}}')->queryAll();
            foreach($data as $row){
                $newsCategory[$row['news_category_id']] .= $row['news_id'].',';
            }
            foreach($newsCategory as $key => $value){
                $newsCategory[$key] = trim($value,',');
            }

            foreach($cachedNewsCategoryIDS as $key => $value)
            {
                if(array_key_exists($key,$newsCategory))
                {
                    if($cachedNewsCategoryIDS[$key]['newsid']!=$newsCategory[$key])
                    {
                        $cachedNewsCategoryIDS[$key]['newsid'] = $newsCategory[$key];
                        $cachedNewsCategoryIDS[$key]['cached'] = false;

                        /*parent category*/
                        //$sql = 'SELECT category_id FROM {{product_category}} WHERE category_parent_id=:id';
                        //$data = Yii::app()->db->createCommand($sql)->bindValue(':id');
                    }
                }
            }
            file_put_contents($filename, "<?php\nreturn " . var_export($cachedNewsCategoryIDS, true) . ";\n");
        }
    }

    public function cacheNews()
    {
        $filename = 'protected/runtime/cache/news/news.php';
        if(!is_file($filename))
        {
            $cachedNews = array();
            $data = Yii::app()->db->createCommand('SELECT news_id FROM {{news}}')->queryAll();
            foreach($data as $row){
                $cachedNews[$row['news_id']] = false;
            }
            file_put_contents($filename, "<?php\nreturn " . var_export($cachedNews, true) . ";\n");
        }

        if(!isset($cachedNews)){
            $cachedNews = require($filename);
        }
        if(array_key_exists($this->news_id,$cachedNews))
        {
            $cachedNews[$this->news_id] = false;
            file_put_contents($filename, "<?php\nreturn " . var_export($cachedNews, true) . ";\n");
        }

        /*如果有一条news修改，所有对于于这条news的分类都要失效*/
        //找到该news对应的分类
        $newsCategory = array();
        $sql = 'SELECT news_category_id FROM {{news_category}} WHERE news_id='.$this->news_id;
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        foreach($data as $row){
            $newsCategory[] = $row['news_category_id'];
        }
        unset($data);

        $newsCachedCategory = require(is_file(Yii::app()->params['newscategoryPath']) ? Yii::app()->params['newscategoryPath']:array());
        foreach($newsCachedCategory as $id => $row)
        {
            if(in_array($id,$newsCategory) && stristr($row['newsid'],strval($this->news_id))!==false){
                $newsCachedCategory[$id]['cached'] = false;
            }
        }
        file_put_contents(Yii::app()->params['newscategoryPath'], "<?php\nreturn " . var_export($newsCachedCategory, true) . ";\n");
    }

    //public function

    /**
     * the path to the cachednewscategory.php restore the category cached information.
     * true means cached,otherwise not cached
     * @return boolean
     */
    public static function checkNewsCategoryIsCached($categoryID=0)
    {
        $cached = false;
        $filename = Yii::app()->params['newscategoryPath'];
        if(is_file($filename))
        {
            $cachedNewsCategoryIDS = require($filename);
            if (array_key_exists($categoryID, $cachedNewsCategoryIDS) && $cachedNewsCategoryIDS[$categoryID]['cached']){
                $cached = true;
            }
        }
        return $cached;
    }

    public static function changeNewsCategoryCache($categoryID)
    {
        $filename = Yii::app()->params['newscategoryPath'];
        if(is_file($filename))
        {
            $cachedNewsCategoryIDS = require($filename);
            if (array_key_exists($categoryID, $cachedNewsCategoryIDS))
            {
                $cachedNewsCategoryIDS[$categoryID]['cached'] = true;
                file_put_contents($filename, "<?php\nreturn " . var_export($cachedNewsCategoryIDS, true) . ";\n");
            }
            
        }
    }

    public static function checkNewsIsCached($newsID=0)
    {
        $cached = false;
        $filename = 'protected/runtime/cache/news/news.php';
        if(is_file($filename))
        {
            $cachedNews = require($filename);
            if (array_key_exists($newsID, $cachedNews) && $cachedNews[$newsID]){
                $cached = true;
            }
        }
        return $cached;
    }

    public static function changeNewsCache($newsID=0)
    {
        $filename = 'protected/runtime/cache/news/news.php';
        if(is_file($filename))
        {
            $cachedNews = require($filename);
            if (array_key_exists($newsID, $cachedNews))
            {
                $cachedNews[$newsID] = true;
                file_put_contents($filename, "<?php\nreturn " . var_export($cachedNews, true) . ";\n");
            }
        }
    }

    public function constructCategoryTree($categoryID=array())
    {
        $tree = array();
        $roots = ProductCategory::model()->rootLevel()->findAll();
        foreach ($roots as $root)
        {//根分类
            $tree[] = $this->packageTree($root, $categoryID);
        }
        return $tree;
    }

    private function packageTree($category,$categoryID)
    {
        $expanded = true;
        if (in_array($category->category_id,$categoryID)){
            $checked = 'checked="checked"';
        }
        else{
            $checked = '';
        }

        if ($category->children)
        {
            $children = array();
            foreach ($category->children as $childCategory){
                $children[] = $this->packageTree($childCategory, $categoryID);
            }
            $node = array(
                'text' => "<input name=category[] {$checked} type='checkbox' value='{$category->category_id}'>{$category->category_name}",
                'expanded' => $expanded,
                'hasChildren' => true,
                'children' => $children,
            );
        }
        else
        {
            $node = array(
                'text' => "<input name=category[] {$checked} type='checkbox' value='{$category->category_id}'>{$category->category_name}",
                'expanded' => $expanded,
            );
        }
        return $node;
    }
}