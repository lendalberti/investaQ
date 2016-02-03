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
    margin-top: 50px;
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
			<br /><!-- <span style='margin-left: 400px;'>( test: Babbleblab, 44 Hazelcrest Junction)</span> -->
		</div>
										
		<div class='my_container'>
			<div id='heading_container' style='display: none;'>
				<span id='span_SelectCustomer' style='display: none;'> Select customer  <select name='Customer[select]' id='Customer_select'> </select> </span> 
				<span id='span_SelectContact'  style='display: none;'> Select contact   <select name='Contact[select]'  id='Contact_select'>  </select> </span>
			</div>

		    <div id="box1">
			    <input type='hidden' id='Customer_id' name='Customer[id]' value=''>
		     	<table>
			       		<tr>  <td>Customer Name</td>            <td><input type='text' id='Customer_name' name='Customer[name]' readonly='readonly' > </td> </tr>
						<tr>  <td>Address1</td>                 <td><input type='text' id='Customer_address1' name='Customer[address1]' readonly='readonly' > </td> </tr>
						<tr>  <td>Address2</td>                 <td><input type='text' id='Customer_address2' name='Customer[address2]' readonly='readonly' > </td> </tr>
						<tr>  <td>City</td>                     <td><input type='text' id='Customer_city' name='Customer[city]' readonly='readonly' > </td> </tr>
						<tr>  <td>US State</td>                 <td><input type='text' id='Customer_state_id' name='Customer[state_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Country</td>                  <td><input type='text' id='Customer_country_id' name='Customer[country_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Zip/Postal Code</td>          <td><input type='text' id='Customer_zip' name='Customer[zip]' readonly='readonly' > </td> </tr>
						<tr>  <td>Region</td>                   <td><input type='text' id='Customer_region_id' name='Customer[region_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Customer Type</td>            <td><input type='text' id='Customer_customer_type_id' name='Customer[customer_type_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Territory</td>                <td><input type='text' id='Customer_territory_id' name='Customer[territory_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Inside Salesperson</td>       <td><input type='text' id='Customer_inside_salesperson_id' name='Customer[inside_salesperson_id]' readonly='readonly' > </td> </tr>
						<tr>  <td>Outside Salesperson</td>      <td><input type='text' id='Customer_outside_salesperson_id' name='Customer[outside_salesperson_id]' readonly='readonly' > </td> </tr>
		      	</table>
		    </div>

		    <div id="box2">
		       	<table>
		                <tr>  <td>Vertical Market</td>          <td><input type='text' id='Customer_vertical_market' name='Customer[vertical_market]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Parent</td>                   <td><input type='text' id='Customer_parent_id' name='Customer[parent_id]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Company Link</td>             <td><input type='text' id='Customer_company_link' name='Customer[company_link]' readonly='readonly' > </td> </tr>
		                <tr>  <td>SYSPRO Account #</td>         <td><input type='text' id='Customer_syspro_account_code' name='Customer[syspro_account_code]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Xmas List</td>                <td><input type='text' id='Customer_xmas_list' name='Customer[xmas_list]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Candy List</td>               <td><input type='text' id='Customer_candy_list' name='Customer[candy_list]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Strategic</td>                <td><input type='text' id='Customer_strategic' name='Customer[strategic]' readonly='readonly' > </td> </tr>
		                <tr>  <td>Tier</td>                     <td><input type='text' id='Customer_tier_id' name='Customer[tier_id]' readonly='readonly' > </td> </tr>
		      	</table>
		    </div>

		    <div id="box3">
		    	<input type='hidden' id='Contact_id' name='Contact[id]' value=''>  
			    <table>
				        <tr>  <td>Contact First Name</td>       <td><input type='text' id='Contact_first_name' name='Contact[first_name]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Last Name</td>                <td><input type='text' id='Contact_last_name' name='Contact[last_name]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Email</td>                    <td><input type='text' id='Contact_email' name='Contact[email]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Title</td>                    <td><input type='text' id='Contact_title' name='Contact[title]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Phone1</td>                   <td><input type='text' id='Contact_phone1' name='Contact[phone1]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Phone2</td>                   <td><input type='text' id='Contact_phone2' name='Contact[phone2]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Address1</td>                 <td><input type='text' id='Contact_address1' name='Contact[address1]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Address2</td>                 <td><input type='text' id='Contact_address2' name='Contact[address2]' readonly='readonly' > </td> </tr>
				        <tr>  <td>City</td>                     <td><input type='text' id='Contact_city' name='Contact[city]' readonly='readonly' > </td> </tr>
				        <tr>  <td>State</td>                    <td><input type='text' id='Contact_state_id' name='Contact[state_id]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Zip/Postal Code</td>          <td><input type='text' id='Contact_zip' name='Contact[zip]' readonly='readonly' > </td> </tr>
				        <tr>  <td>Country</td>                  <td><input type='text' id='Contact_country_id' name='Contact[country_id]' readonly='readonly' > </td> </tr>
			    </table>
		    </div>

		    <div style='margin-bottom: 20px;'>
		    	<span style='padding-left: 0px; font-weight: bold;'><span class='required'> * </span>Contact Source
					<select name='Quote[source_id]' id='Quote_source_id'>
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
	</div>

	<div id='div_ContinueReset' style='padding: 20px;'> <input type='submit' value='Continue'> <span id='reset_form'>Reset Form</span> </div>


	<!-- ################################################################################################################################################################  -->
	<div id='section_PartsLookup'>

		<div class='quote_section_heading'>
			<!-- <span class='open_close'>&minus;</span> -->
			<span style='padding-left: 350px;'>Inventory Parts Lookup</span>
		</div>

		<div  class='my_container'>
			<div id='selectedParts' style='width: 100%;'></div>

			<div id="box4">
				<table id='quote_parts'>
						<tr>  
							<td style='text-align: center;' colspan='2'>Lookup by:
									 <select id="parts_SearchBy">
						                  <option value=""></option>
						                  <option value="1" selected>Part Number</option>
						                  <!-- <option value="3">Manufacturer</option> -->
						            </select>     
				            
				            	<input id="parts_Searchfield" class="parts_Searchfield" type="text"  />  
						   	    <input id="parts_Searchbutton" class="parts_Searchbutton" type="button" value="Find" /><span> Test part no. AD5555CRUZ</span>
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


	<!-- ################################################################################################################################################################  -->
	<div id='section_TermsConditions'>

		<div class='quote_section_heading'>
			<span class='open_close'>&minus;</span>
			<span style='padding-left: 350px;'>Quote Terms</span>
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

    
	<div id='div_SubmitDone'> <input type='button' value='Done'> </div>



</form>

<div class='print' id="form_PartPricing" style='display: none'> pricing details content goes here </div>

<!--  fini --> 