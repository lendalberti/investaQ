<?php

class ContactsController extends Controller
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
				'actions'=>array('index','view', 'find', 'create', 'update', 'findbycust', 'list'),
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

	public function actionList()  {
		pDebug("Contacts::actionList() - getting list of all Contacts");
		$tmp = Contacts::model()->findAll( array('order' => 'first_name') );

		foreach( $tmp as $c ) {
			$contacts[] = array( 'id' => $c->id, 'name' => $c->first_name." ".$c->last_name);
		}

		pDebug("Contacts::actionList() -  contacts list:", $contacts);
		echo json_encode($contacts);
	}








	public function actionFind_ORIG($id)  {
		pDebug("Contacts::actionFind() - looking for contact id=[$id]");

		$contact = Contacts::model()->findByPk($id);

		$c = $contact->attributes;
		pDebug('Contacts::actionFind() - found contact: ', $c );
		echo json_encode($c);
	}





	public function actionFind($id)  {
		pDebug("Contacts::actionFind() - looking for contact id=[$id]");

		$c = Contacts::model()->findByPk($id);
		$ca = $c->attributes;

		$ca['state_id']    = $c->state->long_name;
		$ca['country_id']  = $c->country->long_name;

		pDebug('Contacts::actionFind() - found contact attributes: ', $ca );
		echo json_encode($ca);
	}


	public function actionFindbycust($id) {
		pDebug("Contacts::actionFindbycust() - looking for contacts of customer id=[$id]");
		$contacts = array();

		$sql = "SELECT co.id AS 'contact_id', concat(co.first_name,' ',co.last_name) AS 'contact_name' FROM customer_contacts cc join contacts co ON cc.contact_id = co.id WHERE cc.customer_id = $id";
		$command = Yii::app()->db->createCommand($sql);
		$results = $command->queryAll();

		foreach( $results as $r ) {
			$contacts[] = array( 'id' => $r['contact_id'], 'label' => $r['contact_name'] );
		}

		pDebug("Contacts::actionFindbycust() - contacts found:", $contacts);
		echo json_encode($contacts);
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
		$model=new Contacts;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Contacts']))
		{
			$model->attributes=$_POST['Contacts'];
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

		if(isset($_POST['Contacts']))
		{
			$model->attributes=$_POST['Contacts'];
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
		$dataProvider=new CActiveDataProvider('Contacts');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Contacts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contacts']))
			$model->attributes=$_GET['Contacts'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Contacts the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Contacts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Contacts $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contacts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
