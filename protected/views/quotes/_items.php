<?php

		function fp($n) {
			setlocale(LC_MONETARY, 'en_US');
			$res = money_format("%6.2n", trim($n) );
			return $res;
		}

		function fq($n) {
			return $n=='' ? '0' : $n;
		}

		function calc($model, $key) {
			$res = $model['qty_'.$key] * $model['price_'.$key];
			return $res; //=='0' ? '--' : $res;
		}

		function subTotal($model) {
			$total = 0;
			foreach( ['1_24','25_99','100_499','500_999','1000_Plus'] as $key ) {
				$total += calc($model,$key);
			}
			return $total;
		}

		$customer_id = $model->customer_id;

		$edit   = Yii::app()->request->baseUrl . "/images/edit_glyph_33x30.png"; 
 		$delete = Yii::app()->request->baseUrl . "/images/delete_glyph.png";
 		$pdf    = Yii::app()->request->baseUrl . "/images/pdf_32x32.png";

		$sql = "SELECT * FROM stock_items WHERE  quote_id = $model->id";
		$command = Yii::app()->db->createCommand($sql);
		$results = $command->queryAll();

		foreach( $results as $key => $i ) { 
 			echo "<table style='' class='items_table'>";
 			echo "<tr><thead><th></th><th>Last Updated</th><th>Part No.</th><th>Mfr</th></th><th>Date Code</th>";
 			echo "<th style='padding-right: 30px; text-align: right;'>Qty</th>";
 			echo "<th style='padding-right: 30px; text-align: right;'>Price</th>";
 			echo "<th style='padding-right: 30px; text-align: right;'>Total</th></thead></tr>";

 			echo "<tr><td><img id='item_edit_".$i['id']."' title='Edit this item' src='$edit' /><img  id='item_delete_".$i['id']."' title='Delete this item' src='$delete' /></td>";
 			echo "<td>".$i['last_updated']."</td>";
 			echo "<td>".$i['part_no']."</td>";
 			echo "<td>".$i['manufacturer']."</td>";
 			echo "<td>".$i['date_code']."</td>";
 			echo "<td colspan='3'><table id='table_quote_pricing' >";


 			if ( fq($i['qty_1_24']) != '0' ) {
	 			echo "<tr>  <td style='text-align: right;'> ".fq($i['qty_1_24'])."</td>        <td style='text-align: right;'><span>1-24</span>"      .fp($i['price_1_24'])."</td>      <td style='text-align: right;'> ".fp(calc($i,'1_24'))."</td>   </tr>"; 
	 		}

	 		if ( fq($i['qty_25_99']) != '0' ) {
	 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_25_99'])."</td>        <td style='text-align: right;'><span>25-99</span>"     .fp($i['price_25_99'])."</td>     <td style='text-align: right;'> ".fp(calc($i,'25_99'))."</td>   </tr>"; 
	 		}

	 		if ( fq($i['qty_100_499']) != '0' ) {
	 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_100_499'])."</td>      <td style='text-align: right;'><span>100-499</span>"   .fp($i['price_100_499'])."</td>   <td style='text-align: right;'> ".fp(calc($i,'100_499'))."</td>   </tr>"; 
	 		}

	 		if ( fq($i['qty_500_999']) != '0' ) {
	 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_500_999'])."</td>      <td style='text-align: right;'><span>500-999</span>"   .fp($i['price_500_999'])."</td>   <td style='text-align: right;'> ".fp(calc($i,'500_999'))."</td>   </tr>"; 
	 		}

	 		if ( fq($i['qty_1000_Plus']) != '0' ) {
	 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_1000_Plus'])."</td>    <td style='text-align: right;'><span>1000+</span>"     .fp($i['price_1000_Plus'])."</td> <td style='text-align: right;'> ".fp(calc($i,'1000_Plus'))."</td>   </tr>"; 
	 		}

			if ( fq($i['qty_Base']) != '0' ) {
	 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_Base'])."</td>    <td style='text-align: right;'><span>Base</span>"     .fp($i['price_Base'])."</td> <td style='text-align: right;'> ".fp(calc($i,'Base'))."</td>   </tr>"; 
	 		}

			if ( fq($i['qty_Custom']) != '0' ) {
	 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_Custom'])."</td>    <td style='text-align: right;'><span>Custom</span>"     .fp($i['price_Custom'])."</td> <td style='text-align: right;'> ".fp(calc($i,'Custom'))."</td>   </tr>"; 
	 		}
			
			echo "</td></table></table>";
	 	}

























?>
