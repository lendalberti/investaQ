<input type='hidden' id='base_url' value='<?php echo Yii::app()->baseUrl; ?>'>
<input type='hidden' id='Customer_id' value=''>
<input type='hidden' id='Contact_id' value=''>

<div class="form">

	<table id='pre_quote_table'>
		<tr>
			<td>
				<div id='quote_customer_container'>
					<table id='quote_customer'>
					<caption>Customer</caption>
						<tr>  <td style='text-align: center;' colspan='2'><span class='select_existing'>Select existing customer</span>  
								<select id='customer_select'>

										<?php
											echo "<option value='0'></option>";
											foreach( $data['customers'] as $c ) {
												echo "<option value='".$c->id."'>".$c->name. ', ' . $c->address1 ."</option>";
											}
										?>

								</select><span style='padding-left: 10px'><a href='#' id='createNewCustomer' >New</a></span>
							 </td> 
						</tr>

<!-- Required: name, address1, city, country_id, region_id, customer_type_id, territory_id -->


						<tr>  <td><span class='required'> * </span>Name</td>       			<td><input type='text' id='Customer_name' name='Customer[name]'></td> </tr>
						<tr>  <td><span class='required'> * </span>Address 1</td>   			<td><input type='text' id='Customer_address1' name='Customer[address1]'></td></tr>
						<tr>  <td>Address 2</td>   			<td><input type='text' id='Customer_address2' name='Customer[address2]'></td></tr>
						<!-- <tr>  <td>Address2</td>   			<td><input type='text' id='Customer_address2' name='Customer[address2]'></td> </tr> -->
						<tr>  <td><span class='required'> * </span>City</td>       			<td><input type='text' id='Customer_city' name='Customer[city]'></td> </tr>

						<tr>  <td>US State</td>       		<td>  <select name='Customer[state_id]' id='Customer_state_id'>
																	<?php
																		echo "<option value='0'></option>";
																		foreach( $data['us_states'] as $c ) {
																			echo "<option value='".$c->id."'>".$c->long_name."</option>";
																		}
																	?>
																</select><span style='padding-left: 10px'></span>  </td> </tr>

						<tr>  <td><span class='required'> * </span>Country</td>       		<td>  <select name='Customer[country_id]' id='Customer_country_id'>
																	<?php
																		echo "<option value='0'></option>";
																		foreach( $data['countries'] as $c ) {
																			echo "<option value='".$c->id."'>".$c->long_name."</option>";
																		}
																	?>
																</select><span style='padding-left: 10px'></span>  </td> </tr>

						<tr>  <td>Zip/Postal Code</td>      <td><input type='text' id='Customer_zip' name='Customer[zip]'></td> </tr>

						<tr>  <td><span class='required'> * </span>Region</td>       		<td>  <select name='Customer[region_id]' id='Customer_region_id'>
																	<?php
																		echo "<option value='0'></option>";
																		foreach( $data['regions'] as $c ) {
																			echo "<option value='".$c->id."'>".$c->name."</option>";
																		}
																	?>
																</select><span style='padding-left: 10px'></span>  </td> </tr>

						<tr>  <td><span class='required'> * </span>Territory</td>       		<td>  <select name='Customer[territory_id]' id='Customer_territory_id'>
																	<?php
																		echo "<option value='0'></option>";
																		foreach( $data['territories'] as $c ) {
																			echo "<option value='".$c->id."'>".$c->name."</option>";
																		}
																	?>
																</select><span style='padding-left: 10px'></span>  </td> </tr>

						<tr>  <td><span class='required'> * </span>Customer Type</td>       		<td>  <select name='Customer[customer_type_id]' id='Customer_customer_type_id'>
																	<?php
																		echo "<option value='0'></option>";
																		foreach( $data['types'] as $c ) {
																			echo "<option value='".$c->id."'>".$c->name."</option>";
																		}
																	?>
																</select><span style='padding-left: 10px'></span>  </td> </tr>


						<tr>  <td>Vertical Market</td>      <td><input type='text' id='Customer_vertical_market' name='Customer[vertical_market]'></td> </tr>
						<tr>  <td>Parent</td>       		<td><input type='text' id='Customer_parent_id' name='Customer[parent_id]'></td> </tr>
						<tr>  <td>Company Link</td>       	<td><input type='text' id='Customer_company_link' name='Customer[company_link]'></td> </tr>
						<tr>  <td>SYSPRO Acount No.</td>    <td><input type='text' id='Customer_syspro_account_code' name='Customer[syspro_account_code]'></td> </tr>

						<tr>  <td>Xmas List?</td>       	<td><input type='text' id='Customer_xmas_list' name='Customer[xmas_list]'></td> </tr>
						<tr>  <td>Candy List?</td>       	<td><input type='text' id='Customer_candy_list' name='Customer[candy_list]'></td> </tr>
						<tr>  <td>Strategic</td>       		<td><input type='text' id='Customer_strategic' name='Customer[strategic]'></td> </tr>
						<tr>  <td>Tier</td>       			<td><input type='text' id='Customer_tier_id' name='Customer[tier_id]'></td> </tr>

						<tr>  <td>Inside Salesperson</td>   <td><input type='text' id='Customer_inside_salesperson_id' name='Customer[inside_salesperson_id]'></td> </tr>
						<tr>  <td>Outside Salesperson</td>  <td><input type='text' id='Customer_outside_salesperson_id' name='Customer[outside_salesperson_id]'></td> </tr>

					</table></div>
			</td>

			<td>
				<div id='quote_contact_container'>
					<table id='quote_contact'>
					<caption>Contact</caption>

<!-- Required contact fields:  first_name, last_name, title, email,  phone1      -->

						<tr>  <td style='text-align: center;' colspan='2'><span class='select_existing'>Select existing contact </span>
								<select id='contact_select'>

										<?php
											echo "<option value='0'></option>";
											foreach( $data['contacts'] as $c ) {
												echo "<option value='".$c->id."'>".$c->first_name. ' ' . $c->last_name ."</option>";
											}
										?>

								</select><span style='padding-left: 10px'><a href='#' id='createNewContact' >New</a></span>
							 </td> 
						</tr>

						<tr>  <td><span class='required'> * </span>First Name</td>     <td><input type='text' id='Contact_first_name' name='Contact[first_name]'></td> </tr>
						<tr>  <td><span class='required'> * </span>Last Name</td>      <td><input type='text' id='Contact_last_name'  name='Contact[last_name]'></td> </tr>
						<tr>  <td><span class='required'> * </span>Title</td>          <td><input type='text' id='Contact_title'      name='Contact[title]'></td> </tr>

						<tr>  <td><span class='required'> * </span>Email</td>          <td><input type='text' id='Contact_email'  name='Contact[email]'></td> </tr>
						<tr>  <td><span class='required'> * </span>Phone1</td>          <td><input type='text' id='Contact_phone1' name='Contact[phone1]'></td> </tr>
						<tr>  <td>Phone2</td>          <td><input type='text' id='Contact_phone2' name='Contact[phone2]'></td> </tr>

						<tr>  <td>Address1</td>          <td><input type='text' id='Contact_address1' name='Contact[address1]'></td> </tr>
						<tr>  <td>Address2</td>          <td><input type='text' id='Contact_address2' name='Contact[address2]'></td> </tr>

						<tr>  <td>City</td>          <td><input type='text' id='Contact_city' name='Contact[city]'></td> </tr>
						<tr>  <td>State</td>          <td><input type='text' id='Contact_state_id' name='Contact[state_id]'></td> </tr>
						<tr>  <td>Zip</td>          <td><input type='text' id='Contact_zip' name='Contact[zip]'></td> </tr>
						<tr>  <td>Country</td>          <td><input type='text' id='Contact_country_id' name='Contact[country_id]'></td> </tr>
					</table></div>
			</td>
		</tr>
	</table>

	<input type='button' id='button_continue' value='Continue'>

</div>

<div class='form_parts' style='display: none;'>

	<table id='quote_parts'>
		<caption>Inventory Parts Lookup</caption>
		<tr>  
			<td style='text-align: center;' colspan='2'>Lookup by:
					 <select id="searchBy">
		                  <option value=""></option>
		                  <option value="1" selected>Part Number</option>
		                  <!-- <option value="3">Manufacturer</option> -->
		            </select>     
            
            	<input id="searchfield" class="searchfield" type="text"  />  
		   	    <input id="searchbutton" class="searchbutton" type="button" value="Find" />
	   	    </td>
   	    </tr>
	</table>

<!-- 

<div class='no-print'>
	<div style='height: 100px; border: 0px solid red; width: 50%'>

				<div style='float: left; padding: 5px 0px 0px 50px;'>
					<form class="searchform">
						<label for="searchBy">Lookup by:</label><br />
			            <select id="searchBy">
			                  <option value=""></option>
			                  <option value="1" selected>Part Number</option>
			                  <!- - <option value="3">Manufacturer</option> - ->
			            </select>     
				   	    <input id="searchfield" class="searchfield" type="text"  />  
				   	    <input id="searchbutton" class="searchbutton" type="button" value="Go" />
				   	    <br />
				   	    
					</form>
				</div>
				
	</div>
	<span style='clear: both'></span>
 -->
	<?php
		if ( $data['item'] != 'Search for part...' && $data['item'] != '' ) { 
			echo "<h2>Search results for ".$data['search_by'].": <span style=' border: 1px solid black; padding: 3px 8px 3px 8px; font-size:.8em; color: black; background: lightyellow'> ". 
				urldecode($data['item']) . " </span><span id='nobid'><span class='nobid_text'>Part not found; click <span id='nobid_link'>here</span> to NoBid.</span></span></h2>";
		}

	?>


		<table id='results_table'>
			<thead>
				<tr>
					<th>Part Number</th>
					<th>Manufacturer</th>
					<th>Supplier</th>
					<th>Quantity<br />Available</th>

					<th>Price<br />1-24</th>
					<th>Price<br />25-99</th>
					<th>Price<br />100-499</th>
					<th>Price<br />500-999</th>
					<th>Price<br />1000+</th>

					<th>Base Price</th>
				</tr>
			</thead>

			<tfoot>
				
			</tfoot>

			<tbody> 

<!-- 
				< ?php 
						setlocale(LC_MONETARY, 'en_US.UTF-8');
						$i = 0;
						foreach( $data['parts'] as $p ) {   
							echo "<tr id='res_$i'>";
							echo "<td>". trim($p->part_number)   . "</td>";
							echo "<td>". trim($p->manufacturer)  . "</td>";
							echo "<td>". $p->supplier            . "</td>";
							echo "<td>". number_format($p->total_qty_for_part)  . "</td>";

							echo "<td>". money_format("%6.2n", trim($p->prices->p1_24)) . "</td>";
							echo "<td>". money_format("%6.2n", trim($p->prices->p25_99)) . "</td>";
							echo "<td>". money_format("%6.2n", trim($p->prices->p100_499)) . "</td>";
							echo "<td>". money_format("%6.2n", trim($p->prices->p500_999)) . "</td>";
							echo "<td>". money_format("%6.2n", trim($p->prices->over_1000)) . "</td>";
							echo "<td>". money_format("%6.2n", trim($p->distributor_price)) . "</td>"; 
							echo "</tr>";

							$i++;
						}
						
					?>
 -->
				

			</tbody>
		</table>















<!--


	<table id='quote_table'  style='border: 1px solid lightgray;'>
		<caption>Quote No. 20160118-0002</caption>
			<tr>
			<td>
				<table id='quote_customer' style='border: 0px solid red;'>

					<!- -	this should be relocated to different page 

						<tr>  <td>Select existing customer quote</td>   
								<td><select>
										<option>20160118-0002</option>
										<option>20160114-0021</option>
										<option>20160103-0015</option>
										<option>20160117-0005</option>
									</select><span style='padding-left: 10px'><a href='#' >New</a></span>
								</td> 
					</tr> - ->

					<tr>  <td>Part No.</td>   <td><input type='text'></td></tr>
					<tr>  <td>Manufacturer</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Supplier</td>   <td><input type='text'></td> </tr>
					<tr>  <td>MPQ</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Carrier Type</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Total Quantity</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Europe RoHS</td>   <td><input type='text'></td> </tr>
					<tr>  <td>China RoHS</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Lead-Free Status</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Tech Desc</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Drawing</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Sell Part?</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Distributor Price</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Price 1-24</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Price 25-99</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Price 100-499</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Price 500-999</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Price 1000+</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Build</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Part No.</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Mfg ID</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Mfg</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Desc</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE RoHS</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE LifeCycle</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Com ID</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Product Line</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Family</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Generic</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE LTB Date</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Cage Code</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Taxonomy Path</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Eccn</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Rad Hard</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Htsusa</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Schedule B</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE SubCategory</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Basic Pkg Type</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Package name</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Package Desc</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Lead Shape</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Pin Count</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Package Length</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Package Width</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Package Height</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Seated Plane Height</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Pin Pitch</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Package Material</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Min Operating Temp</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Max Operating Temp</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Supplier Temp Grade</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Packaging</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Lead-Free Status</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE RoHS</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE China RoHS</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Datasheet</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Material Declaration</td>   <td><input type='text'></td> </tr>
					<tr>  <td>SE Image URL</td>   <td><input type='text'></td> </tr>
					
				</table>
			</td>

			<td>
				<table id='quote_contact' style='border: 0px solid red;'>
					<tr>  <td>First Name</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Last Name</td>   <td><input type='text'></td></tr>
					<tr>  <td>Title</td>   <td><input type='text'></td> </tr>
					<tr>  <td>Phone</td>   <td><input type='text'></td> </tr>
				</table>
			</td>
		</tr>

	</table>

-->


</div>