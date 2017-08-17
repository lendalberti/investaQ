<?php

/**
 * This is the model class for table "coordinators".
 *
 * The followings are the available columns in table 'coordinators':
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 *
 * The followings are the available model relations:
 * @property BtoItemStatus[] $btoItemStatuses
 * @property Users $user
 * @property Groups $group
 */
class Coordinators extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Coordinators the static model class
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
		return 'coordinators';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, group_id', 'required'),
			array('user_id, group_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, group_id', 'safe', 'on'=>'search'),
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
			'btoItemStatuses' => array(self::HAS_MANY, 'BtoItemStatus', 'coordinator_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'group' => array(self::BELONGS_TO, 'Groups', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'group_id' => 'Group',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('group_id',$this->group_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getCoordinatorList() {
		$app = array();

		foreach( array( Groups::ASSEMBLY,Groups::QUALITY,Groups::TEST ) as $i => $g_id ) {
			$criteria = new CDbCriteria;
			$criteria->addCondition("group_id = $g_id");
			//$criteria->addCondition("role_id = " . Roles::COORDINATOR);  // no longer needed
		
			$res = $this->findAll($criteria);
			
			foreach ( $res as $i => $v ) {
				$u = Users::model()->findByPk($v['user_id']);
				$app[ $v['group_id'] ][] = array( $u->id => $u->fullname );
			}
		}
		//pDebug("BtoApprovers::getList() = app:", $app);
		return $app;
	}



}