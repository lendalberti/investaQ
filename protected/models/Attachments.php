<?php

/**
 * This is the model class for table "attachments".
 *
 * The followings are the available columns in table 'attachments':
 * @property integer $id
 * @property integer $quote_id
 * @property string $filename
 * @property string $content_type
 * @property integer $size
 * @property string $md5
 * @property string $uploaded_date
 * @property integer $uploaded_by
 *
 * The followings are the available model relations:
 * @property Quotes $quote
 * @property Users $uploadedBy
 */
class Attachments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Attachments the static model class
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
		return 'attachments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_id, filename, content_type, size, md5, uploaded_date, uploaded_by', 'required'),
			array('quote_id, size, uploaded_by', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>255),
			array('content_type, md5', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quote_id, filename, content_type, size, md5, uploaded_date, uploaded_by', 'safe', 'on'=>'search'),
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
			'uploadedBy' => array(self::BELONGS_TO, 'Users', 'uploaded_by'),
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
			'filename' => 'Filename',
			'content_type' => 'Content Type',
			'size' => 'Size',
			'md5' => 'Md5',
			'uploaded_date' => 'Uploaded Date',
			'uploaded_by' => 'Uploaded By',
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
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('content_type',$this->content_type,true);
		$criteria->compare('size',$this->size);
		$criteria->compare('md5',$this->md5,true);
		$criteria->compare('uploaded_date',$this->uploaded_date,true);
		$criteria->compare('uploaded_by',$this->uploaded_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function getAllAttachments( $quote_id ) {
		$criteria = new CDbCriteria;
 		$criteria->addCondition("quote_id = $quote_id");
 		$criteria->order = 'uploaded_date DESC';
		$res = $this->findAll( $criteria );

		$data = array();
		foreach( $res as $r ) {
			$data[] = $r->id . ' | ' . $r->filename .' | '. $r->size .' bytes | '.  $r->uploaded_date .' | '.  $r->uploadedBy->fullname;
		}

		pDebug("getAllAttachments() - data:", $data);
		return $data;
	}









































}