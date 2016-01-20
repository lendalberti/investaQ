<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css?version=<?php echo time(); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/iq2_main.css" />  <!-- my local changes  -->

	<!-- Add jQuery-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script> 
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script> 
	<link rel="stylesheet" href="http://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" />

	<script type="text/javascript" charset="utf8" src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />


	<script type="text/javascript" charset="utf8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/iq2_main.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />


	

	<title><?php echo Yii::app()->params['app_title']; ?></title>

</head>

<body>

<div class="no-print container" id="page">

	<div id="header">
		<div id="logo">
			<?php echo CHtml::image(Yii::app()->request->baseUrl . "/images/rei_logo.png"); ?>
			<span id='iq2_title'><?php echo Yii::app()->params['app_title']; ?></span>
	</div>


	</div><!-- header -->



	<div id="mainmenu">
		<?php
			$user_type = '';
			date_default_timezone_set('America/New_York');
			if ( Yii::app()->user->isAdmin ) {
				$user_type = ' (Admin)';
			}

			if ( Yii::app()->user->isLoggedIn ) {
				$menuItems = array();
				$menuItems[] = array('label'=>'Home', 'url'=>array('/site/index') );

				$menuItems[] = array('label'=>'My Quotes', 'url'=>array('/quotes/index') ); 
				$menuItems[] = array('label'=>'Movements ', 'url'=>array('/PriceBook/movements') );
				$menuItems[] = array('label'=>'Customers ', 'url'=>array('/Customers') );
				$menuItems[] = array('label'=>'Contacts ', 'url'=>array('/Contacts') );
				$menuItems[] = array('label'=>'My Profile', 'url'=>array('/quotes/index/stock') ); 
				$menuItems[] = array('label'=>'Help',        'url'=>array('/site/help') );

				
				// if ( Yii::app()->user->isAdmin || Yii::app()->user->isApprover ) { 
				// 	$menuItems[] = array('label'=>'Approval Queue', 'url'=>array('/quotes/approve') );
				// }
				
				// $menuItems[] = array('label'=>'Quotes', 'url'=>array('/quotes/index') );

				// if ( Yii::app()->user->isAdmin || Yii::app()->user->isAdmin ) { 
				// 	$menuItems[] = array('label'=>'Users', 'url'=>array('/Users/admin') );
				// }

				// $menuItems[] = array('label'=>'My Profile', 'url'=>array('/Users/profile/'.Yii::app()->user->id) );
				// $menuItems[] = array('label'=>'Movements ', 'url'=>array('/PriceBook/movements') );
				// $menuItems[] = array('label'=>'Customers ', 'url'=>array('/Customers') );
				// $menuItems[] = array('label'=>'Contacts ', 'url'=>array('/Contacts') );
				// $menuItems[] = array('label'=>'Help',        'url'=>array('/site/help') );

				$menuItems[] = array('label'=>'Logout ', 'url'=>array('/site/logout') );
				$menuItems[] = array('label' => Yii::app()->user->fullname . $user_type );
			}
			else {
				$menuItems[] = array('label'=>'Login', 'url'=>array('/site/login') );
				//$menuItems[] = array('label'=>'Help',        'url'=>array('/site/help') );
				$menuItems[] = array('label' => 'Guest - not logged in.' );
			}

			// create top mainmenu bar
			$this->widget( 'zii.widgets.CMenu', array( 'items' => $menuItems ) );

		?>  


	</div>  <!--  mainmenu -->

	
	<?php echo $content; ?>

	<div class="clear"></div>

	<div class='no-print' id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Rochester Electronics, LLC.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
