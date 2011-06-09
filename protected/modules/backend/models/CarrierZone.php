<?php

/**
 * This is the model class for table "{{CarrierZone}}".
 *
 * The followings are the available columns in table '{{CarrierZone}}':
 * @property integer $carrier_id
 * @property integer $zone_id
 */
class CarrierZone extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CarrierZone the static model class
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
		return '{{carrier_zone}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carrier_id, zone_id', 'required'),
			array('carrier_id, zone_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('carrier_id, zone_id', 'safe', 'on'=>'search'),
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
			'carrier_id' => 'Carrier',
			'zone_id' => 'Zone',
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

		$criteria->compare('carrier_id',$this->carrier_id);

		$criteria->compare('zone_id',$this->zone_id);

		return new CActiveDataProvider('CarrierZone', array(
			'criteria'=>$criteria,
		));
	}

    public static function addment($carrierID, $zones)
    {
        if (!$carrierID || !$zones || !is_array($zones))
        {
            return;
        }

        foreach ($zones as $row)
        {
            $insert.="('{$carrierID}','{$row}'),";
        }
        $insert = trim($insert, ',');
        $req = Yii::app()->db->createCommand(
                "INSERT INTO {{carrier_zone}} "
                . " (`carrier_id`,`zone_id`) VALUES " . $insert
        );
        return $req->query();
    }

    public static function updateHook($carrierID, $zones)
    {
        if (!$carrierID || !$zones || !is_array($zones))
        {
            return;
        }
        
        $oldzones = self::getZones($carrierID);
        if ($oldzones)
        {
            $del = array_diff($oldzones, $zones);
            $add = array_diff($zones, $oldzones);
        }
        else
        {
            $add = $zones;
        }
        self::zoneDelete($carrierID, $del);
        self::Addment($carrierID, $add);
    }

    public static function getZones($carrierID)
    {
        $res = array();
        if (!$carrierID)
        {
            return $res;
        }
        $req = Yii::app()->db->createCommand(
                "SELECT zone_id as id FROM {{carrier_zone}} where carrier_id={$carrierID}"
        );
        $res = $req->queryColumn();
        return $res;
    }

    public static function zoneDelete($carrierID, $zones)
    {
        if (!$carrierID || !$zones || !is_array($zones))
        {
            return;
        }
        $IN = trim(implode(',', $zones), ',');
        $req = Yii::app()->db->createCommand(
                "DELETE FROM {{carrier_zone}} "
                . " WHERE zone_id IN ({$IN}) and carrier_id={$carrierID} "
        );
        $req->query();
    }
}