<?php

/**
 * This is the model class for table "{{ProductStatistic}}".
 *
 * The followings are the available columns in table '{{ProductStatistic}}':
 * @property integer $product_id
 * @property integer $product_viewed
 * @property integer $product_carted
 * @property integer $product_buyed
 * @property integer $product_reviewed
 * @property integer $product_wished
 */
class ProductStatistic extends CActiveRecord
{
    public $product_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductStatistic the static model class
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
		return '{{product_statistic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, product_viewed, product_carted,product_buyed, product_reviewed, product_wished', 'required'),
			array('product_id, product_viewed, product_carted,product_buyed, product_reviewed, product_wished', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_id, product_viewed, product_carted,product_buyed, product_reviewed, product_wished,product_name', 'safe', 'on'=>'search'),
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
            'product'=>array(self::BELONGS_TO,'Product','product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_id' => 'Product',
			'product_viewed' => 'Product Viewed',
            'product_carted' => 'Product Carted',
			'product_buyed' => 'Product Buyed',
			'product_reviewed' => 'Product Reviewed',
			'product_wished' => 'Product Wished',
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

       $criteria->compare('product.product_name', $this->product_name);

		$criteria->compare('product_id',$this->product_id);

		$criteria->compare('product_viewed',$this->product_viewed);

        $criteria->compare('product_carted',$this->product_carted);

		$criteria->compare('product_buyed',$this->product_buyed);

		$criteria->compare('product_reviewed',$this->product_reviewed);

		$criteria->compare('product_wished',$this->product_wished);

		return new CActiveDataProvider('ProductStatistic', array(
			'criteria'=>$criteria,
		));
	}

    public function popular($limit=5)
    {
        $this->getDbCriteria()->mergeWith(array(
                'order'=>'product_buyed DESC',
                'limit'=>$limit,
        ));
        return $this;
    }

    public function viewed($limit=5)
    {
        $this->getDbCriteria()->mergeWith(array(
                'order'=>'product_viewed DESC',
                'limit'=>$limit,
        ));
        return $this;
    }

    public function reviewed($limit=5)
    {
        $this->getDbCriteria()->mergeWith(array(
                'order'=>'product_reviewed DESC',
                'limit'=>$limit,
        ));
        return $this;
    }

    public static function Statistic($productID,$data=array())
    {
        if($productID && is_array($data))
        {
            $sql = '';
            if(isset($data['viewed']))
            {
                $sql .= ' ,product_viewed=product_viewed+'.$data['viewed'];
            }
            if(isset($data['carted']))
            {
                $sql .= ' ,product_carted=product_carted+'.$data['carted'];
            }
            if(isset($data['buyed']))
            {
                $sql .= ' ,product_buyed=product_buyed+'.$data['buyed'];
            }
            if(isset($data['product_reviewed']))
            {
                $sql .= ' ,product_reviewed=product_reviewed+'.$data['reviewed'];
            }
            if(isset($data['product_wished']))
            {
                $sql .= ' ,product_wished=product_wished+'.$data['wished'];
            }
            $sql = "UPDATE {{product_statistic}} SET ".substr($sql,2).' WHERE product_id='.$productID;
            Yii::app()->db->createCommand($sql)->execute();
        }
    }
}