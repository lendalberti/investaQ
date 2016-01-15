<div>
	<span style="padding-top: 10px;display:inline-block; vertical-align:top" class='pageTitle'><?php echo $page_title;  ?></span>
	<a id='add_quote' href='#'><img src='../../../images/add1.png' width='48' height='48' title='Start a New Quote'></a>
</div>


<div style='width:906px; margin-top: 80px;'>
	<table id='quotes_table'>
            

				<thead>
					<tr>
						<th>Quote No.</th>
						<th>Status</th>
						<th>Sales Person</th>
						<th>Type</th>

						<th>Customer Name</th>
						<th>Location</th>
						<th>Additional Notes</th>

						<th>Terms &amp; Conditions</th>

						<th>Created on</th>
						<th>Last Updated on</th>
						<th>Customer acknowledgement</th>

						<th>RISL</th>
						<th>Manufacturing lead Time</th>
						<th>Expires on</th>

						<th>Lost Reason</th>
						<th>No Bid Reason</th>
						
					</tr>
				</thead>
				
				<tbody>	

				<?php
					foreach( $model as $m ) {
						echo '<tr>';
						echo '<td>' . $m->quote_no . '</td>'; 
						echo '<td>' . $m->status->name . '</td>'; 
						echo '<td>' . $m->user->fullname . '</td>'; 
						echo '<td>' . $m->type . '</td>'; 

						echo '<td>' . $m->customer->name . '</td>'; 
						echo '<td>' . $m->customer->address1.', '. $m->customer->city . ', '. $m->customer->country->short_name .'</td>'; 
						echo '<td>' .  $m->additional_notes . '</td>'; 

						echo '<td>' .  $m->terms_conditions . '</td>'; 

						echo '<td>' . Date("M. d, 'y", strtotime($m->created) ) . '</td>'; 
						echo '<td>' . Date("M. d, 'y", strtotime($m->updated) ) . '</td>'; 
						echo '<td>' .  $m->customer_acknowledgment . '</td>'; 

						echo '<td>' .  $m->risl . '</td>'; 
						echo '<td>' .  $m->manufacturing_lead_time . '</td>'; 
						echo '<td>' .  Date("M. d, 'y", strtotime($m->expiration_date) ) . '</td>'; 
						
						echo '<td>' .  $m->lost_reason_id . '</td>'; 
						echo '<td>' .  $m->no_bid_reason_id . '</td>'; 
						
						
						echo '</tr>';
					}
				?>
		
				</tbody>


	</table>
</div>