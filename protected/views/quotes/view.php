<?php $this->layout = '//layouts/column1'; ?>


<input type='hidden' id='return_URL' name='return_URL' value='<?php echo $_SERVER['REQUEST_URI'];  ?>'>


<div style='height: 100px; border: 0px solid gray;'>
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>Viewing Stock Quote No.</div>
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'><?php echo $data['model']->quote_no; ?> </div>

	<br />
	<?php 
		$edit   = Yii::app()->request->baseUrl . "/images/New/edit.png"; 
 		$trash  = Yii::app()->request->baseUrl . "/images/New/trash.png";
 		$print  = Yii::app()->request->baseUrl . "/images/New/print.png";
 		$email  = Yii::app()->request->baseUrl . "/images/New/mail.png";
 		$attach = Yii::app()->request->baseUrl . "/images/New/attachment.png";

 		echo "<img id='quote_edit_"  .$data['model']['id']."' title='Edit this quote'   src='$edit' />";
 		echo "<img id='quote_attach_".$data['model']['id']."' title='Attach a file'     src='$attach' />";
 		echo "<img id='quote_print_" .$data['model']['id']."' title='Print this quote'  src='$print' />";
 		echo "<img id='quote_email_" .$data['model']['id']."' title='Email this quote'  src='$email' />";
 		echo "<img id='quote_trash_" .$data['model']['id']."' title='Delete this quote' src='$trash' />";
 		

 		$q  = $data['model']; 
 		$cu = $data['customer'];
 		$co = $data['contact'];

 	?>
</div>

	<!-- ################################################################################################################################################################  -->
	<div id='section_CustomerContact'>
		<div class='quote_section_heading_View'>
			<span>Customer Information</span>
		</div>
			
		<div class='my_container'>
			<div id='heading_container' style='display: none;'>
				<span id='span_SelectCustomer' style='display: none;'> Select customer  <select name='Customer[select]' id='Customer_select'> </select><span id='add_NewCustomer'>New</span> </span>
				<span id='span_SelectContact'  style='display: none;'> Select contact   <select name='Contact[select]'  id='Contact_select'>  </select><span id='add_NewContact'>New</span> </span>
			</div>

		    <div id="box1">
			    <input type='hidden' id='Customer_id' name='Customer[id]' value=''>
		     	<table>
			       		<tr>  <td>Customer Name</td>            <td><input type='text' id='Customer_name' name='Customer[name]' readonly='readonly' value='<?php echo $cu->name; ?>' > </td> </tr>
						<tr>  <td>Address1</td>                 <td><input type='text' id='Customer_address1' name='Customer[address1]' readonly='readonly' value='<?php echo $cu->address1; ?>'  > </td> </tr>
						<tr>  <td>Address2</td>                 <td><input type='text' id='Customer_address2' name='Customer[address2]' readonly='readonly' value='<?php echo $cu->address2; ?>'  > </td> </tr>
						<tr>  <td>City</td>                     <td><input type='text' id='Customer_city' name='Customer[city]' readonly='readonly'  value='<?php echo $cu->city; ?>' > </td> </tr>
						<tr>  <td>US State</td>                 <td><input type='text' id='Customer_state_id' name='Customer[state_id]' readonly='readonly'  value='<?php echo $cu->state->long_name; ?>' > </td> </tr>
						<tr>  <td>Country</td>                  <td><input type='text' id='Customer_country_id' name='Customer[country_id]' readonly='readonly'  value='<?php echo $cu->country->long_name; ?>' > </td> </tr>
						<tr>  <td>Zip/Postal Code</td>          <td><input type='text' id='Customer_zip' name='Customer[zip]' readonly='readonly' value='<?php echo $cu->zip; ?>'  > </td> </tr>
						<tr>  <td>Region</td>                   <td><input type='text' id='Customer_region_id' name='Customer[region_id]' readonly='readonly' value='<?php echo $cu->region->name; ?>'  > </td> </tr>
						<tr>  <td>Customer Type</td>            <td><input type='text' id='Customer_customer_type_id' name='Customer[customer_type_id]' readonly='readonly' value='<?php echo $cu->customerType->name; ?>' > </td> </tr>
						<tr>  <td>Territory</td>                <td><input type='text' id='Customer_territory_id' name='Customer[territory_id]' readonly='readonly' value='<?php echo $cu->territory->name; ?>'  > </td> </tr>
						<tr>  <td>Inside Salesperson</td>       <td><input type='text' id='Customer_inside_salesperson_id' name='Customer[inside_salesperson_id]' readonly='readonly' value='<?php echo $cu->insideSalesperson->fullname; ?>'  > </td> </tr>
						<tr>  <td>Outside Salesperson</td>      <td><input type='text' id='Customer_outside_salesperson_id' name='Customer[outside_salesperson_id]' readonly='readonly'  value='<?php echo $cu->outsideSalesperson->fullname; ?>' > </td> </tr>
		      	</table>
		    </div>

		    <div id="box2">
		       	<table>
		                <tr>  <td>Vertical Market</td>          <td><input type='text' id='Customer_vertical_market' name='Customer[vertical_market]' readonly='readonly'  value='<?php echo $cu->vertical_market; ?>' > </td> </tr>
		                <tr>  <td>Parent</td>                   <td><input type='text' id='Customer_parent_id' name='Customer[parent_id]' readonly='readonly'  value='<?php echo $cu->parent->name; ?>' > </td> </tr>
		                <tr>  <td>Company Link</td>             <td><input type='text' id='Customer_company_link' name='Customer[company_link]' readonly='readonly'  value='<?php echo $cu->company_link; ?>' > </td> </tr>
		                <tr>  <td>SYSPRO Account #</td>         <td><input type='text' id='Customer_syspro_account_code' name='Customer[syspro_account_code]' readonly='readonly'  value='<?php echo $cu->syspro_account_code; ?>' > </td> </tr>
		                <tr>  <td>Xmas List</td>                <td><input type='text' id='Customer_xmas_list' name='Customer[xmas_list]' readonly='readonly' value='<?php echo $cu->xmas_list; ?>'  > </td> </tr>
		                <tr>  <td>Candy List</td>               <td><input type='text' id='Customer_candy_list' name='Customer[candy_list]' readonly='readonly'  value='<?php echo $cu->candy_list; ?>' > </td> </tr>
		                <tr>  <td>Strategic</td>                <td><input type='text' id='Customer_strategic' name='Customer[strategic]' readonly='readonly' value='<?php echo $cu->strategic; ?>'  > </td> </tr>
		                <tr>  <td>Tier</td>                     <td><input type='text' id='Customer_tier_id' name='Customer[tier_id]' readonly='readonly' value='<?php echo $cu->tier->name; ?>'  > </td> </tr>
		      	</table>
		    </div>

		    <div id="box3">
		    	<input type='hidden' id='Contact_id' name='Contact[id]' value=''>  
			    <table>
				        <tr>  <td>Contact First Name</td>       <td><input type='text' id='Contact_first_name' name='Contact[first_name]' readonly='readonly'  value='<?php echo $co->first_name; ?>' > </td> </tr>
				        <tr>  <td>Last Name</td>                <td><input type='text' id='Contact_last_name' name='Contact[last_name]' readonly='readonly'   value='<?php echo $co->last_name; ?>' > </td> </tr>
				        <tr>  <td>Email</td>                    <td><input type='text' id='Contact_email' name='Contact[email]' readonly='readonly'   value='<?php echo $co->email; ?>' > </td> </tr>
				        <tr>  <td>Title</td>                    <td><input type='text' id='Contact_title' name='Contact[title]' readonly='readonly'  value='<?php echo $co->title; ?>'  > </td> </tr>
				        <tr>  <td>Phone1</td>                   <td><input type='text' id='Contact_phone1' name='Contact[phone1]' readonly='readonly'   value='<?php echo $co->phone1; ?>' > </td> </tr>
				        <tr>  <td>Phone2</td>                   <td><input type='text' id='Contact_phone2' name='Contact[phone2]' readonly='readonly'   value='<?php echo $co->phone2; ?>' > </td> </tr>
				        <tr>  <td>Address1</td>                 <td><input type='text' id='Contact_address1' name='Contact[address1]' readonly='readonly'  value='<?php echo $co->address1; ?>'  > </td> </tr>
				        <tr>  <td>Address2</td>                 <td><input type='text' id='Contact_address2' name='Contact[address2]' readonly='readonly'   value='<?php echo $co->address2; ?>' > </td> </tr>
				        <tr>  <td>City</td>                     <td><input type='text' id='Contact_city' name='Contact[city]' readonly='readonly'   value='<?php echo $co->city; ?>' > </td> </tr>
				        <tr>  <td>State</td>                    <td><input type='text' id='Contact_state_id' name='Contact[state_id]' readonly='readonly'  value='<?php echo $co->state->long_name; ?>'  > </td> </tr>
				        <tr>  <td>Zip/Postal Code</td>          <td><input type='text' id='Contact_zip' name='Contact[zip]' readonly='readonly'   value='<?php echo $co->zip; ?>' > </td> </tr>
				        <tr>  <td>Country</td>                  <td><input type='text' id='Contact_country_id' name='Contact[country_id]' readonly='readonly'  value='<?php echo $co->country->long_name; ?>'  > </td> </tr>
			    </table>
		    </div>
		    <span style='padding-left: 50px; font-weight: bold;'>Contact Source: </span><span style='background-color: #E6E6E6; font-size: .8em; font-weight: bold; color: black; border: 1px solid lightgray; padding: 3px;'><?php echo $q->source->name; ?></span>
		</div>
	</div>

	<!-- ################################################################################################################################################################  -->
	<div id='section_TermsConditions'>

		<div class='quote_section_heading_View'>
			<span>Quote Terms</span>
		</div>

		<div  class='my_container'>
			
			<div id="box5" style='border: 0px solid green; width: 45%; margin: 5px;'>
				<span class='terms'>Terms & Conditions</span><textarea rows="4" cols="50" name="quote_Terms" id="quote_Terms" readonly='readonly'><?php echo $q->terms_conditions; ?></textarea>
			</div>

			<div id="box6" style='border: 0px solid blue; width: 45%; margin: 5px'>
				<span class='terms'>Customer Ackowledgment<textarea rows="4" cols="50" name="quote_CustAck" id="quote_CustAck" readonly='readonly'><?php echo $q->customer_acknowledgment; ?></textarea>
			</div>

			<div id="box7" style='border: 0px solid orange; width: 45%; margin: 5px;'>
				<span class='terms'>Risl<textarea rows="4" cols="50" name="quote_RISL" id="quote_RISL" readonly='readonly' ><?php echo $q->risl; ?></textarea>
			</div>

			<div id="box8" style='border: 0px solid red; width: 45%; margin: 5px;'>
				<span class='terms'>Manufacturing Lead Time<textarea rows="4" cols="50" name="quote_MfgLeadTime" id="quote_MfgLeadTime" readonly='readonly' ><?php echo $q->manufacturing_lead_time; ?></textarea>
			</div>
			
			<div id="box9" style='border: 0px solid cyan; width: 95%; margin: 5px;'>
				<span class='terms'>Additional Notes<textarea rows="4" cols="100" name="quote_Notes" id="quote_Notes" readonly='readonly' ><?php echo $q->additional_notes; ?></textarea>
			</div>

		</div>
	</div>

	<!-- ################################################################################################################################################################  -->
	<div id='section_Parts'>
		
		<div >
			<div class='quote_section_heading_View'>
				<span>Inventory Items</span>
			</div>

			<div  class='my_container'>

				<div id="box4" style='margin-top: 30px;'>
					<div style='margin: 10px 0px 50px 100px; '>
						<table id='table_CurrentParts' style='width: 700px;border: 1px solid gray;margin-top: 5px;'>
						<thead>
							<tr>
								<th></th>
								<th>Part Number</th>
								<th>Manufacturer</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
								<?php
									foreach( $data['items'] as $i ) {
										echo '<tr>';
										echo '<td>';
										echo '<td>' . $i['part_no'] . '</td>';
										echo '<td>' . $i['manufacturer'] . '</td>';
										echo '<td>' . $i['qty'] . '</td>';
										echo '<td>' . $i['price'] . '</td>';
										echo '<td>' . $i['total'] . '</td>';
										echo '</tr>';
									}
								?>
						</tbody>
						</table>
					</div>
				</div>  <!--  box4  -->
			</div>
		</div>
	</div>


	<div id='div_ActionButtons'> <input id='button_Home' type='button' value='Home'> </div>


<!--  fini --> 