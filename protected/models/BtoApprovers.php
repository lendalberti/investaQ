<?php

/**
 * This is the model class for table "bto_approvers".
 *
 * The followings are the available columns in table 'bto_approvers':
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property integer $role_id
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property BtoGroups $group
 * @property Roles $role
 */
class BtoApprovers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BtoApprovers the static model class
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
		return 'bto_approvers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, group_id, role_id', 'required'),
			array('user_id, group_id, role_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, group_id, role_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'group' => array(self::BELONGS_TO, 'BtoGroups', 'group_id'),
			'role' => array(self::BELONGS_TO, 'Roles', 'role_id'),
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
			'role_id' => 'Role',
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
		$criteria->compare('role_id',$this->role_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}







	// $data['bto_approvers'] = BtoApprovers::model()->getList();
	//
	// $data['bto_approvers']['assembly'] 
	public function getList() {
		$app = array();

		foreach( array( BtoGroups::ASSEMBLY,BtoGroups::QUALITY,BtoGroups::TEST,BtoGroups::PRODUCTION ) as $i => $g_id ) {
			$criteria = new CDbCriteria;
			$criteria->addCondition("group_id = $g_id");
			$criteria->addCondition("role_id = " . Roles::BTO_APPROVER);
		
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