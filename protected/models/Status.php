<?php

/**
 * This is the model class for table "status".
 *
 * The followings are the available columns in table 'status':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Quotes[] $quotes
 */
class Status extends CActiveRecord {

	const 	DRAFT         = 1, 
			PENDING       = 2, 
			ORDER_PLACED  = 3,
			WON           = 4,
			LOST          = 5,
			NO_BID        = 6,
			SUBMITTED     = 7,
			APPROVED      = 8,
			REJECTED	  = 9;
		

	const		
			SUCCESS       = 0,
			FAILURE       = 1;
			
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Status the static model class
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
		return 'status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'quotes' => array(self::HAS_MANY, 'Quotes', 'status_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
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
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}