
<?php $this->layout = '//layouts/column1'; ?>


<!-- <form> -->
<form id="formCustomer" name="formCustomer" method="post">

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
				<span style='padding-left: 120px;'><input type='text' name='Search[typeahead]' id='search_typeahead' size='40' placeholder='Search for...'/> </span>
			</div>

			<div id='div_ViewCustomer' style='width: 100%;'>
				<div style='height: 300px; width: 66%; border: 2px solid orange;'>
					<div style='float: left; border: 1px solid red;'>
						customer - 1st column
					</div>

					<div style='float: left; border: 1px solid green;'>
						customer - 2nd column
					</div>
				</div>

				<div style='width: 33%; border: 2px solid purple;'>
					<div style='float: right; border: 1px solid blue;'>
						contact column
					</div>
				</div>
			</div>   <!-- div_ViewCustomer -->







			<table id='table_CustomersContacts'>
					<tr>
						<td>
							





								<table id='table_CustomerLeft' style='border: 1px solid cyan;'>
									<!-- <caption><span id='customer_span_text'>Customer</span> -->
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
									<!-- </caption> -->
									<tr>  
										<td><span class='required'> * </span>Name </td><td> <input type='text' id='Customer_name' name='Customer[name]' ></td> 
									    <td>Vertical Market</td><td> <input type='text' id='Customer_vertical_market' name='Customer[vertical_market]'></td>
									</tr>
								</table>  <!-- table_CustomerLeft -->

								<table id='table_CustomerRight' style='border: 1px solid purple;'>

								</table>  <!-- table_CustomerRight -->

								<table id='table_Contact' style='border: 1px solid cyan;'>

								</table>  <!-- table_Contact -->
					









							
						</td>

						<td>
							<div id='div_ViewContact'>
							</div>   <!-- div_ViewContact -->
						</td>

					</tr>
			</table>  <!-- table_CustomersContacts -->



			<input type='submit' id='button_continue' value='Continue'><span id='reset_form'>Reset Form</span>
		</div>  <!-- form_customer_contact -->



</form>

<!--  &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&  -->


