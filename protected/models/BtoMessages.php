<?php

/**
 * This is the model class for table "bto_messages".
 *
 * The followings are the available columns in table 'bto_messages':
 * @property integer $id
 * @property integer $quote_id
 * @property integer $bto_item_id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $subject
 * @property string $message
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Users $fromUser
 * @property BtoItems $btoItem
 * @property Users $toUser
 */
class BtoMessages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BtoMessages the static model class
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
		return 'bto_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_id, bto_item_id, from_user_id, to_user_id, subject, message', 'required'),
			array('quote_id, bto_item_id, from_user_id, to_user_id', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>255),
			array('date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quote_id, bto_item_id, from_user_id, to_user_id, subject, message, date_created', 'safe', 'on'=>'search'),
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
			'fromUser' => array(self::BELONGS_TO, 'Users', 'from_user_id'),
			'btoItem' => array(self::BELONGS_TO, 'BtoItems', 'bto_item_id'),
			'toUser' => array(self::BELONGS_TO, 'Users', 'to_user_id'),
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
			'bto_item_id' => 'Bto Item',
			'from_user_id' => 'From User',
			'to_user_id' => 'To User',
			'subject' => 'Subject',
			'message' => 'Message',
			'date_created' => 'Date Created',
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
		$criteria->compare('bto_item_id',$this->bto_item_id);
		$criteria->compare('from_user_id',$this->from_user_id);
		$criteria->compare('to_user_id',$this->to_user_id);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	public function getAllMessageSubjects($quote_id) {
		$criteria = new CDbCriteria;
 		$criteria->addCondition("quote_id = $quote_id");
 		$criteria->order = 'date_created DESC';
		$res = $this->findAll( $criteria );

		$data = array();
		foreach( $res as $r ) {
			$data[] = $r->date_created . ' - [' . $r->fromUser->fullname . '] to [' . $r->toUser->fullname . '] - ' . $r->subject;
		}

		pDebug("getAllComments() - data:", $data);
		return $data;
	}







}