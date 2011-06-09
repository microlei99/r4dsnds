<?php

/**
 * This is the model class for table "{{Promotion}}".
 *
 * The followings are the available columns in table '{{Promotion}}':
 * @property integer $promotion_id
 * @property integer $promotion_price
 * @property integer $promotion_percent
 * @property integer $promotion_type
 * @property string $promotion_start_at
 * @property string $promotion_end_at
 * @property string $promotion_status
 * @property integer $promotion_group_id
 * @property integer $promotion_product_id
 */
class Promotion extends CActiveRecord
{
    const PROMOTION_EXPIRE = 1;
    const PROMOTION_ACTIVE = 2;
    const PROMOTION_CLOSED = 3;
    public $product_name;
    public $product_sku;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Promotion the static model class
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
		return '{{promotion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('promotion_start_at, promotion_end_at, promotion_status,promotion_type,promotion_percent, promotion_group_id,promotion_price, promotion_product_id', 'required'),
			array('promotion_type,promotion_group_id, promotion_product_id', 'numerical', 'integerOnly'=>true),
            array('promotion_product_id','unique','message'=>'该产品已存在促销信息'),
            array('promotion_price', 'numerical'),
            array('promotion_percent','numerical','max'=>100,'min'=>0),
			array('promotion_status', 'length', 'max'=>1),
            array('promotion_start_at,promotion_end_at','type','dateFormat'=>'yyyy-MM--dd'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('promotion_id, promotion_price,promotion_percent,promotion_start_at, promotion_end_at, promotion_status, promotion_group_id, promotion_product_id,product_name,product_sku', 'safe', 'on'=>'search'),
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
            'product'=>array(self::BELONGS_TO,'Product','promotion_product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'promotion_id' => 'Promotion',
			'promotion_start_at' => 'Promotion Start At',
			'promotion_end_at' => 'Promotion End At',
			'promotion_status' => 'Promotion Status',
			'promotion_group_id' => 'Promotion Group',
			'promotion_product_id' => 'Promotion Product',
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

		$criteria->compare('promotion_id',$this->promotion_id);

        $criteria->compare('promotion_price', $this->promotion_price);

        $criteria->compare('promotion_percent', $this->promotion_percent);

        $criteria->compare('promotion_type', $this->promotion_type);

		$criteria->compare('promotion_start_at',$this->promotion_start_at,true);

		$criteria->compare('promotion_end_at',$this->promotion_end_at,true);

		$criteria->compare('promotion_status',$this->promotion_status,true);

		$criteria->compare('promotion_group_id',$this->promotion_group_id);

		$criteria->compare('promotion_product_id',$this->promotion_product_id);

		return new CActiveDataProvider('Promotion', array(
			'criteria'=>$criteria,
		));
	}

    public function  beforeSave()
    {
        if($this->promotion_type==2)//折扣
        {
            $this->promotion_percent = $this->promotion_percent/100;
        }

        if(strtotime($this->promotion_start_at) >= strtotime($this->promotion_end_at))
        {
            $this->promotion_status = self::PROMOTION_EXPIRE;
        }

        return true;
    }

    public function afterSave()
    {
        /*更新产品表*/
        if($this->promotion_id)
        {
            $sign = ($this->promotion_status==Promotion::PROMOTION_ACTIVE) ? 1 : 0;
            Yii::app()->db->createCommand("UPDATE {{product}} SET product_promotion={$sign} WHERE product_id=".$this->promotion_product_id)->execute();
            Product::maintainStatus($this->promotion_product_id);
        }
    }

    public function  afterFind()
    {
        
        $this->promotion_percent*=100;
        if($this->promotion_percent>100)
        {
            $this->promotion_percent=100;
        }
    }

    public function  afterDelete()
    {
        if($this->promotion_product_id)
        {
            Yii::app()->db->createCommand("UPDATE {{product}} SET product_promotion=0 WHERE product_id=".$this->promotion_product_id)->execute();
            Product::maintainStatus($this->promotion_product_id);
        }
    }

    
}