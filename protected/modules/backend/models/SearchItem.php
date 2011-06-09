<?php

/**
 * This is the model class for table "{{Search}}".
 *
 * The followings are the available columns in table '{{Search}}':
 * @property integer $search_id
 * @property string $search_query
 * @property integer $search_times
 * @property integer $search_result
 * @property integer $search_user
 * @property string $search_update_at
 */
class SearchItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Search the static model class
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
		return '{{search}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('search_query, search_times, search_result, search_user, search_update_at', 'required'),
			array('search_times, search_result, search_user', 'numerical', 'integerOnly'=>true),
			array('search_query', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('search_id, search_query, search_times, search_result, search_user, search_update_at', 'safe', 'on'=>'search'),
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
			'search_id' => 'Search',
			'search_query' => 'Search Query',
			'search_times' => 'Search Times',
			'search_result' => 'Search Result',
			'search_user' => 'Search User',
			'search_update_at' => 'Search Update At',
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

        $criteria->order = 'search_times DESC';

		$criteria->compare('search_id',$this->search_id);

		$criteria->compare('search_query',$this->search_query,true);

		$criteria->compare('search_times',$this->search_times);

		$criteria->compare('search_result',$this->search_result);

		$criteria->compare('search_user',$this->search_user);

		$criteria->compare('search_update_at',$this->search_update_at,true);

		return new CActiveDataProvider('SearchItem', array(
			'criteria'=>$criteria,
		));
	}

    public function rcently($limit=5)
    {
        $this->getDbCriteria()->mergeWith(array(
                'order'=>'search_update_at DESC',
                'limit'=>$limit,
        ));
        return $this;
    }

    public function popular($limit=5)
    {
        $this->getDbCriteria()->mergeWith(array(
                'order'=>'search_times DESC',
                'limit'=>$limit,
        ));
        return $this;
    }
}