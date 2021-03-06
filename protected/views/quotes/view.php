<?php 
	$this->layout = '//layouts/column1';
	$status_name  = $data['model']->status->name;
	$status_id    = $data['model']->status_id;
	$quote_no     = $data['model']->quote_no;
	$quoteType    = $data['model']->quoteType->name;
	$mfgQuote     = $data['model']->quote_type_id == QuoteTypes::MANUFACTURING ? true : false;

	$coordinatorsNotified = $data['BtoItems_model']->coordinators_notified;

	$im_a_coordinator = true;  // TODO:     xxx ? true : false;

?>

<input type='hidden' id='return_URL' name='return_URL' value="<?php echo $_SERVER['REQUEST_URI'];  ?> ">
<input type='hidden' id='quoteTypeID' name='quoteTypeID' value="<?php echo $data['model']->quote_type_id; ?>">
<input type='hidden' id='quoteTypeName' name='quoteTypeName' value="<?php echo $data['model']->quoteType->name; ?>">

<input type='hidden' id='coordinatorGroup' name='coordinatorGroup' value='<?php echo Yii::app()->user->groupId; ?>'>
<input type='hidden' id='myRoleIDs' name='myRoleIDs' value='<?php echo json_encode(Yii::app()->user->roles); ?>'>

<div style='height: 100px; border: 0px solid gray;'>
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>Viewing Quote No.</div>
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'><?php echo $quote_no; ?> 
		<?php 
			if ( Yii::app()->user->isAdmin ) {
				echo "<span style='color: #2C6371;  font-size: .7em; border: 0px solid red; '> [ $quoteType,$status_name ] [ " . $data['model']->owner->fullname . " ]</span>";
			}
			else if ( Yii::app()->user->isProposalManager ) {
				echo "<span style='color: #2C6371;  font-size: .7em; border: 0px solid red; '> [ ". $data['model']->owner->fullname . ", $status ]</span>";
			}
		?>
	</div>

	<br />
	<?php 
		$edit   = Yii::app()->request->baseUrl . "/images/New/edit.png"; 
 		$trash  = Yii::app()->request->baseUrl . "/images/New/trash.png";
 		$print  = Yii::app()->request->baseUrl . "/images/New/print.png";
 		$attach = Yii::app()->request->baseUrl . "/images/New/attachment.png";
 		$email  = Yii::app()->request->baseUrl . "/images/New/mail.png";
 		$contact = Yii::app()->request->baseUrl . "/images/New/contact.png";
 		
 		$submit = Yii::app()->request->baseUrl . "/images/New/submit.png";
 		$draft = Yii::app()->request->baseUrl . "/images/New/draft.png";

 		$approved = Yii::app()->request->baseUrl . "/images/New/approved.png";
 		$rejected = Yii::app()->request->baseUrl . "/images/New/rejected.png";
 		$pending = Yii::app()->request->baseUrl . "/images/New/pending.png";

 		if ( Yii::app()->user->isAdmin || Yii::app()->user->isApprover ) { // allow all for Admin
 			echo "<img id='quote_edit_"  .$data['model']['id']."' title='Edit this quote'   src='$edit' />";
	 		echo "<img id='quote_contact_" .$data['model']['id']."' title='Contact Salesperson'  src='$contact' />";
			echo "<img id='quote_print_" .$data['model']['id']."' title='Print this quote'  src='$print' />";
			echo "<img id='quote_attach_".$data['model']['id']."' title='Attach a file'     src='$attach' />";
			echo "<img id='quote_email_" .$data['model']['id']."' title='Email this quote'  src='$email' />";
			echo "<img id='quote_trash_" .$data['model']['id']."' title='Delete this quote' src='$trash' />";
 		}
 		else {
 			//if ( $data['model']->status_id == Status::DRAFT || $data['model']->status_id == Status::REJECTED ) { // edits allowed only for draft,rejected quotes

 			if ( $data['model']->status_id != Status::PENDING ) {
 				echo "<img id='quote_edit_"  .$data['model']['id']."' title='Edit this quote'   src='$edit' />";
 			}
 			

 			//}
	 		echo "<img id='quote_attach_".$data['model']['id']."' title='Attach a file'     src='$attach' />";
	 		echo "<img id='quote_print_" .$data['model']['id']."' title='Print this quote'  src='$print' />";
	 		echo "<img id='quote_email_" .$data['model']['id']."' title='Email this quote'  src='$email' />";
	 		echo "<img id='quote_trash_" .$data['model']['id']."' title='Delete this quote' src='$trash' />";
	 	}
 	

 		$q  = $data['model']; 
 		$cu = $data['customer'];
 		$co = $data['contact'];

 	?>
</div>

 <div id='quoteViewForm' name='quoteViewForm'>

 	<?php if ( $data['model']->quote_type_id == QuoteTypes::MANUFACTURING &&  $data['model']->status_id == Status::DRAFT ) { ?>  <!--  Manufacturing, Draft          -->
 		<span style='padding-left: 670px;'><a href='#' id='submitProcessApproval'><span style='color: #a31128'>Submit Quote for Process Approval</span></a></span>
	<?php } ?>

	<div id="QuoteView_Tabs" style='margin-top: 5px;'>

		<ul >
			<li><a href="#section_CustomerContact">Customer &amp; Contact Information</a></li>
			<li><a href="#section_TermsConditions">Quote Terms</a></li>
			<li><a href="#section_Parts">Inventory Items</a></li>
			<li><a href="#section_Manufacturing">Manufacturing Details</a></li>
			<li><a href="#section_Approvals">Process Approval Status</a></li>
			<?php if ( Yii::app()->user->isProposalManager || Yii::app()->user->isCoordinator ) { ?> 
				<li><a href="#section_Coordinators">Coordinators</a></li>
			<?php } ?>
		</ul>

		<div id='section_CustomerContact'>
			<div class='my_container'>
				<div id='heading_container' style='display: none;'>
					<span id='span_SelectCustomer' style='display: none;'> Select customer  <select name='Customers[select]' id='Customers_select'> </select><span id='add_NewCustomer'>New</span> </span>
					<span id='span_SelectContact'  style='display: none;'> Select contact   <select name='Contacts[select]'  id='Contacts_select'>  </select><span id='add_NewContact'>New</span> </span>
				</div>

			    <div id="box1">
				    <input type='hidden' id='Customers_id' name='Customers[id]' value=''>
			     	<table>
				       		<tr>  <td>Customer Name</td>            <td><input type='text' id='Customers_name' name='Customers[name]' readonly='readonly' value='<?php echo $cu->name; ?>' > </td> </tr>
							<tr>  <td>Address1</td>                 <td><input type='text' id='Customers_address1' name='Customers[address1]' readonly='readonly' value='<?php echo $cu->address1; ?>'  > </td> </tr>
							<tr>  <td>Address2</td>                 <td><input type='text' id='Customers_address2' name='Customers[address2]' readonly='readonly' value='<?php echo $cu->address2; ?>'  > </td> </tr>
							<tr>  <td>City</td>                     <td><input type='text' id='Customers_city' name='Customers[city]' readonly='readonly'  value='<?php echo $cu->city; ?>' > </td> </tr>
							<tr>  <td>US State</td>                 <td><input type='text' id='Customers_state_id' name='Customers[state_id]' readonly='readonly'  value='<?php echo $cu->state->long_name; ?>' > </td> </tr>
							<tr>  <td>Country</td>                  <td><input type='text' id='Customers_country_id' name='Customers[country_id]' readonly='readonly'  value='<?php echo $cu->country->long_name; ?>' > </td> </tr>
							<tr>  <td>Zip/Postal Code</td>          <td><input type='text' id='Customers_zip' name='Customers[zip]' readonly='readonly' value='<?php echo $cu->zip; ?>'  > </td> </tr>
							<tr>  <td>Region</td>                   <td><input type='text' id='Customers_region_id' name='Customers[region_id]' readonly='readonly' value='<?php echo $cu->region->name; ?>'  > </td> </tr>
							<tr>  <td>Customer Type</td>            <td><input type='text' id='Customers_customer_type_id' name='Customers[customer_type_id]' readonly='readonly' value='<?php echo $cu->customerType->name; ?>' > </td> </tr>
							<tr>  <td>Territory</td>                <td><input type='text' id='Customers_territory_id' name='Customers[territory_id]' readonly='readonly' value='<?php echo $cu->territory->name; ?>'  > </td> </tr>
							<tr>  <td>Inside Salesperson</td>       <td><input type='text' id='Customers_inside_salesperson_id' name='Customers[inside_salesperson_id]' readonly='readonly' value='<?php echo $cu->insideSalesperson->fullname; ?>'  > </td> </tr>
							<tr>  <td>Outside Salesperson</td>      <td><input type='text' id='Customers_outside_salesperson_id' name='Customers[outside_salesperson_id]' readonly='readonly'  value='<?php echo $cu->outsideSalesperson->fullname; ?>' > </td> </tr>
			      	</table>
			    </div>

			    <div id="box2">
			       	<table>
			                <tr>  <td>Vertical Market</td>          <td><input type='text' id='Customers_vertical_market' name='Customers[vertical_market]' readonly='readonly'  value='<?php echo $cu->vertical_market; ?>' > </td> </tr>
			                <tr>  <td>Parent</td>                   <td><input type='text' id='Customers_parent_id' name='Customers[parent_id]' readonly='readonly'  value='<?php echo $cu->parent->name; ?>' > </td> </tr>
			                <tr>  <td>Company Link</td>             <td><input type='text' id='Customers_company_link' name='Customers[company_link]' readonly='readonly'  value='<?php echo $cu->company_link; ?>' > </td> </tr>
			                <tr>  <td>SYSPRO Account #</td>         <td><input type='text' id='Customers_syspro_account_code' name='Customers[syspro_account_code]' readonly='readonly'  value='<?php echo $cu->syspro_account_code; ?>' > </td> </tr>
			                <tr>  <td>Xmas List</td>                <td><input type='text' id='Customers_xmas_list' name='Customers[xmas_list]' readonly='readonly' value='<?php echo $cu->xmas_list; ?>'  > </td> </tr>
			                <tr>  <td>Candy List</td>               <td><input type='text' id='Customers_candy_list' name='Customers[candy_list]' readonly='readonly'  value='<?php echo $cu->candy_list; ?>' > </td> </tr>
			                <tr>  <td>Strategic</td>                <td><input type='text' id='Customers_strategic' name='Customers[strategic]' readonly='readonly' value='<?php echo $cu->strategic; ?>'  > </td> </tr>
			                <tr>  <td>Tier</td>                     <td><input type='text' id='Customers_tier_id' name='Customers[tier_id]' readonly='readonly' value='<?php echo $cu->tier->name; ?>'  > </td> </tr>
			      	</table>
			    </div>

			    <div id="box3">
			    	<input type='hidden' id='Contacts_id' name='Contacts[id]' value=''>  
				    <table>
					        <tr>  <td>Contact First Name</td>       <td><input type='text' id='Contacts_first_name' name='Contacts[first_name]' readonly='readonly'  value='<?php echo $co->first_name; ?>' > </td> </tr>
					        <tr>  <td>Last Name</td>                <td><input type='text' id='Contacts_last_name' name='Contacts[last_name]' readonly='readonly'   value='<?php echo $co->last_name; ?>' > </td> </tr>
					        <tr>  <td>Email</td>                    <td><input type='text' id='Contacts_email' name='Contacts[email]' readonly='readonly'   value='<?php echo $co->email; ?>' > </td> </tr>
					        <tr>  <td>Title</td>                    <td><input type='text' id='Contacts_title' name='Contacts[title]' readonly='readonly'  value='<?php echo $co->title; ?>'  > </td> </tr>
					        <tr>  <td>Phone1</td>                   <td><input type='text' id='Contacts_phone1' name='Contacts[phone1]' readonly='readonly'   value='<?php echo $co->phone1; ?>' > </td> </tr>
					        <tr>  <td>Phone2</td>                   <td><input type='text' id='Contacts_phone2' name='Contacts[phone2]' readonly='readonly'   value='<?php echo $co->phone2; ?>' > </td> </tr>
					        <tr>  <td>Address1</td>                 <td><input type='text' id='Contacts_address1' name='Contacts[address1]' readonly='readonly'  value='<?php echo $co->address1; ?>'  > </td> </tr>
					        <tr>  <td>Address2</td>                 <td><input type='text' id='Contacts_address2' name='Contacts[address2]' readonly='readonly'   value='<?php echo $co->address2; ?>' > </td> </tr>
					        <tr>  <td>City</td>                     <td><input type='text' id='Contacts_city' name='Contacts[city]' readonly='readonly'   value='<?php echo $co->city; ?>' > </td> </tr>
					        <tr>  <td>State</td>                    <td><input type='text' id='Contacts_state_id' name='Contacts[state_id]' readonly='readonly'  value='<?php echo $co->state->long_name; ?>'  > </td> </tr>
					        <tr>  <td>Zip/Postal Code</td>          <td><input type='text' id='Contacts_zip' name='Contacts[zip]' readonly='readonly'   value='<?php echo $co->zip; ?>' > </td> </tr>
					        <tr>  <td>Country</td>                  <td><input type='text' id='Contacts_country_id' name='Contacts[country_id]' readonly='readonly'  value='<?php echo $co->country->long_name; ?>'  > </td> </tr>
				    </table>
			    </div>

			    <div style='width: 100%; border: 0px solid green; text-align: center;'>
					<span id='span_SelectSource'><span class='required'> * </span>Opportunity Source
						<span style='background-color: #E6E6E6; font-size: .8em; font-weight: bold; color: black; border: 1px solid lightgray; padding: 3px;'>
			    			<?php echo $q->source->name; ?>
			    		</span> 
					</span>
				</div>



			    
			   <!--  <span style='padding-left: 50px; font-weight: bold;'>Contact Source: </span>
			    <span style='background-color: #E6E6E6; font-size: .8em; font-weight: bold; color: black; border: 1px solid lightgray; padding: 3px;'>
			    	< ?php echo $q->source->name; ?>
			    </span> -->

			</div>
		</div>

		<div id='section_TermsConditions'>
			<div  class='my_container'>
				
				<div id="box5" style='border: 0px solid green; width: 45%; margin: 5px;'>
					<span class='terms'>Terms &amp; Conditions<br /></span><textarea rows="4" cols="40" name="quote_Terms" id="quote_Terms" readonly='readonly'><?php echo $q->terms_conditions; ?></textarea>
				</div>

				<div id="box6" style='border: 0px solid blue; width: 45%; margin: 5px'>
					<span class='terms'>Customer Ackowledgment<br /></span><textarea rows="4" cols="40" name="quote_CustAck" id="quote_CustAck" readonly='readonly'><?php echo $q->customer_acknowledgment; ?></textarea>
				</div>

				<div id="box7" style='border: 0px solid orange; width: 45%; margin: 5px;'>
					<span class='terms'>Risl</span><br /><textarea rows="4" cols="40" name="quote_RISL" id="quote_RISL" readonly='readonly' ><?php echo $q->risl; ?></textarea>
				</div>

				<div id="box8" style='border: 0px solid red; width: 45%; margin: 5px;'>
					<span class='terms'>Manufacturing Lead Time<br /></span><textarea rows="4" cols="40" name="quote_MfgLeadTime" id="quote_MfgLeadTime" readonly='readonly' ><?php echo $q->manufacturing_lead_time; ?></textarea>
				</div>
				
				<div id="box9" style='border: 0px solid cyan; width: 95%; margin: 5px;'>
					<span class='terms'>Additional Notes<br /></span><textarea rows="4" cols="90" name="quote_Notes" id="quote_Notes" readonly='readonly' ><?php echo $q->additional_notes; ?></textarea>
				</div>

			</div>
		</div>

		<div id='section_Parts'>
			
			<div >
				<div  class='my_container'>

					<div id="box4">
						<div style='margin: 10px 0px 50px 10px; '>
							<table id='table_CurrentParts' style='width: 100%; border: 1px solid gray;margin-top: 5px;'>
							<thead>
								<tr>
									<!-- <th></th>
									<th>Part Number</th>
									<th>Mfg</th>
									<th>LifeCycle</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Total</th>
									<th>Comments</th> -->

									
									<th >Part Number</th>
									<th >Mfg</th>
									<th >LifeCycle</th>
									<th >Max<br />Available</th>
									<th >Qty<br />Ordered</th>
									
									<th >Price</th>
									<th > </th>

									<th >Total</th>
									<th></th>
									<!-- <th >Comments</th> -->

								</tr>
							</thead>
							<tbody>
									<?php
										if ( $data['items'] ) {
											foreach( $data['items'] as $i ) {
												echo '<tr id="item_row_'.$i['id'].'">';
												echo '<td>' . $i['part_no'] . '</td>';
												echo '<td>' . $i['manufacturer'] . '</td>';
												echo '<td>' . $i['lifecycle'] . '</td>'; 
												echo '<td>' . $i['available'] . '</td>'; 
												echo '<td>' . $i['qty'] . '</td>';

												echo '<td>' . $i['price'] . '</td>';
												echo '<td><span class="volume">' . $i['volume'] . '</span></td>'; 

												echo '<td>' . $i['total'] . '</td>';
												if ( $i['status_id'] == Status::PENDING ) {
													echo "<td><img id='item_status_" . $i['id'] . "' title='Pending approval'  src='$pending' width='20' height='20' /></td>";
												}
												else if ($i['status_id'] == Status::REJECTED ) {
													echo "<td><img id='item_status_" . $i['id'] . "' title='Rejected'  src='$rejected' width='20' height='20' /></td>";
												}
												else if ($i['status_id'] == Status::APPROVED ) {
													echo "<td><img id='item_status_" . $i['id'] . "' title='Approved'  src='$approved' width='20' height='20' /></td>";
												}
												else if ($i['status_id'] == Status::DRAFT ) {
													echo "<td><img id='item_status_" . $i['id'] . "' title='Draft'  src='$draft' width='20' height='20' /></td>";
												}
												else {
													echo '<td></td>';
												}
												echo '</tr>';
											}
										}
									?>
							</tbody>
							</table>

							<?php if ( Yii::app()->user->isApprover ) { ?>
								<span style='display:none;' id='button_ApproveItem'>Approve this Item</span>
								<span style='display:none;' id='button_RejectItem'>Reject this Item</span>
							<?php } ?>  


						</div>
					</div>  <!--  box4  -->
				</div>
			</div>
		</div>


		<!--  for Manufacturing Quotes--> 
		<div id='section_Manufacturing'>  
			<?php if ($mfgQuote)   require '_mfg_details_RO.php';    ?> <!-- readonly view of _mfg_details.php -->
		</div>

		<div id='section_Approvals'>
			<?php if ($mfgQuote)   require '_mfg_approvals.php';    ?>
		</div>
		
		<div id='section_Coordinators'>
			<?php if ($mfgQuote && $im_a_coordinator && $coordinatorsNotified )   require '_mfg_coordinators.php';    ?>
		</div>


		



	</div>  <!-- end of QuoteView_Tabs -->
	

		<!-- TODO - clean up, no longer neede -->
		<div id="dialog_status_form" title="Change Quote Status">
			<form id='new_status_form' name='new_status_form' >
				<fieldset>

				<input type='hidden' id='Quotes_id' name='Quotes[id]' value='<?php echo $data['model']->id; ?>'>

					<label for="name">Select new status: </label>
						
						<select id='newQuoteStatus' name='newQuoteStatus' style='margin-top: 10px;'>
								<?php
									foreach( $data['status'] as $arr ) {
										echo "<option value=".$arr->id.">$arr->name</option>";
									}
								?>
						</select>

					<!-- Allow form submission with keyboard without duplicating the dialog button -->
					<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
				</fieldset>
			</form>
		</div>

		<div style='text-align: center;'>
			<img id='ajax_loading_image' src='<?php echo Yii::app()->baseUrl; ?>/images/New/ajax_loading_image.gif' width='48' height='48' title='Waiting to load...'>
		</div>

		<div id='item_details'>Loading...</div>


</div>

<!-- <div style='margin: 20px 20px 20px 10px;'> <input type='button' id='back_to_index' value='Done' /> </div> -->

<!--  fini --> 