<?php

/**
 * This is the model class for table "bto_comments".
 *
 * The followings are the available columns in table 'bto_comments':
 * @property integer $id
 * @property integer $bto_item_id
 * @property integer $quote_id
 * @property integer $user_id
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property Quotes $quote
 * @property Users $user
 * @property BtoItems $btoItem
 */
class BtoComments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BtoComments the static model class
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
		return 'bto_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bto_item_id, quote_id, user_id, comment', 'required'),
			array('bto_item_id, quote_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bto_item_id, quote_id, user_id, comment', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'btoItem' => array(self::BELONGS_TO, 'BtoItems', 'bto_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bto_item_id' => 'Bto Item',
			'quote_id' => 'Quote',
			'user_id' => 'User',
			'comment' => 'Comment',
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
		$criteria->compare('bto_item_id',$this->bto_item_id);
		$criteria->compare('quote_id',$this->quote_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}