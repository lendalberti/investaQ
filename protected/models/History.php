<?php

/**
 * This is the model class for table "history".
 *
 * The followings are the available columns in table 'history':
 * @property integer $id
 * @property integer $quote_id
 * @property string $quote_no
 * @property string $part_no
 * @property string $created
 * @property integer $type_id
 * @property string $manufacturer
 * @property string $date_code
 * @property integer $customer_id
 * @property string $location
 * @property integer $contact_id
 * @property integer $salesperson_id
 * @property integer $status_id
 * @property integer $lost_reason_id
 * @property integer $no_bid_reason_id
 * @property integer $quantity
 * @property double $unit_price
 *
 * The followings are the available model relations:
 * @property Types $type
 * @property Status $status
 * @property Customers $customer
 * @property Users $salesperson
 * @property Quotes $quote
 * @property LostReasons $lostReason
 * @property NoBidReasons $noBidReason
 * @property Contacts $contact
 */
class History extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return History the static model class
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
		return 'history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_id, quote_no, part_no', 'required'),
			array('quote_id, type_id, customer_id, contact_id, salesperson_id, status_id, lost_reason_id, no_bid_reason_id, quantity', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'numerical'),
			array('quote_no, part_no, manufacturer, date_code', 'length', 'max'=>45),
			array('location', 'length', 'max'=>255),
			array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quote_id, quote_no, part_no, created, type_id, manufacturer, date_code, customer_id, location, contact_id, salesperson_id, status_id, lost_reason_id, no_bid_reason_id, quantity, unit_price', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'Types', 'type_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
			'salesperson' => array(self::BELONGS_TO, 'Users', 'salesperson_id'),
			'quote' => array(self::BELONGS_TO, 'Quotes', 'quote_id'),
			'lostReason' => array(self::BELONGS_TO, 'LostReasons', 'lost_reason_id'),
			'noBidReason' => array(self::BELONGS_TO, 'NoBidReasons', 'no_bid_reason_id'),
			'contact' => array(self::BELONGS_TO, 'Contacts', 'contact_id'),
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
			'quote_no' => 'Quote No',
			'part_no' => 'Part No',
			'created' => 'Created',
			'type_id' => 'Type',
			'manufacturer' => 'Manufacturer',
			'date_code' => 'Date Code',
			'customer_id' => 'Customer',
			'location' => 'Location',
			'contact_id' => 'Contact',
			'salesperson_id' => 'Salesperson',
			'status_id' => 'Status',
			'lost_reason_id' => 'Lost Reason',
			'no_bid_reason_id' => 'No Bid Reason',
			'quantity' => 'Quantity',
			'unit_price' => 'Unit Price',
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
		$criteria->compare('quote_no',$this->quote_no,true);
		$criteria->compare('part_no',$this->part_no,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('date_code',$this->date_code,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('contact_id',$this->contact_id);
		$criteria->compare('salesperson_id',$this->salesperson_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('lost_reason_id',$this->lost_reason_id);
		$criteria->compare('no_bid_reason_id',$this->no_bid_reason_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('unit_price',$this->unit_price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}