
<?php $this->layout = '//layouts/column1'; ?>


<!-- <form> -->
<form id="formCustomer" name="formCustomer" method="post">

	<input type='hidden' id='base_url' value='<?php echo Yii::app()->baseUrl; ?>'>
	<input type='hidden' id='Customer_id' name='Customer[id]' value=''>
	<input type='hidden' id='Contact_id' name='Contact[id]' value=''>  
	<input type='hidden' id='Quote_quote_type_id' name='Quote[quote_type_id]' value='1'>  <!-- tbd  -->
	<input type='hidden' id='Quote_level_id' name='Quote[level_id]' value='1'>

	<div class="form">
		<div class='quote_section_heading'>
			<span id='showHide_form_customer_contact' style='display: none;'>&minus;</span>
			<span style='padding-left: 350px;'>Customer &amp; Contacts</span>
		</div>

		<div id='form_customer_contact'>

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

				<!--  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%   Search[typeahead]   %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
				<span style='padding-left: 120px;'>
					<input type='text' name='Search[typeahead]' id='search_typeahead' size='40' placeholder='Search for...'/> 
				</span>

				

			</div>

				<table id='pre_quote_table'>
					<tr>
						<td>
							<div id='quote_customer_container'>
								<table id='quote_customer' style='border: 0px solid cyan;'>
									<caption><span id='customer_span_text'>Customer</span>
											<span id='customer_span_select' style='display:none; padding-left: 50px;'>Select customer &nbsp;
												<select name='Customer[select]' id='Customer_select'>
													<?php
														echo "<option value='0'></option>";
														foreach( $results as $c ) {
															echo "<option value='".$c->id."'>".$c->name."</option>";
														}
													?>
												</select>
											</span>
									</caption>
										

										<tr>  
											<td><span class='required'> * </span>Name </td><td> <input type='text' id='Customer_name' name='Customer[name]' ></td> 
										    <td>Vertical Market</td><td> <input type='text' id='Customer_vertical_market' name='Customer[vertical_market]'></td>
										</tr>

										<tr>
											<td><span class='required'> * </span>Address 1 </td><td> <input type='text' id='Customer_address1' name='Customer[address1]'></td>
											<td>Parent</td><td> <select name='Customer[parent_id]' id='Customer_parent_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['customers'] as $c ) {
																							echo "<option value='".$c->id."'>".$c->name. ', ' .  $c->country->short_name ."</option>";
																						}
																					?>
																	</select><span style='padding-left: 10px'></span>  
											</td>

										</tr>
										<tr>
											<td>Address 2 </td><td> <input type='text' id='Customer_address2' name='Customer[address2]'></td>
											<td>Company Link </td><td> <input type='text' id='Customer_company_link' name='Customer[company_link]'></td>
										</tr>

										<tr>	
											<td><span class='required'> * </span>City </td><td> <input type='text' id='Customer_city' name='Customer[city]'></td>
											<td>SYSPRO Acount No.</td><td><input type='text' id='Customer_syspro_account_code' name='Customer[syspro_account_code]'></td>
										</tr>
										<!-- -->
										<tr>







											<td>US State  </td><td> <select name='Customer[state_id]' id='Customer_state_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['us_states'] as $c ) {
																							echo "<option value='".$c->id."'>".$c->long_name."</option>";
																						}
																					?>
																				</select><!-- <span id='Customer_state_id_label' style='display: none;'></span> -->
																				<span style='padding-left: 10px'></span>  </td>











											<td>Xmas List? </td><td> <input type='text' id='Customer_xmas_list' name='Customer[xmas_list]'></td>
										</tr>
										<!-- -->
										<tr>
											<td><span class='required'> * </span>Country  </td><td>  <select name='Customer[country_id]' id='Customer_country_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['countries'] as $c ) {
																							echo "<option value='".$c->id."'>".$c->long_name."</option>";
																						}
																					?>
																				</select><span style='padding-left: 10px'></span>  </td>
											<td>Candy List? </td><td> <input type='text' id='Customer_candy_list' name='Customer[candy_list]'></td>
										</tr>
										<!-- -->	
										<tr>
											<td>Zip/Postal Code </td><td> <input type='text' id='Customer_zip' name='Customer[zip]'></td>
											<td>Strategic </td><td> <input type='text' id='Customer_strategic' name='Customer[strategic]'></td>
										</tr>
										<!-- -->	
										<tr>
											<td><span class='required'> * </span>Region </td><td>  <select name='Customer[region_id]' id='Customer_region_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['regions'] as $c ) {
																							echo "<option value='".$c->id."'>".$c->name."</option>";
																						}
																					?>
																				</select><span style='padding-left: 10px'></span>  </td>
											<!-- <td>Tier </td><td> <input type='text' id='Customer_tier_id' name='Customer[tier_id]'></td> -->
											<td><span class='required'> * </span>Tier </td><td>  <select name='Customer[tier_id]' id='Customer_tier_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['tiers'] as $c ) {
																							echo "<option value='".$c->id."'>".$c->name."</option>";
																						}
																					?>
																				</select><span style='padding-left: 10px'></span>  </td>
										</tr>
										<!-- -->	
										<tr>
											<td><span class='required'> * </span>Territory  </td><td> <select name='Customer[territory_id]' id='Customer_territory_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['territories'] as $c ) {
																							echo "<option value='".$c->id."'>".$c->name."</option>";
																						}
																					?>
																				</select><span style='padding-left: 10px'></span>  </td>
											<td>Inside Salesperson</td><td> <select name='Customer[inside_salesperson_id]' id='Customer_inside_salesperson_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['salespersons'] as $c ) {
																							echo "<option value='".$c->id."'>".substr($c->fullname,0,15)."</option>";
																						}
																					?>
																				</select><span style='padding-left: 10px'></span>  </td>
										</tr>
										<!-- -->	
										<tr>
											<td><span class='required'> * </span>Customer Type  </td><td> <select name='Customer[customer_type_id]' id='Customer_customer_type_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['types'] as $c ) {
																							echo "<option value='".$c->id."'>".$c->name. "</option>";
																						}
																					?>
																				</select><span style='padding-left: 10px'></span>  </td>
											<td>Outside Salesperson</td><td> <select name='Customer[outside_salesperson_id]' id='Customer_outside_salesperson_id'>
																					<?php
																						echo "<option value='0'></option>";
																						foreach( $data['salespersons'] as $c ) {
																							echo "<option value='".$c->id."'>".substr($c->fullname,0,15)."</option>";
																						}
																					?>
																				</select><span style='padding-left: 10px'></span>  </td>


										</tr>
								</table>
							</div>
						</td>

						<td>
							<div id='quote_contact_container'>
								<table id='quote_contact' style='border: 0px solid orange;'>
									<caption><span id='contact_span_text'>Contact</span> 
										<span id='contact_span_select' style='display:none; padding-left: 50px;'>Select contact &nbsp;
												<select name='Contact[select]' id='Contact_select'>
													<?php
														echo "<option value='0'></option>";
														foreach( $results as $c ) {
															echo "<option value='".$c->id."'>".$c->name."</option>";
														}
													?>
												</select>
										</span>
									</caption>

									<tr>  <td><span class='required'> * </span>First Name</td>     <td><input type='text' id='Contact_first_name' name='Contact[first_name]'></td> </tr>
									<tr>  <td><span class='required'> * </span>Last Name</td>      <td><input type='text' id='Contact_last_name'  name='Contact[last_name]'></td> </tr>
									<tr>  <td><span class='required'> * </span>Title</td>          <td><input type='text' id='Contact_title'      name='Contact[title]'></td> </tr>

									<tr>  <td><span class='required'> * </span>Email</td>          <td><input type='text' id='Contact_email'  name='Contact[email]'></td> </tr>
									<tr>  <td><span class='required'> * </span>Phone1</td>          <td><input type='text' id='Contact_phone1' name='Contact[phone1]'></td> </tr>
									<!-- <tr>  <td>Phone2</td>          <td><input type='text' id='Contact_phone2' name='Contact[phone2]'></td> </tr> -->

									<tr>  <td>Address1</td>          <td><input type='text' id='Contact_address1' name='Contact[address1]'></td> </tr>
									<!-- <tr>  <td>Address2</td>          <td><input type='text' id='Contact_address2' name='Contact[address2]'></td> </tr> -->

									<tr>  <td>City</td>          <td><input type='text' id='Contact_city' name='Contact[city]'></td> </tr>
									<tr><td>US State  </td><td> <select name='Contact[state_id]' id='Contact_state_id'>
																				<?php
																					echo "<option value='0'></option>";
																					foreach( $data['us_states'] as $c ) {
																						echo "<option value='".$c->id."'>".$c->long_name."</option>";
																					}
																				?>
																			</select><span style='padding-left: 10px'></span>  </td> </tr>

									<tr>  <td>Zip</td>          <td><input type='text' id='Contact_zip' name='Contact[zip]'></td> </tr>
									<tr> <td> Country </td><td>  <select name='Contact[country_id]' id='Contact_country_id'>
																				<?php
																					echo "<option value='0'></option>";
																					foreach( $data['countries'] as $c ) {
																						echo "<option value='".$c->id."'>".$c->long_name."</option>";
																					}
																				?>
																			</select><span style='padding-left: 10px'></span>  </td> </tr>
								</table></div>
						</td>
					</tr>
				</table>

				<input type='submit' id='button_continue' value='Continue'><span id='reset_form'>Reset Form</span>
		</div>
	</div>

	
	<div class="form">
		<div class='quote_section_heading' style='display: none;'>
			<span id='showHide_form_parts_lookup'>&minus;</span><span style='padding-left: 350px;'>Inventory Parts Lookup</span>
		</div>

		<div id='form_parts_lookup'>
			<table id='quote_parts'>
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

				
			<?php
				if ( $data['item'] != 'Search for part...' && $data['item'] != '' ) { 
					echo "<h2>Search results for ".$data['search_by'].": <span style=' border: 0px solid black; padding: 3px 8px 3px 8px; font-size:.8em; color: black; background: lightyellow'> ". 
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


					</tbody>
				</table>

		</div>
	</div>

</form>

<div id='lastDiv' style='display: none;'></div>








