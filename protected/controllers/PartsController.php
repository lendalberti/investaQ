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

		if ( isset($_GET['item']) ) {
			$item       = urlencode($_GET['item']);
			$url        = 'http://mongoa/parts/*/500/?q='.$item;	  // mongoa for my local use

			$tmp        = file_get_contents($url);
			echo ( isset($_GET['dialog']) ?  $this->formatDialog($tmp) : $tmp );



			/*

				In the event that http://mongoa is not available, use the files in Docs as a temp solution for testing purposes;

						[iMac@Home] /Users/len/www/iq2/Docs (master) 
						>> dir
						total 320
						  0 drwxrwxr-x   5 len  _www     170 Jan 27 05:01 .
						  0 drwxr-xr-x  16 len  _www     544 Jan 26 18:20 ..
						 16 -rwxr-xr-x   1 len  _www    6334 Jan 26 18:20 TODO
						 16 -rw-r--r--   1 len  _www    5761 Jan 27 05:01 mongo_sample_records_1.inc
						288 -rw-r--r--   1 len  _www  147345 Jan 26 21:17 mongo_sample_records_3333.inc

				php -a
				$m = jason_decode( file_get_contents('mongo_sample_records_1.inc') );

				you can then access the data by: $m->parts[0]->part_number, $m->total_count, etc.

			*/


		}
	}



	private function formatDialog( $data) {
		$html = "this is a test... Part Details:<br />";

		$m = json_decode($data);

		$html .= $m->parts[0]->part_number . ", ";
		$html .= $m->parts[0]->manufacturer . ", ";
		$html .= $m->parts[0]->mpq . ", ";
		$html .= $m->parts[0]->drawing . ", ";
		$html .= $m->parts[0]->se_data->Lifecycle;
		


		pDebug('PartsController::formatDialog() - formatted mongo data=', $html );
		return $html;

	}




}



























