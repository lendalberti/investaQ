<?php

class StockItemsController extends Controller
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
				'actions'=>array('create','update', 'delete'),
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
	public function actionCreate() 	{
		$return_url = isset($_GET['returnUrl']) ?  $_GET['returnUrl'] : null; 
		$model = new StockItems;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if ( isset($_POST['StockItems']) ) {
			$model->attributes=$_POST['StockItems'];
			if($model->save())
				$this->redirect( $return_url ? $return_url : '/iq2' );
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) 	{
		pDebug('StockItemsController::actionUpdate() - _POST:', $_POST);
		$modelStockItems = $this->loadModel($id);

		if ( isset($_POST['StockItems']) ) {
			$return_url = isset($_GET['returnUrl']) ?  $_GET['returnUrl'] : null; 
			$status = Status::DRAFT;
	 		
 			if ( $_POST['StockItems']['price_Custom'] ) {
 				$dpf = Yii::app()->params['DISTRIBUTOR_PRICE_FLOOR'];
		 		
		 		$min_custom_price    =  $modelStockItems->price_Base * $dpf;
		 		$actual_custom_price = $_POST['StockItems']['price_Custom'];

		 		pDebug("min_custom_price=[$min_custom_price], actual price_Custom=[".$_POST['StockItems']['price_Custom']."]");
		 		if ( $_POST['StockItems']['price_Custom'] < $min_custom_price ) {
		 			$status = Status::PENDING;
		 			notifyApprovers($modelStockItems);
		 		}
 			}

			$modelQuote = Quotes::model()->findByPk( $modelStockItems->quote_id );
			$modelQuote->status_id = $status;
			if ( $modelQuote->save() ) {
				pDebug( 'StockItemsController::actionUpdate() - updated quote: '.$modelStockItems->quote_id.'; status=' . $modelQuote->status->name );
			}
			else {
				pDebug( 'StockItemsController::actionUpdate() - could NOT update quote: '.$modelStockItems->quote_id.'; status='.  $modelQuote->status->name  .', error: ', $modelQuote->errors );
			}


			$modelStockItems->attributes = $_POST['StockItems'];

			if ( $this->moreThanAvailable($modelStockItems) ) {
				$modelStockItems->addError('', "Can't specify more than what's available.");
			}
			else {
				if($modelStockItems->save()) {
					$this->redirect( $return_url ? $return_url : '/iq2' );
				}
			}
		}

		$this->render('update',array(
			'model'=>$modelStockItems,
		));
	} // END_OF_FUNCTION actionUpdate()






	public function moreThanAvailable( $m ) {
    	$tot = $m->qty_1_24+$m->qty_25_99+$m->qty_100_499+$m->qty_500_999+$m->qty_1000_Plus+$m->qty_Base+$m->qty_Custom;
    	if ( $tot > $m->qty_Available ) {
    		return true;
    	}
    	return false;
	}



	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
			echo 'ok';

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			//if(!isset($_GET['ajax']))
			//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('StockItems');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StockItems('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StockItems']))
			$model->attributes=$_GET['StockItems'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=StockItems::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='stock-items-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
