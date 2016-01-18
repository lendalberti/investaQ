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
				'users'=>array('admin'),
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
		$quote_type = '';
		$model = new Quotes;

		if ( isset($_GET['t']) ) {
			$quote_type = $_GET['t'];
		}

		pDebug("quote_type = $quote_type");
		$this->render('create',array(
			'model'=>$model,
			'quote_type' => $quote_type,
		));

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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

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

		if ( isset($_GET['stock']) ) {
			$quote_type = Quotes::STOCK;
			$page_title = "My Quotes";
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
		if ( !Yii::app()->user->isAdmin )   $criteria->addCondition("owner_id = " . Yii::app()->user->id);
		$criteria->addCondition("quote_type_id = $quote_type");
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
}
