<?php

/**
 * This is the model class for table "{{ProductImage}}".
 *
 * The followings are the available columns in table '{{ProductImage}}':
 * @property integer $image_id
 * @property string $image_path
 * @property string $image_alt
 * @property string $image_default
 * @property string $image_used
 * @property integer $image_product_id
 */
class ProductImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductImage the static model class
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
		return '{{product_image}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image_path, image_product_id', 'required'),
			array('image_product_id', 'numerical', 'integerOnly'=>true),
			array('image_path', 'length', 'max'=>64),
			array('image_alt', 'length', 'max'=>100),
			array('image_used,image_default', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('image_id, image_path, image_alt, image_default,image_used, image_product_id', 'safe', 'on'=>'search'),
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
			'image_id' => 'Image',
			'image_path' => 'Image Path',
			'image_alt' => 'Image Alt',
			'image_used' => 'Image Used',
			'image_product_id' => 'Image Product',
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

		$criteria->compare('image_id',$this->image_id);

		$criteria->compare('image_path',$this->image_path,true);

		$criteria->compare('image_alt',$this->image_alt,true);

        $criteria->compare('image_default',$this->image_default,true);

		$criteria->compare('image_used',$this->image_used,true);

		$criteria->compare('image_product_id',$this->image_product_id);

		return new CActiveDataProvider('ProductImage', array(
			'criteria'=>$criteria,
		));
	}

    public function beforeValidate()
    {
        if($this->isNewRecord)
        {
            $this->image_used = 0;
            $this->image_default = 0;
            $this->image_alt = '';
        }
        return true;
    }

    public function afterDelete()
    {
        if(file_exists('.'.$image->image_path))
        {
            if(is_writable('.' . $image->image_path))
            {
                /*$info = pathinfo($image->image_path);
                unlink('.' . $image->image_path);
                unlink('.' . $info['dirname'] . '/' . $info['filename'] . '_large.' . $info['extension']);
                unlink('.' . $info['dirname'] . '/' . $info['filename'] . '_small.' . $info['extension']);
                unlink('.' . $info['dirname'] . '/' . $info['filename'] . '_super.' . $info['extension']);*/
            }
        }
    }

    public function createImageDir($productID)
    {
        if(file_exists('./media/product') && is_dir('./media/product'))
        {
            if(!file_exists('./media/product/'.$productID))
            {
                mkdir('./media/product/'.$productID,0777);
                file_put_contents('./media/product/'.$productID.'/index.html', '');
            }
        }
        else
        {
            mkdir('./media/product',0777,true);
            $this->createImageDir($productID);
        }
        return '/media/product/'.$productID;
    }

    public function imageCut($imagePath,$ext)
    {
        Yii::import('ext.image.TradeImage');
        $image = new TradeImage( $imagePath . $ext);

        $sizeConfig = Config::items('image');

        $image->resize($sizeConfig['small_size_x'],$sizeConfig['small_size_y']);
        $image->save($imagePath .  '_small' . $ext);

        $image->resize(80,80);
        $image->save($imagePath .  '_middle' . $ext);

        $image->resize($sizeConfig['list_size_x'],$sizeConfig['list_size_y']);//列表
        $image->save($imagePath . '_list' .$ext);

        $image->resize($sizeConfig['product_size_x'],$sizeConfig['product_size_y']);//产品页
        $image->save($imagePath . '_product' .$ext);

        return true;
    }

    public function getImage($type='')
    {      
        $name = substr($this->image_path,0,strrpos($this->image_path,'.'));
        $ext = end(explode('.',$this->image_path));
        return $name.$type.'.'.$ext;
    }
}