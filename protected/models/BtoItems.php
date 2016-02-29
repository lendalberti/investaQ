<?php

/**
 * This is the model class for table "bto_items".
 *
 * The followings are the available columns in table 'bto_items':
 * @property integer $id
 * @property integer $quote_id
 * @property integer $approvers_notified
 * @property string $requested_part_number
 * @property string $generic_part_number
 * @property integer $order_probability_id
 * @property integer $quantity1
 * @property integer $quantity2
 * @property integer $quantity3
 * @property integer $die_manufacturer_id
 * @property integer $package_type_id
 * @property integer $lead_count
 * @property integer $process_flow_id
 * @property integer $testing_id
 * @property integer $priority_id
 * @property string $temp_low
 * @property string $temp_high
 * @property integer $ncnr
 * @property integer $itar
 * @property integer $have_die
 * @property integer $spa
 * @property integer $recreation
 * @property integer $wip_product
 * @property string $created_date
 * @property string $updated_date
 *
 * The followings are the available model relations:
 * @property BtoComments[] $btoComments
 * @property DieManufacturers $dieManufacturer
 * @property PackageTypes $packageType
 * @property ProcessFlow $processFlow
 * @property Testing $testing
 * @property Quotes $quote
 * @property Priority $priority
 * @property OrderProbability $orderProbability
 * @property BtoStatus[] $btoStatuses
 */
class BtoItems extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BtoItems the static model class
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
		return 'bto_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_id, requested_part_number', 'required'),
			array('quote_id, approvers_notified, order_probability_id, quantity1, quantity2, quantity3, die_manufacturer_id, package_type_id, lead_count, process_flow_id, testing_id, priority_id, ncnr, itar, have_die, spa, recreation, wip_product', 'numerical', 'integerOnly'=>true),
			array('requested_part_number, generic_part_number, temp_low, temp_high', 'length', 'max'=>45),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quote_id, approvers_notified, requested_part_number, generic_part_number, order_probability_id, quantity1, quantity2, quantity3, die_manufacturer_id, package_type_id, lead_count, process_flow_id, testing_id, priority_id, temp_low, temp_high, ncnr, itar, have_die, spa, recreation, wip_product, created_date, updated_date', 'safe', 'on'=>'search'),
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
			'btoMessages' => array(self::HAS_MANY, 'BtoMessages', 'bto_item_id'),
			'dieManufacturer' => array(self::BELONGS_TO, 'DieManufacturers', 'die_manufacturer_id'),
			'packageType' => array(self::BELONGS_TO, 'PackageTypes', 'package_type_id'),
			'processFlow' => array(self::BELONGS_TO, 'ProcessFlow', 'process_flow_id'),
			'testing' => array(self::BELONGS_TO, 'Testing', 'testing_id'),
			'quote' => array(self::BELONGS_TO, 'Quotes', 'quote_id'),
			'priority' => array(self::BELONGS_TO, 'Priority', 'priority_id'),
			'orderProbability' => array(self::BELONGS_TO, 'OrderProbability', 'order_probability_id'),
			'btoStatuses' => array(self::HAS_MANY, 'BtoStatus', 'bto_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quote_id' => 'Quote',
			'approvers_notified' => 'Approvers Notified',
			'requested_part_number' => 'Requested Part Number',
			'generic_part_number' => 'Generic Part Number',
			'order_probability_id' => 'Order Probability',
			'quantity1' => 'Quantity1',
			'quantity2' => 'Quantity2',
			'quantity3' => 'Quantity3',
			'die_manufacturer_id' => 'Die Manufacturer',
			'package_type_id' => 'Package Type',
			'lead_count' => 'Lead Count',
			'process_flow_id' => 'Process Flow',
			'testing_id' => 'Testing',
			'priority_id' => 'Priority',
			'temp_low' => 'Temp Low',
			'temp_high' => 'Temp High',
			'ncnr' => 'Ncnr',
			'itar' => 'Itar',
			'have_die' => 'Have Die',
			'spa' => 'Spa',
			'recreation' => 'Recreation',
			'wip_product' => 'Wip Product',
			'created_date' => 'Created Date',
			'updated_date' => 'Updated Date',
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
		$criteria->compare('quote_id',$this->quote_id);
		$criteria->compare('approvers_notified',$this->approvers_notified);
		$criteria->compare('requested_part_number',$this->requested_part_number,true);
		$criteria->compare('generic_part_number',$this->generic_part_number,true);
		$criteria->compare('order_probability_id',$this->order_probability_id);
		$criteria->compare('quantity1',$this->quantity1);
		$criteria->compare('quantity2',$this->quantity2);
		$criteria->compare('quantity3',$this->quantity3);
		$criteria->compare('die_manufacturer_id',$this->die_manufacturer_id);
		$criteria->compare('package_type_id',$this->package_type_id);
		$criteria->compare('lead_count',$this->lead_count);
		$criteria->compare('process_flow_id',$this->process_flow_id);
		$criteria->compare('testing_id',$this->testing_id);
		$criteria->compare('priority_id',$this->priority_id);
		$criteria->compare('temp_low',$this->temp_low,true);
		$criteria->compare('temp_high',$this->temp_high,true);
		$criteria->compare('ncnr',$this->ncnr);
		$criteria->compare('itar',$this->itar);
		$criteria->compare('have_die',$this->have_die);
		$criteria->compare('spa',$this->spa);
		$criteria->compare('recreation',$this->recreation);
		$criteria->compare('wip_product',$this->wip_product);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}