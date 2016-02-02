<?php $this->layout = '//layouts/column1'; ?>
<div>
	<span style="padding-top: 10px;display:inline-block; vertical-align:top" class='pageTitle'><?php echo $page_title;  ?></span>
	<span id='add_quote' href='#'><img src='<?php echo Yii::app()->baseUrl; ?>/images/add1.png' width='48' height='48' title='Add a New Quote'></span>
</div>


<div style='width:906px; margin-top: 30px;'>
	<table id='quotes_table'>
				<thead>
					<tr>
						<th></th>
						<th>Quote No.</th>
						<th>Type</th>
						<th>Status</th>
						<th>Level</th>

						<th>No. of Items</th>

						<!-- <th>Sales Person</th> -->
						<th>Customer </th>
						<th>Location</th>
						<th>Contact </th>
					</tr>
				</thead>

				<tbody>	

				<?php 
					foreach( $model as $m ) { 
						echo '<tr>';
						echo '<td>';
						echo '<span title="View this quote" id="view_quote_'.     $m->id  .'" ><img src="' .Yii::app()->baseUrl. '/images/view_glyph.png"   height="24" width="24"></span>';
						// echo '<span title="Edit this quote" id="edit_quote_'.     $m->id  .'" ><img src="' .Yii::app()->baseUrl. '/images/edit_glyph.png"   height="24" width="24"></span>'; 
						// echo '<span title="Delete this quote" id="delete_quote_'. $m->id  .'" ><img src="' .Yii::app()->baseUrl. '/images/delete_glyph.png" height="24" width="24"></span>';
						echo '</td>'; 
						echo '<td>' . $m->quote_no . '</td>'; 
						echo '<td>' . $m->quoteType->name . '</td>'; 
						echo '<td>' . $m->status->name . '</td>'; 
						echo '<td>' . $m->level->name . '</td>'; 

						echo '<td>' . getQuotePartNumbers($m->id) . '</td>';   

						// echo '<td>' . $m->owner->fullname . '</td>'; 
						echo '<td>' . $m->customer->name . '</td>'; 
						echo '<td>' . $m->customer->address1.', '. $m->customer->city . ', '. $m->customer->country->short_name .'</td>'; 
						echo '<td>' . $m->contact->first_name . ' ' . $m->contact->last_name . '</td>'; 
						echo '</tr>';
					}
				?>
		
				</tbody>

				

	</table>
</div>

<div class='print' id="form_ViewQuoteDetails" style='display: none'> quote details content goes here </div>