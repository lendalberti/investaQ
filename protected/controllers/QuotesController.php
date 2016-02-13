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
				'actions'=>array('index', 'indexApproval', 'view','create','update', 'search', 'partsUpdate', 'delete', 'select'),
				'expression' => '$user->isLoggedIn'
			),
		
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'config'),
				'expression' => '$user->isAdmin'
			),

			array('allow', // allow approvers  to perform 'approval' 
				'actions'=>array('approve', 'reject'),
				'expression' => '$user->isApprover'
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionConfig() {
		pDebug("actionConfig() - _GET=", $_GET);

		$model = new Quotes;
		$this->render('config',array(
			'model'=>$model,
		));
	}



	public function actionSelect() {
		pDebug("actionSelect() - _GET=", $_GET);

		 // us_states, countries, regions, customer_types, users, customers, tiers, territories
		if ( isset($_GET['q']) ) {
			$q = $_GET['q'];

			if ( in_array( $q, array('regions', 'customer_types', 'tiers', 'territories' )) ) {
				$list = array();
				$sql  = "SELECT * FROM $q ORDER BY name";
				$command = Yii::app()->db->createCommand($sql);
				$results = $command->queryAll();
				// pDebug("actionSelect() - sql=[$sql], results:", $results );

				foreach( $results as $r ) {
					$list[] = array( 'id' => $r['id'], 'label' => $r['name'] );
				}
				// pDebug("actionSelect() - list:", $list); 
				echo json_encode($list);
			}
			else if ( in_array( $q, array( 'us_states', 'countries' )) ) {
				$list = array();
				$sql  = "SELECT * FROM $q ORDER BY long_name";
				$command = Yii::app()->db->createCommand($sql);
				$results = $command->queryAll();
				// pDebug("actionSelect() - sql=[$sql], results:", $results );

				foreach( $results as $r ) {
					$list[] = array( 'id' => $r['id'], 'label' => $r['long_name'] );
				}
				// pDebug("actionSelect() - list:", $list); 
				echo json_encode($list);
			}
			else if ( in_array( $q, array( 'users' )) ) {
				$list = array();
				$sql  = "SELECT * FROM $q ORDER BY first_name";
				$command = Yii::app()->db->createCommand($sql);
				$results = $command->queryAll();
				// pDebug("actionSelect() - sql=[$sql], results:", $results );

				foreach( $results as $r ) {
					$list[] = array( 'id' => $r['id'], 'label' => $r['first_name'].' '.$r['last_name'] );
				}
				// pDebug("actionSelect() - list:", $list); 
				echo json_encode($list);
			}
			else if ( in_array( $q, array('customers' )) ) {
				$list = array();
				$sql  = "SELECT * FROM $q ORDER BY name";
				$command = Yii::app()->db->createCommand($sql);
				$results = $command->queryAll();
				// pDebug("actionSelect() - sql=[$sql], results:", $results );

				foreach( $results as $r ) {
					$list[] = array( 'id' => $r['id'], 'label' => $r['name'].' ('.$r['syspro_account_code'].') ');
				}
				// pDebug("actionSelect() - list:", $list); 
				echo json_encode($list);
			}
			else {
				pDebug("actionSelect() - list:", $list);
				$this->redirect(array('index'));
			}
		}

	}     




	// ------------------------------------- Approve Quote...  TODO:  combine these 2 ( actionDisposition() with POST variable? )
    public function actionApprove($id)     { 
		pTrace( __METHOD__ );
    	
    	$model = $this->loadModel($id);
    	$model->status_id = Status::APPROVED;

    	if ( $model->save() ) {
    		pDebug('actionApprove() - quote ' . $model->quote_no . ' approved');
    		notifySalespersonStatusChange($model);
    		echo Status::SUCCESS;
    	}
    	else {
    		pDebug('actionApprove() - ERROR approving quote: ', $model->errors);
    		echo Status::FAILURE;
    	}
    	return;
    }
    // ------------------------------------- Reject Quote...
    public function actionReject($id)     { 
		pTrace( __METHOD__ );
    	$model = $this->loadModel($id);
    	$model->status_id = Status::REJECTED;
    	if ( $model->save() ) {
    		pDebug('actionReject() - quote ' . $model->quote_no . ' rejected');
    		notifySalespersonStatusChange($model);
    		echo Status::SUCCESS;
    	}
    	else {
    		pDebug('actionReject() - ERROR rejecting quote: ', $model->errors);
    		echo Status::FAILURE;
    	}
    	return;
    }

	



	// ------------------------------------- AutoCompletion Search...
    public function actionSearch()     {        
 		pTrace( __METHOD__ );
       $term = isset( $_GET['term'] ) ? trim(strip_tags($_GET['term'])) : null; if ( !$term ) return null;
        
        // search customer fields: [ name, address1, syspro_account_code ]
		$tmp = Customers::model()->findAll( array('condition' => "name LIKE '%$term%' OR address1 LIKE '%$term%' OR syspro_account_code LIKE '%$term%' OR zip LIKE '%$term%'  OR city LIKE '%$term%' ") );
		foreach( $tmp as $c ) {
			$results[] = array( 'label' => $c->name . " (" . $c->syspro_account_code . "), " . $c->address1, 'value' => $c->id );
		}

		// search contact fields: [ first_name, last_name, email, title, phone1, phone2 ] 
		$tmp = Contacts::model()->findAll( array('condition' => "first_name LIKE '%$term%' OR last_name LIKE '%$term%' OR email LIKE '%$term%' OR title LIKE '%$term%' OR title LIKE '%$term%' OR phone1 LIKE '%$term%'  OR phone2 LIKE '%$term%'  OR zip LIKE '%$term%' "));
		foreach( $tmp as $c ) {
			$results[] = array( 'label' => $c->first_name . " " . $c->last_name, 'value' => $c->id );
		}

		array_multisort($results);
		$data['results'] = json_encode($results);
		echo json_encode($results);
    }



	
	// ------------------------------------- 
	public function actionView($id) {
		pTrace( __METHOD__ );

		$data['model'] = $this->loadModel($id);
		//pDebug('quote model attributes: ', $data['model']->attributes );

		$data['items'] = array();
		$data['status'] = array();

		$customer_id = $data['model']->customer_id;
		$contact_id  = $data['model']->contact_id;
		$quote_id    = $data['model']->id;

		// ------------------------------ get customer
		$data['customer'] = Customers::model()->findByPk($customer_id);
		
		// ------------------------------ get contact
		$data['contact']  = Contacts::model()->findByPk($contact_id);

		// ------------------------------ get status
		$data['status']  = Status::model()->findAll();


		// ------------------------------ get stock_items
		$sql = "SELECT * FROM stock_items WHERE  quote_id = $quote_id";
		$command = Yii::app()->db->createCommand($sql);
		$results = $command->queryAll();

		foreach( $results as $i ) {
			foreach( array('1_24', '25_99', '100_499', '500_999', '1000_Plus', 'Base', 'Custom') as $v ) {
				if ( fq($i['qty_'.$v]) != '0' ) {
		 			//$data .=  "  <tr>  <td> ".fq($i['qty_'.$v])."</td>        <td><span class='volume'>$v</span>"      .fp($i['price_'.$v])."</td>          <td> ".fp(calc($i,$v))."</td>   </tr>"; 
		 			//$data['items'][] = array( 'id' => $i['id'],  'part_no' => $i['part_no'], 'manufacturer'=>$i['manufacturer'], 'date_code'=>$i['date_code'], "qty" => fq($i["qty_$v"]), "price" => "<span class='volume'>$v</span>". fp($i["price_$v"]), "total" => fp(calc($i,$v)), "comments" => mb_strimwidth($i['comments'],0,150, '...')  );
		 			$data['items'][] = array( 'id' => $i['id'],  'part_no' => $i['part_no'], 'manufacturer'=>$i['manufacturer'], 'date_code'=>$i['date_code'], "qty" => fq($i["qty_$v"]), "volume" => $v,   "price" => fp($i["price_$v"]), "total" => fp(calc($i,$v)), "comments" => mb_strimwidth($i['comments'],0,150, '...')  );
		 		}
			}
		}  //  mb_strimwidth("Hello World", 0, 10, "...");

		//pDebug('actionView() - data[items]:', $data['items'] );

		$this->render('view',array(
			'data'=>$data,
		));

	}

	
	public function actionCreate() {
		pTrace( __METHOD__ );
		
		// if ( count($_POST) > 0 ) {
		// 	pDebug('Quotes:actionCreate() - _POST=', $_POST);
		// 	echo '0';
		// 	return;
		// }

		if ( isset($_POST['Customers']) && isset($_POST['Contacts']) && isset($_POST['Quotes'])   ) {
			pDebug("Quotes::actionCreate() - _POST values from serialzed form values:", $_POST);

			$customer_id = $_POST['Customers']['id'];
			$contact_id  = $_POST['Contacts']['id'];
			$quote_type  = $_POST['Quotes']['quote_type_id'];

			if (!$customer_id ) {
				// create new customer, get id
				$modelCustomers = new Customers;
				$modelCustomers->attributes      = $_POST['Customers'];

				$modelCustomers->country_id				= $_POST['Customers']['country_id'];
				$modelCustomers->region_id				= $_POST['Customers']['region_id'];
				$modelCustomers->customer_type_id		= $_POST['Customers']['customer_type_id'];
				$modelCustomers->territory_id			= $_POST['Customers']['territory_id'];
				$modelCustomers->xmas_list				= $_POST['Customers']['xmas_list'];
				$modelCustomers->candy_list				= $_POST['Customers']['candy_list'];
				$modelCustomers->strategic				= $_POST['Customers']['strategic'];
				$modelCustomers->address1				= $_POST['Customers']['address1'];
				$modelCustomers->city					= $_POST['Customers']['city'];
				$modelCustomers->vertical_market		= $_POST['Customers']['vertical_market'];
				$modelCustomers->syspro_account_code	= $_POST['Customers']['syspro_account_code'];

				if ( $modelCustomers->save() ) {
					$customer_id = $modelCustomers->id; 
					pDebug("Quotes::actionCreate() - created new customer with the following attributes:", $modelCustomers->attributes );
				}
				else {
					pDebug("Quotes::actionCreate() - ERROR: couldn't create new customer with the following attributes:", $modelCustomers->attributes );
					pDebug("Quotes::actionCreate() - Error Message", $modelCustomers->errors );
					echo Status::FAILURE; 
					return;
				}
			}

			if (!$contact_id ) {
				// create new contact, get id
				$modelContacts = new Contacts;
				$modelContacts->attributes      = $_POST['Contacts'];
				if ( $modelContacts->save() ) {
					$contact_id = $modelContacts->id; 
					pDebug("Quotes::actionCreate() - created new contact with the following attributes:", $modelContacts->attributes );
				}
				else {
					pDebug("Quotes::actionCreate() - ERROR: couldn't create new contact with the following attributes:", $modelContacts->attributes );
					echo Status::FAILURE; 
					return;
				}
			}

			$modelQuotes                  = new Quotes;
			$modelQuotes->attributes      = $_POST['Quotes'];
			$modelQuotes->customer_id     = $customer_id;
			$modelQuotes->contact_id      = $contact_id;
			$modelQuotes->quote_no        = $this->getQuoteNumber();
			$modelQuotes->status_id       = Status::DRAFT;
			$modelQuotes->owner_id        = Yii::app()->user->id;
			$modelQuotes->created_date    = Date('Y-m-d 00:00:00');
			$modelQuotes->updated_date    = Date('Y-m-d 00:00:00');
			$modelQuotes->expiration_date = $this->getQuoteExpirationDate();

			$modelQuotes->quote_type_id   = QuoteTypes::TBD;
			
			pDebug("Quotes::actionCreate() - saving Quote with the following attributes", $modelQuotes->attributes );
			if ( $modelQuotes->save() ) {
				pDebug("Quotes::actionCreate() - Quote No. " . $modelQuotes->quote_no . " saved; quote ID=" . $modelQuotes->id );
				Customers::model()->addContact($customer_id,$contact_id);
				echo $modelQuotes->id . '|' . $modelQuotes->quote_no;
			}
			else {
				pDebug("actionCreate() - Error on modelQuotes->save(): ", $modelQuotes->errors);
				echo Status::FAILURE;
			}
		}
		else {
			$data['sources'] = Sources::model()->findAll( array('order' => 'name') );
			$this->render('create',array(
				'data'=>$data,
			));
		}
	}


	public function actionPartsUpdate() 	{
		pTrace( __METHOD__ );
		$arr = array();

		try {
			pDebug( "actionPartsUpdate() - _POST=", $_POST ); 

			
			if ( isset($_POST['item_id']) ) {   // editing Inventory Item
				$modelStockItem = StockItems::model()->findByPk( $_POST['item_id']);

				
				$modelStockItem->setAttribute("comments",$_POST['item_comments']);

				preg_match('/^item_price_(.+)$/', $_POST['item_volume'], $match); 
				$volume = $match[1]; 
				pDebug("volume=[$volume]");

				$modelStockItem->setAttribute( 'qty_1_24', '' );
				$modelStockItem->setAttribute( 'qty_25_99', '' );
				$modelStockItem->setAttribute( 'qty_100_499', '' );
				$modelStockItem->setAttribute( 'qty_500_999', '' );
				$modelStockItem->setAttribute( 'qty_1000_Plus', '' );
				$modelStockItem->setAttribute( 'qty_Base', '' );
				$modelStockItem->setAttribute( 'qty_Custom', '' );

				$modelStockItem->setAttribute( 'qty_'    .$volume, $_POST['item_qty'] );
				$modelStockItem->setAttribute( 'comments',         $_POST['item_comments'] );

				pDebug( "actionPartsUpdate() - updating Inventory Item with the following attributes: ", $modelStockItem->attributes );

				if ( $modelStockItem->save() ) {
					pDebug("actionPartsUpdate() - Inventory Item updated.");
				}
				else {
					pDebug("actionPartsUpdate() - Inventory Item NOT updated; error=", $modelStockItem->errors);
				}
			}
			else {
				$modelStockItem = new StockItems;
				$modelStockItem->attributes = $_POST;
				pDebug( "actionPartsUpdate() - updating StockItems model with the following attributes: ", $modelStockItem->attributes );

				if ( !$modelStockItem->save() ) {
					pDebug("actionPartsUpdate() - item NOT saved; error=", $modelStockItem->errors);
				}

				$stockItem_ID = $modelStockItem->getPrimaryKey();

				$modelQuote = Quotes::model()->findByPk( $_POST['quote_id'] );
				$modelQuote->quote_type_id = QuoteTypes::STOCK;   // update Quote type

				if ( $_POST['approval_needed'] ) {
					$modelQuote->status_id = Status::PENDING;
					notifyApprovers($modelStockItem);
				}
				else {
					$modelQuote->status_id = Status::DRAFT;
				}

				if ( $modelQuote->save() ) {
					pDebug("actionPartsUpdate() - called from: ".$_GET['from']." - quote saved; new stock item id=" . $stockItem_ID );
					$arr = array( 'item_id' => $stockItem_ID );
				}
				else {
					pDebug("actionPartsUpdate() - quote NOT saved; error=", $modelQuote->errors);
				}
			}
		}
		catch (Exception $e) {
			Debug("actionPartsUpdate() - Exception: ", $e->errorInfo );
		}

        pDebug('Sending json:', json_encode($arr) );
		echo json_encode($arr);
	}







	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) 	{
		pTrace( __METHOD__ );
		$quote_id = $id;

		if ( $_POST ) {
			
			if ( isset( $_POST['quoteForm_Terms_QuoteID'] ) ) {   // updating just terms from Create page
				$quoteModel = $this->loadModel( $_POST['quoteForm_Terms_QuoteID'] );

				$quoteModel->terms_conditions =  $_POST['quote_Terms'];
				$quoteModel->customer_acknowledgment =  $_POST['quote_CustAck'];
				$quoteModel->risl =  $_POST['quote_RISL'];
				$quoteModel->manufacturing_lead_time =  $_POST['quote_MfgLeadTime'];
				$quoteModel->additional_notes =  $_POST['quote_Notes'];

				if ($quoteModel->save()) {
					pDebug( "actionUpdate() -  Terms saved for quote no. " . $_POST['quoteForm_Terms_QuoteID'] );
					echo Status::SUCCESS;
				}
				else {
					pDebug( "actionUpdate() -  Error in saving terms: ", $quoteModel->errors );
					echo Status::FAILURE;
				}
				return;
			}

			if ( isset($_POST['newQuoteStatus']) && Yii::app()->user->isAdmin ) {  // should only be Admin updating status
				$quoteModel = $this->loadModel($quote_id);
				$oldQuoteStatus = $quoteModel->status->name;

				$quoteModel->status_id = $_POST['newQuoteStatus'];
				if ($quoteModel->save()) {
					$new_quoteModel = $this->loadModel($quote_id);
					pDebug("Changed quote status from [$oldQuoteStatus] to [" . $new_quoteModel->status->name . "]" );
					notifySalespersonStatusChange($quoteModel);
					echo Status::SUCCESS;
				}
				else {
					pDebug("actionUpdate() - can't update quote status; error=", $quoteModel->errors );
					echo Status::FAILURE;
				}
				return;
			}

			// validate source id > 0
			if ( $_POST['Quotes']['source_id'] == 0 ) {
				echo Status::FAILURE;
				return;
			}

			// validate customer - if missing id, then assume it's a new customer, check for required fields
			if ( $_POST['Customers']['id'] ) {
				$customer_id =  $_POST['Customers']['id'];
			}
			else {
				if ( 	$_POST['Customers']['name'] && 
						$_POST['Customers']['address1'] && 
						$_POST['Customers']['city'] && 
						$_POST['Customers']['country_id'] ) {
					// create new customer
					$customerModel = new Customers();
					$customerModel->attributes =  $_POST['Customers'];
					if ($customerModel->save()) {
						pDebug('Saved new customer: ', $customerModel->attributes);
						$customer_id = $customerModel->id;
					}
					else {
						pDebug("actionUpdate() - can't save new contact; error=", $customerModel->errors );
						echo Status::FAILURE;
					}
				}
				else {
					echo Status::FAILURE;
				}
			}

			// validate contact - if missing id, then assume it's a new customer, check for required fields
			if ( $_POST['Contacts']['id'] ) {
				$contact_id =  $_POST['Contacts']['id'];
			}
			else {
				if ( 	$_POST['Contacts']['first_name'] &&
						$_POST['Contacts']['last_name'] && 
						$_POST['Contacts']['email'] &&
						$_POST['Contacts']['title'] &&
						$_POST['Contacts']['phone1'] ) {
					
					// create new contact
					$contactModel = new Contacts();
					$contactModel->attributes =  $_POST['Contacts'];
					if ($contactModel->save()) {
						pDebug('Saved new contact: ', $contactModel->attributes);
						$contact_id = $contactModel->id;
					}
					else {
						pDebug("actionUpdate() - can't save new contact; error=", $contactModel->errors );
						echo Status::FAILURE;
					}
				}
				else {
					echo Status::FAILURE;
				}
			}

			// update quote with source_id, contact_id, terms
			$quoteModel = $this->loadModel($quote_id);

			$quoteModel->customer_id             = $customer_id;
			$quoteModel->contact_id              = $contact_id;
			$quoteModel->source_id               = $_POST['Quotes']['source_id'];
			$quoteModel->status_id               = $_POST['Quotes']['status_id'];
    		$quoteModel->additional_notes        = $_POST['Quotes']['additional_notes'];
    		$quoteModel->terms_conditions        = $_POST['Quotes']['terms_conditions'];
    		$quoteModel->customer_acknowledgment = $_POST['Quotes']['customer_acknowledgment'];
    		$quoteModel->risl                    = $_POST['Quotes']['risl'];
    		$quoteModel->manufacturing_lead_time = $_POST['Quotes']['manufacturing_lead_time'];

         	if ($quoteModel->save()) {
				pDebug('Saved quote changes: ', $quoteModel->attributes);
				echo Status::SUCCESS;
			}
			else {
				pDebug("actionUpdate() - can't save quote changes; error=", $quoteModel->errors );
				echo Status::FAILURE;
			}
			return;
		}
		else {
			$data['model'] = $this->loadModel($quote_id);
			if ( $data['model']->status_id != Status::DRAFT && $data['model']->status_id != Status::REJECTED && !Yii::app()->user->isAdmin  ) { // allow for edits only for draft,rejected quotes
				$this->redirect(array('index'));
			}



			$data['items'] = array();

			$customer_id = $data['model']->customer_id;
			$contact_id  = $data['model']->contact_id;

			// ------------------------------ get customer
			$data['customer'] = Customers::model()->findByPk($customer_id);
			
			// ------------------------------ get contact
			$data['contact']  = Contacts::model()->findByPk($contact_id);

			$sql = "SELECT * FROM stock_items WHERE  quote_id = $quote_id";
			$command = Yii::app()->db->createCommand($sql);
			$results = $command->queryAll();

			foreach( $results as $i ) {
				foreach( array('1_24', '25_99', '100_499', '500_999', '1000_Plus', 'Base', 'Custom') as $v ) {
					if ( fq($i['qty_'.$v]) != '0' ) {
			 			//$data['items'][] = array( 'id' => $i['id'],  'part_no' => $i['part_no'], 'manufacturer'=>$i['manufacturer'], 'date_code'=>$i['date_code'], "qty" => fq($i["qty_$v"]), "price" => "<span class='volume'>$v</span>". fp($i["price_$v"]), "total" => fp(calc($i,$v)), "comments" => mb_strimwidth($i['comments'],0,150, '...')  );
			 			$data['items'][] = array( 'id' => $i['id'],  'part_no' => $i['part_no'], 'manufacturer'=>$i['manufacturer'], 'date_code'=>$i['date_code'], "qty" => fq($i["qty_$v"]), "volume" => $v, "price" => fp($i["price_$v"]), "total" => fp(calc($i,$v)), "comments" => mb_strimwidth($i['comments'],0,150, '...')  );
			 		}
				}
			}

			$data['model']    = $this->loadModel($quote_id);
			$data['sources']  = Sources::model()->findAll( array('order' => 'name') );
			$data['status']   = Status::model()->findAll();

			$this->render('update',array(
				'data'=>$data,
			));
		}
	}





	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 	{
		pTrace( __METHOD__ );
		pDebug("QuotesController::actionDelete() - _GET=", $_GET);
		pDebug("QuotesController::actionDelete() - _POST=", $_POST);

		if ( $_POST['data'][0] == $id ) {
			if ( $this->loadModel($id)->delete() ) {
				pDebug("Quotes:actionDelete() - quote id $id deleted...");
				echo Status::SUCCESS;
			}
			else {
				pDebug("Quotes:actionDelete() - ERROR: can't delete quote id $id; error=", $model->errors  );
				echo Status::FAILURE;
			}
		}
		return;
	}

	public function actionIndexApproval() 	{
		pTrace( __METHOD__ );
		pDebug('actionIndexApproval() - _GET=', $_GET);

		$criteria = new CDbCriteria();

		if ( Yii::app()->user->isApprover || Yii::app()->user->isAdmin ) {
			$page_title = "Quotes Needing Approval";
			$criteria->addCondition("status_id = " . Status::PENDING);

			$criteria->order = 'id DESC';
			$model = Quotes::model()->findAll( $criteria );

			$this->render( 'index', array(
				'model' => $model,
				'page_title' => $page_title,
			));
		}
		else {

		}
	}

	public function actionIndex() 	{
		pTrace( __METHOD__ );
		pDebug('actionIndex() - _GET=', $_GET);

		$criteria = new CDbCriteria();
		if ( !Yii::app()->user->isAdmin ) {
			$criteria->addCondition("owner_id = " . Yii::app()->user->id);
		}

		$criteria->order = 'id DESC';
		
		$model = Quotes::model()->findAll( $criteria );

		$this->render( 'index', array(
			'model' => $model,
			'page_title' => "My Quotes",
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

	


    	//-------------------------------------------------------
	public function actionPdf($id) {
		pTrace( __METHOD__ );
		pDebug('actionPdf() - creating PDF file for quote no. ' . $id);

		$data          = array();
		$modelQuote    = $this->loadModel($id);
		$modelCustomer = Customers::model()->findByPk($modelQuote->customer_id);  
		$modelItems    = Items::model()->findAll( array( 'condition' => "quote_id=$id") );   
		$contact       = getContactInfoByCustomerID($modelQuote->customer_id); 

		// start filling $data for pdf
		$data['terms_conditions']        = $modelQuote->terms_conditions;
		$data['expiration_date']         = $modelQuote->expiration_date;
		$data['additional_notes']        = $modelQuote->additional_notes;
		$data['customer_acknowledgment'] = $modelQuote->customer_acknowledgment;
		$data['risl']                    = $modelQuote->risl;
		$data['terms']                   = $tc->content;
		$data['manufacturing_lead_time'] = $modelQuote->manufacturing_lead_time;
		$data['quote_no']                = $modelQuote->quote_no;
		$data['status_id']             = $modelQuote->status_id;

		$st                              = UsStates::model()->findByPk($modelCustomer->state_id);
		$co                              = Countries::model()->findByPk($modelCustomer->country_id); 
		$data['customer']['name']        = $modelCustomer->name;
		$data['customer']['address1']    = $modelCustomer->address1;
		$data['customer']['address2']    = $modelCustomer->address2;
		$data['customer']['city']        = $modelCustomer->city;
		$data['customer']['state']       = $st->short_name;
		$data['customer']['zip']         = $modelCustomer->zip;
		$data['customer']['country']     = $co->long_name;
		$data['customer']['quote_id']    = $id;

		$data['customer']['contact']['name']   = $contact['fullname']; 
		$data['customer']['contact']['email']  = $contact['email'];
		$data['customer']['contact']['phone1'] = $contact['phone1']; 
		$data['customer']['contact']['phone2'] = $contact['phone2'];
	
		$u = Users::model()->findByPk($modelQuote->user_id);

		$data['profile']['name']  = $u->fullname;
		$data['profile']['title'] = $u->title;
		$data['profile']['phone'] = $u->phone;
		$data['profile']['fax']   = $u->fax;
		$data['profile']['email'] = $u->email;
		$data['profile']['sig']   = $u->sig;
		
		foreach( $modelItems as $i => $m ) {
			$data['items'][] = array(	'part_no'       => $m->part_no, 
										'manufacturer'  => $m->manufacturer, 
										'line_note'     => $m->line_note,
										'date_code'     => $m->date_code,

										'1_24'      => array( $m->qty_1_24,      $m->price_1_24 ),
										'25_99'     => array( $m->qty_25_99,     $m->price_25_99 ),
										'100_499'   => array( $m->qty_100_499,   $m->price_100_499 ),
										'500_999'   => array( $m->qty_500_999,   $m->price_500_999 ),
										'1000_Plus' => array( $m->qty_1000_Plus, $m->price_1000_Plus ),
										'Base'      => array( $m->qty_Base,      $m->price_Base ),
										'Custom'    => array( $m->qty_Custom,    $m->price_Custom )
									);
		}

		//pDebug('Quotes::actionPdf() - data:', $data);
		$this->createPDF($data);
		
	}






	public function createPDF($d) {
		//pDebug('createPDF() - data:', $d);
	    $pdf = new PDF();
	    
	    // define colors
	    $pdf->definePallette();

	    // set up page, margin
	    $pdf->AliasNbPages();
	    $pdf->SetLeftMargin(20);
	    $pdf->AddPage( 'Portrait', 'Letter');
	    $pdf->SetAutoPageBreak(true,35); 
	    $pdf->SetTopMargin(50);

	    // User Profile
	    $u = array();
	    $u['name']   = $d['profile']['name'];
	    $u['title']  = $d['profile']['title'];
	    $u['phone']  = $d['profile']['phone'];
	    $u['fax']    = $d['profile']['fax'];
	    $u['email']  = $d['profile']['email'];
	    $u['sig']    = $d['profile']['sig'];
	    $pdf->userProfile = $u; 
	    pDebug("createPDF() user profile: ", $pdf->userProfile);

	    // Page Heading
	    $pdf->displayPageHeading();

	    // --------------------------------------------- Add Watermark
	    if ( $d['status_id'] == Status::DRAFT || $d['status_id'] == Status::PENDING ) {
	    	$pdf->addWatermark();
	    } 
	    	


	    // Company & Contact Info
	    $c = array();
	    $c['quote_no']          = $d['quote_no'];
	    $c['name']              = $d['customer']['name'];
	    $c['address1']          = $d['customer']['address1'];
	    $c['address2']          = $d['customer']['address2'];
	    $c['city']              = $d['customer']['city'];
	    $c['state']             = $d['customer']['state'];
	    $c['zip']               = $d['customer']['zip'];
	    $c['country']           = $d['customer']['country'];
	    $c['contact']['name']   = $d['customer']['contact']['name'];
	    $c['contact']['email']  = $d['customer']['contact']['email'];
	    $c['contact']['phone1'] = $d['customer']['contact']['phone1'];
	    $c['contact']['phone2'] = $d['customer']['contact']['phone2'];
	    $pdf->displayCompanyInfo($c);

	    // Introduction letter
	    $name       = explode(' ', $c['contact']['name']); 
	    $first_name = $name[0];
	    $cre = $d['created'];
	    $exp = $d['expiration_date'];

	    $letter_intro = <<<EOT
Dear $first_name,
    Thank you for the opportunity to provide you with this quotation. Outlined below are Rochester Electronics' acknowledgement, NCNR, if applicable, and order processing instructions; please feel free to contact us at any time if you have questions regarding this quote. We are pleased to offer the following:
EOT;

	    $letter_conclusion = <<<EOT
Again, thank you for this opportunity; we look forward to receiving your order.

Regards,

EOT;

	    $pdf->displayLetterIntro($letter_intro);

	    // $row = array();
	    $line_num = 1;
	    $items = array();
	    $items[] = array( 'Line', 'Part No.','Mfr.','Line Note','Date Code','Quantity','Price','Total');
	    $grand_total = 0;

	    foreach( $d['items'] as $i => $arr ) {
	    	$row = array();
	    	$row[] = $line_num;		 				
	    	foreach( $arr as $k => $v ) {
	    		if ( !is_array($v) ) {
	    			$row[] = $v; 					   
	    		}
	    		else {
    				if ( $v[0] ) {
    					$row[] = $v[0];
    					setlocale(LC_MONETARY, 'en_US.UTF-8');
    					$row[] = money_format('%.2n', $v[1]);
    					$row[] = money_format('%.2n', ($v[0]*$v[1]) );
    					$grand_total += ($v[0]*$v[1]);

    					$items[] = $row;
    					$row = array();
    					$line_num++;
    				}
	    		}
	    	}

	    }
	    // $items[] = array( '','','','','','','Order Total', money_format('%.2n', $grand_total) ) ;   no need to totaling...

	    $pdf->displayQuoteDetails($items);

	    $notes = array();
	    $notes[] = array('Quote Expiration' => $d['expiration_date']);

	    if ($d['additional_notes']) $notes[] = array('Additional Notes' => $d['additional_notes'] );   
	    if ($d['terms']) $notes[] = array('Terms & Conditions' => $d['terms'] );   
	    if ($d['customer_acknowledgment']) $notes[] = array('Customer Acknowledgment' => $d['customer_acknowledgment'] );   
	    if ($d['risl']) $notes[] = array('RISL' => $d['risl'] );   
	    if ($d['manufacturing_lead_time']) $notes[] = array('Manufacturing Lead Time' => $d['manufacturing_lead_time'] );   

	    $pdf->displayNotes($notes);
	    $pdf->displayLetterConclusion($letter_conclusion);
	    $pdf->displayProfile();

		// --------------------------------------------- Add Watermark
    	if ( $d['status_id'] == Status::DRAFT || $d['status_id'] == Status::PENDING ) {
    		$pdf->addWatermark();
    	}

	    $pdf->Output("MyQuote_" . $d['quote_no'] . ".pdf", "D");
	}





	// --------------------------------------------------------
	private function getQtyPriceTotal( $i ) { 
		$data = '<table id="table_Parts">';
		if ( fq($i['qty_1_24']) != '0' ) {
 			$data .=  "<tr>  <td> ".fq($i['qty_1_24'])."</td>        <td><span class='volume'>1-24</span>"      .fp($i['price_1_24'])."</td>      <td> ".fp(calc($i,'1_24'))."</td>   </tr>"; 
 		}

 		if ( fq($i['qty_25_99']) != '0' ) {
 			$data .=  "<tr> <td> ".fq($i['qty_25_99'])."</td>        <td><span class='volume'>25-99</span>"     .fp($i['price_25_99'])."</td>     <td> ".fp(calc($i,'25_99'))."</td>   </tr>"; 
 		}

 		if ( fq($i['qty_100_499']) != '0' ) {
 			$data .=  "<tr> <td> ".fq($i['qty_100_499'])."</td>      <td><span class='volume'>100-499</span>"   .fp($i['price_100_499'])."</td>   <td> ".fp(calc($i,'100_499'))."</td>   </tr>"; 
 		}

 		if ( fq($i['qty_500_999']) != '0' ) {
 			$data .=  "<tr> <td> ".fq($i['qty_500_999'])."</td>      <td><span class='volume'>500-999</span>"   .fp($i['price_500_999'])."</td>   <td> ".fp(calc($i,'500_999'))."</td>   </tr>"; 
 		}

 		if ( fq($i['qty_1000_Plus']) != '0' ) {
 			$data .=  "<tr> <td> ".fq($i['qty_1000_Plus'])."</td>    <td><span class='volume'>1000+</span>"     .fp($i['price_1000_Plus'])."</td> <td> ".fp(calc($i,'1000_Plus'))."</td>   </tr>"; 
 		}

		if ( fq($i['qty_Base']) != '0' ) {
 			$data .=  "<tr> <td> ".fq($i['qty_Base'])."</td>    <td><span class='volume'>Base</span>"     .fp($i['price_Base'])."</td> <td> ".fp(calc($i,'Base'))."</td>   </tr>"; 
 		}

		if ( fq($i['qty_Custom']) != '0' ) {
 			$data .=  "<tr> <td> ".fq($i['qty_Custom'])."</td>    <td><span class='volume'>Custom</span>"     .fp($i['price_Custom'])."</td> <td> ".fp(calc($i,'Custom'))."</td>   </tr>"; 
 		}
 		$data .= "</table>";

 		return $data;
	}


	// --------------------------------------------------------
	private function getQuoteNumber() {
		$id = Yii::app()->db->createCommand()->select('max(id) as max')->from('quotes')->queryScalar() + 1;
		$id = $id ? $id : 1;
		return Date('Ymd-') . sprintf("%04d", $id);
	}


	// -----------------------------------------------------------
    private function getQuoteExpirationDate() {
        // quote expiration 30 days from today
        $exp = "+30 days";
        return Date( 'Y-m-d 00:00:00', strtotime($exp) );
    }

}
