<div>
	<span style="padding-top: 10px;display:inline-block; vertical-align:top" class='pageTitle'><?php echo $page_title;  ?></span>
	<a id='add_quote' href='#'><img src='../../../images/add1.png' width='48' height='48' title='Start a New Quote'></a>
</div>


<div style='width:906px; margin-top: 80px;'>
	<table id='quotes_table'>
            

				<thead>
					<tr>
						<th>Quote No.</th>
						<th>Type</th>
						<th>Status</th>

						<th>Part No.</th>

						<th>Sales Person</th>
						<th>Customer Name</th>
						<th>Location</th>
					</tr>
				</thead>
				
				<tbody>	

				<?php
					foreach( $model as $m ) {
						echo '<tr>';
						echo '<td>' . $m->quote_no . '</td>'; 
						echo '<td>' . $m->type->name . '</td>'; 
						echo '<td>' . $m->status->name . '</td>'; 

						echo '<td>' . getQuotePartNumbers($m->id) . '</td>'; 

						echo '<td>' . $m->user->fullname . '</td>'; 
						echo '<td>' . $m->customer->name . '</td>'; 
						echo '<td>' . $m->customer->address1.', '. $m->customer->city . ', '. $m->customer->country->short_name .'</td>'; 
						echo '</tr>';
					}
				?>
		
				</tbody>


	</table>
</div>