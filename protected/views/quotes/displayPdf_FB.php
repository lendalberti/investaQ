
	<!-- displayPdf_FB -->
<?php

	$data_dir[] = Yii::app()->params['current_invoices'];
	$data_dir[] = Yii::app()->params['older_invoices'];

	foreach( $data_dir as $dd ) {
		$filename = "$dd/$invoice.pdf";
		if ( file_exists( $filename ) ) {
			header('Content-type: application/pdf');
			header("Content-Disposition: inline; filename=\"{$invoice}\"");
			readfile($filename);
			exit;
		}
	}

	echo "<h3>Invoice #$invoice is not available</h3><br />Only Invoices scanned during the current year are accessible from within this application";

?>