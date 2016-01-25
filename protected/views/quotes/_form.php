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
	margin-left: 30px;
	width: 28%;
	padding-right: 0px;
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


</style>


<div class='quote_section_heading'>
	<span class='show_hide' style='display: none;'>&minus;</span>
	<span style='padding-left: 350px;'>Customer Information</span>
</div>

<div style='padding: 10px 0px 10px 0px;'>
	<span style='padding-left: 50px;'><span class='required'> * </span>Contact Source
		<select name='Quote[source_id]' id='Quote_source_id'>
			<?php
				echo "<option value='0'></option>";
				foreach( $data['sources'] as $c ) {
					echo "<option value='".$c->id."'>".$c->name."</option>";
				}
			?>
		</select>
	</span>
	<span style='padding-left: 120px;'><input type='text' name='Search[typeahead]' id='search_typeahead' size='40' placeholder='Search for...'/> </span>
</div>


<div class='my_container'>
	<div id='heading_container'>
		<div id='customer_heading'
			<span id='customer_span_text'> Customer </span> 
			<span id='customer_span_select' style='display: none;'> Select customer &nbsp;
				<select name='Customer[select]' id='Customer_select'>
					<?php
						echo "<option value='0'></option>";
						foreach( $results as $c ) {
							echo "<option value='".$c->id."'>".$c->name."</option>";
						}
					?>
				</select>
			</span>
		</div>
		<div id='contact_heading'>
			<span id='contact_span_text'> Contact </span> 
			<span id='contact_span_select' style='display: none;' >Select contact &nbsp;
					<select name='Contact[select]' id='Contact_select'>
						<?php
							echo "<option value='0'></option>";
							foreach( $results as $c ) {
								echo "<option value='".$c->id."'>".$c->name."</option>";
							}
						?>
					</select>
			</span>
		</div>
	</div>

    <div id="box1">
     	<table>
       		<tr>  <td>Name</td>                     <td><input type='text' id='Customer_name' name='Customer[name]' readonly='readonly' > </td> </tr>
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
	    <table>
		        <tr>  <td>First Name</td>               <td><input type='text' id='Contact_first_name' name='Contact[first_name]' readonly='readonly' > </td> </tr>
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
</div>


<div style='padding: 20px;'>
	<input type='submit' id='button_continue' value='Continue'><span id='reset_form'>Reset Form</span>
</div>


<!--  fini -->