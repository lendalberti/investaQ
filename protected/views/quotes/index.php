<div>
	<span style="padding-top: 10px;display:inline-block; vertical-align:top" class='pageTitle'><?php echo $page_title;  ?></span>
	<a id='add_quote' href='#'><img src='../../../images/add1.png' width='48' height='48' title='Start a New Quote'></a>
</div>


<div style='width:906px; margin-top: 80px;'>
	<table id='quotes_table'>
				<thead>
					<tr>
						<th></th>
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
						echo '<td><a title="View this quote" id="view_quote_'. $m->id  .'" href="#"><img src="' .Yii::app()->baseUrl. '/images/view_glyph.png" height="24" width="24"></a>';
						echo '<a title="Edit this quote" id="edit_quote_'. $m->id  .'" href="#"><img src="' .Yii::app()->baseUrl. '/images/edit_glyph.png" height="24" width="24"></a>'; 
						echo '<a title="Delete this quote" id="delete_quote_'. $m->id  .'" href="#"><img src="' .Yii::app()->baseUrl. '/images/delete_glyph.png" height="24" width="24"></a></td>'; 
						echo '<td>' . $m->quote_no . '</td>'; 
						echo '<td>' . $m->quoteType->name . '</td>'; 
						echo '<td>' . $m->status->name . '</td>'; 

						echo '<td>' . getQuotePartNumbers($m->id) . '</td>';   

						echo '<td>' . $m->owner->fullname . '</td>'; 
						echo '<td>' . $m->customer->name . '</td>'; 
						echo '<td>' . $m->customer->address1.', '. $m->customer->city . ', '. $m->customer->country->short_name .'</td>'; 
						echo '</tr>';
					}
				?>
		
				</tbody>

				<tfoot>
				</tfoot>

	</table>
</div>

<div class='print' id="form_ViewQuoteDetails" style='display: none'> quote details content goes here </div>