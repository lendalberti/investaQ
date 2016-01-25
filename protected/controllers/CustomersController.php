<?php

class CustomersController extends Controller
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
				'actions'=>array('index','view', 'find', 'findbycontact', 'create', 'update', 'list'),
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
		pDebug("Customers::actionList() - getting list of all customers");
		$tmp = Customers::model()->findAll( array('order' => 'name') );

		foreach( $tmp as $c ) {
			$customers[] = array( 'id' => $c->id, 'name' => $c->name, 'address1' => $c->address1, 'city' => $c->city, 'country' => $c->country->short_name );
		}

		pDebug("Customers::actionList() -  customer list:", $customers);
		echo json_encode($customers);
	}







	public function actionFind($id)  {
		pDebug("Customers::actionFind() - looking for customer id=[$id]");

		$c = Customers::model()->findByPk($id);
		$ca = $c->attributes;

		$ca['state_id']               = $c->state->long_name;
		$ca['country_id']             = $c->country->long_name;
		$ca['region_id']              = $c->region->name;
		$ca['territory_id']           = $c->territory->name;
		$ca['customer_type_id']       = $c->customerType->name;
		$ca['parent_id']              = $c->parent->name;
		$ca['tier_id']                = $c->tier->name;
		$ca['inside_salesperson_id']  = $c->insideSalesperson->fullname;
		$ca['outside_salesperson_id'] = $c->outsideSalesperson->fullname;
		//ksort($ca); 

		pDebug('Customers: actionFind() - found customer attributes: ',$ca );
		echo json_encode($ca);
	}


	public function actionFindbycontact($id) {
		pDebug("Customers::actionFindbycontact() - looking for customers of contact id=[$id]");
		$customers = array();
		
		$sql  = "SELECT cu.id AS 'customer_id', CONCAT(cu.name, ',', cu.address1, ',', cu.city, ',', cn.short_name) AS 'customer_info' ";
		$sql .= " FROM  customer_contacts cc join customers cu on cu.id = cc.customer_id join countries cn on cu.country_id = cn.id where cc.contact_id = $id";
		$command = Yii::app()->db->createCommand($sql);
		$results = $command->queryAll();

		foreach( $results as $r ) {
			$customers[] = array( 'id' => $r['customer_id'], 'label' => $r['customer_info'] );
		}

		pDebug("Customers::actionFindbycontact() - customers found:", $customers);
		echo json_encode($customers);
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
		$model=new Customers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Customers']))
		{
			$model->attributes=$_POST['Customers'];
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

		if(isset($_POST['Customers']))
		{
			$model->attributes=$_POST['Customers'];
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
		$dataProvider=new CActiveDataProvider('Customers');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Customers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customers']))
			$model->attributes=$_GET['Customers'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Customers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Customers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Customers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
