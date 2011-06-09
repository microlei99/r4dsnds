<?php

/**
 * This is the model class for table "{{ProductAttribute}}".
 *
 * The followings are the available columns in table '{{ProductAttribute}}':
 * @property integer $id
 * @property integer $attribute_id
 * @property integer $attribute_value_id
 * @property integer $attribute_group_id
 * @property integer $attribute_product_id
 */
class ProductAttribute extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductAttribute the static model class
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
		return '{{product_attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attribute_value_id, attribute_group_id, attribute_product_id', 'required'),
			array('attribute_id, attribute_value_id, attribute_group_id, attribute_product_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, attribute_id, attribute_value_id, attribute_group_id, attribute_product_id', 'safe', 'on'=>'search'),
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
            'group'=>array(self::BELONGS_TO,'AttributeGroup','attribute_group_id'),
            'attr'=>array(self::BELONGS_TO,'Attribute','attribute_id'),
            'attrvalue'=>array(self::BELONGS_TO,'AttributeValue','attribute_value_id'),
            'stock'=>array(self::HAS_ONE,'ProductStock','stock_attribute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'attribute_id' => 'Attribute',
			'attribute_value_id' => 'Attribute Value',
			'attribute_group_id' => 'Attribute Group',
			'attribute_product_id' => 'Attribute Product',
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

		$criteria->compare('id',$this->id);

		$criteria->compare('attribute_id',$this->attribute_id);

		$criteria->compare('attribute_value_id',$this->attribute_value_id);

		$criteria->compare('attribute_group_id',$this->attribute_group_id);

		$criteria->compare('attribute_product_id',$this->attribute_product_id);

		return new CActiveDataProvider('ProductAttribute', array(
			'criteria'=>$criteria,
		));
	}

    public function getID()
    {
        return $this->id;
    }
}