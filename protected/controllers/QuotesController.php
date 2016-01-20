<?php

class QuotesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update'),
				'expression' => '$user->isLoggedIn'
			),
		
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'expression' => '$user->isAdmin'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate_ORIG() 
	{
		$model=new Quotes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Quotes']))
		{
			$model->attributes=$_POST['Quotes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionCreate() {
		pDebug("Quotes::actionCreate() - _POST values from serialzed form values:", $_POST);
		





		if ( isset($_POST['customer_id']) || isset($_POST['contact_id']) ) {
			// pDebug("Quotes::actionCreate() - _POST=", $_POST);

			// $model = new Quotes;

			// $model->customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : 


			/* 
				initial save:

					- required fields:
							┏━━━━━━━━━━━━━━━━━━━━━━━━━┳━━━━━━━━━━━━━┳━━━━━━┳━━━━━┳━━━━━━━━━━━━━━━━━━━┳━━━━━━━━━━━━━━━━┓
						    ┃ Field                   ┃ Type        ┃ Null ┃ Key ┃ Default           ┃ Extra          ┃
							┡━━━━━━━━━━━━━━━━━━━━━━━━━╇━━━━━━━━━━━━━╇━━━━━━╇━━━━━╇━━━━━━━━━━━━━━━━━━━╇━━━━━━━━━━━━━━━━┩
							| quote_no                │ varchar(45) │ NO   │ UNI │ NULL              │                │
							│ quote_type_id           │ int(11)     │ NO   │ MUL │ NULL              │                │
							│ status_id               │ int(11)     │ NO   │ MUL │ NULL              │                │
							│ owner_id                │ int(11)     │ NO   │ MUL │ NULL              │                │
							│ customer_id             │ int(11)     │ NO   │ MUL │ NULL              │                │
							│ created_date            │ timestamp   │ NO   │     │ CURRENT_TIMESTAMP │                │
							│ updated_date            │ datetime    │ NO   │     │ NULL              │                │
							│ expiration_date         │ datetime    │ NO   │     │ NULL              │                │
							│ level_id                │ int(11)     │ NO   │ MUL │ NULL              │                │
							│ source_id               │ int(11)     │ NO   │ MUL │ NULL              │                │

			*/

			//$quote_no = $this->getQuoteNumber();







		}
		else {
			$data['customers'] = Customers::model()->findAll( array('order' => 'name') );
			$data['contacts'] = Contacts::model()->findAll( array('order' => 'first_name') );

			$data['us_states']      = UsStates::model()->findAll( array('order' => 'long_name') );
			$data['countries']   = Countries::model()->findAll( array('order' => 'long_name') );
			$data['regions']     = Regions::model()->findAll( array('order' => 'name') );

			$data['types']       = CustomerTypes::model()->findAll( array('order' => 'name') );
			$data['territories'] = Territories::model()->findAll( array('order' => 'name') );

			$this->render('create',array(
				'data'=>$data,
			));
		}
		
	}





	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Quotes']))
		{
			$model->attributes=$_POST['Quotes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 	{
		if ( $this->loadModel($id)->delete() ) {
			pDebug("Quotes:actionDelete() - quote id $id deleted...");
		}
		else {
			pDebug("Quotes:actionDelete() - ERROR: can't delete quote id $id; error=", $model->errors  );
		}


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() 	{
		pDebug('actionIndex() - _GET=', $_GET);

		$quote_type = '';
		$navigation_links = '';
		$page_title = "My Quotes";

		if ( isset($_GET['stock']) ) {
			$quote_type = Quotes::STOCK;
			$navigation_links .= "<span style='padding-right: 10px;'><a href='".Yii::app()->homeUrl."/quotes/index/mfg'> Manufacturing Quotes </a></span>";
			$navigation_links .= "<span style='padding-right: 10px;'><a href='".Yii::app()->homeUrl."/quotes/index/srf'> Supplier Request Form </a></span>";
		}
		else if ( isset($_GET['mfg']) ) {
			$quote_type = Quotes::MANUFACTURING;
			$page_title = "Manufacturing Quotes";
			$navigation_links .= "<span style='padding-right: 10px;'><a href='".Yii::app()->homeUrl."/quotes/index/stock'> Stock Quotes </a></span>";
			$navigation_links .= "<span style='padding-right: 10px;'><a href='".Yii::app()->homeUrl."/quotes/index/srf'> Supplier Request Form </a></span>";
		}
		else if ( isset($_GET['srf']) ) {
			$quote_type = Quotes::SUPPLIER_REQUEST_FORM;
			$page_title = "Supplier Request Form";
			$navigation_links .= "<span style='padding-right: 10px;'><a href='".Yii::app()->homeUrl."/quotes/index/stock'> Stock Quotes </a></span>";
			$navigation_links .= "<span style='padding-right: 10px;'><a href='".Yii::app()->homeUrl."/quotes/index/mfg'> Manufacturing Quotes </a></span>";
		}
		
		$criteria = new CDbCriteria();
		if ( !Yii::app()->user->isAdmin ) {
			 $criteria->addCondition("owner_id = " . Yii::app()->user->id);
		} 

		if ( $quote_type ) {
			$criteria->addCondition("quote_type_id = $quote_type");
		}

		$model = Quotes::model()->findAll( $criteria );

		$this->render( 'index', array(
			'model' => $model,
			'page_title' => $page_title,
			'navigation_links' => $navigation_links,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Quotes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Quotes']))
			$model->attributes=$_GET['Quotes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Quotes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Quotes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Quotes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='quotes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	// --------------------------------------------------------
	private function getQuoteNumber() {
		$id = Yii::app()->db->createCommand()->select('max(id) as max')->from('quotes')->queryScalar() + 1;
		$id = $id ? $id : 1;
		return Date('Ymd-') . sprintf("%04d", $id);
	}



}
