<?php

/**
 * This is the model class for table "{{Wholesale}}".
 *
 * The followings are the available columns in table '{{Wholesale}}':
 * @property integer $wholesale_id
 * @property integer $wholesale_product_id
 * @property integer $wholesale_product_interval1
 * @property integer $wholesale_product_interval2
 * @property integer $wholesale_type
 * @property integer $wholesale_active
 * @property string $wholesale_product_price
 * @property integer $wholesale_product_percent
 * @property string $wholesale_create_at
 */
class Wholesale extends CActiveRecord
{
    public $product_name;
    public $product_sku;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Wholesale the static model class
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
		return '{{wholesale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wholesale_product_id, wholesale_product_interval1, wholesale_product_interval2, wholesale_type, wholesale_active, wholesale_product_price, wholesale_product_percent', 'required'),
			array('wholesale_product_id, wholesale_product_interval1, wholesale_product_interval2, wholesale_type, wholesale_active', 'numerical', 'integerOnly'=>true),
			array('wholesale_product_price', 'length', 'max'=>6),
            array('wholesale_product_price,wholesale_product_percent','numerical'),
            array('wholesale_product_percent','numerical','max'=>100,'min'=>0),
            array('wholesale_product_interval2','compare','compareAttribute'=>'wholesale_product_interval1','operator'=>'>=','message'=>'批发上限必须大于等于批发下限'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_name,product_sku,wholesale_id, wholesale_product_id, wholesale_product_interval1, wholesale_product_interval2, wholesale_type, wholesale_active, wholesale_product_price, wholesale_product_percent, wholesale_create_at', 'safe', 'on'=>'search'),
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
            'product'=>array(self::BELONGS_TO,'Product','wholesale_product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wholesale_id' => 'Wholesale',
			'wholesale_product_id' => 'Wholesale Product',
			'wholesale_product_interval1' => 'Wholesale Product Interval1',
			'wholesale_product_interval2' => 'Wholesale Product Interval2',
			'wholesale_type' => 'Wholesale Type',
			'wholesale_active' => 'Wholesale Active',
			'wholesale_product_price' => 'Wholesale Product Price',
			'wholesale_product_percent' => 'Wholesale Product Percent',
			'wholesale_create_at' => 'Wholesale Create At',
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

		$criteria=new CDbCriteria(array(
            'with'=>array('product'),
        ));

        $criteria->compare('product_name',$this->product_name,true);

        $criteria->compare('product_sku', $this->product_sku,true);

		$criteria->compare('wholesale_id',$this->wholesale_id);

		$criteria->compare('wholesale_product_id',$this->wholesale_product_id);

		$criteria->compare('wholesale_product_interval1',$this->wholesale_product_interval1);

		$criteria->compare('wholesale_product_interval2',$this->wholesale_product_interval2);

		$criteria->compare('wholesale_type',$this->wholesale_type);

		$criteria->compare('wholesale_active',$this->wholesale_active);

		$criteria->compare('wholesale_product_price',$this->wholesale_product_price,true);

		$criteria->compare('wholesale_product_percent',$this->wholesale_product_percent);

		$criteria->compare('wholesale_create_at',$this->wholesale_create_at,true);

		return new CActiveDataProvider('Wholesale', array(
			'criteria'=>$criteria,
		));
	}
    

    public function afterSave()
    {
        /*更新产品表*/
        if($this->wholesale_id)
        {
            if(self::model()->exists(array('condition'=>'wholesale_product_id='.$this->wholesale_product_id))){
                $sign = 4;
            }
            else{
                $sign = 0;
            }
            
            Yii::app()->db->createCommand("UPDATE {{product}} SET product_wholesale={$sign} WHERE product_id=".$this->wholesale_product_id)->execute();
            Product::maintainStatus($this->wholesale_product_id);
        }
    }

    public function  afterDelete()
    {
        if($this->wholesale_id)
        {
            if(self::model()->exists(array('condition'=>'wholesale_product_id='.$this->wholesale_product_id))){
                $sign = 4;
            }
            else{
                $sign = 0;
            }
            Yii::app()->db->createCommand("UPDATE {{product}} SET product_wholesale={$sign} WHERE product_id=".$this->wholesale_product_id)->execute();
            Product::maintainStatus($this->wholesale_product_id);
        }
    }
}