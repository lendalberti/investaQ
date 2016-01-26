<?php

class PartsController extends Controller {


	public function accessRules() 	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'search' actions
				'actions'=>array('index','search'),
				'expression' => '$user->isLoggedIn'
			),
		
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionIndex() 	{
		$this->render('index');
	}


	public function actionSearch() 	{
		pDebug("Parts::actionSearch() _GET", $_GET);
		pDebug("Parts::actionSearch() _POST", $_POST);

		$parts = Array();
		// $parts[Parts::PART_NUMBER]  = 'Part Number';
		// $parts[Parts::MANUFACTURER] = 'Manufacturer';

		$item         = '';
		$data         = array();
		$part_details = array();

		if ( isset($_GET['item']) || isset($_GET['by']) ) {
			$item       = urlencode($_GET['item']);
			$by         = $_GET['by'];
			$search_by  = $parts[$by];
			$url        = 'http://mongoa/parts/*/500/?q='.$item;	  // mongoa for my local use

			$tmp        = file_get_contents($url);
			pDebug('PartsController::actionSearch() - mongo data: ', $tmp);

			echo $tmp;

			// $mongo_data = json_decode($tmp);  // from json to array
			// pDebug("Parts::actionSearch() - search results for item:[$item] (from mongo): ", $mongo_data);
			// echo json_encode($mongo_data->parts);


		}

	}






}