
<div style='height: 50px; border: 0px solid gray;'>
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>View Stock Quote No.</div>
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'><?php echo $data['model']->quote_no; ?> </div>

	<!-- <input type='hidden' id='form_QuoteID' name='form_QuoteID' value=''> -->

</div>





<!-- <h1>View Stock Quote No. <?php echo $data['model']->quote_no; ?></h1> -->

<?php 
			
	$return_url = $_SERVER['REQUEST_URI'];  // need to define this so we can return here after a 'Save Changes' or 'Cancel' on 'Update Customer' page

	// display quote status  
	$status_display = $data['model']->status->name;
	if ( $data['model']->status_id == Status::LOST ) {
		$status_display .= " (" . $data['model']->lostReason->name . ")";
	} 
	else if ( $data['model']->status_id == Status::NO_BID ) {
		$status_display .= " (" . $data['model']->noBidReason->name . ")";
	}

	$edit_contacts_link    = quoteIsUserModifiable($data['model']->status_id) ? "<a class='edit_quote_cust' href='../customers/update/" . $data['model']->customer->id . "?return_url=" . $return_url."'>edit</a>" : null;
	$edit_attachments_link = "<a class='edit_quote_cust' href='../attachments/upload/" . $data['model']->id . "?return_url=" . $return_url."'>edit</a>";

	$this->layout = '//layouts/column1';
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$data['model'],
		'attributes'=>array(
			array(
				 	'label' => 'Customer',
				 	'value' =>  $data['model']->customer->name. ", " . $data['model']->customer->address1 . ", " . $data['model']->customer->city . ", " .  $data['model']->customer->country->long_name, 
				 	'type' => 'raw',
				 ),
			array(
				 	'label' => 'Salesperson',
				 	'value' =>  $data['model']->owner->first_name . ' ' .  $data['model']->owner->last_name,
				 	'type' => 'raw',
				 ),
			array(
				 	'label' => 'Quote Type',
				 	'value' =>  $data['model']->quoteType->name,
				 	'type' => 'raw',
				 ),
			array(
					'label' => 'Created On',
				 	'value' =>  Date('M d, Y', strtotime($data['model']->created_date)),
				 	'type' => 'raw',
				),
			array(
					'label' => 'Expires On',
				 	'value' =>  Date('M d, Y', strtotime($data['model']->expiration_date)),
				 	'type' => 'raw',

				),
			array(
					'label' => 'Source',
				 	'value' =>  $data['model']->source->name,
				 	'type' => 'raw',

				),
			array(
				 	'label' => 'Terms & Conditions',
				 	'value' =>  $data['model']->terms_conditions,
				 	'type' => 'raw',
				 ),
			'customer_acknowledgment',
			'risl',
			'manufacturing_lead_time',
			'additional_notes',
			array(
				 	'label' => 'Status',
				 	'value' => $status_display,
				 ),
		),
	)); 

?>  <!-- $customerContacts[] = array( 'fullname' => $r['fullname'], 'title' => $r['title'], 'email' => $r['email'], 'phone1' => $r['phone1'] ); -->

	<div style='margin-top: 20px;'>
		<ul id='view_contacts'><span>Contacts</span> <!--  < ?php echo $edit_contacts_link; ?>  -->
				<?php
					foreach( $data['customerContacts'] as $cc ) {
						echo "<li>" . $cc['fullname'] . ", " . $cc['title'] . ", " . $cc['email'] . ", " . $cc['phone1'] .       "<input type='hidden' name='selectedCustomers[".$cc['id']."]' /></li>";
					}
				?>
		</ul> 
	</div>



	<div style='margin-top: 20px;'>
		<ul id='view_attachments'><span>Attachments</span>  <!-- < ?php echo $edit_attachments_link; ?>  -->
				<!-- < ?php
					foreach( $data['quoteAttachments'] as $qa ) {
						echo "<li>" . $qa['filename'] . ", " . $qa['uploaded_date'] . ", " . getUploader($qa['uploaded_by']) . "<input type='hidden' name='selectedAttachments[".$qa['id']."]' /></li>";
					}
				?> -->
		</ul> 
	</div>




<?php echo $this->renderPartial('_items', array('model'=>$data['model'])); ?>
<br />


<a href="javascript:history.back()">Go Back</a>


    <div class='no-print' id='form_contactSalesPerson' style='display: none; padding-top: 25px;'> 

    	<label style='font-weight: bold; font-size: .8em; color: gray;'>Enter your message</label><br />
	    <textarea rows="4" cols="45" name="message_from_approver" id="message_from_approver"></textarea>
	    <span id='draft_checkbox'><input type='checkbox' id='draft' name='draft' value='1' /> Reject quote</span>

    </div>
