<?php 
	$this->layout = '//layouts/column1';
	$status       = $data['model']->status->name;
	$quoteType    = $data['model']->quoteType->name;
?>

<input type='hidden' id='return_URL' name='return_URL' value='<?php echo $_SERVER['REQUEST_URI'];  ?>'>
<input type='hidden' id='quoteTypeID' name='quoteTypeID' value='<?php echo $data['model']->quote_type_id ?>'>


<div style='height: 100px; border: 0px solid gray;'>
	
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>Updating Quote No.</div>
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'><?php echo $data['model']->quote_no; ?> 
		<span style='color: #2C6371;  font-size: .7em; border: 0px solid red; '> [ <?php echo $quoteType . ', ' . $status; ?> ]</span>
	</div>

	
	<?php 
		$edit   = Yii::app()->request->baseUrl . "/images/New/edit.png"; 
 		$trash  = Yii::app()->request->baseUrl . "/images/New/trash.png";
 		$print  = Yii::app()->request->baseUrl . "/images/New/print.png";
 		$email  = Yii::app()->request->baseUrl . "/images/New/mail.png";
 		$attach = Yii::app()->request->baseUrl . "/images/New/attachment.png";
 		$pending = Yii::app()->request->baseUrl . "/images/New/gear_yellow.png";
 		$rejected = Yii::app()->request->baseUrl . "/images/New/gear_yellow_x.png";

 		$q  = $data['model']; 
 		$cu = $data['customer'];
 		$co = $data['contact'];

 		$quote_id    	 = $q->id;
 		$quote_status_id = $q->status_id;
 		$customer_id     = $cu->id;
 		$contact_id      = $co->id; 
 		$source_id       = $q->source_id;

 	?>
</div>



<form id='quoteUpdateForm' name='quoteUpdateForm' method='post'>

	<input type='hidden' id='Quotes_id'  name='Quotes[id]' value='<?php echo $quote_id; ?>'>
	<input type='hidden' id='form_QuoteID' name='form_QuoteID' value='<?php echo $quote_id; ?>'>
	<input type='hidden' id='item_id' name='item_id' value=''>

	<div id="QuoteView_Tabs">

		<ul>
			<li><a href="#section_CustomerContact">Customer &amp; Contact Information</a></li>
			<li><a href="#section_TermsConditions">Quote Terms</a></li>
			<li><a href="#section_Parts">Inventory Items</a></li>
			<!--  Manufacturing : hide (3), show (4),(5)-->
			<li><a href="#section_Manufacturing">Manufacturing Details</a></li>
			<li><a href="#section_Approvals">Process Approvals</a></li>
		</ul>

		<!--  for Stock Quotes -->
		<div id='section_CustomerContact'>
			<input type='hidden' id='returnUrl'       value='<?php echo Yii::app()->request->baseUrl . '/index.php/quotes/update/' . $quote_id  ?>'>
			<input type='hidden' id='Quotes_source_id' name='Quotes[source_id]' value='<?php echo $source_id; ?>'>
			<input type='hidden' id='Quotes_status_id' name='Quotes[status_id]' value='<?php echo $quote_status_id; ?>'>

			<span style='color: #555; font-size: 14px;'>Fields with <span class="required">*</span> are required.</span>
				
			<div class='my_container'>
			    <div id="box1">
				    <input type='hidden' id='Customers_id' name='Customers[id]' value='<?php echo $customer_id; ?>'>
			     	<table>
				       		<tr>  <td>Customer Name</td>            <td><input  readonly='readonly' type='text' id='Customers_name' name='Customers[name]'  value='<?php echo $cu->name; ?>' > </td> </tr>
							<tr>  <td>Address1</td>                 <td><input  readonly='readonly' type='text' id='Customers_address1' name='Customers[address1]'  value='<?php echo $cu->address1; ?>'  > </td> </tr>
							<tr>  <td>Address2</td>                 <td><input  readonly='readonly' type='text' id='Customers_address2' name='Customers[address2]'  value='<?php echo $cu->address2; ?>'  > </td> </tr>
							<tr>  <td>City</td>                     <td><input  readonly='readonly' type='text' id='Customers_city' name='Customers[city]'   value='<?php echo $cu->city; ?>' > </td> </tr>
							<tr>  <td>US State</td>                 <td><input  readonly='readonly' type='text' id='Customers_state_id' name='Customers[state_id]'   value='<?php echo $cu->state->long_name; ?>' > </td> </tr>
							<tr>  <td>Country</td>                  <td><input  readonly='readonly' type='text' id='Customers_country_id' name='Customers[country_id]'   value='<?php echo $cu->country->long_name; ?>' > </td> </tr>
							<tr>  <td>Zip/Postal Code</td>          <td><input  readonly='readonly' type='text' id='Customers_zip' name='Customers[zip]'  value='<?php echo $cu->zip; ?>'  > </td> </tr>
							<tr>  <td>Region</td>                   <td><input  readonly='readonly' type='text' id='Customers_region_id' name='Customers[region_id]'  value='<?php echo $cu->region->name; ?>'  > </td> </tr>
							<tr>  <td>Customer Type</td>            <td><input  readonly='readonly' type='text' id='Customers_customer_type_id' name='Customers[customer_type_id]'  value='<?php echo $cu->customerType->name; ?>' > </td> </tr>
							<tr>  <td>Territory</td>                <td><input  readonly='readonly' type='text' id='Customers_territory_id' name='Customers[territory_id]'  value='<?php echo $cu->territory->name; ?>'  > </td> </tr>
							<tr>  <td>Inside Salesperson</td>       <td><input  readonly='readonly' type='text' id='Customers_inside_salesperson_id' name='Customers[inside_salesperson_id]'  value='<?php echo $cu->insideSalesperson->fullname; ?>'  > </td> </tr>
							<tr>  <td>Outside Salesperson</td>      <td><input  readonly='readonly' type='text' id='Customers_outside_salesperson_id' name='Customers[outside_salesperson_id]'   value='<?php echo $cu->outsideSalesperson->fullname; ?>' > </td> </tr>
			      			<tr>  <td colspan='2'><span  id='check_SameAsContact' class='checkbox_sameAddress'><input type='checkbox'>Use same address as contact </span> </td> </tr>
			      	</table>
			    </div>

			    <div id="box2">
			       	<table>
			                <tr>  <td>Vertical Market</td>          <td><input  readonly='readonly' type='text' id='Customers_vertical_market' name='Customers[vertical_market]'   value='<?php echo $cu->vertical_market; ?>' > </td> </tr>
			                <tr>  <td>Parent</td>                   <td><input  readonly='readonly' type='text' id='Customers_parent_id' name='Customers[parent_id]'   value='<?php echo $cu->parent->name; ?>' > </td> </tr>
			                <tr>  <td>Company Link</td>             <td><input  readonly='readonly' type='text' id='Customers_company_link' name='Customers[company_link]'   value='<?php echo $cu->company_link; ?>' > </td> </tr>
			                <tr>  <td>SYSPRO Account #</td>         <td><input  readonly='readonly' type='text' id='Customers_syspro_account_code' name='Customers[syspro_account_code]'   value='<?php echo $cu->syspro_account_code; ?>' > </td> </tr>
			                <tr>  <td>Xmas List</td>                <td><input  readonly='readonly' type='text' id='Customers_xmas_list' name='Customers[xmas_list]'  value='<?php echo $cu->xmas_list; ?>'  > </td> </tr>
			                <tr>  <td>Candy List</td>               <td><input  readonly='readonly' type='text' id='Customers_candy_list' name='Customers[candy_list]'   value='<?php echo $cu->candy_list; ?>' > </td> </tr>
			                <tr>  <td>Strategic</td>                <td><input  readonly='readonly' type='text' id='Customers_strategic' name='Customers[strategic]'  value='<?php echo $cu->strategic; ?>'  > </td> </tr>
			                <tr>  <td>Tier</td>                     <td><input  readonly='readonly' type='text' id='Customers_tier_id' name='Customers[tier_id]'  value='<?php echo $cu->tier->name; ?>'  > </td> </tr>
			      	</table>
			    </div>

			    <div id="box3">
			    	<input type='hidden' id='Contacts_id' name='Contacts[id]' value='<?php echo $contact_id; ?>'>  

			    	
			    	<span id='span_NewContact' class='span_links' title='Create a new contact' >New Contact</span> 
				    <table>
					        <tr>  <td><span class='required'> * </span>Contact First Name</td>       <td><input  readonly='readonly' type='text' id='Contacts_first_name' name='Contacts[first_name]'   value='<?php echo $co->first_name; ?>' > </td> </tr>
					        <tr>  <td><span class='required'> * </span>Last Name</td>                <td><input  readonly='readonly' type='text' id='Contacts_last_name' name='Contacts[last_name]'    value='<?php echo $co->last_name; ?>' > </td> </tr>
					        <tr>  <td><span class='required'> * </span>Email</td>                    <td><input  readonly='readonly' type='text' id='Contacts_email' name='Contacts[email]'    value='<?php echo $co->email; ?>' > </td> </tr>
					        <tr>  <td><span class='required'> * </span>Title</td>                    <td><input  readonly='readonly' type='text' id='Contacts_title' name='Contacts[title]'   value='<?php echo $co->title; ?>'  > </td> </tr>
					        <tr>  <td><span class='required'> * </span>Phone1</td>                   <td><input  readonly='readonly' type='text' id='Contacts_phone1' name='Contacts[phone1]'    value='<?php echo $co->phone1; ?>' > </td> </tr>
					        <tr>  <td>Phone2</td>                   <td><input  readonly='readonly' type='text' id='Contacts_phone2' name='Contacts[phone2]'    value='<?php echo $co->phone2; ?>' > </td> </tr>
					        <tr>  <td>Address1</td>                 <td><input  readonly='readonly' type='text' id='Contacts_address1' name='Contacts[address1]'   value='<?php echo $co->address1; ?>'  > </td> </tr>
					        <tr>  <td>Address2</td>                 <td><input  readonly='readonly' type='text' id='Contacts_address2' name='Contacts[address2]'    value='<?php echo $co->address2; ?>' > </td> </tr>
					        <tr>  <td>City</td>                     <td><input  readonly='readonly' type='text' id='Contacts_city' name='Contacts[city]'    value='<?php echo $co->city; ?>' > </td> </tr>
					        <tr>  <td>State</td>                    <td><input  readonly='readonly' type='text' id='Contacts_state_id' name='Contacts[state_id]'   value='<?php echo $co->state->long_name; ?>'  > </td> </tr>
					        <tr>  <td>Zip/Postal Code</td>          <td><input  readonly='readonly' type='text' id='Contacts_zip' name='Contacts[zip]'    value='<?php echo $co->zip; ?>' > </td> </tr>
					        <tr>  <td>Country</td>                  <td><input  readonly='readonly' type='text' id='Contacts_country_id' name='Contacts[country_id]'   value='<?php echo $co->country->long_name; ?>'  > </td> </tr>
						    <tr>  <td colspan='2'><span id='check_SameAsCustomer' class='checkbox_sameAddress'><input type='checkbox' >Use same address as customer </span> </td> </tr>
				    
				    </table>
			    </div>

			    <div style='width: 100%; border: 0px solid green; text-align: center;'>
					<span id='span_SelectSource'><span class='required'> * </span>Opportunity Source
						<select name='Quotes[source_id]' id='Quotes_source_id'>
							<?php
								echo "<option value='0'></option>";
								foreach( $data['sources'] as $c ) {
									$selected = ($c->id == $source_id ? 'selected' : null );
									echo "<option value='".$c->id."' $selected>".$c->name."</option>";
								}
							?>
						</select>
					</span>
				</div>

			</div>
		</div>

		<div id='section_TermsConditions'>

			<div  class='my_container'>

				<div id="box5" style='border: 0px solid green; width: 45%; margin: 5px;'>
					<span class='terms'>Terms &amp; Conditions</span><textarea rows="4" cols="40"  name="Quotes[terms_conditions]"         id="Quotes_terms_conditions" ><?php echo $q->terms_conditions; ?></textarea>
				</div>

				<div id="box6" style='border: 0px solid blue; width: 45%; margin: 5px'>
					<span class='terms'>Customer Ackowledgment</span><textarea rows="4" cols="40"  name="Quotes[customer_acknowledgment]" id="Quotes_customer_acknowledgment" ><?php echo $q->customer_acknowledgment; ?></textarea>
				</div>

				<div id="box7" style='border: 0px solid orange; width: 45%; margin: 5px;'>
					<span class='terms'>Risl</span><textarea rows="4" cols="40"                    name="Quotes[risl]"                    d="Quotes_risl"  ><?php echo $q->risl; ?></textarea>
				</div>

				<div id="box8" style='border: 0px solid red; width: 45%; margin: 5px;'>
					<span class='terms'>Manufacturing Lead Time</span><textarea rows="4" cols="40" name="Quotes[manufacturing_lead_time]" id="Quotes_manufacturing_lead_time"  ><?php echo $q->manufacturing_lead_time; ?></textarea>
				</div>
				
				<div id="box9" style='border: 0px solid cyan; width: 95%; margin: 5px;'>
					<span class='terms'>Additional Notes</span><textarea rows="4" cols="90"       name="Quotes[additional_notes]"         id="Quotes_additional_notes"  ><?php echo $q->additional_notes; ?></textarea>
				</div>

			</div>
		</div>

		<div id='section_Parts'>
			<div>
				<div  class='my_container'>
					<div id="box4">

						<div style='margin: 10px 0px 10px 10px; '>
							<table id='table_CurrentParts' style='width: 100%; border: 1px solid lightgray; margin-top: 5px;'>
								<caption>Item updated.</caption>
								<thead>
									<tr>
										<th></th>
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
													
													//if ( Yii::app()->user->isAdmin || $i['status_id'] != Status::PENDING ) {
													if ( $i['status_id'] != Status::PENDING ) {
														echo "<td style='font-size: .9em; padding: 2px;'><img id='item_edit_"  . $i['id'] . "' title='Edit this item'    src='$edit' width='16' height='16' />";
														echo "<img id='item_trash_" . $i['id'] . "' title='Delete this item'  src='$trash' width='16' height='16' /></td>";
													}
													else {
														echo '<td></td>';
													}

													echo '<td>' . $i['part_no'] . '</td>';
													echo '<td>' . $i['manufacturer'] . '</td>';

													echo '<td>' . $i['lifecycle'] . '</td>'; 
													echo '<td>' . $i['available'] . '</td>';  

													echo '<td>' . $i['qty'] . '</td>';
													echo '<td>' . $i['price'] . '</td>';
													echo '<td><span class="volume">' . $i['volume'] . '</span></td>';
													echo '<td>' . $i['total'] . '</td>';

													if ( $i['status_id'] == Status::PENDING ) {
														echo "<td ><img id='item_status_" . $i['id'] . "' title='Item waiting for approval'  src='$pending' width='20' height='20' /></td>";
													}
													else if ($i['status_id'] == Status::REJECTED ) {
														echo "<td ><img id='item_status_" . $i['id'] . "' title='Item has been rejected'  src='$rejected' width='20' height='20' /></td>";
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

							<div id='div_EditItem' style='padding-left: 20px; border: 0px solid lightblue; display: none;' >
								<div id='div_ItemContent' style='margin-bottom: 20px; padding: 20px 20px 0px 20px; border: 0px solid pink;'>
									
								<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  -->
								<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  -->
								<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  -->

								<!--  to be filled out by an ajax call  -->
								<span style='font-size: 1.2em;' >Part No.</span> <span id='span_PartNo' style='font-size: 1.2em; color: #a31128' ></span> 

								<table style='border: 0px solid green; margin-top: 10px;'>
									<tr><th>Quantity</th>  <th>Volume </th> <th>Price</th> 	<th>Total</th> 	<th>Comments</th> 		</tr>
									<tr>
										<td><input id='item_qty' name='item_qty' ></td>   	   
										<td>
											<select id='item_SelectVolume'>
												<option value=0></option>
												<option value='item_price_1_24'>1 - 24</option>
												<option value='item_price_25_99'>25 - 99</option>
												<option value='item_price_100_499'>100 - 499</option>
												<option value='item_price_500_999'>500 - 999</option>
												<option value='item_price_1000_Plus'>1000+</option>
												<option value='item_price_Base'>Distributor</option>
												<!-- <option value='item_price_Custom'>Custom</option> ** TODO: SAVE THIS FOR LATER SINCE IT INVOLVES A LOT MORE WORK    --> 

											</select>
										</td>   	 

										<td><span id='item_price'>$ 0.00</span></td>   
										<td><span id='item_total'>$ 0.00</span></td>   
										<td><input id='item_comments' name='item_comments' ></td>  
									</tr> 
									<tr>
										<td></td>   <td></td>   <td></td>   <td></td>   
										<td><textarea readonly='readonly' rows="10" cols="55"  name="previous_comments" id="previous_comments" ></textarea></td>
									</tr>  
									
								</table>


								<div style='display: none; padding: 5px 0px 5px 5px; background-color: pink;' > 
									<span style='padding: 0px 5px 0px 0px; font-weight: bold;'>REMINDER:</span> 
									<span style='font-weight: normal;'>Since this part is Obsolete, approval is needed if custom price is less than <span id='min_custom_price' style='color: blue;'><?php echo $min_custom_price; ?></span>  (<?php echo $dpf*100; ?>% of Distributor Price) </span> 
								</div>


								<div style='display: none; padding: 5px 0px 5px 5px; background-color: pink;' > 
									<span style='padding: 0px 5px 0px 0px; font-weight: bold;'>REMINDER:</span> 
									<span style='font-weight: normal;'>Since this part is Active, approval is needed if custom price is less than the Distributor Price of $ 3.50</span> 
								</div>

								<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  -->
								<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  -->
								<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  -->

								</div>
		
								<div style='margin-top: 100px;'>
									<input id='button_SaveItemChanges' type='button' value='Update Item'> 
									<input id='button_CancelItemChanges' type='button' value='Cancel'> 
								</div>
							</div>

							<span id='addPartToQuote'>Add item(s) to this quote</span>
						</div>

						<div id='div_PartsLookup' style='display: none'>
							<table id='parts_lookup' >
								<tr>  
									<td style='text-align: center;' colspan='2'>Lookup by:
											 <select id="parts_SearchBy">
								                  <option value=""></option>
								                  <option value="1" selected>Part Number</option>
								                  <!-- <option value="3">Manufacturer</option> -->
								            </select>     
						            
						            	<input id="parts_Searchfield" class="parts_Searchfield" type="text"  />  
								   	    <input id="parts_Searchbutton" class="parts_Searchbutton" type="button" value="Find" />

							   	    </td>
							   	   
						   	    </tr>
							</table>

							<div style='text-align: center;'>
								<img id='ajax_loading_image' src='<?php echo Yii::app()->baseUrl; ?>/images/New/ajax_loading_image.gif' width='48' height='48' title='Waiting to load...'>
							</div>

							<table id='results_table' style='margin-top: 5px;'>
								<thead>
									<tr>
										<th>Part Number</th>
										<th>Status</th>
										<th>Mfg</th>
										<th>Supplier</th>
										<th>Lifecycle</th>
										<th>Drawing</th>
										<th>Carrier Type</th>
										<th>MPQ</th>
										<th>Quantity<br />Available</th>
									</tr>
								</thead>
								<tbody>
										
								</tbody>
							</table>
						</div>
						
					</div>  <!--  box4  -->
				</div>
			</div>
		</div>
	
		
		<!--  for Manufacturing Quotes--> 
		<div id='section_Manufacturing'>
			<?php require '_mfg_details.php';    ?>
		</div>

		<div id='section_Approvals'>
			<?php require '_mfg_approvals.php';    ?>
		</div>




	</div>  <!-- end of QuoteView_Tabs -->

	<div id='div_ActionButtons'> 
		<input id='button_SaveQuoteChanges' type='submit' value='Save Changes'> 
		<span class='cancel_operation' id='cancelQuoteChanges' >Cancel</span>
	</div> 

</form>


<div class='print' id="form_PartPricing" style='display: none'> pricing details content goes here </div>

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


<!--  fini --> 



