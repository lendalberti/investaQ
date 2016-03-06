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
 * @property string $additional_notes
 * @property string $terms_conditions
 * @property string $customer_acknowledgment
 * @property string $risl
 * @property string $manufacturing_lead_time
 * @property integer $lost_reason_id
 * @property integer $no_bid_reason_id
 * @property integer $ready_to_order
 * @property string $salesperson_notes
 *
 * The followings are the available model relations:
 * @property Attachments[] $attachments
 * @property BtoItems[] $btoItems
 * @property Status $status
 * @property Customers $customer
 * @property Users $owner
 * @property LostReasons $lostReason
 * @property NoBidReasons $noBidReason
 * @property QuoteTypes $quoteType
 * @property Levels $level
 * @property Sources $source
 * @property Contacts $contact
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
			array('quote_no, quote_type_id, status_id, owner_id, customer_id, contact_id, updated_date, expiration_date, source_id', 'required'),
			array('quote_type_id, status_id, owner_id, customer_id, contact_id, level_id, source_id, lost_reason_id, no_bid_reason_id, ready_to_order', 'numerical', 'integerOnly'=>true),
			array('quote_no', 'length', 'max'=>45),
			array('created_date, additional_notes, terms_conditions, customer_acknowledgment, risl, manufacturing_lead_time, salesperson_notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quote_no, quote_type_id, status_id, owner_id, customer_id, contact_id, created_date, updated_date, expiration_date, level_id, source_id, additional_notes, terms_conditions, customer_acknowledgment, risl, manufacturing_lead_time, lost_reason_id, no_bid_reason_id, ready_to_order, salesperson_notes', 'safe', 'on'=>'search'),
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
			'btoItems' => array(self::HAS_MANY, 'BtoItems', 'quote_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
			'owner' => array(self::BELONGS_TO, 'Users', 'owner_id'),
			'lostReason' => array(self::BELONGS_TO, 'LostReasons', 'lost_reason_id'),
			'noBidReason' => array(self::BELONGS_TO, 'NoBidReasons', 'no_bid_reason_id'),
			'quoteType' => array(self::BELONGS_TO, 'QuoteTypes', 'quote_type_id'),
			'level' => array(self::BELONGS_TO, 'Levels', 'level_id'),
			'source' => array(self::BELONGS_TO, 'Sources', 'source_id'),
			'contact' => array(self::BELONGS_TO, 'Contacts', 'contact_id'),
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
			'additional_notes' => 'Additional Notes',
			'terms_conditions' => 'Terms Conditions',
			'customer_acknowledgment' => 'Customer Acknowledgment',
			'risl' => 'Risl',
			'manufacturing_lead_time' => 'Manufacturing Lead Time',
			'lost_reason_id' => 'Lost Reason',
			'no_bid_reason_id' => 'No Bid Reason',
			'ready_to_order' => 'Ready To Order',
			'salesperson_notes' => 'Salesperson Notes',
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
		$criteria->compare('additional_notes',$this->additional_notes,true);
		$criteria->compare('terms_conditions',$this->terms_conditions,true);
		$criteria->compare('customer_acknowledgment',$this->customer_acknowledgment,true);
		$criteria->compare('risl',$this->risl,true);
		$criteria->compare('manufacturing_lead_time',$this->manufacturing_lead_time,true);
		$criteria->compare('lost_reason_id',$this->lost_reason_id);
		$criteria->compare('no_bid_reason_id',$this->no_bid_reason_id);
		$criteria->compare('ready_to_order',$this->ready_to_order);
		$criteria->compare('salesperson_notes',$this->salesperson_notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function getAllSelects() {
		$selects = array();
		// order_probability  package_types  process_flow  testing  die_manufacturers

		foreach( array( 'order_probability', 'package_types', 'process_flow', 'testing') as $t ) {
			$order_by = ( $t=='order_probability' ? 'id' : 'name');
			$sql     = "SELECT * FROM $t ORDER BY $order_by";
			$command = Yii::app()->db->createCommand($sql);
			$results = $command->queryAll();

			foreach( $results as $r ) {
				$selects[$t][] = array( $r['id'] => $r['name'] );
			}
		}

		$sql     = "SELECT * FROM die_manufacturers ORDER BY short_name";
		$command = Yii::app()->db->createCommand($sql);
		$results = $command->queryAll();
		foreach( $results as $r ) {
			$selects['die_manufacturers'][] = array( $r['id'] => $r['short_name'] . ' - ' . $r['long_name'] );
		}

		//pDebug('getAllSelects() - selects:', $selects);
		return $selects;
	}





	// ----------------------------------------------------------------------
	public function getQuoteHistory($pn=null) {
		if ( !$pn ) {
			return null;
		}
		pDebug("Quotes::getQuoteHistory() - part no: [$pn]");

		$hostname = "crmpdb";
		$database = 'ProdED.[REI\elowell].erin_quote_history_vw'; 
		$username = 'CRMserver'; 
		$password = 'Rochester123'; 
		$count    = 1;
		$quotes = array();

		// ---------------------------------- 
		// query SQL Server on CRMpdb
		// ---------------------------------- 
		$MSSQL_conn = mssql_connect($hostname, $username, $password);
		if ( !$MSSQL_conn ) {
			pDebug("getQuoteHistory() - Can't connect to $hostname...\n\n");
		}

		$sql      = "SELECT TOP 1000 * FROM $database WHERE Part_Number LIKE '%$pn%'"; 
		$resource = mssql_query( $sql);

		if ( $resource ) {
			while( $q = mssql_fetch_assoc($resource) ) {
				$quotes[] = $q;
			}
		}
		else {
			pDebug("getQuoteHistory() - No resource found for db fetch...\n");
		}

		mssql_close($MSSQL_conn);



		// -------------------------------------------------------------------------
		// append local records into same array as remote record list above
		// -------------------------------------------------------------------------

		$sql = <<<EOS

		SELECT 	h.quote_no,		h.customer_id, 	h.salesperson_id, t.name as type, 
				s.name as status, l.name as lost_reason, b.name as no_bid_reason, 
				h.manufacturer, h.part_no, h.date_code, h.quantity, h.created, 	h.unit_price
		  FROM
		  		history h
		  			JOIN types          t ON t.id = h.type_id 
		  			JOIN status         s ON s.id = h.status_id
		  			JOIN lost_reasons   l ON l.id = h.lost_reason_id
		  			JOIN no_bid_reasons b ON b.id = h.no_bid_reason_id
		 WHERE
				h.part_no LIKE '%$pn%'
EOS;

		$local_quotes = Yii::app()->db->createCommand($sql)->queryAll();
		foreach( $local_quotes as $rec ) {

			$cust  = Customers::model()->findByPk( $rec['customer_id'] );
			$sales = Users::model()->findByPk($rec['salesperson_id']); 

			$tmp = array();
			$tmp['Opportunity_ID']     = $rec['quote_no'];
			$tmp['Type']               = $rec['type'];
			$tmp['Status']             = $rec['status'];
			$tmp['No_Bid_Lost_Reason'] = $rec['lost_reason'] . $rec['no_bid_reason']; 
			$tmp['Mfr']                = $rec['manufacturer'];
			$tmp['Part_Number']        = $rec['part_no'];
			$tmp['Date_Code']          = $rec['date_code'];
			$tmp['Quantity']           = $rec['quantity'];
			$tmp['Date']               = $rec['created'];
			$tmp['Unit_Price']         = $rec['unit_price'];

			$tmp['Address_1']          = $cust->address1;
			$tmp['Address_2']          = $cust->address2;
			$tmp['Customer']           = $cust->name;
			$tmp['City']               = $cust->city;
			$tmp['State_']             = $cust->state->short_name;
			$tmp['Country']            = $cust->country->short_name;
			$tmp['Zip']                = $cust->zip;
			$tmp['Location']           = $cust->city . ", " . $cust->state->short_name;

			$tmp['Contact']            = "tbd";   // $cust->contact_name;  // TODO: get name from contact id
			$tmp['Email']              = "tbd";   //$cust->contact_email;
			$tmp['Phone']              = "tbd";   //$cust->contact_phone1;

			$tmp['Sales_Person']       = $sales->first_name . " " . $sales->last_name;

			$quotes[] = $tmp;

		}

		return $quotes;

	}  // END_OF_FUNCTION getQuoteHistory()






	public function getSalesHistory($pn=null) {
		if ( !$pn ) {
			return null;
		}
		pDebug("Quotes::getSalesHistory() - part no: [$pn]");

		$hostname = "ERPPDB";
		$database = "CompanyR";
		$username = "ReadmeCase";
		$password = "Mexico1981#";
		$view     = "a_invoiced_sales_all_history_vw";

		$count    = 1;
		$sales   = array();

		// ---------------------------------- 
		// query SQL Server on erppdb
		// ---------------------------------- 
		$MSSQL_conn = mssql_connect($hostname, $username, $password);
		if ( !$MSSQL_conn ) {
			pDebug("getSalesHistory() - Can't connect to $hostname...\n\n");
		}

		$sql = <<<EOT

SELECT
		Order_Status, Order_Date, 	Customer_ID, 	Customer_Name, Ship_To_Customer_Name, 
		Invoice_Date, Invoice, Ship_To_City, Sales_Order, Ship_Date, Customer_Purchase_Order_ID,
		Sales_Person_Name,Line_Number,Part_Number,QTY_Invoiced,	Unit_Price,	Net_Amount

  FROM  
  		$view where Part_Number = '$pn' and Product_Class_Code != '_FRT'
 
ORDER BY 
			Order_Date DESC

EOT;

		$resource = mssql_query( $sql);

		if ( $resource ) {
			while( $record = mssql_fetch_assoc($resource) ) {
				$sales[] = $record;
			}
		}
		else {
			pDebug("getSalesHistory() - No resource found for db fetch...\n");
		}

		pDebug("Quotes::getSalesHistory() - sales history:", $sales);


		mssql_close($MSSQL_conn);
		return $sales;

	}  // END_OF_FUNCTION getSalesHistory()





	
}