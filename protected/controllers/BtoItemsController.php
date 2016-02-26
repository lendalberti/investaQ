<?php

class BtoItemsController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'process'),
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


	public function actionProcess() {
		pDebug( "actionProcess() - _POST=", $_POST);
		/*
			1. set quote status to BTO_PENDING
			2. notify Proposal Manager
		*/
		$quote_id = $_POST['quote_id'];

		try {
			$quoteModel            = Quotes::model()->findByPk($quote_id);
			$quoteModel->status_id = Status::BTO_PENDING; 
			if ( $quoteModel->save() ) {
				pDebug( "actionProcess() - manufacturing quote no. " . $quoteModel->quote_no . " is now 'Pending Approval'.");
				notifyProposalManager($quoteModel);
				echo  Status::SUCCESS;
			}
			else {
				pDebug( "actionProcess() - could not change status of manufacturing quote no. " . $quoteModel->quote_no . "; error=", $quoteModel->errors);
				echo Status::FAILURE;
			}
			return;
		}
		catch( Exception $ex ) {
			pDebug("BtoItems::actionCreate() - exception caught: trying to save BtoItems model", $ex );
		}
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
	public function actionCreate() 	{
		pDebug("BtoItems::actionCreate() - _POST=", $_POST);
		
		if ( isset($_POST['requested_part_number']) && isset($_POST['mfg']) && isset($_POST['quote_id'])  ) {
			$itemModel = new BtoItems;

			$itemModel->requested_part_number = $_POST['requested_part_number'];
			$itemModel->quote_id              = $_POST['quote_id'];
			$itemModel->die_manufacturer_id   = getMfgID( $_POST['mfg'] );
			pDebug("BtoItems::actionCreate() - trying to save itemModel with these attributes: ", $itemModel->attributes);

			try {
				if ( $itemModel->save() ) {					// 1. save BtoItems model
					$quoteModel                = Quotes::model()->findByPk( $_POST['quote_id'] );
					$quoteModel->quote_type_id = QuoteTypes::MANUFACTURING;
					if ( $quoteModel->save() ) {		// 2. update Quote type
						echo  Status::SUCCESS;
					}
					else {
						pDebug("BtoItems::actionCreate() - BtoItems model saved BUT error trying to update Quote model: ", $quoteModel->errors);
						echo  Status::FAILURE;
					}
				}
				else {
					pDebug("BtoItems::actionCreate() - error trying to save BtoItems model: ", $itemModel->errors);
					echo  Status::FAILURE;
				}
			}
			catch (Exception $ex) {
				pDebug("BtoItems::actionCreate() - error trying to save BtoItems model: ", $ex);
			}
				
		}
				// from original
				//
				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);

				// if(isset($_POST['BtoItems']))
				// {
				// 	$model->attributes=$_POST['BtoItems'];
				// 	if($model->save())
				// 		$this->redirect(array('view','id'=>$model->id));
				// }

				// $this->render('create',array(
				// 	'model'=>$model,
				// ));
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

		if(isset($_POST['BtoItems']))
		{
			$model->attributes=$_POST['BtoItems'];
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('BtoItems');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BtoItems('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BtoItems']))
			$model->attributes=$_GET['BtoItems'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BtoItems the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=BtoItems::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BtoItems $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bto-items-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
