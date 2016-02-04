<?php $this->layout = '//layouts/column1'; ?>

<input type='hidden' id='return_URL' name='return_URL' value='<?php echo $_SERVER['REQUEST_URI'];  ?>'>

<?php
	if ( Yii::app()->user->isAdmin ) {
		$status_link = "<span id='changeStatus'>".$data['model']->status->name."</span>";
	}
	else {
		$status_link = $data['model']->status->name;
	}
?>


<div style='height: 80px; border: 0px solid gray;'>
	
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>Updating Stock Quote No.</div>
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'><?php echo $data['model']->quote_no; ?> 
		<span style='color: #2C6371;  font-size: .7em; border: 0px solid red; '> [  <?php echo $status_link; ?>  ]</span>
	</div>

<!-- 

	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>Updating Stock Quote No. <br />
		
	</div>
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'>< ?php echo $data['model']->quote_no; ?> 
		</div> -->

	
	<?php 
		$edit   = Yii::app()->request->baseUrl . "/images/New/edit.png"; 
 		$trash  = Yii::app()->request->baseUrl . "/images/New/trash.png";
 		$print  = Yii::app()->request->baseUrl . "/images/New/print.png";
 		$email  = Yii::app()->request->baseUrl . "/images/New/mail.png";
 		$attach = Yii::app()->request->baseUrl . "/images/New/attachment.png";

 		$q  = $data['model']; 
 		$cu = $data['customer'];
 		$co = $data['contact'];

 		$quote_id    = $q->id;
 		$customer_id = $cu->id;
 		$contact_id  = $co->id; 
 		$source_id   = $q->source_id;

 	?>
</div>

<span style='color: #555; font-size: 14px;'>Fields with <span class="required">*</span> are required.</span>

<form id='quoteUpdateForm' name='quoteUpdateForm' method='post'>

	<input type='hidden' id='Quote_id'  name='Quote[id]' value='<?php echo $quote_id; ?>'>
	<input type='hidden' id='form_QuoteID' name='form_QuoteID' value='<?php echo $quote_id; ?>'>

	<!-- ################################################################################################################################################################  -->
	<div id='section_CustomerContact'>

		<div class='quote_section_heading_View'>
			<span>Customer Information</span>
			<input type='hidden' id='returnUrl'       value='<?php echo Yii::app()->request->baseUrl . '/index.php/quotes/update/' . $quote_id  ?>'>
			<input type='hidden' id='Quote_source_id' name='Quote[source_id]' value='<?php echo $source_id; ?>'>
		</div>
			
		<div class='my_container'>
		    <div id="box1">
			    <input type='hidden' id='Customer_id' name='Customer[id]' value='<?php echo $customer_id; ?>'>
		     	<table>
			       		<tr>  <td>Customer Name</td>            <td><input  readonly='readonly' type='text' id='Customer_name' name='Customer[name]'  value='<?php echo $cu->name; ?>' > </td> </tr>
						<tr>  <td>Address1</td>                 <td><input  readonly='readonly' type='text' id='Customer_address1' name='Customer[address1]'  value='<?php echo $cu->address1; ?>'  > </td> </tr>
						<tr>  <td>Address2</td>                 <td><input  readonly='readonly' type='text' id='Customer_address2' name='Customer[address2]'  value='<?php echo $cu->address2; ?>'  > </td> </tr>
						<tr>  <td>City</td>                     <td><input  readonly='readonly' type='text' id='Customer_city' name='Customer[city]'   value='<?php echo $cu->city; ?>' > </td> </tr>
						<tr>  <td>US State</td>                 <td><input  readonly='readonly' type='text' id='Customer_state_id' name='Customer[state_id]'   value='<?php echo $cu->state->long_name; ?>' > </td> </tr>
						<tr>  <td>Country</td>                  <td><input  readonly='readonly' type='text' id='Customer_country_id' name='Customer[country_id]'   value='<?php echo $cu->country->long_name; ?>' > </td> </tr>
						<tr>  <td>Zip/Postal Code</td>          <td><input  readonly='readonly' type='text' id='Customer_zip' name='Customer[zip]'  value='<?php echo $cu->zip; ?>'  > </td> </tr>
						<tr>  <td>Region</td>                   <td><input  readonly='readonly' type='text' id='Customer_region_id' name='Customer[region_id]'  value='<?php echo $cu->region->name; ?>'  > </td> </tr>
						<tr>  <td>Customer Type</td>            <td><input  readonly='readonly' type='text' id='Customer_customer_type_id' name='Customer[customer_type_id]'  value='<?php echo $cu->customerType->name; ?>' > </td> </tr>
						<tr>  <td>Territory</td>                <td><input  readonly='readonly' type='text' id='Customer_territory_id' name='Customer[territory_id]'  value='<?php echo $cu->territory->name; ?>'  > </td> </tr>
						<tr>  <td>Inside Salesperson</td>       <td><input  readonly='readonly' type='text' id='Customer_inside_salesperson_id' name='Customer[inside_salesperson_id]'  value='<?php echo $cu->insideSalesperson->fullname; ?>'  > </td> </tr>
						<tr>  <td>Outside Salesperson</td>      <td><input  readonly='readonly' type='text' id='Customer_outside_salesperson_id' name='Customer[outside_salesperson_id]'   value='<?php echo $cu->outsideSalesperson->fullname; ?>' > </td> </tr>
		      	</table>
		    </div>

		    <div id="box2">
		       	<table>
		                <tr>  <td>Vertical Market</td>          <td><input  readonly='readonly' type='text' id='Customer_vertical_market' name='Customer[vertical_market]'   value='<?php echo $cu->vertical_market; ?>' > </td> </tr>
		                <tr>  <td>Parent</td>                   <td><input  readonly='readonly' type='text' id='Customer_parent_id' name='Customer[parent_id]'   value='<?php echo $cu->parent->name; ?>' > </td> </tr>
		                <tr>  <td>Company Link</td>             <td><input  readonly='readonly' type='text' id='Customer_company_link' name='Customer[company_link]'   value='<?php echo $cu->company_link; ?>' > </td> </tr>
		                <tr>  <td>SYSPRO Account #</td>         <td><input  readonly='readonly' type='text' id='Customer_syspro_account_code' name='Customer[syspro_account_code]'   value='<?php echo $cu->syspro_account_code; ?>' > </td> </tr>
		                <tr>  <td>Xmas List</td>                <td><input  readonly='readonly' type='text' id='Customer_xmas_list' name='Customer[xmas_list]'  value='<?php echo $cu->xmas_list; ?>'  > </td> </tr>
		                <tr>  <td>Candy List</td>               <td><input  readonly='readonly' type='text' id='Customer_candy_list' name='Customer[candy_list]'   value='<?php echo $cu->candy_list; ?>' > </td> </tr>
		                <tr>  <td>Strategic</td>                <td><input  readonly='readonly' type='text' id='Customer_strategic' name='Customer[strategic]'  value='<?php echo $cu->strategic; ?>'  > </td> </tr>
		                <tr>  <td>Tier</td>                     <td><input  readonly='readonly' type='text' id='Customer_tier_id' name='Customer[tier_id]'  value='<?php echo $cu->tier->name; ?>'  > </td> </tr>
		      	</table>
		    </div>

		    <div id="box3">
		    	<input type='hidden' id='Contact_id' name='Contact[id]' value='<?php echo $contact_id; ?>'>  
			    <table>
			    		<tr>  <td></td>                         <td style='text-align: right;'><span id='clearContactFields'>New Contact</span></td> </tr>
				        <tr>  <td><span class='required'> * </span>Contact First Name</td>       <td><input  readonly='readonly' type='text' id='Contact_first_name' name='Contact[first_name]'   value='<?php echo $co->first_name; ?>' > </td> </tr>
				        <tr>  <td><span class='required'> * </span>Last Name</td>                <td><input  readonly='readonly' type='text' id='Contact_last_name' name='Contact[last_name]'    value='<?php echo $co->last_name; ?>' > </td> </tr>
				        <tr>  <td><span class='required'> * </span>Email</td>                    <td><input  readonly='readonly' type='text' id='Contact_email' name='Contact[email]'    value='<?php echo $co->email; ?>' > </td> </tr>
				        <tr>  <td><span class='required'> * </span>Title</td>                    <td><input  readonly='readonly' type='text' id='Contact_title' name='Contact[title]'   value='<?php echo $co->title; ?>'  > </td> </tr>
				        <tr>  <td><span class='required'> * </span>Phone1</td>                   <td><input  readonly='readonly' type='text' id='Contact_phone1' name='Contact[phone1]'    value='<?php echo $co->phone1; ?>' > </td> </tr>
				        <tr>  <td>Phone2</td>                   <td><input  readonly='readonly' type='text' id='Contact_phone2' name='Contact[phone2]'    value='<?php echo $co->phone2; ?>' > </td> </tr>
				        <tr>  <td>Address1</td>                 <td><input  readonly='readonly' type='text' id='Contact_address1' name='Contact[address1]'   value='<?php echo $co->address1; ?>'  > </td> </tr>
				        <tr>  <td>Address2</td>                 <td><input  readonly='readonly' type='text' id='Contact_address2' name='Contact[address2]'    value='<?php echo $co->address2; ?>' > </td> </tr>
				        <tr>  <td>City</td>                     <td><input  readonly='readonly' type='text' id='Contact_city' name='Contact[city]'    value='<?php echo $co->city; ?>' > </td> </tr>
				        <tr>  <td>State</td>                    <td><input  readonly='readonly' type='text' id='Contact_state_id' name='Contact[state_id]'   value='<?php echo $co->state->long_name; ?>'  > </td> </tr>
				        <tr>  <td>Zip/Postal Code</td>          <td><input  readonly='readonly' type='text' id='Contact_zip' name='Contact[zip]'    value='<?php echo $co->zip; ?>' > </td> </tr>
				        <tr>  <td>Country</td>                  <td><input  readonly='readonly' type='text' id='Contact_country_id' name='Contact[country_id]'   value='<?php echo $co->country->long_name; ?>'  > </td> </tr>
			    </table>
		    </div>

		    <span style='padding-left: 50px; font-weight: bold;'><span class='required'> * </span>Contact Source
				<select name='Quote[source_id]' id='Quote_source_id'>
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

	<!-- ################################################################################################################################################################  -->
	<div id='section_TermsConditions'>

		<div class='quote_section_heading_View'>
			<span>Quote Terms</span>
		</div>

		<div  class='my_container'>

			<div id="box5" style='border: 0px solid green; width: 45%; margin: 5px;'>
				<span class='terms'>Terms &amp; Conditions</span><textarea rows="4" cols="50"  name="Quote[terms_conditions]"         id="Quote_terms_conditions" ><?php echo $q->terms_conditions; ?></textarea>
			</div>

			<div id="box6" style='border: 0px solid blue; width: 45%; margin: 5px'>
				<span class='terms'>Customer Ackowledgment</span><textarea rows="4" cols="50"  name="Quote[customer_acknowledgment]" id="Quote_customer_acknowledgment" ><?php echo $q->customer_acknowledgment; ?></textarea>
			</div>

			<div id="box7" style='border: 0px solid orange; width: 45%; margin: 5px;'>
				<span class='terms'>Risl</span><textarea rows="4" cols="50"                    name="Quote[risl]"                    d="Quote_risl"  ><?php echo $q->risl; ?></textarea>
			</div>

			<div id="box8" style='border: 0px solid red; width: 45%; margin: 5px;'>
				<span class='terms'>Manufacturing Lead Time</span><textarea rows="4" cols="50" name="Quote[manufacturing_lead_time]" id="Quote_manufacturing_lead_time"  ><?php echo $q->manufacturing_lead_time; ?></textarea>
			</div>
			
			<div id="box9" style='border: 0px solid cyan; width: 95%; margin: 5px;'>
				<span class='terms'>Additional Notes</span><textarea rows="4" cols="100"       name="Quote[additional_notes]"         id="Quote_additional_notes"  ><?php echo $q->additional_notes; ?></textarea>
			</div>

		</div>
	</div>

	<!-- ################################################################################################################################################################  -->
	<div id='section_Parts'>
		
		<div>

			<div class='quote_section_heading_View'>
				<span>Inventory Items</span>
			</div>

			<div  class='my_container'>
				<div id="box4">

					<div style='margin: 10px 0px 50px 10px; '>
						<table id='table_CurrentParts' style='width: 100%; border: 1px solid lightgray; margin-top: 5px;'>
							<thead>
								<tr>
									<th></th>
									<th >Part Number</th>
									<th >Manufacturer</th>
									<th >Quantity</th>
									<th >Price</th>
									<th >Total</th>
									<th >Comments</th>
								</tr>
							</thead>
							<tbody>
									<?php
										foreach( $data['items'] as $i ) {
											echo '<tr>';
											echo '<td style="font-size: .9em; padding: 2px;">';
											echo "<img id='item_edit_"  . $i['id'] . "' title='Edit this item'    src='$edit' width='16' height='16' />";
											echo "<img id='item_trash_" . $i['id'] . "' title='Delete this item'  src='$trash' width='16' height='16' />";
											
											echo '<td>' . $i['part_no'] . '</td>';
											echo '<td>' . $i['manufacturer'] . '</td>';

											echo '<td>' . $i['qty'] . '</td>';
											echo '<td>' . $i['price'] . '</td>';
											echo '<td>' . $i['total'] . '</td>';
											echo '<td style="text-align:left:">' . $i['comments'] . '</td>';
											
											echo '</tr>';
										}
									?>
							</tbody>
						</table>
						<span id='addPartToQuote'>Add item(s) to this quote</span>
					</div>

					<div id='div_PartsLookup' style='display: none;'>
						<table id='parts_lookup'>
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


						<table id='results_table' style='margin-top: 5px;'>
							<thead>
								<tr>
									<th>Part Number</th>
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


	<div id='div_ActionButtons'> 
		<input id='button_SaveQuoteChanges' type='submit' value='Save Changes'> 
		<input id='button_CancelQuoteChanges' type='button' value='Cancel'> 
	</div> 

</form>

<div class='print' id="form_PartPricing" style='display: none'> pricing details content goes here </div>


<div class='print' id="form_PartPricing" style='display: none'> pricing details content goes here </div>

<div id="dialog_status_form" title="Change Quote Status">
	<form id='new_status_form' name='new_status_form' >
		<fieldset>

		<input type='hidden' id='Quote_id' name='Quote[id]' value='<?php echo $data['model']->id; ?>'>

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



