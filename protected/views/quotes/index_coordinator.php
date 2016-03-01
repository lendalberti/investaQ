<?php $this->layout = '//layouts/column1'; ?>
<div>
	<span style="display:inline-block; vertical-align:top" class='pageTitle'><?php echo $page_title;  ?></span>
	<br />

	<?php 
		if ( $quote_type != QuoteTypes::MANUFACTURING ) { ?>
			<span id='add_quote' href='#'><img src='<?php echo Yii::app()->baseUrl; ?>/images/New/new_quote_button.png' title='Add a New Quote'></span>
	<?php } ?>

</div>


<div>
	<table id='quotes_table'>
				<thead>
					<tr>
						<th></th>
						<th>Quote No.</th>
						<th>Type</th>
						<th>Status</th>
						<th>Level</th>

						<th>No. of Items</th>

						<th>Sales Person</th>
						<th>Customer </th>
						<!-- <th>Location</th> -->
						<th>Contact </th>
					</tr>
				</thead>

				<tbody>	

				<?php 
					foreach( $model as $m ) { //         id  quote_no quote_type status level  owner_name  customer_name  contact_name
						echo '<tr>';
						echo '<td>';
						echo '<span title="View this quote" id="quote_view_'.     $m['id']  .'" ><img src="' .Yii::app()->baseUrl. '/images/view_glyph.png"   height="24" width="24"></span>';
						echo '</td>'; 
						echo '<td>' . $m['quote_no']    . '</td>'; 
						echo '<td>' . $m['quote_type']  . '</td>'; 
						//
						// TODO: consider using color-coded status (ala Annalyse) see iq2_main.css for '.status_xxxxxxx'
						//						echo '<td><span class="status_inprocess" >' . $m->status->name . '</span></td>'; 
						//
						echo '<td>' . $m['status'] . '</td>'; 
						echo '<td>' . $m['level']  . '</td>'; 
						echo '<td>' . getQuotePartNumbers($m['id']) . '</td>';   
						echo '<td>' . $m['owner_name']    . '</td>'; 
						echo '<td>' . $m['customer_name'] . '</td>'; 
						echo '<td>' . $m['contact_name']  . '</td>'; 
						echo '</tr>';
					}
				?>
		
				</tbody> <!--   status_id   quoteType  level   owner customer_id   contact             -->

				

	</table>
</div>

<div class='print' id="form_ViewQuoteDetails" style='display: none'> quote details content goes here </div>
<div class='print' id="form_PartPricing" style='display: none'> pricing details content goes here </div>

