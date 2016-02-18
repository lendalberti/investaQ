<?php $this->layout = '//layouts/column1'; ?>


<div style='height: 100px; border: 0px solid gray;'>
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>Start a New<?php echo $data['quote_type']; ?>Quote</div>
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'> </div>
	<input type='hidden' id='form_QuoteID' name='form_QuoteID' value=''>
</div>


<form id='quoteAddForm' name='quoteAddForm' method='post'> 

	<div id="QuoteView_Tabs">

		<ul>
			<li><a href="#section_CustomerContact">Customer &amp; Contact Information</a></li>
		</ul>

		<div id='section_CustomerContact'>
			<span style='color: #555; font-size: 14px;'>Fields with <span class="required">*</span> are required.</span>

			<div id='heading_container'>
				<span><input type='text' name='Search[typeahead]' id='search_typeahead' size='40' placeholder='Search for...'/> </span>
				<span id='span_SelectCustomer' > Select customer  <select name='Customers[select]' id='Customers_select'> </select> </span> 
				<span id='span_SelectContact'  > Select contact   <select name='Contacts[select]'  id='Contacts_select'>  </select> </span>
			</div>

			<div class='my_container'>
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
							<tr>  <td colspan='2'><span  id='check_SameAsContact' class='checkbox_sameAddress'><input type='checkbox'>Use same address as contact </span> </td> </tr>
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
					        <tr>  <td colspan='2'><span id='check_SameAsCustomer' class='checkbox_sameAddress'><input type='checkbox' >Use same address as customer </span> </td> </tr>
				    </table>
				</div>

				<div style='width: 100%; border: 0px solid green; text-align: center;'>
					<span id='span_SelectSource'><span class='required'> * </span>Opportunity Source
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
		</div>

		<div id='div_ContinueReset' style='padding: 20px;'> 
			<input type='submit' value='Continue'> 
			<span id='cancel_Start'>Cancel</span> <span id='reset_form'>Reset Form</span> 
		</div>
	</div>    <!-- end of QuoteView_Tabs -->

</form>

<div class='print' id="form_PartPricing" style='display: none'> pricing details content goes here </div>

<!--  fini --> 