<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property integer $role_id
 * @property integer $group_id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $title
 * @property string $phone
 * @property string $fax
 * @property string $sig
 *
 * The followings are the available model relations:
 * @property Attachments[] $attachments
 * @property Bto[] $btos
 * @property BtoApprovals[] $btoApprovals
 * @property Customers[] $customers
 * @property Customers[] $customers1
 * @property History[] $histories
 * @property Quotes[] $quotes
 * @property Roles $role
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id', 'required'),
			array('role_id, group_id', 'numerical', 'integerOnly'=>true),
			array('username, first_name, last_name, email, title, phone, fax', 'length', 'max'=>45),
			array('sig', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, role_id, group_id, username, first_name, last_name, email, title, phone, fax, sig', 'safe', 'on'=>'search'),
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
			'attachments' => array(self::HAS_MANY, 'Attachments', 'uploaded_by'),
			'btos' => array(self::HAS_MANY, 'Bto', 'owner_id'),
			'btoApprovals' => array(self::HAS_MANY, 'BtoApprovals', 'user_id'),
			'customers' => array(self::HAS_MANY, 'Customers', 'inside_salesperson_id'),
			'customers1' => array(self::HAS_MANY, 'Customers', 'outside_salesperson_id'),
			'histories' => array(self::HAS_MANY, 'History', 'salesperson_id'),
			'quotes' => array(self::HAS_MANY, 'Quotes', 'user_id'),
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
			'role_id' => 'Role',
			'group_id' => 'Group',
			'username' => 'Username',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'title' => 'Title',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'sig' => 'Sig',
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
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('sig',$this->sig,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	// =============================================================================================
	// =============================================================================================
	// =============================================================================================


		public function findByUsername($username) {
			return Users::model()->find('LOWER(username)=?',array($username));
		}


		public function registerUser($u) {
				pDebug("Users::registerUser() - trying to register user=[" . $u['username'] . "]");

			$model = self::findByUsername($u['username']);
			if ( $model ) {
				pDebug("Users::registerUser() - already registered:", $model->attributes);
				pDebug("Users::registerUser() - logged in:[" . Yii::app()->user->isLoggedIn . "]");
				return $model->id;  // found, no need to register
			}

			$model             = new Users;
			$model->role_id    = Roles::USER;
			$model->username   = $u['username'];
			$model->first_name = $u['first_name'];
			$model->last_name  = $u['last_name'];
			$model->email      = $u['email'];
			$model->title      = $u['title'];
			$model->phone      = $u['phone'];
			$model->fax        = $u['fax'];
			$model->sig        = $u['sig'];
			$model->role_id    = Roles::USER;

			pDebug("Users::registerUser() - model attributes=", $model->attributes );

			if ( $model->save() ) {
				$newId = $model->getPrimaryKey();
				pDebug("Users::registerUser() - user registered; new id=[" .  $newId . ']');
				return $newId;
			}
			else {
				pDebug("Users::registerUser() - can't register user, errors=", $model->errors );
				return null;
			}

		}


		public function getFullname()  {
		    return $this->first_name.' '.$this->last_name;
		}


		public function getAdminsEmail() {
			return Users::model()->findAllBySql( 'SELECT email FROM users WHERE role_id = ' . Roles::ADMIN . ' AND id > 1 ' );
		}

		public function getAdminsFullname() {
			return Users::model()->findAllBySql( 'SELECT id, CONCAT(first_name, " ", last_name) AS fullname FROM users WHERE role_id = ' . Roles::ADMIN . ' AND id > 1 ' );
		}


		public function removeSignature($id) {
			$sql = "UPDATE users SET sig = null WHERE id = $id";
			$command = Yii::app()->db->createCommand($sql);
			$command->execute();
		}

		// ----------------------------------------------------------------
		public function getApproverEmails() {
			$email_list = [];

			$users = Users::model()->findAllBySql( 'SELECT email FROM users WHERE role_id  = ' . Roles::APPROVER );
			foreach( $users as $u ) {
				$email_list[] = $u->email;
			}

			pDebug("getApproverEmails() - email_list=", $email_list);
			return $email_list;
		}


		public function getBtoApprovers() {
			$sql = "select * from users where role_id = " . Roles::BTO_APPROVER;
			$users = Users::model()->findAllBySql($sql);
			
			foreach( $users as $u ) {
				pDebug("user attributes=", $u->attributes);
				$userList[$u->id] = $u->fullname . ' (' . $u->group->name . ')';
			}

			pDebug("userList=", $userList);
			return $userList;

		}         





































}