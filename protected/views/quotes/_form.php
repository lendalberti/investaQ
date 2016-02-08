<?php $this->layout = '//layouts/column1'; ?>


<style>

div.my_container {
	padding: 5px;
	border: 1px solid lightgray;
	height: 100%; 
	overflow: auto;
}

div.my_container > div {
	float: left;
	padding: 10px;
	width: 25%;
	margin: 2px;
}

div.my_container > div > table > tbody > tr > td {
	font-size: .8em;
}

div.my_container > div > table > tbody > tr > td > input {
	background-color: #f0f0f0;
	font-family: Courier;
	font-weight: bold;
}

div.my_container > div > table > tbody > tr > td:nth-child(odd) {
	text-align: right;
	font-weight: bold;
}

#box1 {
   border: 0px solid orange;
   width: 31%;
}

#box2 {
	border: 0px solid green;
	width: 30%;
}

#box3 {
	border-left: 1px solid lightgray; 	
	/*border: 1px solid blue;*/
	margin-left: 20px;
	width: 28%;
	padding-right: 0px;
}

#box4 {
	border: 0px solid lightgreen;
	width: 97%;
	/*display: none;*/
}

#heading_container {
	border: 0px solid purple;
	text-align: center; 
	float: left;  
	width: 100%; 
	font-weight: bold; 
}

#customer_heading {
	border: 0px solid green;
	float: left;
	margin-left: 300px;
}

#contact_heading {
	border: 0px solid blue;
	float: right;
	margin-right: 100px;
}

#add_NewContact,
#add_NewCustomer {
	text-decoration: underline;
	color: #2C6371;
	padding-left: 10px;
	font-variant: small-caps;
}

#add_NewContact:hover,
#add_NewCustomer:hover {
	cursor: pointer;
}

#selection_container {
	padding: 10px 0px 10px 0px;
}

span.open_close {
	display: none;
	padding-left: 10px;
}

#section_PartsLookup,
#section_TermsConditions {
	display: none;
}

span.open_close:hover {
	cursor: pointer;
}

#results_table > tbody > tr:hover {
	background-color: lightyellow;
	cursor: pointer;
}

#results_table > tbody > tr > td {
	text-align: center;
}

#section_CustomerContact {
    margin-top: 70px;
}

#div_SubmitDone {
	margin-top: 20px;
	display: none;
}

#div_SubmitDone > input {
	background-color: lightgray;
    font-size: 1.2em;
}


</style>

<script>

	$(document).ready(function() {

		$(window).on('beforeunload', function(){
			return '';
		})

	});


</script>





<form id='quoteForm' name='quoteForm' method='post'>

	<!-- ################################################################################################################################################################  -->
	<div id='section_CustomerContact'>

		<div class='quote_section_heading'>
			<span class='open_close'>&minus;</span>
			<span style='padding-left: 350px;'>Customer Information</span>
		</div>

		<div id='selection_container'>
			<span style='padding-left: 300px;'><input type='text' name='Search[typeahead]' id='search_typeahead' size='40' placeholder='Search for...'/> </span>
			<!-- <span id='span_NewCustomer' class='span_links'>New customer</span>   <span id='span_NewContact' class='span_links'>New Contact</span> -->
		</div>
										
		<div class='my_container'>
			

<!--
			<div id='heading_container' style='display: none;'>
				<span id='span_SelectCustomer' style='display: none;'> Select customer  <select name='Customers[select]' id='Customers_select'> </select> </span> 
				<span id='span_SelectContact'  style='display: none;'> Select contact   <select name='Contacts[select]'  id='Contacts_select'>  </select> </span>
		    	<span id ='span_SelectSource' style='padding-left: 50px; font-weight: bold;'><span class='required'> * </span>Source
					<select name='Quotes[source_id]' id='Quotes_source_id'>
						< ?php
							echo "<option value='0'></option>";
							foreach( $data['sources'] as $c ) {
								echo "<option value='".$c->id."'>".$c->name."</option>";
							}
						?>
					</select>
				</span>
			</div>
-->

			<div id='heading_container' style='border: 0px solid red;'>

				<div id='heading_container_left' style='display: none; float: left; margin-left: 200px; border: 0px solid orange;'>
					<span id='span_SelectCustomer' > Select customer  <select name='Customers[select]' id='Customers_select'> </select> </span> 
					<span id='span_SelectContact'  > Select contact   <select name='Contacts[select]'  id='Contacts_select'>  </select> </span>
				</div>

				<div id='heading_container_right' style='float: left; border: 0px solid blue;'>
					<span id ='span_SelectSource' style='padding-left: 50px; font-weight: bold;'><span class='required'> * </span>Source
						<select name='Quotes[source_id]' id='Quotes_source_id'>
							<?php
								echo "<option value='0'></option>";
								foreach( $data['sources'] as $c ) {
									echo "<option value='".$c->id."'>".$c->name."</option>";
								}
							?>
						</select>
					</span>
				</div>



			</div>























		    <div id="box1">
			    <input type='hidden' id='Customers_id' name='Customers[id]' value=''>
			    <span id='span_NewCustomer' class='span_links' title='Create a new customer'>New customer</span>
		     	<table>
			       		<tr>  <td><span class='required'> * </span>Customer Name</td>            <td><input type='text' id='Customers_name' name='Customers[name]' readonly='readonly' > </td> </tr>
						<tr>  <td><span class='required'> * </span>Address1</td>                 <td><input type='text' id='Customers_address1' name='Customers[address1]' readonly='readonly' > </td> </tr>
						<tr>  <td>Address2</td>                 <td><input type='text' id='Customers_address2' name='Customers[address2]' readonly='readonly' > </td> </tr>
						<tr>  <td><span class='required'> * </span>City</td>                     <td><input type='text' id='Customers_city' name='Customers[city]' readonly='readonly' > </td> </tr>
						<tr>  <td>US State</td>                 <td><input type='text' id='Customers_state_id' name='Customers[state_id]' readonly='readonly' > </td> </tr>
						<tr>  <td><span class='required'> * </span>Country</td>                  <td><input type='text' id='Customers_country_id' name='Customers[country_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Zip/Postal Code</td>          <td><input type='text' id='Customers_zip' name='Customers[zip]' readonly='readonly' > </td> </tr>
						<tr>  <td>Region</td>                   <td><input type='text' id='Customers_region_id' name='Customers[region_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Customer Type</td>            <td><input type='text' id='Customers_customer_type_id' name='Customers[customer_type_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Territory</td>                <td><input type='text' id='Customers_territory_id' name='Customers[territory_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Inside Salesperson</td>       <td><input type='text' id='Customers_inside_salesperson_id' name='Customers[inside_salesperson_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Outside Salesperson</td>      <td><input type='text' id='Customers_outside_salesperson_id' name='Customers[outside_salesperson_id]' readonly='readonly' > </td> </tr>
		      	</table>
		    </div>

		    <div id="box2">
		       	<table>
		                <tr>  <td>Vertical Market</td>          <td><input type='text' id='Customers_vertical_market' name='Customers[vertical_market]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Parent</td>                   <td><input type='text' id='Customers_parent_id' name='Customers[parent_id]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Company Link</td>             <td><input type='text' id='Customers_company_link' name='Customers[company_link]' readonly='readonly' > </td> </tr>
		                <tr>  <td>SYSPRO Account #</td>         <td><input type='text' id='Customers_syspro_account_code' name='Customers[syspro_account_code]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Xmas List</td>                <td><input type='text' id='Customers_xmas_list' name='Customers[xmas_list]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Candy List</td>               <td><input type='text' id='Customers_candy_list' name='Customers[candy_list]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Strategic</td>                <td><input type='text' id='Customers_strategic' name='Customers[strategic]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Tier</td>                     <td><input type='text' id='Customers_tier_id' name='Customers[tier_id]' readonly='readonly' > </td> </tr>
		      	</table>
		    </div>

		    <div id="box3">
		    	<input type='hidden' id='Contacts_id' name='Contacts[id]' value=''>  
		    	<span id='span_NewContact' class='span_links' title='Create a new contact' >New Contact</span> 
			    <table>
				        <tr>  <td><span class='required'> * </span>Contact First Name</td>       <td><input type='text' id='Contacts_first_name' name='Contacts[first_name]' readonly='readonly' > </td> </tr>
				        <tr>  <td><span class='required'> * </span>Last Name</td>                <td><input type='text' id='Contacts_last_name' name='Contacts[last_name]' readonly='readonly' > </td> </tr>
				        <tr>  <td><span class='required'> * </span>Email</td>                    <td><input type='text' id='Contacts_email' name='Contacts[email]' readonly='readonly' > </td> </tr>
				        <tr>  <td><span class='required'> * </span>Title</td>                    <td><input type='text' id='Contacts_title' name='Contacts[title]' readonly='readonly' > </td> </tr>
				        <tr>  <td><span class='required'> * </span>Phone1</td>                   <td><input type='text' id='Contacts_phone1' name='Contacts[phone1]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Phone2</td>                   <td><input type='text' id='Contacts_phone2' name='Contacts[phone2]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Address1</td>                 <td><input type='text' id='Contacts_address1' name='Contacts[address1]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Address2</td>                 <td><input type='text' id='Contacts_address2' name='Contacts[address2]' readonly='readonly' > </td> </tr>
				        <tr>  <td>City</td>                     <td><input type='text' id='Contacts_city' name='Contacts[city]' readonly='readonly' > </td> </tr>
				        <tr>  <td>State</td>                    <td><input type='text' id='Contacts_state_id' name='Contacts[state_id]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Zip/Postal Code</td>          <td><input type='text' id='Contacts_zip' name='Contacts[zip]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Country</td>                  <td><input type='text' id='Contacts_country_id' name='Contacts[country_id]' readonly='readonly' > </td> </tr>
			    </table>
		    </div>

		   <!--  <div style='margin-bottom: 20px;'>
		    	<span style='padding-left: 0px; font-weight: bold;'><span class='required'> * </span>Contact Source
					<select name='Quotes[source_id]' id='Quotes_source_id'>
						< ?php
							echo "<option value='0'></option>";
							foreach( $data['sources'] as $c ) {
								echo "<option value='".$c->id."'>".$c->name."</option>";
							}
						?>
					</select>
				</span>
			</div> -->


		</div>
	</div>

	<div id='div_ContinueReset' style='padding: 20px;'> <input type='submit' value='Continue'> <span id='reset_form'>Reset Form</span> </div>


	<!-- ################################################################################################################################################################  -->
	<div id='section_PartsLookup'>

		<div class='quote_section_heading'>
			<!-- <span class='open_close'>&minus;</span> -->
			<span style='padding-left: 350px;'>Inventory Parts Lookup</span>
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
								
						</tbody>
					</table>
				</div>

				<table id='quote_parts'>
						<tr>  
							<td style='text-align: center;' colspan='2'>Lookup by:
									 <select id="parts_SearchBy">
						                  <option value=""></option>
						                  <option value="1" selected>Part Number</option>
						                  <!-- <option value="3">Manufacturer</option> -->
						            </select>     
				            
				            	<input id="parts_Searchfield" class="parts_Searchfield" type="text"  />  
						   	    <input id="parts_Searchbutton" class="parts_Searchbutton" type="button" value="Find" />
						   	    <span id='ajax_loading_image' style='display: none;'>
						   	      	  <img src='<?php echo Yii::app()->baseUrl; ?>/images/ajax_loading.gif' width='48' height='48' title='Waiting to load...'>
						   	    </span>

					   	    </td>
				   	    </tr>
				</table>

				<table id='results_table'>
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

				</table>

			</div>  <!--  box4  -->
		</div>
	</div>



</form>


	<!-- ################################################################################################################################################################  -->
	<form id='quoteForm_Terms' name='quoteForm_Terms'  method='post'>

		<div id='section_TermsConditions'>
			<div class='quote_section_heading'>
				<span class='open_close'>&minus;</span>
				<span style='padding-left: 350px;'>Quote Terms</span>

				<input type='hidden' id='quoteForm_Terms_QuoteID' name='quoteForm_Terms_QuoteID' value=''>

			</div>

			<div  class='my_container'>
				<div id="box5" style='border: 0px solid green; width: 45%; margin: 5px;'>
					<span class='terms'>Terms & Conditions</span><textarea rows="4" cols="50" name="quote_Terms" id="quote_Terms"></textarea>
				</div>

				<div id="box6" style='border: 0px solid blue; width: 45%; margin: 5px'>
					<span class='terms'>Customer Ackowledgment<textarea rows="4" cols="50" name="quote_CustAck" id="quote_CustAck"></textarea>
				</div>

				<div id="box7" style='border: 0px solid orange; width: 45%; margin: 5px;'>
					<span class='terms'>Risl<textarea rows="4" cols="50" name="quote_RISL" id="quote_RISL"></textarea>
				</div>

				<div id="box8" style='border: 0px solid red; width: 45%; margin: 5px;'>
					<span class='terms'>Manufacturing Lead Time<textarea rows="4" cols="50" name="quote_MfgLeadTime" id="quote_MfgLeadTime"></textarea>
				</div>
				
				<div id="box9" style='border: 0px solid cyan; width: 95%; margin: 5px;'>
					<span class='terms'>Additional Notes<textarea rows="4" cols="100" name="quote_Notes" id="quote_Notes"></textarea>
				</div>
			</div>
		</div>

	    
		<!-- <div id='div_SubmitDone'> <input type='button' value='Save Quote'> </div> -->
		<div id='div_SubmitDone' > <input type='submit' value='Save Quote'> </div>

	</form>



	<div class='print' id="form_PartPricing" style='display: none'> pricing details content goes here </div>


<!--  fini --> 