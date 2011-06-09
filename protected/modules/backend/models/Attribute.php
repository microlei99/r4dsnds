<?php

/**
 * This is the model class for table "{{Attribute}}".
 *
 * The followings are the available columns in table '{{Attribute}}':
 * @property integer $attribute_id
 * @property string $attribute_name
 * @property string $attribute_status
 * @property integer $attribute_group_id
 */
class Attribute extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Attribute the static model class
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
		return '{{attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attribute_name, attribute_status, attribute_group_id', 'required'),
			array('attribute_group_id', 'numerical', 'integerOnly'=>true),
            array('attribute_name','unique','criteria'=>array('condition'=>'attribute_group_id='.$this->attribute_group_id)),
			array('attribute_name', 'length', 'max'=>32),
			array('attribute_status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('attribute_id, attribute_name, attribute_status, attribute_group_id', 'safe', 'on'=>'search'),
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
            'attributeGroup'=>array(self::BELONGS_TO,'AttributeGroup','attribute_group_id'),
            'attributeValue'=>array(self::STAT,'AttributeValue','attribute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'attribute_id' => 'Attribute',
			'attribute_name' => 'Attribute Name',
			'attribute_status' => 'Attribute Status',
			'attribute_group_id' => 'Attribute Group',
		);
	}

    public function beforeDelete()
    {
        $model = AttributeValue::model()->findAllByAttributes(array('attribute_id'=>$this->attribute_id));
        if($model)
        {
            foreach($model as $key)
            {
                $key->delete();
            }
        }
        return true;
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

		$criteria->compare('attribute_id',$this->attribute_id);

		$criteria->compare('attribute_name',$this->attribute_name,true);

		$criteria->compare('attribute_status',$this->attribute_status,true);

		$criteria->compare('attribute_group_id',$this->attribute_group_id);

		return new CActiveDataProvider('Attribute', array(
			'criteria'=>$criteria,
		));
	}

    public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'attribute_status=1'
            ),
        );
    }

    /*暂无用到*/
    public function defaultAttribute()
    {
        $m = AttributeGroup::model()->active()->findByAttributes(array('group_default'=>1));
        if($m)
        {
            $m = Attribute::model()->active()->findAllByAttributes(array('attribute_group_id'=>$m->group_id));
            if($m)
            {
                foreach($m as $key)
                {
                    $t[$key->attribute_id] = $key->attribute_name;
                }
                return $t;
            }
        }
        return array();
    }
}