<!-- <form>
  
  First name:  <input type="text" name="firstname" value="Mickey"><br>
  Last name:   <input type="text" name="lastname" value="Mouse">

  <br><br>
  <input type="submit" value="Submit">

</form> -->

	<form id="formCustomer" name="formCustomer" method="post">

		<div class="form">
			<div class='quote_section_heading'>
				<span id='showHide_form_cutomer_contact' style='display: none;'>-</span><span style='padding-left: 350px;'>Customer &amp; Contacts</span>
			</div>

			<input type='hidden' id='base_url' value='<?php echo Yii::app()->baseUrl; ?>'>
			<input type='hidden' id='Customer_id' value=''>
			<input type='hidden' id='Contact_id' value=''>  

			<div id='form_cutomer_contact'>
			
				<table id='quote_customer'>
								<caption>Customer</caption>
									<tr>  
										<td style='padding-bottom: 20px; text-align: center;' colspan='4'><span class='select_existing'>Select existing customer</span>  
											<select id='customer_select'>

												
													<?php
														//echo "<option value='0'> </option>";
														foreach( $data['customers'] as $c ) {
															echo "<option value='".$c->id."'>".$c->name. ', ' . $c->address1 ."</option>";
														}
													?>
											

											</select><span style='padding-left: 10px'><a href='#' id='createNewCustomer' >New</a></span>
										 </td> 
									</tr>

									<!--   ###############################################################################################   -->

									<tr>  
										<td><span class='required'> * </span>Name </td><td> <input type='text' id='Customer_name' name='Customer[name]'></td> 
									    <!-- <td>Vertical Market</td><td> <input type='text' id='Customer_vertical_market' name='Customer[vertical_market]'></td> -->
									</tr>

									
									<!-- -->
									
									
							</table>

				<input type='submit'  value='MickeyMouse Button'>

			</div>
		</div>

		
	</form>



