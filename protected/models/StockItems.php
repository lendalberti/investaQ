<?php

/**
 * This is the model class for table "stock_items".
 *
 * The followings are the available columns in table 'stock_items':
 * @property integer $id
 * @property integer $quote_id
 * @property string $part_no
 * @property string $manufacturer
 * @property string $line_note
 * @property string $date_code
 * @property integer $qty_1_24
 * @property integer $qty_25_99
 * @property integer $qty_100_499
 * @property integer $qty_500_999
 * @property integer $qty_1000_Plus
 * @property integer $qty_Base
 * @property integer $qty_Custom
 * @property string $qty_NoBid
 * @property integer $qty_Available
 * @property double $price_1_24
 * @property double $price_25_99
 * @property double $price_100_499
 * @property double $price_500_999
 * @property double $price_1000_Plus
 * @property double $price_Base
 * @property double $price_Custom
 * @property string $last_updated
 * @property string $comments
 *
 * The followings are the available model relations:
 * @property Quotes $quote
 */
class StockItems extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StockItems the static model class
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
		return 'stock_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_id, part_no', 'required'),
			array('quote_id, qty_1_24, qty_25_99, qty_100_499, qty_500_999, qty_1000_Plus, qty_Base, qty_Custom, qty_Available', 'numerical', 'integerOnly'=>true),
			array('price_1_24, price_25_99, price_100_499, price_500_999, price_1000_Plus, price_Base, price_Custom', 'numerical'),
			array('part_no, manufacturer, date_code, qty_NoBid', 'length', 'max'=>45),
			array('line_note, last_updated, comments', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quote_id, part_no, manufacturer, line_note, date_code, qty_1_24, qty_25_99, qty_100_499, qty_500_999, qty_1000_Plus, qty_Base, qty_Custom, qty_NoBid, qty_Available, price_1_24, price_25_99, price_100_499, price_500_999, price_1000_Plus, price_Base, price_Custom, last_updated, comments', 'safe', 'on'=>'search'),
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
			'quote' => array(self::BELONGS_TO, 'Quotes', 'quote_id'),
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
			'part_no' => 'Part No',
			'manufacturer' => 'Manufacturer',
			'line_note' => 'Line Note',
			'date_code' => 'Date Code',
			'qty_1_24' => 'Qty 1 24',
			'qty_25_99' => 'Qty 25 99',
			'qty_100_499' => 'Qty 100 499',
			'qty_500_999' => 'Qty 500 999',
			'qty_1000_Plus' => 'Qty 1000 Plus',
			'qty_Base' => 'Qty Base',
			'qty_Custom' => 'Qty Custom',
			'qty_NoBid' => 'Qty No Bid',
			'qty_Available' => 'Qty Available',
			'price_1_24' => 'Price 1 24',
			'price_25_99' => 'Price 25 99',
			'price_100_499' => 'Price 100 499',
			'price_500_999' => 'Price 500 999',
			'price_1000_Plus' => 'Price 1000 Plus',
			'price_Base' => 'Price Base',
			'price_Custom' => 'Price Custom',
			'last_updated' => 'Last Updated',
			'comments' => 'Comments',
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
		$criteria->compare('part_no',$this->part_no,true);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('line_note',$this->line_note,true);
		$criteria->compare('date_code',$this->date_code,true);
		$criteria->compare('qty_1_24',$this->qty_1_24);
		$criteria->compare('qty_25_99',$this->qty_25_99);
		$criteria->compare('qty_100_499',$this->qty_100_499);
		$criteria->compare('qty_500_999',$this->qty_500_999);
		$criteria->compare('qty_1000_Plus',$this->qty_1000_Plus);
		$criteria->compare('qty_Base',$this->qty_Base);
		$criteria->compare('qty_Custom',$this->qty_Custom);
		$criteria->compare('qty_NoBid',$this->qty_NoBid,true);
		$criteria->compare('qty_Available',$this->qty_Available);
		$criteria->compare('price_1_24',$this->price_1_24);
		$criteria->compare('price_25_99',$this->price_25_99);
		$criteria->compare('price_100_499',$this->price_100_499);
		$criteria->compare('price_500_999',$this->price_500_999);
		$criteria->compare('price_1000_Plus',$this->price_1000_Plus);
		$criteria->compare('price_Base',$this->price_Base);
		$criteria->compare('price_Custom',$this->price_Custom);
		$criteria->compare('last_updated',$this->last_updated,true);
		$criteria->compare('comments',$this->comments,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}