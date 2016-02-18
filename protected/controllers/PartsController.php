<?php

class PartsController extends Controller {

	public function accessRules() 	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'search' actions
				'actions'=>array('index','search', 'lookup', 'showDetails'),
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



	public function actionLookup($id) 	{
		pDebug("Parts::actionLookup() _GET", $_GET);

		$item_id = $id;
		// TODO: check for build or stock

		$model = StockItems::model()->findByPk($item_id);
		echo json_encode($model->attributes);

	}




	public function actionShowDetails( $id ) 	{
		$model    = StockItems::model()->findByPk($id);

		if ( !$model ) {
			return false;
		}


		$part_no  = $model->part_no;
		

		$item = urlencode($part_no);
		$url  = 'http://mongoa/parts/*/500/?q='.$item;	  // mongoa for my local use
		$tmp  = file_get_contents($url);

		//pDebug('actionShowDetails() - mongo record=', $tmp);
		echo  $this->formatItemDetails( $tmp, $model );
	}





	private function formatItemDetails( $data, $model ) {
		$p       = json_decode($data);
		$se_data = $p->parts[0]->se_data; 
		$sc_Arr  = $p->parts[0]->stock_codes;

		$com     = $model->comments;
		$item_id = $model->id;

		//pDebug( "formatItemDetails() item: " , $p);

		$href   = $se_data->Datasheet ? $se_data->Datasheet : '#';

		$tech_note            = 'n/a';
		$lifeCycle            = trim($se_data->Lifecycle) ? trim($se_data->Lifecycle) : "n/a";
		$mfg                  = $p->parts[0]->manufacturer;
		$supplier             = $p->parts[0]->supplier ;
		$drawing              = $p->parts[0]->drawing            ? $p->parts[0]->drawing              : "<span class='tbd'>n/a</span>";
		$desc                 = $se_data->Description; 
		$fam                  = $se_data->Family;
		$test_level           = $se_data->test_level   		   ? $se_data->test_level   			: "<span class='tbd'>n/a</span>";
		$mpq                  = $p->parts[0]->mpq                ? $p->parts[0]->mpq                  : "<span class='tbd'>n/a</span>";
		$carrier              = $p->parts[0]->carrier_type       ? $p->parts[0]->carrier_type         : "<span class='tbd'>n/a</span>";
		$part_status          = $p->parts[0]->build == 1 ? 'Build to Order' : 'Stock';
		$life_class           = $lifeCycle;

		$container_start = "<div class='container_11'>";
		$container_end = "</div>";

			$left_box = "<div class='grid_6'>";
				$t  = "<table><tr> <td>Tech Note:</td><td><span id='tech_note_span' class='tn'>"   . $tech_note      . "</span></td> </tr>";
				$t .= "<tr> <td>Lifecycle:</td><td><span id='lifeCycle' class='$life_class'>"  . $lifeCycle    . "</span></td> </tr>";
				$t .= "<tr> <td>Manufacturer:</td><td>"                     . $mfg          . "</td> </tr>";
				$t .= "<tr> <td>Supplier:</td><td>"                         . $supplier     . "</td> </tr>";
				$t .= "<tr> <td>Drawing:</td><td>"                          . $drawing      . "</td> </tr>";				
				$t .= "<tr> <td>Description:</td><td>"                      . $desc         . "</td> </tr>";
				$t .= "<tr> <td>Product Family:</td><td>"                   . $fam          . "</td> </tr>";
				$t .= "<tr> <td>Test Level:</td><td>"                       . $test_level   . "</td> </tr>";	
				$t .= "<tr> <td>MPQ:</td><td>"                              . $mpq          . "</td> </tr>";
				$t .= "<tr> <td>Carrier Type:</td><td>"                     . $carrier      . "</td> </tr>";
				$t .= "<tr> <td>Item Status:</td><td>"                      . $part_status  . "</td> </tr>";
				$t .= "<tr> <td colspan='2'>";
				$t .= "<span id='link_QuoteHistory'><a href='#'>Quote History</a></span>"; 
				$t .= "<span id='link_SalesHistory'><a href='#'>Sales History</a></span>"; 
				//$t .= "<span id='link_DataSheet'><a " . $href . $target . " >DataSheet</a></span>"; 

				$t .= "<span id='link_DataSheet'><a href='$href' target='_blank' >DataSheet</a></span>"; 
				
				$t .= "</td></tr>";
				$t .= "</table></div>";
			$left_box .= $t ; 

			$right_box = "<div class='grid_5'>";
				$t = "<table><tr><th>Stock Code</th><th>Warehouse</th><th>Date Code</th><th>Tech Notes</th><th>Qty Available</th> </tr>";

				foreach( $sc_Arr as $i => $v ) {
					foreach( $v->warehouses as $ii => $WH) {
						$display = ( $ii == 0 ? '' : "style='color: lightgray;'" );
						$t .= "<tr><td class='stock_code_selected' $display >" . $v->stock_code . "</td>";

						$t .= '<td class="warehouse_selected">'.$WH->warehouse.'</td>';
						$t .= '<td class="date_code_selected">'.$WH->date_code.'</td>';

						if ( $WH->notes == 'T' ) {
							$note = '<span class="view_tech_notes">view</span>';
							$techNotes = $v->tech_notes;
							$hiddenTechNotes .= "<input type='hidden' value='[StockCode=".$v->stock_code."]<br />".$techNotes."' id='tech_note_".$v->stock_code."' />";
						}
						else {
							$note = 'n/a';
						}
						$t .= '<td class="notes_selected">'.$note.'</td>';
						$t .= '<td class="qty_available_selected">'. $WH->qty_available .'</td></tr>';
					}
				}

				$t .= "</table></div>";

			$right_box .= $t; 

			$pricing  = "<div class='grid_5'>";
			$pricing .= "<table>";
			$pricing .= "<tr>   <th>1-24</th>  <th>25-99</th>  <th>100-499</th>  <th>500-999</th>  <th>1000+</th>  <th>Distributor</th>   </tr>";
			$pricing .= "<tr>   <td>". money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p1_24)));  
			$pricing .= "</td>  <td>". money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p25_99)));  
			$pricing .= "</td>  <td>". money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p100_499)));  
			$pricing .= "</td>  <td>". money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p500_999)));  
			$pricing .= "</td>  <td>". money_format("$%6.2n", trim(floatval($p->parts[0]->prices->over_1000)));  
			$pricing .= "</td>  <td>". money_format("$%6.2n", trim(floatval($p->parts[0]->distributor_price)));  
			$pricing .= "</td>  </tr>";
			$pricing .= "</table></div>";

			$comments  = "<div class='clear'></div><div class='grid_10'>";  //<textarea rows='10' cols='49' name='comments' id='comments'>$com</textarea></div>";
			$comments .= "<table><tr> <td><textarea readonly='readonly' rows='10' cols='105'  name='previous_comments' id='previous_comments' >$com</textarea></td></tr>";
			$comments .= "</table></div>";

		echo $container_start . $left_box . $pricing . $right_box .  $comments . $approve . $container_end;

	}






	public function actionSearch() 	{
		pDebug("Parts::actionSearch() _GET", $_GET);

		if ( isset($_GET['item']) ) {
			$item       = urlencode($_GET['item']);
			$url        = 'http://mongoa/parts/*/500/?q='.$item;	  // mongoa for my local use
			$tmp        = file_get_contents($url);

			//pDebug('actionSearch() - mongo record=', $tmp);
			// $tmp = file_get_contents('/Users/len/www/iq2/Docs/mongo_sample_records_3333.inc');
			

			/*
				In the event that http://mongoa is not available, use the files in Docs as a temp solution for testing purposes;

						[iMac@Home] /Users/len/www/iq2/protected/data (master) 
						>> dir mongo/
						total 408
						  0 drwxr-xr-x   6 len  _www     204 Feb 16 15:30 .
						  0 drwxrwxr-x  12 len  _www     408 Feb 16 15:30 ..
						 16 -rwxrwxr-x   1 len  _www    5867 Feb 12 20:19 AD5555CRUZ_mongo.inc
						 16 -rwxrwxr-x   1 len  _www    5761 Jan 27 07:09 mongo_sample_records_1.inc
						288 -rwxrwxr-x   1 len  _www  147336 Jan 26 12:33 mongo_sample_records_3333.inc
						 88 -rwxrwxr-x   1 len  _www   41533 Feb 12 20:19 mongo_sample_records_5555.inc


				php -a
				$m = json_decode( file_get_contents('mongo_sample_records_1.inc') );

				you can then access the data by: $m->parts[0]->part_number, $m->total_count, etc.

			*/

			echo ( isset($_GET['dialog']) ?  $this->formatDialog($tmp) : $tmp );
		}
		else {
			pDebug("Parts::actionSearch() _GET['item']: not set...");
		}

		
	}

	private function formatDialog($data) {
		$p       = json_decode($data);
		$prices  = $p->parts[0]->prices;
		$sc_Arr  = $p->parts[0]->stock_codes;

		if ( $p->parts[0]->build == 1 ) {
			$part_status = 'Build to Order';
			$_itemIsBuildToOrder = true;
		}
		else {
			$part_status = 'Stock';
			$_itemIsBuildToOrder = false;
		}


		$part_status = $p->parts[0]->build == 1 ? 'Build to Order' : 'Stock';

		$css = '<style type="text/css">' . file_get_contents('http://localhost/iq2/css/dialog.css') . '</style>';
		// $js  = '<script type="text/javascript">' . file_get_contents('http://localhost/iq2/js/dialog.js') . '</script>';


		//$css = '<style type="text/css">' . file_get_contents('http://localhost/iq2/css/iq2_main.css') . '</style>';
		$js  = '<script type="text/javascript">' . file_get_contents('http://localhost/iq2/js/iq2_main.js') . '</script>';

		$se_data = $p->parts[0]->se_data; 

		$hiddenTechNotes = '';
		$spacingDiv      = "<div style='height: 20px; border: 0px solid lightblue;'></div>";
		$techNotes       = 'n/a';

		$tHeader  = "<div id='containerDiv'>";
		$tHeader .= "<div id='leftDiv'><span>Part Number: </span><span id='part_no' name='part_no'>" .          $p->parts[0]->part_number . "</span><br /></div>";
		$tHeader .= "</div>";

		$fixedHeading = "<table id='table_fixedHeading'><tr>";
		$fixedHeading .= "<th>Stock Code</th> ";
		$fixedHeading .= "<th>Warehouse</th>"; 
		$fixedHeading .= "<th>Date Code</th>";
		$fixedHeading .= "<th>&#10004;</th>";
		$fixedHeading .= "<th>Tech Notes</th>";
		$fixedHeading .= "<th>Qty Available</th>";  
		$fixedHeading .= "</tr></table>";		
		$tStart0 = $fixedHeading . "<div id='div_StockCodes'><table id='table_StockCodes'>"; 
		$tEnd = "</table></div>";
		$rows = '';

		foreach( $sc_Arr as $i => $v ) {
			foreach( $v->warehouses as $ii => $WH) {
				$display = ( $ii == 0 ? '' : 'style="color: lightgray;"' );
				$rows .= '<tr><td class="stock_code_selected" '. $display .'>'. $v->stock_code.'</td>';
				$rows .= '<td class="warehouse_selected">'.$WH->warehouse.'</td>';
				$rows .= '<td class="date_code_selected">'.$WH->date_code.'</td>';
				$rows .= '<td class="row_selected"></td>';
				
				if ( $WH->notes == 'T' ) {
					$note = '<span class="view_tech_notes">view</span>';
					$techNotes = $v->tech_notes;
					$hiddenTechNotes .= "<input type='hidden' value='[StockCode=".$v->stock_code."]<br />".$techNotes."' id='tech_note_".$v->stock_code."' />";
				}
				else {
					$note = 'n/a';
				}
				$rows .= '<td class="notes_selected">'.$note.'</td>';
				$rows .= '<td class="qty_available_selected">'. $WH->qty_available .'</td></tr>';
			}
		};
		$tableStockCodes = $tStart0 . $rows . $tEnd . $hiddenTechNotes;
		
		$drawing    = $p->parts[0]->drawing            ? $p->parts[0]->drawing              : "<span class='tbd'>n/a</span>";
		$tech_note  = 'n/a';
		$test_level = $se_data->test_level   ? $se_data->test_level   : "<span class='tbd'>n/a</span>";
		$mpq        = $p->parts[0]->mpq                ? $p->parts[0]->mpq                  : "<span class='tbd'>n/a</span>";
		$carrier    = $p->parts[0]->carrier_type       ? $p->parts[0]->carrier_type         : "<span class='tbd'>n/a</span>";


		// --------------------------------------------- Details table 
		$pack   = ( $se_data->StandardPackageName ?  $se_data->StandardPackageName->Value : "" );
		$pins   = ( $se_data->PinCount            ?  $se_data->PinCount->Value            : "" );
		$desc   = $se_data->Description; 
		$fam    = $se_data->Family;
		$rohs   = $se_data->RoHS;
		$href   = " href='" . $se_data->Datasheet . "'";
		$target = " target='_blank'";
		//$lifeCycle = "<span id='lifeCycle'>" . (trim($se_data->Lifecycle) ? trim($se_data->Lifecycle) : "n/a" ) . '</span>';

		$lifeCycle = trim($se_data->Lifecycle) ? trim($se_data->Lifecycle) : "n/a";


		// --------------------------------------------- Links, Misc
		$links  = "<span id='link_QuoteHistory'><a href='#'>Quote History</a></span>";
		$links .= "<span id='link_SalesHistory'><a href='#'>Sales History</a></span>";     
		$links .= "<span id='link_DataSheet'><a " . $href . $target . " >DataSheet</a></span>"; 

		$tStart1 = $links . "<table id='table_Details'>"; 
		$tEnd = "</table>";
		$rows = '';
		$rows .= "<tr> <td>Tech Note:</td><td><span id='tech_note_span' class='tn'>"     . $tech_note      . "</span></td> </tr>";		
		
		$rows .= "<tr> <td>Lifecycle:</td><td><span id='lifeCycle' >" . $lifeCycle  . "</span></td> </tr>";

		$rows .= "<tr> <td>Manufacturer:</td><td>"  . $p->parts[0]->manufacturer . "</td> </tr>";
		$rows .= "<tr> <td>Supplier:</td><td>"      . $p->parts[0]->supplier     . "</td> </tr>";
		$rows .= "<tr> <td>Drawing:</td><td>"       . $drawing        . "</td> </tr>";				
		$rows .= "<tr> <td>Description:</td><td>"   . $desc           . "</td> </tr>";
		
		$rows .= "<tr> <td>Product Family:</td><td>" . $fam            . "</td> </tr>";
		$rows .= "<tr> <td>Test Level:</td><td>"     . $test_level     . "</td> </tr>";	
		$rows .= "<tr> <td>MPQ:</td><td>"            . $mpq            . "</td> </tr>";
		$rows .= "<tr> <td>Carrier Type:</td><td>"   . $carrier        . "</td> </tr>";
		$rows .= "<tr> <td>Item Status:</td><td>"    . $part_status    . "</td> </tr>";

		$tableDetails = $tStart1 . $rows . $tEnd;

		if ( $_itemIsBuildToOrder ) {
			pDebug('formatDialog() - item is Build to Order: ', $data);
			$pricing_table = '';
		}
		else {
			// ------------------------------------------------ Add to Quote
			$caption = "<span style='color: black; font-size: .9em;'>Total Qty Available: </span><span style='font-size: .9em;color: red; font-weight: bold;'>" . number_format($p->parts[0]->total_qty_for_part) . "</span>";

			$tStart2 = "<table id='table_AddToQuote'><caption style='text-align: right;'>$caption</caption>";
			$pricingtHeader = "<tr><th>Volume</th><th>Unit Price</th><th>Quantity</th><th>SubTotal</th></tr>";
			$tEnd = "</table>";

			// $dpf = Yii::app()->params['DISTRIBUTOR_PRICE_FLOOR'];   // .75
			// $min_custom_price =  money_format("$%6.2n", $p->parts[0]->distributor_price * $dpf );  
			
			$pRows  = '';
			$pRows .= "<tr style='font-size: .8em;' ><td>1-24</td>    <td><span id='price_1_24'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p1_24)))          .  "</span></td><td><input type='text' size='7' id='qty_1_24'>    </td><td><span id='subTotal_1_24'>    </span></td></tr>";	
			$pRows .= "<tr style='font-size: .8em;' ><td>25-99</td>   <td><span id='price_25_99'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p25_99)))        .  "</span></td><td><input type='text'        size='7' id='qty_25_99'>   </td><td><span id='subTotal_25_99'>   </span></td></tr>";	
			$pRows .= "<tr style='font-size: .8em;' ><td>100-499</td> <td><span id='price_100_499'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p100_499)))    .  "</span></td><td><input type='text'        size='7' id='qty_100_499'> </td><td><span id='subTotal_100_499'> </span></td></tr>";		
			$pRows .= "<tr style='font-size: .8em;' ><td>500-999</td> <td><span id='price_500_999'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p500_999)))    .  "</span></td><td><input type='text'        size='7' id='qty_500_999'> </td><td><span id='subTotal_500_999'> </span></td></tr>";	
			$pRows .= "<tr style='font-size: .8em;' ><td>1000+ </td>   <td><span id='price_1000_Plus'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->over_1000)))   .  "</span></td><td><input type='text'        size='7' id='qty_1000_Plus'>   </td><td><span id='subTotal_1000_Plus'>   </span></td></tr>";	
			$pRows .= "<tr style='font-size: .8em;' ><td style='font-weight: bold;'>Distributor</td>   <td><span id='price_Base'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->distributor_price)))          .  "</span></td><td><input type='text' size='7' id='qty_Base'>     </td><td><span id='subTotal_Base'>     </span></td></tr>";	
			$pRows .= "<tr style='font-size: .8em;' ><td style='font-weight: bold;'>Custom</td>   <td> <input type='text' size='7' id='price_Custom'></td><td><input type='text' size='7' id='qty_Custom'> </td><td><span id='subTotal_Custom'>   </span></td></tr>";	
			
			$pRows .= "<tr style='font-size: .8em;' id='special_note' ><td colspan='4' style='padding: 10px 0px 10px 0px; background-color: lightyellow; color: #a31128; font-weight: bold;'>NOTE: <span style='padding: 20px 0px 20px 0px;color: #a31128; font-weight: normal;'>Approval is needed if custom price is less than <span style='color: blue;' id='dialog_min_custom_price' >0</span> <br />" . "<span id='dialog_min_custom_price_comment'>comment</span> </span></td></tr>";

			$pRows .= "<tr style='font-size: .8em;' ><td colspan='4'><textarea rows='4' cols='45' name='comments' id='comments' placeholder='Add comments...'></textarea></td></tr>";

			$pricing_table = $tStart2  .  $pricingtHeader  .  $pRows  .  $tEnd ;
		}

		$hiddenValues  = '';
		$hiddenValues .= "<input type='hidden' name='distributor_price' id='distributor_price' value='". $p->parts[0]->distributor_price  . "'  >";
		// $hiddenValues .= "<input type='hidden' name='lifeCycle'         id='lifeCycle'         value='". $lifeCycle                       . "'  >";  

		$hiddenValues .= "<input type='hidden' name='manufacturer' id='manufacturer' value='".$p->parts[0]->manufacturer."'  >";
		$hiddenValues .= "<input type='hidden' name='total_qty_for_part' id='total_qty_for_part' value='".$p->parts[0]->total_qty_for_part."'  >";
		$hiddenValues .= "<input type='hidden' name='distributor_price_floor' id='distributor_price_floor' value='".Yii::app()->params['DISTRIBUTOR_PRICE_FLOOR']."' >";
		
		

		// --------------------------------------------- Last piece
		$html = $js . $css . $tHeader . $tableStockCodes .  $spacingDiv . $tableDetails . $hiddenValues . $pricing_table; 
		//$html = $css . $tHeader . $tableStockCodes .  $spacingDiv . $tableDetails . $hiddenValues . $pricing_table; 
		//pDebug('formatDialog() - html:', $html);
		return $html;
	}

}


























