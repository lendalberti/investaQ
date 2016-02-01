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
	/*display: none;*/
	padding-left: 10px;
}

#section_PartsLookup {
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

span.terms {
	font-variant: small-caps;
	color: black;
}

span.volume {
	font-size: .8em;
	color: blue;
}

</style>

<script>

	$(document).ready(function() {

		

	});

</script>

<div style='height: 100px; border: 0px solid gray;'>
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>Viewing Stock Quote No.</div>
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'><?php echo $data['model']->quote_no; ?> </div>
</div>


<form id='quoteForm' name='quoteForm' method='post'>

	<!-- ################################################################################################################################################################  -->
	<div id='section_CustomerContact'>
		<div class='quote_section_heading'>
			<span style='padding-left: 350px;'>Customer Information</span>
		</div>
			
		<div class='my_container'>
			<div id='heading_container' style='display: none;'>
				<span id='span_SelectCustomer' style='display: none;'> Select customer  <select name='Customer[select]' id='Customer_select'> </select><span id='add_NewCustomer'>New</span> </span>
				<span id='span_SelectContact'  style='display: none;'> Select contact   <select name='Contact[select]'  id='Contact_select'>  </select><span id='add_NewContact'>New</span> </span>
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
		</div>
	</div>

	


	<!-- ################################################################################################################################################################  -->
	<div id='section_TermsConditions'>

		<div class='quote_section_heading'>
			<span style='padding-left: 350px;'>Quote Terms</span>
		</div>

		<div  class='my_container'>
			
			<div id="box5" style='border: 0px solid green; width: 45%; margin: 5px;'>
				<span class='terms'>Terms & Conditions</span><textarea rows="4" cols="60" name="quote_Terms" id="quote_Terms"></textarea>
			</div>

			<div id="box6" style='border: 0px solid blue; width: 45%; margin: 5px'>
				<span class='terms'>Customer Ackowledgment<textarea rows="4" cols="60" name="quote_CustAck" id="quote_CustAck"></textarea>
			</div>

			<div id="box7" style='border: 0px solid orange; width: 45%; margin: 5px;'>
				<span class='terms'>Risl<textarea rows="4" cols="60" name="quote_RISL" id="quote_RISL"></textarea>
			</div>

			<div id="box8" style='border: 0px solid red; width: 45%; margin: 5px;'>
				<span class='terms'>Manufacturing Lead Time<textarea rows="4" cols="60" name="quote_MfgLeadTime" id="quote_MfgLeadTime"></textarea>
			</div>
			
			<div id="box9" style='border: 0px solid cyan; width: 95%; margin: 5px;'>
				<span class='terms'>Additional Notes<textarea rows="4" cols="135" name="quote_Notes" id="quote_Notes"></textarea>
			</div>

		</div>

	</div>



	<!-- ################################################################################################################################################################  -->
	<div id='section_Parts'>

		<div class='quote_section_heading'>
			<span style='padding-left: 350px;'>Inventory Parts Lookup</span>
		</div>

		<div  class='my_container'>

			<div style='overflow: auto; border: 1px solid red; width: 97%;'>
				<?php

				    function fp($n) {
				        setlocale(LC_MONETARY, 'en_US');
				        $res = money_format("%6.2n", trim($n) );
				        return $res;
				    }

				    function fq($n) {
				        return $n=='' ? '0' : $n;
				    }

				    function calc($model, $key) {
				        $res = $model['qty_'.$key] * $model['price_'.$key];
				        return $res; //=='0' ? '--' : $res;
				    }

				    function subTotal($model) {
				        $total = 0;
				        foreach( ['1_24','25_99','100_499','500_999','1000_Plus'] as $key ) {
				            $total += calc($model,$key);
				        }
				        return $total;
				    }

					$customer_id = $data['model']->customer_id;

					$edit   = Yii::app()->request->baseUrl . "/images/edit_glyph_33x30.png"; 
			 		$delete = Yii::app()->request->baseUrl . "/images/delete_glyph.png";
			 		$pdf    = Yii::app()->request->baseUrl . "/images/pdf_32x32.png";

					$sql = "SELECT * FROM stock_items WHERE  quote_id = " . $data['model']->id;
					$command = Yii::app()->db->createCommand($sql);
					$results = $command->queryAll();

					foreach( $results as $key => $i ) { 
			 			echo "<table style='border: 1px solid blue; width: 100%;' class='items_table'>";
			 			// echo "<tr><thead>";
			 			// echo "<th>Part No.</th>";
			 			// echo "<th>Manufacturer</th>";
			 			// echo "<th>Supplier</th>";
			 			// echo "<th>Date Code</th>";
			 			// echo "<th>Qty</th>";
			 			// echo "<th>Price</th>";
			 			// echo "<th>Total</th>";
			 			// echo "</thead></tr>";

			 			echo "<td>".$i['part_no']."</td>";
			 			echo "<td>".$i['manufacturer']."</td>";
			 			echo "<td>".$i['supplier']."</td>";
			 			echo "<td>".$i['date_code']."</td>";
			 			echo "<td colspan='3'><table style='text-align: center;border: 1px solid orange;' id='table_quote_pricing' >";

			 			echo "<tr><thead><th style='text-align: right;'>Qty</th>";
			 			echo "<th style='text-align: right;'>Price</th>";
			 			echo "<th style='text-align: right;'>Total</th></thead></tr>";

			 			if ( fq($i['qty_1_24']) != '0' ) {
				 			echo "<tr>  <td style='text-align: right;'> ".fq($i['qty_1_24'])."</td>        <td style='text-align: right;'><span class='volume'>1-24</span>"      .fp($i['price_1_24'])."</td>      <td style='text-align: right;'> ".fp(calc($i,'1_24'))."</td>   </tr>"; 
				 		}

				 		if ( fq($i['qty_25_99']) != '0' ) {
				 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_25_99'])."</td>        <td style='text-align: right;'><span class='volume'>25-99</span>"     .fp($i['price_25_99'])."</td>     <td style='text-align: right;'> ".fp(calc($i,'25_99'))."</td>   </tr>"; 
				 		}

				 		if ( fq($i['qty_100_499']) != '0' ) {
				 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_100_499'])."</td>      <td style='text-align: right;'><span class='volume'>100-499</span>"   .fp($i['price_100_499'])."</td>   <td style='text-align: right;'> ".fp(calc($i,'100_499'))."</td>   </tr>"; 
				 		}

				 		if ( fq($i['qty_500_999']) != '0' ) {
				 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_500_999'])."</td>      <td style='text-align: right;'><span class='volume'>500-999</span>"   .fp($i['price_500_999'])."</td>   <td style='text-align: right;'> ".fp(calc($i,'500_999'))."</td>   </tr>"; 
				 		}

				 		if ( fq($i['qty_1000_Plus']) != '0' ) {
				 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_1000_Plus'])."</td>    <td style='text-align: right;'><span class='volume'>1000+</span>"     .fp($i['price_1000_Plus'])."</td> <td style='text-align: right;'> ".fp(calc($i,'1000_Plus'))."</td>   </tr>"; 
				 		}

						if ( fq($i['qty_Base']) != '0' ) {
				 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_Base'])."</td>    <td style='text-align: right;'><span class='volume'>Base</span>"     .fp($i['price_Base'])."</td> <td style='text-align: right;'> ".fp(calc($i,'Base'))."</td>   </tr>"; 
				 		}

						if ( fq($i['qty_Custom']) != '0' ) {
				 			echo "<tr> <td style='text-align: right;'> ".fq($i['qty_Custom'])."</td>    <td style='text-align: right;'><span class='volume'>Custom</span>"     .fp($i['price_Custom'])."</td> <td style='text-align: right;'> ".fp(calc($i,'Custom'))."</td>   </tr>"; 
				 		}
						
						echo "</td></table></table>";
				 	}
			 	?>

			</div>

			<div id="box4">
				<!-- <table id='quote_parts'>
						<tr>  
							<td style='text-align: center;' colspan='2'>Lookup by:
									 <select id="parts_SearchBy">
						                  <option value=""></option>
						                  <option value="1" selected>Part Number</option>
						                  
						            </select>     
				            
				            	<input id="parts_Searchfield" class="parts_Searchfield" type="text"  />  
						   	    <input id="parts_Searchbutton" class="parts_Searchbutton" type="button" value="Find" /><span> Test part no. AD5555CRUZ</span>
					   	    </td>
				   	    </tr>
				</table> -->

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

<div class='print' id="form_PartPricing" style='display: none'> pricing details content goes here </div>

<!--  fini --> 