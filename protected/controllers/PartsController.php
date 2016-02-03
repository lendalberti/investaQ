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
			//pDebug("Found item: ", $tmp);

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
				$m = json_decode( file_get_contents('mongo_sample_records_1.inc') );

				you can then access the data by: $m->parts[0]->part_number, $m->total_count, etc.

			*/
		}
		else {
			pDebug("Parts::actionSearch() _GET['item']: not set...");
		}

		
	}

	private function formatDialog($data) {
		$p       = json_decode($data);
		$prices  = $p->parts[0]->prices;
		$sc_Arr  = $p->parts[0]->stock_codes;

		$css = '<style type="text/css">' . file_get_contents('http://localhost/iq2/css/dialog.css') . '</style>';
		$js = '<script type="text/javascript">' . file_get_contents('http://localhost/iq2/js/dialog.js') . '</script>';

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
		$lifeCycle = trim($se_data->Lifecycle) ? "<span id='lifeCycle'>" . trim($se_data->Lifecycle) . "</span>" : "<span class='tbd'>n/a</span>";


		// --------------------------------------------- Links, Misc
		$links  = "<span id='link_QuoteHistory'><a href='#'>Quote History</a></span>";
		$links .= "<span id='link_SalesHistory'><a href='#'>Sales History</a></span>";     
		$links .= "<span id='link_DataSheet'><a " . $href . $target . " >DataSheet</a></span>"; 

		$tStart1 = $links . "<table id='table_Details'>"; 
		$tEnd = "</table>";
		$rows = '';
		$rows .= "<tr> <td>Tech Note:</td><td><span id='tech_note_span' class='tn'>"     . $tech_note      . "</span></td> </tr>";		
		$rows .= "<tr> <td>Lifecycle:</td><td>"     . $lifeCycle      . "</td> </tr>";
		$rows .= "<tr> <td>Manufacturer:</td><td>"  . $p->parts[0]->manufacturer . "</td> </tr>";
		$rows .= "<tr> <td>Supplier:</td><td>"      . $p->parts[0]->supplier     . "</td> </tr>";
		$rows .= "<tr> <td>Drawing:</td><td>"       . $drawing        . "</td> </tr>";				
		$rows .= "<tr> <td>Description:</td><td>"   . $desc           . "</td> </tr>";
		
		$rows .= "<tr> <td>Product Family:</td><td>" . $fam            . "</td> </tr>";
		$rows .= "<tr> <td>Test Level:</td><td>"     . $test_level     . "</td> </tr>";	
		$rows .= "<tr> <td>MPQ:</td><td>"            . $mpq            . "</td> </tr>";
		$rows .= "<tr> <td>Carrier Type:</td><td>"   . $carrier        . "</td> </tr>";

		$tableDetails = $tStart1 . $rows . $tEnd;

		// ------------------------------------------------ Add to Quote
		$caption = "<span style='color: black; font-size: .9em;'>Total Qty Available: </span><span style='font-size: .9em;color: red; font-weight: bold;'>" . number_format($p->parts[0]->total_qty_for_part) . "</span>";

		$tStart2 = "<table id='table_AddToQuote'><caption style='text-align: right;'>$caption</caption>";
		$pricingtHeader = "<tr><th>Volume</th><th>Unit Price</th><th>Quantity</th><th>SubTotal</th></tr>";
		$tEnd = "</table>";

		$min_custom_price =  money_format("$%6.2n", $p->parts[0]->distributor_price * .75);
		
		$pRows  = '';
		$pRows .= "<tr style='font-size: .8em;' ><td>1-24</td>    <td><span id='price_1_24'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p1_24)))          .  "</span></td><td><input type='text' size='7' id='qty_1_24'>    </td><td><span id='subTotal_1_24'>    </span></td></tr>";	
		$pRows .= "<tr style='font-size: .8em;' ><td>25-99</td>   <td><span id='price_25_99'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p25_99)))        .  "</span></td><td><input type='text'        size='7' id='qty_25_99'>   </td><td><span id='subTotal_25_99'>   </span></td></tr>";	
		$pRows .= "<tr style='font-size: .8em;' ><td>100-499</td> <td><span id='price_100_499'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p100_499)))    .  "</span></td><td><input type='text'        size='7' id='qty_100_499'> </td><td><span id='subTotal_100_499'> </span></td></tr>";		
		$pRows .= "<tr style='font-size: .8em;' ><td>500-999</td> <td><span id='price_500_999'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->p500_999)))    .  "</span></td><td><input type='text'        size='7' id='qty_500_999'> </td><td><span id='subTotal_500_999'> </span></td></tr>";	
		$pRows .= "<tr style='font-size: .8em;' ><td>1000+ </td>   <td><span id='price_1000_Plus'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->prices->over_1000)))   .  "</span></td><td><input type='text'        size='7' id='qty_1000_Plus'>   </td><td><span id='subTotal_1000_Plus'>   </span></td></tr>";	
		$pRows .= "<tr style='font-size: .8em;' ><td style='font-weight: bold;'>Distributor</td>   <td><span id='price_Base'>" .  money_format("$%6.2n", trim(floatval($p->parts[0]->distributor_price)))          .  "</span></td><td><input type='text' size='7' id='qty_Base'>     </td><td><span id='subTotal_Base'>     </span></td></tr>";	
		$pRows .= "<tr style='font-size: .8em;' ><td style='font-weight: bold;'>Custom</td>   <td> <input type='text' size='7' id='price_Custom'></td><td><input type='text' size='7' id='qty_Custom'> </td><td><span id='subTotal_Custom'>   </span></td></tr>";	
		$pRows .= "<tr style='font-size: .8em;' ><td colspan='4' style='padding: 10px 0px 10px 0px; background-color: lightyellow; color: #a31128; font-weight: bold;'>NOTE: <span style='padding: 20px 0px 20px 0px;color: #a31128; font-weight: normal;'>Approval is needed if custom price is less than <span id='min_custom_price' style='color: blue;'>$min_custom_price</span> <br /> (75% of Distributor Price) </span></td></tr>";
		$pRows .= "<tr style='font-size: .8em;' ><td colspan='4'><textarea rows='4' cols='45' name='comments' id='comments' placeholder='Add comments...'></textarea></td></tr>";

		$hiddenValues  = '';
		$hiddenValues .= "<input type='hidden' name='manufacturer' id='manufacturer' value='".$p->parts[0]->manufacturer."'  >";
		$hiddenValues .= "<input type='hidden' name='total_qty_for_part' id='total_qty_for_part' value='".$p->parts[0]->total_qty_for_part."'  >";
		// $hiddenValues .= "<input type='hidden' name='xxx' id='xxx' value='".xxx."'  >";
		// $hiddenValues .= "<input type='hidden' name='xxx' id='xxx' value='".xxx."'  >";
		// $hiddenValues .= "<input type='hidden' name='xxx' id='xxx' value='".xxx."'  >";
		// $hiddenValues .= "<input type='hidden' name='xxx' id='xxx' value='".xxx."'  >";
		// $hiddenValues .= "<input type='hidden' name='xxx' id='xxx' value='".xxx."'  >";
		// $hiddenValues .= "<input type='hidden' name='xxx' id='xxx' value='".xxx."'  >";
		
		$pricing_table = $tStart2  .  $pricingtHeader  .  $pRows  .  $tEnd ;

		// --------------------------------------------- Last piece
		$html = $js . $css . $tHeader . $tableStockCodes .  $spacingDiv . $tableDetails . $hiddenValues . $pricing_table; 
		//pDebug('formatDialog() - html:', $html);
		return $html;
	}

}


























