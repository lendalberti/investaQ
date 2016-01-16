<?php

/**
 * This is the model class for table "quotes".
 *
 * The followings are the available columns in table 'quotes':
 * @property integer $id
 * @property string $quote_no
 * @property integer $type_id
 * @property integer $status_id
 * @property integer $user_id
 * @property integer $customer_id
 * @property string $additional_notes
 * @property string $terms_conditions
 * @property string $created
 * @property string $updated
 * @property string $customer_acknowledgment
 * @property string $risl
 * @property string $manufacturing_lead_time
 * @property string $expiration_date
 * @property integer $lost_reason_id
 * @property integer $no_bid_reason_id
 * @property integer $ready_to_order
 *
 * The followings are the available model relations:
 * @property Attachments[] $attachments
 * @property History[] $histories
 * @property Items[] $items
 * @property Status $status
 * @property Customers $customer
 * @property Users $user
 * @property LostReasons $lostReason
 * @property NoBidReasons $noBidReason
 * @property Types $type
 */
class Quotes extends CActiveRecord {

	const   STOCK                   = 1,  
            MANUFACTURING           = 2,  
            SUPPLIER_REQUEST_FORM   = 3;


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
			array('quote_no, status_id, user_id, customer_id, created, expiration_date', 'required'),
			array('type_id, status_id, user_id, customer_id, lost_reason_id, no_bid_reason_id, ready_to_order', 'numerical', 'integerOnly'=>true),
			array('quote_no', 'length', 'max'=>45),
			array('additional_notes, terms_conditions, updated, customer_acknowledgment, risl, manufacturing_lead_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quote_no, type_id, status_id, user_id, customer_id, additional_notes, terms_conditions, created, updated, customer_acknowledgment, risl, manufacturing_lead_time, expiration_date, lost_reason_id, no_bid_reason_id, ready_to_order', 'safe', 'on'=>'search'),
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
			'histories' => array(self::HAS_MANY, 'History', 'quote_id'),
			'items' => array(self::HAS_MANY, 'Items', 'quote_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'lostReason' => array(self::BELONGS_TO, 'LostReasons', 'lost_reason_id'),
			'noBidReason' => array(self::BELONGS_TO, 'NoBidReasons', 'no_bid_reason_id'),
			'type' => array(self::BELONGS_TO, 'Types', 'type_id'),
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
			'type_id' => 'Type',
			'status_id' => 'Status',
			'user_id' => 'User',
			'customer_id' => 'Customer',
			'additional_notes' => 'Additional Notes',
			'terms_conditions' => 'Terms Conditions',
			'created' => 'Created',
			'updated' => 'Updated',
			'customer_acknowledgment' => 'Customer Acknowledgment',
			'risl' => 'Risl',
			'manufacturing_lead_time' => 'Manufacturing Lead Time',
			'expiration_date' => 'Expiration Date',
			'lost_reason_id' => 'Lost Reason',
			'no_bid_reason_id' => 'No Bid Reason',
			'ready_to_order' => 'Ready To Order',
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('additional_notes',$this->additional_notes,true);
		$criteria->compare('terms_conditions',$this->terms_conditions,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('customer_acknowledgment',$this->customer_acknowledgment,true);
		$criteria->compare('risl',$this->risl,true);
		$criteria->compare('manufacturing_lead_time',$this->manufacturing_lead_time,true);
		$criteria->compare('expiration_date',$this->expiration_date,true);
		$criteria->compare('lost_reason_id',$this->lost_reason_id);
		$criteria->compare('no_bid_reason_id',$this->no_bid_reason_id);
		$criteria->compare('ready_to_order',$this->ready_to_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}