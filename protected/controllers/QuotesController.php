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
			'postOnly + delete, disposition', // we only allow deletion via POST request
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
				'actions'=>array('admin', 'config', 'disposition'),
				'expression' => '$user->isAdmin'
			),

			array('allow', // allow approvers  to perform 'disposition' 
				'actions'=>array('disposition'),
				'expression' => '$user->isApprover'
			),

			array('allow', // allow Proposal Manager to initiate Manufacturing Quote 
				'actions'=>array('manufacturing', 'notifyMfgApprovers'),
				'expression' => '$user->isProposalManager'
			),

			array('allow', 
				'actions'=>array('coordinator'),
				'expression' => '$user->isBtoApprover'
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



	public function actionDisposition($id)     { 
		pTrace( __METHOD__ );
		pDebug('actionDisposition() = _POST:', $_POST);

		$quote_id = $id;


		// TODO: refactor all this...


		// 1. get item id, disposition
		$item_id          = $_POST['item_id'];
		$item_disposition = $_POST['item_disposition'];

		$modelStockItems = StockItems::model()->findByPk($item_id);

		// 2. update item status
		if ( $item_disposition == 'Approve' ) {
			$modelStockItems->status_id = Status::APPROVED;  				 // set Item status

			if ( $modelStockItems->save() ) {
				// update quote status
				$quoteModel = $this->loadModel($quote_id);
				$quoteModel->status_id = $this->getUpdatedQuoteStatus($quote_id);   // set Quote status

				if ( $quoteModel->save() ) {
					pDebug("actionDisposition() - Quote status updated to: " . $quoteModel->status->name . "; calling notifySalespersonStatusChange()...");
					notifySalespersonStatusChange($quoteModel,$modelStockItems );

					echo Status::SUCCESS;
				}
				else {
					pDebug("actionDisposition() - Couldn't update Quote status: ", $quoteModel->errors );
					echo Status::FAILURE;
				}

				// // 3. check for other items in same quote
				// $pending_items = getPendingItemCount($id);
				// pDebug('Any more items still pending? ' . $pending_items );

				// if ( $pending_items == 0 ) {
				// 	// 4. if no more items neeed approval, change quote status to Approved
				// 	$model = $this->loadModel($id);
			 //    	$model->status_id = Status::APPROVED;

			 //    	if ( $model->save() ) {
			 //    		pDebug('actionDisposition() - quote ' . $model->quote_no . ' approved');
			 //    		notifySalespersonStatusChange($model);
			 //    		echo Status::SUCCESS;
			 //    	}
			 //    	else {
			 //    		pDebug('actionDisposition() - ERROR approving quote: ', $model->errors);
			 //    		echo Status::FAILURE;
			 //    	}
				// }
				// else {
				// 	pDebug("actionDisposition() - can't approve quote yet; still pending items.");
				// 	echo Status::SUCCESS;
				// }

			}
			else {
				pDebug("actionDisposition() - couldn't save new model; errors: ", $modelStockItems->errors);
				echo Status::FAILURE;
			}
		}
		else if ( $item_disposition == 'Reject' ) {
			$modelStockItems->status_id = Status::REJECTED;
			if ( $modelStockItems->save() ) {
				pDebug("actionDisposition() - item [$item_id] in quote [$id] rejected.");
				// update 
				$quoteModel = $this->loadModel($quote_id);
				$quoteModel->status_id = $this->getUpdatedQuoteStatus($quote_id);

				if ( $quoteModel->save() ) {
					pDebug("actionDisposition() - Quote status updated to: " . $quoteModel->status->name . "; calling notifySalespersonStatusChange()...");
					//notifySalespersonStatusChange($quoteModel, $modelStockItems);
					echo Status::SUCCESS;
				}
				else {
					pDebug("actionPartsUpdate() - Couldn't update Quote status: ", $quoteModel->errors );
					echo Status::FAILURE;
				}
			}
			else {
				pDebug("actionDisposition() - couldn't save new model; errors: ", $modelStockItems->errors);
				echo Status::FAILURE;
			}
			// // 5. if item rejected, change quote status to Rejected
			// $model = $this->loadModel($id);
	  //   	$model->status_id = Status::REJECTED;

	  //   	if ( $model->save() ) {
	  //   		pDebug('actionDisposition() - quote ' . $model->quote_no . ' rejected');
	  //   		notifySalespersonStatusChange($model);
	  //   		echo Status::SUCCESS;
	  //   	}
	  //   	else {
	  //   		pDebug('actionDisposition() - ERROR rejecting quote: ', $model->errors);
	  //   		echo Status::FAILURE;
	  //   	}
		}


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
		pDebug('actionView() - Viewing quote model:', $data['model']->attributes );

		$customer_id = $data['model']->customer_id;
		$contact_id  = $data['model']->contact_id;
		$quote_id    = $data['model']->id;

		// ------------------------------ get customer
		$data['customer'] = Customers::model()->findByPk($customer_id);
		
		// ------------------------------ get contact
		$data['contact']  = Contacts::model()->findByPk($contact_id);

		// ------------------------------ get status
		$data['status'] = array();
		$data['status']  = Status::model()->findAll();

		// ------------------------------ get items
		$data['items'] = array();
		$data['items'] = $this->getItemsByQuote($quote_id);

		$data['bto_approvers'] = BtoApprovers::model()->getList();

		// $criteria = new CDbCriteria();

		// if ( Yii::app()->user->isApprover || Yii::app()->user->isAdmin ) {
		// 	$page_title = "Quotes Needing Approval";
		// 	$criteria->addCondition("status_id = " . Status::PENDING);

		// 	$criteria->order = 'id DESC';
		// 	$model = Quotes::model()->findAll( $criteria );

		$criteria =  new CDbCriteria();
		$criteria->addCondition("quote_id = $id");
		$data['BtoItems_model'] = BtoItems::model()->find( $criteria );

		// $data['coordinators'] = approver_Assembly  approver_Production  approver_Test  approver_Quality
		// +----+------------+
		// | id | name       |
		// +----+------------+
		// |  1 | Assembly   |
		// |  2 | Quality    |
		// |  3 | Test       |
		// |  4 | Production |
		// +----+------------+


		$data['selects']      = Quotes::model()->getAllSelects();
		$data['bto_messages'] = BtoMessages::model()->getAllMessageSubjects($id);
		$data['attachments']  = Attachments::model()->getAllAttachments($id);

		$this->render('view',array(
			'data'=>$data,
		));

	}

	
	public function actionCreate() {
		pTrace( __METHOD__ );
		
		if ( isset($_POST['Customers']) && isset($_POST['Contacts']) && isset($_POST['Quotes'])   ) {
			pDebug("Quotes::actionCreate() - _POST values from serialized form values:", $_POST);

			$customer_id = $_POST['Customers']['id'];
			$contact_id  = $_POST['Contacts']['id'];
			$quote_type  = $_POST['Quotes']['quote_type_id'];

			if (!$customer_id ) {				// create new customer, get id
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

			if (!$contact_id ) {					// create new contact, get id
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
			try {
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
			catch (Exception $e) {
				pDebug("actionCreate() - Exception: ", $e );
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

	private function getTimeStamp() {
		$u = Yii::app()->user->fullname;
		$t = Date('D Y-m-d h:i:s');

		return "[$t] $u";
	}

	private function getUpdatedQuoteStatus( $quote_id ) {
		// any Rejected items?
		$rejected_items = getRejectedItemCount($quote_id);

		// any Pending items?
		$pending_items = getPendingItemCount($quote_id);

		if ( !$rejected_items && !$pending_items ) {  // set back to Draft
			$new_quote_status = Status::DRAFT;
		}
		
		if ($rejected_items) {
			$new_quote_status = Status::REJECTED;
		}

		// Pending trumps Rejected
		if ($pending_items) { 						 // set back to Pending
			$new_quote_status = Status::PENDING;
		}

		return $new_quote_status;
	}


	public function actionPartsUpdate() 	{
		pTrace( __METHOD__ );
		$arr = array();

		try {
			
			if ( isset($_POST['item_id']) ) {   												// editing Inventory Item
				pDebug( "actionPartsUpdate() - editing Inventory item: _POST=", $_POST ); 

				$quote_id       = $_POST['quote_id'];
				$modelStockItem = StockItems::model()->findByPk( $_POST['item_id']);

				/*
					if editing an item that has been rejected, then set it back to 'DRAFT';
					then, check to see if there are any more Rejected or Pending items
					- if neither, change status respectively
				*/

				if ( $modelStockItem->status_id == Status::REJECTED ) {
					$modelStockItem->setAttribute( 'status_id', Status::DRAFT );
				}


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

				$modelStockItem->setAttribute( 'qty_'. $volume, $_POST['item_qty'] );

				if  ( $_POST['item_comments'] ) {
					$old_comments = $modelStockItem->comments;
					$modelStockItem->setAttribute( 'comments', $this->getTimeStamp() . "\n....." . $_POST['item_comments'] . "\n\n" . $old_comments );
				}

				pDebug( "actionPartsUpdate() - updating Inventory Item with the following attributes: ", $modelStockItem->attributes );

				if ( $modelStockItem->save() ) {
					pDebug("actionPartsUpdate() - Inventory Item updated.");

					$quoteModel = $this->loadModel($quote_id);
					$quoteModel->status_id = $this->getUpdatedQuoteStatus($quote_id);

					if ( $quoteModel->save() ) {
						pDebug("actionPartsUpdate() - Quote status updated to: " . $quoteModel->status_id );
					}
					else {
						pDebug("actionPartsUpdate() - Couldn't update Quote status: ", $quoteModel->errors );
					}
				}
				else {
					pDebug("actionPartsUpdate() - Inventory Item NOT updated; error=", $modelStockItem->errors);
				}
			}
			else {  																			// adding Inventory Item
				pDebug('actionPartsUpdate() - _POST:', $_POST);

				$modelStockItem = new StockItems;
				$modelStockItem->attributes = $_POST;

				// TODO - refactor this
				if ( $_POST['lifecycle'] == 'Active' ) {
					$lifecycle = Lifecycles::ACTIVE;
				}
				else if ( $_POST['lifecycle'] == 'Obsolete' ) {
					$lifecycle = Lifecycles::OBSOLETE;
				}
				else {
					$lifecycle = Lifecycles::N_A;
				}

				$modelStockItem->setAttribute( 'lifecycle_id', $lifecycle ); 
				$modelStockItem->setAttribute( 'status_id', $_POST['approval_needed'] == 1 ? Status::PENDING : Status::DRAFT ); 

				if ( $_POST['comments'] ) {
					$modelStockItem->setAttribute( 'comments', $this->getTimeStamp() . "\n....." . $_POST['comments'] );
				}

				pDebug( "actionPartsUpdate() - updating StockItems model with the following attributes: ", $modelStockItem->attributes );

				if ( $modelStockItem->save() ) {
					$stockItem_ID = $modelStockItem->getPrimaryKey();
					$modelQuote = Quotes::model()->findByPk( $_POST['quote_id'] );
					$modelQuote->quote_type_id = QuoteTypes::STOCK;   					// update Quote type

					if ( $_POST['approval_needed'] ) {
						$modelQuote->status_id = Status::PENDING;
						notifyApprovers($modelStockItem);
					}
					else {
						$modelQuote->status_id = Status::DRAFT;
					}

					if ( $modelQuote->save() ) {
						$arr[] = array( 'item_id' => $stockItem_ID );

						/*
							TODO: check out why this is causing an error in function checkCustomPrice() - see iq2_main.js
						
									Sending json: (Len D'Alberti)
									[{"item_id":"51"}]

									Your Customer Quote could NOT be updated - see Admin (checkCustomPrice)

									ERROR=SyntaxError: Unexpected token I
									VM2125:1394 jqXHR{"readyState":4,"responseText":"Invalid address: [{\"item_id\":\"50\"}]","status":200,"statusText":"OK"}
									Navigated to http://lenscentos/iq2/index.php/quotes/update/7

						*/

							// 	$list[] = array( 'id' => $r['id'], 'label' => $r['name'] );
							// }
							// // pDebug("actionSelect() - list:", $list); 
							// echo json_encode($list);
						
							// pDebug('Sending json:', json_encode($arr) );
							// echo json_encode($arr);

					}
					else {
						pDebug("actionPartsUpdate() - quote NOT saved; error=", $modelQuote->errors);
					}
				}
				else {
					pDebug("actionPartsUpdate() - item NOT saved; error=", $modelStockItem->errors);
				}

			}
		}
		catch (Exception $e) {
			pDebug("actionPartsUpdate() - Exception: ", $e->errorInfo );
		}

		pDebug('Sending json:', json_encode($arr) );  //  [{"item_id":"51"}]
		echo json_encode($arr);
		return;

	}







	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) 	{
		pTrace( __METHOD__ );
		$quote_id = $id;

		pDebug("Quotes::actionUpdate() - id=[$id], _POST=", $_POST);
		if ( $_POST ) {
			
			// validate source id > 0
			if ( $_POST['Quotes']['source_id'] == 0 ) {
				echo Status::FAILURE;
				return;
			}

			if ( $_POST['quoteTypeID'] == QuoteTypes::MANUFACTURING ) {
				if ( isset($_POST['BtoItems']) ) {
					$item_id = $_POST['BtoItems']['id'];

					pDebug("Quotes::actionUpdate() - saving item_id:[$item_id] for Manufacturing quote: [$id]");

					$itemsModel                        = BtoItems::model()->findByPk($item_id);
					$itemsModel->order_probability_id  = $_POST['BtoItems']['order_probability_id'];
					$itemsModel->requested_part_number = $_POST['BtoItems']['requested_part_number'];
					$itemsModel->generic_part_number   = $_POST['BtoItems']['generic_part_number'];
					$itemsModel->quantity1             = $_POST['BtoItems']['quantity1'];
					$itemsModel->quantity2             = $_POST['BtoItems']['quantity2'];
					$itemsModel->quantity3             = $_POST['BtoItems']['quantity3'];
					$itemsModel->die_manufacturer_id   = $_POST['BtoItems']['die_manufacturer_id'];
					$itemsModel->package_type_id       = $_POST['BtoItems']['package_type_id'];
					$itemsModel->lead_count            = $_POST['BtoItems']['lead_count'];
					$itemsModel->temp_low              = $_POST['BtoItems']['temp_low'];
					$itemsModel->temp_high             = $_POST['BtoItems']['temp_high'];
					$itemsModel->process_flow_id       = $_POST['BtoItems']['process_flow_id'];
					$itemsModel->testing_id            = $_POST['BtoItems']['testing_id'];
					$itemsModel->ncnr                  = $_POST['BtoItems']['ncnr'];
					$itemsModel->itar                  = $_POST['BtoItems']['itar'];
					$itemsModel->have_die              = $_POST['BtoItems']['have_die'];
					$itemsModel->spa                   = $_POST['BtoItems']['spa'];
					$itemsModel->recreation            = $_POST['BtoItems']['recreation'];
					$itemsModel->wip_product           = $_POST['BtoItems']['wip_product'];

					pDebug("Quotes::actionUpdate() - item attributes:", $itemsModel->attributes );

					try { 
						if ( $itemsModel->save() ) {
							pDebug("Quotes::actionUpdate() - Manufacturing quote saved.");
						}
						else {
							pDebug("Quotes::actionUpdate() - Error: manufacturing quote NOT saved, error=", $itemsModel->errors);
							echo Status::FAILURE;
							return;
						}
					}
					catch( Exception $ex ) {
						pDebug("actionPartsUpdate() - Exception: ", $e->errorInfo );
						echo Status::FAILURE;
						return;
					}
				}
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

			// validate contact - if missing id, then assume it's a new contact, check for required fields
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

			$quoteModel                    = $this->loadModel($quote_id);
			$quoteModel->attributes        = $_POST['Quotes'];
			$quoteModel->status_id         =  $this->getUpdatedQuoteStatus($quote_id); 
			$quoteModel->salesperson_notes = $_POST['Quotes']['salesperson_notes'];

			pDebug("actionPartsUpdate() - Updating quote with these attributes:", $quoteModel->attributes);

			try {
				$res = $quoteModel->save();
			}
			catch (Exception $e) {
				pDebug("actionPartsUpdate() - Exception: ", $e->errorInfo );
				echo Status::FAILURE;
				return;
			}

			echo Status::SUCCESS;
			return;
		}
		else {
			pDebug("actionUpdate() - _GET=", $_GET);

			$data['model'] = $this->loadModel($quote_id);
			$customer_id   = $data['model']->customer_id;
			$contact_id    = $data['model']->contact_id;

			// ------------------------------ get customer
			$data['customer'] = Customers::model()->findByPk($customer_id);
			
			// ------------------------------ get contact
			$data['contact']  = Contacts::model()->findByPk($contact_id);
			
			// ------------------------------ get items
			$data['items']   = array();
			$data['items']   = $this->getItemsByQuote($quote_id);
			$data['selects'] = Quotes::model()->getAllSelects();
			$data['model']   = $this->loadModel($quote_id);
			$data['sources'] = Sources::model()->findAll( array('order' => 'name') );
			$data['status']  = Status::model()->findAll();

			$criteria =  new CDbCriteria();
			$criteria->addCondition("quote_id = $quote_id");
			$data['BtoItems_model'] = BtoItems::model()->find( $criteria );

			$this->render('update',array(
				'data'=>$data,
			));
		}
	}  // END_OF_FUNCTION actionUpdate()

















	// -----------------------------------------------------------------------------
	private function getItemsByQuote( $quote_id ) {
		$sql = "SELECT * FROM stock_items WHERE  quote_id = $quote_id";
		$command = Yii::app()->db->createCommand($sql);
		$results = $command->queryAll();

		foreach( $results as $i ) {
			// pDebug('Quotes:getItemsByQuote() - results from stock_items:', $i );
			foreach( array('1_24', '25_99', '100_499', '500_999', '1000_Plus', 'Base', 'Custom') as $v ) {
				if ( fq($i['qty_'.$v]) != '0' ) {

					// TODO - refactor
					if ( $i['lifecycle_id'] == Lifecycles::ACTIVE ) {
						$lifecycle = 'Active';
					}
					else if ( $i['lifecycle_id'] == Lifecycles::OBSOLETE ) {
						$lifecycle = 'Obsolete';
					} 
					else {
						$lifecycle = 'n/a';
					}
		 			
		 			$items[] = array( 	"id"            	=> $i['id'], 
 										"available"     	=> $i['qty_Available'], 
 										"status_id"         => $i['status_id'], 
 										"part_no"       	=> $i['part_no'], 
 										"lifecycle"     	=> $lifecycle,
 										"manufacturer"  	=> $i['manufacturer'], 
 										"date_code"     	=> $i['date_code'], 
 										"qty"           	=> fq($i["qty_$v"]), 
 										"volume"        	=> $v, 
 										"price"         	=> fp($i["price_$v"]), 
 										"total"         	=> fp(calc($i,$v)), 
 										"comments"      	=> mb_strimwidth($i['comments'],0,150, '...')  );
		 		}
			}
		}

		pDebug('Quotes::getItemsByQuote() - final items:', $items );
		return $items;
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

			try {
				if ( $this->loadModel($id)->delete() ) {
					pDebug("Quotes:actionDelete() - quote id $id deleted...");
					echo Status::SUCCESS;
				}
				else {
					pDebug("Quotes:actionDelete() - ERROR: can't delete quote id $id; error=", $model->errors  );
					echo Status::FAILURE;
				}
			}
			catch (Exception $ex) {
				pDebug("Quotes:actionDelete() - Exception caught: ",  $ex->errorInfo  );
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

		$quote_type = QuoteTypes::STOCK;

		$criteria = new CDbCriteria();
		if ( !Yii::app()->user->isAdmin ) {
			$criteria->addCondition("owner_id = " . Yii::app()->user->id);
		}

		$criteria->order = 'id DESC';
		$model = Quotes::model()->findAll( $criteria );

		$this->render( 'index', array(
			'quote_type' => $quote_type,
			'model'      => $model,
			'page_title' => "My Quotes",
		));
	}

	public function actionManufacturing() {
		pTrace( __METHOD__ );
		pDebug('actionIndexApproval() - _GET=', $_GET);

		$quote_type = QuoteTypes::MANUFACTURING;
		$status     = Status::BTO_PENDING;

		$criteria = new CDbCriteria();

		if ( Yii::app()->user->isProposalManager || Yii::app()->user->isAdmin ) {
			$page_title = "Manufacturing Quotes";
			$criteria->addCondition("quote_type_id = $quote_type");
			$criteria->addCondition("status_id = $status");

			$criteria->order = 'id DESC';
			$model = Quotes::model()->findAll( $criteria );

			$this->render( 'index', array(
				'quote_type' => $quote_type,
				'model'      => $model,
				'page_title' => $page_title,
			));
		}
		else {

		}

	}


	// isBtoApprover
	public function actionCoordinator() {
		pTrace( __METHOD__ );
		pDebug('actionCoordinator() - _GET=', $_GET);

		if ( Yii::app()->user->isBtoApprover || Yii::app()->user->isAdmin ) { 
			$quote_type = QuoteTypes::MANUFACTURING;
			$status     = Status::BTO_PENDING;
			$page_title = "Manufacturing Quotes";

			$my_id = Yii::app()->user->id;
			$sql = <<<EOT

SELECT 
		q.id, 
		q.quote_no,      
		qt.name as quote_type, 
		s.name as status,
		l.name as level, 
		concat(u.first_name, ' ', u.last_name) as owner_name,  
		cu.name as customer_name, 
		concat(con.first_name, ' ', con.last_name) as contact_name
  FROM
  		quotes AS q
  			JOIN bto_messages  m ON m.quote_id  = q.id 
  			JOIN bto_approvers a ON a.user_id   = m.to_user_id
  			JOIN users u  		 ON u.id        = m.to_user_id
  			JOIN levels l 		 ON l.id        = q.level_id
  			JOIN quote_types qt  ON qt.id       = q.quote_type_id
  			JOIN customers cu    ON cu.id  = q.customer_id
  			JOIN contacts con    ON con.id = q.contact_id
  			JOIN status s        ON s.id   = q.status_id
 WHERE
 		m.to_user_id = $my_id

EOT;

			$command = Yii::app()->db->createCommand($sql);
			$results = $command->queryAll();
			pDebug("results=", $results);

			$this->render( 'index_coordinator', array(
				'quote_type' => $quote_type,
				'model'      => $results,
				'page_title' => $page_title,
			));
		}



		// $criteria = new CDbCriteria();

		// if ( Yii::app()->user->isBtoApprover || Yii::app()->user->isAdmin ) {
		// 	$page_title = "Manufacturing Quotes";
		// 	$criteria->addCondition("quote_type_id = $quote_type");
		// 	$criteria->addCondition("status_id = $status");

		// 	$criteria->order = 'id DESC';
		// 	$model = Quotes::model()->findAll( $criteria );

		// 	$this->render( 'index', array(
		// 		'quote_type' => $quote_type,
		// 		'model' => $model,
		// 		'page_title' => $page_title,
		// 	));
		// }
		// else {

		// }




	}




	public function actionNotifyMfgApprovers() {
		pDebug("Quotes::actionNotifyMfgApprovers() - _POST=", $_POST); 
		
		$toBeNotified = array();
		foreach( array( $_POST['approver_Assembly'] ,$_POST['approver_Production'] ,$_POST['approver_Test'] ,$_POST['approver_Quality'] ) as $id ) {
			if ( $id ) {
				$toBeNotified[] = $id;
			}
		}
		pDebug("Quotes::actionNotifyMfgApprovers() - to be notified:", $toBeNotified);

		if ( $_POST['quoteID'] === '' || $_POST['text_Subject'] === '' || $_POST['text_Message'] === '' || count($toBeNotified) === 0 ) {
			pDebug("Quotes::actionNotifyMfgApprovers() - missing _POST variables...");
			echo Status::FAILURE;
		}

		try {
			$criteria = new CDbCriteria();
			$criteria->addCondition("quote_id = " . $_POST['quoteID'] );
			
			$modelItems =  BtoItems::model()->find($criteria);
			$modelItems->approvers_notified = true;
			$modelItems->save();

			// save comment
			foreach( $toBeNotified as $user_id ) {
				$modelMessages = new BtoMessages;
				$modelMessages->quote_id     = $_POST['quoteID'];
				$modelMessages->bto_item_id  = $modelItems->id;
				$modelMessages->from_user_id = Yii::app()->user->id;
				$modelMessages->to_user_id   = $user_id;
				$modelMessages->subject      = $_POST['text_Subject'];
				$modelMessages->message      = $_POST['text_Message'];
				$modelMessages->save();
			}

			// notify approvers
			if ( !notifyBtoApprovers( $modelMessages ) ) {
				throw new Exception("Couldn't notify approvers.");
			}
		}
		catch( Exception $ex ) {
			pDebug("Quotes::actionNotifyMfgApprovers() - Exception: ", $ex );
			echo Status::FAILURE;
		}
		echo Status::SUCCESS;
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
