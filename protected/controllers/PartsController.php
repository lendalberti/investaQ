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
			// pDebug('PartsController::actionSearch() - mongo data: ', $tmp);
			echo ( isset($_GET['dialog']) ?  formatDialog($tmp) : $tmp );
		}
	}

	private function formatDialog( $m ) {
		$html = 'this is a test...';

		pDebug('PartsController::formatDialog() - mongo data=', $m);





		return $html;
	}




}