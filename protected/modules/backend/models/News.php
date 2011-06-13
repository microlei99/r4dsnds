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
        $this->news_updateat = new CDbExpression('CURRENT_DATE()');
        
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
        
        /*新闻缓存*/
        //$this->attachEventHandler('onCacheNews',array($this,'cacheNews'));
        //$this->onCacheNews(new CEvent($this));
        $this->doCacheNews();
    }

    /*protected function onCacheNews($event)
    {
        $this->raiseEvent('onCacheNews', $event);
    }*/

    public function doCacheNews()
    {
        $cache = new CFileCache();
        $cache->init();
        $cache->cachePath = 'protected/runtime/cache/news/'.date('Ym');
        $cache->cacheFileSuffix = Yii::app()->params['urlSuffix'];
        $cache->set(md5($this->news_url), $this->news_content);
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