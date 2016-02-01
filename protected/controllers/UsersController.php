<?php

class UsersController extends Controller
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
				'actions'=>array('create','update', 'profile', 'profileUpdate', 'uploadSig'),
				'expression' => '$user->isLoggedIn',
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



	
	public function actionProfile($id) {
		pDebug('actionProfile()');

		if ($id != Yii::app()->user->id) {
			return;
		}

		$this->render('myProfile',array(
			'model'=>$this->loadModel($id),
		));
	}

	// --------------------------------------------------
	public function actionProfileUpdate($id) {
		if ($id != Yii::app()->user->id) {
			return;
		}

		pDebug('actionProfileUpdate() - _POST:', $_POST);
		pDebug('actionProfileUpdate() - _FILES:', $_FILES);

		if ( isset($_POST['user_sig_file']) ) {
			$sig_file = $_POST['user_sig_file'];
		}
		else {
			$sig_file = null;
		}

		$model=$this->loadModel($id);
		if ( isset($_POST['Users']) )	{
			$model->attributes = $_POST['Users'];
			$model->title      = $_POST['Users']['title'];
			$model->phone      = $_POST['Users']['phone'];
			$model->fax        = $_POST['Users']['fax'];
			$model->sig        = $_POST['Users']['sig'];

			// if ( $sig_file ) {
			// 	$model->sig    = $sig_file;
			// }

			if ( $model->save() ) {
				pDebug("actionProfileUpdate() - profile saved:", $model->attributes);
				$this->redirect(array('profile','id'=>$model->id));
			}
			else {
				pDebug("actionProfileUpdate() - Can't update profile; error: ",  $model->errors);
			}
		}

		$this->render('myProfileUpdate',array(
			'model'=>$model,
		));
	}


	public function actionUploadSig($id) {
		$model = $this->loadModel($id);

		if ( isset($_FILES["uploaded_file"]) ) {
			if ( $_FILES["uploaded_file"]['name']  )  {

				pDebug("upload file:", $_FILES["uploaded_file"]);

				$name = $_FILES["uploaded_file"]["name"];
				$from = $_FILES["uploaded_file"]["tmp_name"];
				$size = $_FILES["uploaded_file"]["size"];
				$type = $_FILES["uploaded_file"]["type"];

				if ( $size > Yii::app()->params['max_upload_size'] ) {
					$uploadMessage = "File is too large; needs to be less than " . Yii::app()->params['max_upload_size'] . ' bytes';
				}
				else {
					$model->sig = $name;
					if ( $model->save() ) {
						pDebug("actionUploadSig() - model saved.");

						$new_file = 'user'.Yii::app()->user->id; 							// "user1", "user2", "user3", etc.
						$to   = Yii::app()->params['profile_sig'] . '/' . $new_file;
						
					 	if ( move_uploaded_file( $from, $to ) ) {
					 		`convert -resize 240x140 $to $to.png; rm -f $to`;
						    $uploadMessage ="File successfully uploaded; moved from [$from] to [$to]";
						}
					}
					else {
						pDebug("actionUploadSig() - error: can't save model with sig",  $model->errors);
					}
					}
			}
			else {
				$uploadMessage = "Nothing to upload.";
			}
		}

		$this->render('uploadSig',array(
			'model'         => $model,
			'uploadMessage' => $uploadMessage,
		));

	}  // END_OF_FUNCTION actionUploadSig()




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
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
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

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
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
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
