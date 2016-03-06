<?php

class AttachmentsController extends Controller
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
				'actions'=>array('index','view', 'upload'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
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



	public function actionUpload($id) {
		$quote_id    = $id;
		pDebug("AttachmentsController::actionUpload($quote_id) - _POST variables:", $_POST );
		pDebug("AttachmentsController::actionUpload($quote_id) - _FILES variables:", $_FILES );
		
		$modelQuotes = Quotes::model()->findByPk($quote_id);
		$quote_no    = $modelQuotes->quote_no;

		$uploadMessage = '';
		$modelAttachment = new Attachments;
		

		////////////////////////////////////////////////////////////////////////////////////
		if ( isset($_FILES["quote_attachment"]) )  {

			$name     = $_FILES["quote_attachment"]["name"];
			$type     = $_FILES["quote_attachment"]["type"];
			$size     = $_FILES["quote_attachment"]["size"];
			$tmp_name = $_FILES["quote_attachment"]["tmp_name"];

			preg_match('/(\w+$)/', $name, $match);
		    $extension = $match[0];

		    $md5 = md5( time() . $tmp_name ) . ".$extension";
			$target   = Yii::app()->params['attachments'] . '/' . $md5;

			pDebug("AttachmentsController::actionUpload($quote_id) - moving file [$tmp_name] to [$target]");

			if ( move_uploaded_file( $tmp_name, $target ) ) {
				$uploadMessage ="File successfully uploaded.";
				$modelAttachment->quote_id     = $quote_id;  
				$modelAttachment->filename     = $name;  
				$modelAttachment->md5          = $md5;  
				$modelAttachment->content_type = $type;     
				$modelAttachment->size         = $size;   
				$modelAttachment->uploaded_by  = Yii::app()->user->id;  
				$modelAttachment->uploaded_date  = Date('Y-m-d H:i:s');

				if( $modelAttachment->save() ) {
					//save History record
					//addHistory( $quote_id, Actions::ATTACH_FILE, "FILE attached: [$title]", $modelAttachment->getPrimaryKey() );  // TODO: is this needed??
				}
				else {
					$uploadMessage = "Error: couldn't save attachment info in db; file not attached; ";
					pDebug("AttachmentsController::actionUpload($quote_id) - Error:", $modelAttachment->getErrors() );
				}
			}
			else {
				$uploadMessage = "Error in upload; ";
				pDebug("AttachmentsController::actionUpload($quote_id) - Error: couldn't move uploaded file [$tmp_name] to [$target]."); 
			}
		}

        $attachment_list = getQuoteAttachments($quote_id);
        pDebug("AttachmentsController::actionUpload() - attachment_list:", $attachment_list);

		$this->render('upload',array(
			'modelAttachment' => $modelAttachment,
			'quote_id'        => $quote_id,
			'quote_no'        => $quote_no,
			'uploadMessage'   => $uploadMessage,
			'attachment_list' => $attachment_list,
		));
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
	public function actionCreate()
	{
		$model=new Attachments;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Attachments']))
		{
			$model->attributes=$_POST['Attachments'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Attachments']))
		{
			$model->attributes=$_POST['Attachments'];
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
		$dataProvider=new CActiveDataProvider('Attachments');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Attachments('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Attachments']))
			$model->attributes=$_GET['Attachments'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Attachments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Attachments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Attachments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='attachments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
