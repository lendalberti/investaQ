<?php

/**
 * This is the model class for table "quotes".
 *
 * The followings are the available columns in table 'quotes':
 * @property integer $id
 * @property string $quote_no
 * @property integer $quote_type_id
 * @property integer $status_id
 * @property integer $owner_id
 * @property integer $customer_id
 * @property integer $contact_id
 * @property string $created_date
 * @property string $updated_date
 * @property string $expiration_date
 * @property integer $level_id
 * @property integer $source_id
 * @property integer $lead_quality_id
 * @property string $additional_notes
 * @property string $terms_conditions
 * @property string $customer_acknowledgment
 * @property string $risl
 * @property string $manufacturing_lead_time
 * @property integer $lost_reason_id
 * @property integer $no_bid_reason_id
 * @property integer $ready_to_order
 * @property string $requested_part_number
 * @property string $generic_part_number
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
 *
 * The followings are the available model relations:
 * @property Attachments[] $attachments
 * @property BtoApprovals[] $btoApprovals
 * @property Customers $customer
 * @property Users $owner
 * @property Status $status
 * @property LostReasons $lostReason
 * @property NoBidReasons $noBidReason
 * @property QuoteTypes $quoteType
 * @property Levels $level
 * @property Sources $source
 * @property DieManufacturers $dieManufacturer
 * @property PackageTypes $packageType
 * @property ProcessFlow $processFlow
 * @property Testing $testing
 * @property Priority $priority
 * @property LeadQuality $leadQuality
 * @property StockItems[] $stockItems
 */
class Quotes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Quotes the static model class
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
		return 'quotes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_no, quote_type_id, status_id, owner_id, customer_id, contact_id, created_date, updated_date, expiration_date, source_id', 'required'),
			array('quote_type_id, status_id, owner_id, customer_id, contact_id, level_id, source_id, lead_quality_id, lost_reason_id, no_bid_reason_id, ready_to_order, quantity1, quantity2, quantity3, die_manufacturer_id, package_type_id, lead_count, process_flow_id, testing_id, priority_id, ncnr, itar, have_die, spa', 'numerical', 'integerOnly'=>true),
			array('quote_no, requested_part_number, generic_part_number, temp_low, temp_high', 'length', 'max'=>45),
			array('additional_notes, terms_conditions, customer_acknowledgment, risl, manufacturing_lead_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quote_no, quote_type_id, status_id, owner_id, customer_id, contact_id, created_date, updated_date, expiration_date, level_id, source_id, lead_quality_id, additional_notes, terms_conditions, customer_acknowledgment, risl, manufacturing_lead_time, lost_reason_id, no_bid_reason_id, ready_to_order, requested_part_number, generic_part_number, quantity1, quantity2, quantity3, die_manufacturer_id, package_type_id, lead_count, process_flow_id, testing_id, priority_id, temp_low, temp_high, ncnr, itar, have_die, spa', 'safe', 'on'=>'search'),
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
			'attachments' => array(self::HAS_MANY, 'Attachments', 'quote_id'),
			'btoApprovals' => array(self::HAS_MANY, 'BtoApprovals', 'quote_id'),
			'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
			'contact' => array(self::BELONGS_TO, 'Contacts', 'contact_id'),
			'owner' => array(self::BELONGS_TO, 'Users', 'owner_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'lostReason' => array(self::BELONGS_TO, 'LostReasons', 'lost_reason_id'),
			'noBidReason' => array(self::BELONGS_TO, 'NoBidReasons', 'no_bid_reason_id'),
			'quoteType' => array(self::BELONGS_TO, 'QuoteTypes', 'quote_type_id'),
			'level' => array(self::BELONGS_TO, 'Levels', 'level_id'),
			'source' => array(self::BELONGS_TO, 'Sources', 'source_id'),
			'dieManufacturer' => array(self::BELONGS_TO, 'DieManufacturers', 'die_manufacturer_id'),
			'packageType' => array(self::BELONGS_TO, 'PackageTypes', 'package_type_id'),
			'processFlow' => array(self::BELONGS_TO, 'ProcessFlow', 'process_flow_id'),
			'testing' => array(self::BELONGS_TO, 'Testing', 'testing_id'),
			'priority' => array(self::BELONGS_TO, 'Priority', 'priority_id'),
			'leadQuality' => array(self::BELONGS_TO, 'LeadQuality', 'lead_quality_id'),
			'stockItems' => array(self::HAS_MANY, 'StockItems', 'quote_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quote_no' => 'Quote No',
			'quote_type_id' => 'Quote Type',
			'status_id' => 'Status',
			'owner_id' => 'Owner',
			'customer_id' => 'Customer',
			'contact_id' => 'Contact',
			'created_date' => 'Created Date',
			'updated_date' => 'Updated Date',
			'expiration_date' => 'Expiration Date',
			'level_id' => 'Level',
			'source_id' => 'Source',
			'lead_quality_id' => 'Lead Quality',
			'additional_notes' => 'Additional Notes',
			'terms_conditions' => 'Terms Conditions',
			'customer_acknowledgment' => 'Customer Acknowledgment',
			'risl' => 'Risl',
			'manufacturing_lead_time' => 'Manufacturing Lead Time',
			'lost_reason_id' => 'Lost Reason',
			'no_bid_reason_id' => 'No Bid Reason',
			'ready_to_order' => 'Ready To Order',
			'requested_part_number' => 'Requested Part Number',
			'generic_part_number' => 'Generic Part Number',
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
		$criteria->compare('quote_no',$this->quote_no,true);
		$criteria->compare('quote_type_id',$this->quote_type_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('contact_id',$this->contact_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('expiration_date',$this->expiration_date,true);
		$criteria->compare('level_id',$this->level_id);
		$criteria->compare('source_id',$this->source_id);
		$criteria->compare('lead_quality_id',$this->lead_quality_id);
		$criteria->compare('additional_notes',$this->additional_notes,true);
		$criteria->compare('terms_conditions',$this->terms_conditions,true);
		$criteria->compare('customer_acknowledgment',$this->customer_acknowledgment,true);
		$criteria->compare('risl',$this->risl,true);
		$criteria->compare('manufacturing_lead_time',$this->manufacturing_lead_time,true);
		$criteria->compare('lost_reason_id',$this->lost_reason_id);
		$criteria->compare('no_bid_reason_id',$this->no_bid_reason_id);
		$criteria->compare('ready_to_order',$this->ready_to_order);
		$criteria->compare('requested_part_number',$this->requested_part_number,true);
		$criteria->compare('generic_part_number',$this->generic_part_number,true);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}