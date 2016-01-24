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
				'actions'=>array('index','view','create','update', 'search'),
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


	// ------------------------------------- AutoCompletion Search...
    public function actionSearch()     {        
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

		$data['results'] = json_encode($results);
		echo json_encode($results);
    }














	
	// --- 
	public function actionView($id) {

		$model = $this->loadModel($id);
		pDebug('QuotesController::actionView() - quote attributes:', $model->attributes);
		
		if ( $model->quote_type_id == QuoteTypes::STOCK ) {
			// display only Stock Quote relevant fields
			echo 'displaying Stock quote...';
		}
		else if ( $model->quote_type_id == QuoteTypes::MANUFACTURING ) {
			// display only Manufacturing Quote relevant fields
			echo 'displaying Manufacturing quote...';
		}
		else if ( $model->quote_type_id == QuoteTypes::SUPPLIER_REQUEST_FORM ) {
			// display only SRF relevant fields
			echo 'displaying SRF...';
		}
		else if ( $model->quote_type_id == QuoteTypes::TBD ) {
			echo 'quote type tbd...';
		}



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

		if ( isset($_POST['Customer']) && isset($_POST['Contact']) && isset($_POST['Quote'])   ) {

			$customer_id = $_POST['Customer']['id'];
			$contact_id  = $_POST['Contact']['id'];
			$quote_type  = $_POST['Quote']['quote_type_id'];

			if (!$customer_id ) {
				// create new customer, get id
				$modelCustomers = new Customers;
				$modelCustomers->attributes      = $_POST['Customer'];
				if ( $modelCustomers->save() ) {
					$customer_id = $modelCustomers->id; 
					pDebug("Quotes::actionCreate() - created new customer with the following attributes:", $modelCustomers->attributes );
				}
				else {
					pDebug("Quotes::actionCreate() - ERROR: couldn't create new customer with the following attributes:", $modelCustomers->attributes );
					echo ''; return;
				}
			}

			if (!$contact_id ) {
				// create new contact, get id
				$modelContacts = new Contacts;
				$modelContacts->attributes      = $_POST['Contact'];
				if ( $modelContacts->save() ) {
					$contact_id = $modelContacts->id; 
					pDebug("Quotes::actionCreate() - created new contact with the following attributes:", $modelContacts->attributes );
				}
				else {
					pDebug("Quotes::actionCreate() - ERROR: couldn't create new contact with the following attributes:", $modelContacts->attributes );
					echo ''; return;
				}
			}

			$modelQuotes                  = new Quotes;
			pDebug("Quotes::actionCreate() - empty new modelQuotes:", $modelQuotes->attributes );

			$modelQuotes->attributes      = $_POST['Quote'];
			$modelQuotes->customer_id     = $customer_id;
			$modelQuotes->quote_no        = $this->getQuoteNumber();
			$modelQuotes->status_id       = Status::DRAFT;
			$modelQuotes->owner_id        = Yii::app()->user->id;
			$modelQuotes->created_date    = Date('Y-m-d 00:00:00');
			$modelQuotes->updated_date    = Date('Y-m-d 00:00:00');
			$modelQuotes->expiration_date = $this->getQuoteExpirationDate();
			
			pDebug("Quotes::actionCreate() - saving Quote with the following attributes", $modelQuotes->attributes );
			if ( $modelQuotes->save() ) {
				pDebug("Quotes::actionCreate() - Quote No. " . $modelQuotes->quote_no . " saved.");
				Customers::model()->addContact($customer_id,$contact_id);
				echo $modelQuotes->quote_no;
			}
			else {
				pDebug("actionCreate() - Error on modelQuotes->save(): ", $modelQuotes->errors);
				echo '';
			}
		}
		else {
			$data['customers'] = Customers::model()->findAll( array('order' => 'name') );
			foreach ( $data['customers'] as $c ) {
				$tmp[] = $c->name;
			}
			$data['[parent'] = array_unique($tmp);
			$data['contacts'] = Contacts::model()->findAll( array('order' => 'first_name') );
			$data['salespersons'] = Users::model()->findAll( array('order' => 'first_name') );

			$data['us_states']      = UsStates::model()->findAll( array('order' => 'long_name') );
			$data['countries']   = Countries::model()->findAll( array('order' => 'long_name') );
			$data['regions']     = Regions::model()->findAll( array('order' => 'name') );

			$data['types']       = CustomerTypes::model()->findAll( array('order' => 'name') );
			$data['territories'] = Territories::model()->findAll( array('order' => 'name') );

			$data['quote_types'] = QuoteTypes::model()->findAll( array('order' => 'name') );
			$data['sources']     = Sources::model()->findAll( array('order' => 'name') );
			$data['levels']      = Levels::model()->findAll( array('order' => 'name') );

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


	// -----------------------------------------------------------
    function getQuoteExpirationDate() {
        // quote expiration 30 days from today
        $exp = "+30 days";
        return Date( 'Y-m-d 00:00:00', strtotime($exp) );
    }




    	//-------------------------------------------------------
	public function actionPdf($id) {
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
	    if ( $d['status_id'] == Status::DRAFT || $d['status_id'] == Status::WAITING_APPROVAL ) {
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
    	if ( $d['status_id'] == Status::DRAFT || $d['status_id'] == Status::WAITING_APPROVAL ) {
    		$pdf->addWatermark();
    	}

	    $pdf->Output("MyQuote_" . $d['quote_no'] . ".pdf", "D");
	}




}
