<?php

/**
 * This is the model class for table "bto_status".
 *
 * The followings are the available columns in table 'bto_status':
 * @property integer $id
 * @property integer $bto_item_id
 * @property integer $status_id
 * @property integer $group_id
 * @property integer $approver_id
 *
 * The followings are the available model relations:
 * @property Status $status
 * @property BtoItems $btoItem
 * @property BtoGroups $group
 * @property Users $approver
 */
class BtoStatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BtoStatus the static model class
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
		return 'bto_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bto_item_id, status_id, group_id', 'required'),
			array('bto_item_id, status_id, group_id, approver_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bto_item_id, status_id, group_id, approver_id', 'safe', 'on'=>'search'),
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
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'btoItem' => array(self::BELONGS_TO, 'BtoItems', 'bto_item_id'),
			'group' => array(self::BELONGS_TO, 'BtoGroups', 'group_id'),
			'approver' => array(self::BELONGS_TO, 'Users', 'approver_id'),
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
			'status_id' => 'Status',
			'group_id' => 'Group',
			'approver_id' => 'Approver',
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
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('approver_id',$this->approver_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}