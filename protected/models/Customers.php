<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 * @property integer $id
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property integer $state_id
 * @property integer $country_id
 * @property string $zip
 * @property integer $region_id
 * @property integer $customer_type_id
 * @property integer $territory_id
 * @property string $vertical_market
 * @property integer $parent_id
 * @property string $company_link
 * @property string $syspro_account_code
 * @property integer $xmas_list
 * @property integer $candy_list
 * @property integer $strategic
 * @property integer $tier_id
 * @property integer $inside_salesperson_id
 * @property integer $outside_salesperson_id
 *
 * The followings are the available model relations:
 * @property CustomerContacts[] $customerContacts
 * @property UsStates $state
 * @property Countries $country
 * @property CustomerTypes $customerType
 * @property Regions $region
 * @property Tiers $tier
 * @property Customers $parent
 * @property Customers[] $customers
 * @property Users $insideSalesperson
 * @property Users $outsideSalesperson
 * @property Territories $territory
 * @property Quotes[] $quotes
 */
class Customers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Customers the static model class
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
		return 'customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address1, city, country_id, region_id, customer_type_id, territory_id', 'required'),
			array('state_id, country_id, region_id, customer_type_id, territory_id, parent_id, xmas_list, candy_list, strategic, tier_id, inside_salesperson_id, outside_salesperson_id', 'numerical', 'integerOnly'=>true),
			array('name, address1, address2, city, zip, vertical_market, company_link, syspro_account_code', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, address1, address2, city, state_id, country_id, zip, region_id, customer_type_id, territory_id, vertical_market, parent_id, company_link, syspro_account_code, xmas_list, candy_list, strategic, tier_id, inside_salesperson_id, outside_salesperson_id', 'safe', 'on'=>'search'),
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
			'customerContacts' => array(self::HAS_MANY, 'CustomerContacts', 'customer_id'),
			'state' => array(self::BELONGS_TO, 'UsStates', 'state_id'),
			'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
			'customerType' => array(self::BELONGS_TO, 'CustomerTypes', 'customer_type_id'),
			'region' => array(self::BELONGS_TO, 'Regions', 'region_id'),
			'tier' => array(self::BELONGS_TO, 'Tiers', 'tier_id'),
			'parent' => array(self::BELONGS_TO, 'Customers', 'parent_id'),
			'customers' => array(self::HAS_MANY, 'Customers', 'parent_id'),
			'insideSalesperson' => array(self::BELONGS_TO, 'Users', 'inside_salesperson_id'),
			'outsideSalesperson' => array(self::BELONGS_TO, 'Users', 'outside_salesperson_id'),
			'territory' => array(self::BELONGS_TO, 'Territories', 'territory_id'),
			'quotes' => array(self::HAS_MANY, 'Quotes', 'customer_id'),
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
			'address1' => 'Address1',
			'address2' => 'Address2',
			'city' => 'City',
			'state_id' => 'State',
			'country_id' => 'Country',
			'zip' => 'Zip',
			'region_id' => 'Region',
			'customer_type_id' => 'Customer Type',
			'territory_id' => 'Territory',
			'vertical_market' => 'Vertical Market',
			'parent_id' => 'Parent',
			'company_link' => 'Company Link',
			'syspro_account_code' => 'Syspro Account Code',
			'xmas_list' => 'Xmas List',
			'candy_list' => 'Candy List',
			'strategic' => 'Strategic',
			'tier_id' => 'Tier',
			'inside_salesperson_id' => 'Inside Salesperson',
			'outside_salesperson_id' => 'Outside Salesperson',
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
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('customer_type_id',$this->customer_type_id);
		$criteria->compare('territory_id',$this->territory_id);
		$criteria->compare('vertical_market',$this->vertical_market,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('company_link',$this->company_link,true);
		$criteria->compare('syspro_account_code',$this->syspro_account_code,true);
		$criteria->compare('xmas_list',$this->xmas_list);
		$criteria->compare('candy_list',$this->candy_list);
		$criteria->compare('strategic',$this->strategic);
		$criteria->compare('tier_id',$this->tier_id);
		$criteria->compare('inside_salesperson_id',$this->inside_salesperson_id);
		$criteria->compare('outside_salesperson_id',$this->outside_salesperson_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function getLocation()  {
	    return $this->address1.', '.$this->address2 .', '.$this->city .', '.$this->zip .', '.$this->country->name ;
	}


}