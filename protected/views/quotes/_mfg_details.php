<?php

	$q  = $data['BtoItems_model']; 

?>

	<div style='border: 0px solid blue; height: 100%; overflow: auto; '>

		<div style='border: 0px solid green; margin: 20px 0px 0px 60px; float: left; width: 40%;'> 

			<input type='hidden' id='BtoItems_id' name='BtoItems[id]' value='<?php echo $q->id; ?>'>

			<table id='mfg_details'>
				<tr>   <td>Order Probability</td>     	
							<td>
								<select id='BtoItems_order_probability_id' 		name='BtoItems[order_probability_id]'>
									<?php
											if ( isset($data['selects']['order_probability']) ) {
												echo "<option></option>";
												foreach( $data['selects']['order_probability'] as $s => $arr ) {
													foreach( $arr as $k => $v ) {
														$selected = ( $k==$q->orderProbability->name ? 'selected' : '' );
														echo "<option $selected value='" . $k."'>".$v."</option>";
													}
												}
											}
									?>
								</select>
							</td> </tr>

				<tr>   <td>Requested Part No.</td>   <td><input value='<?php echo $q->requested_part_number; ?>' id='BtoItems_requested_part_number' name='BtoItems[requested_part_number]' /></td> </tr>
				<tr>   <td>Generic Part No.</td>     <td><input value='<?php echo $q->generic_part_number; ?>' 	   id='BtoItems_generic_part_number'   name='BtoItems[generic_part_number]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity1; ?>'			   id='BtoItems_quantity1' 			name='BtoItems[quantity1]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity2; ?>' 			   id='BtoItems_quantity2' 			name='BtoItems[quantity2]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity3; ?>' 			   id='BtoItems_quantity3' 			name='BtoItems[quantity3]' /></td> </tr>

				<tr>   <td>Die Manufacturer</td>     	
							<td>
								<select id='BtoItems_die_manufacturer_id' 	name='BtoItems[die_manufacturer_id]' >
									<?php
											if ( isset($data['selects']['die_manufacturers']) ) {
												echo "<option></option>";
												foreach( $data['selects']['die_manufacturers'] as $s => $arr ) {
													foreach( $arr as $k => $v ) {
														$selected = ( $k==$q->die_manufacturer_id ? 'selected' : '' );
														echo "<option $selected value='" . $k."'>".$v."</option>";
													}
												}
											}
									?>
								</select>
							</td> </tr>

				<tr>   <td>Package Type</td>  
							<td>
								<select id='BtoItems_package_type_id' 	name='BtoItems[package_type_id]' >
									<?php
											if ( isset($data['selects']['package_types']) ) {
												echo "<option></option>";
												foreach( $data['selects']['package_types'] as $s => $arr ) {
													foreach( $arr as $k => $v ) {
														$selected = ( $k==$q->package_type_id ? 'selected' : '' );
														echo "<option $selected value='" . $k."'>".$v."</option>";
													}
												}
											}
									?>
								</select>
							</td> </tr>

				<tr>   <td>Lead Count</td>  <td><input   id='BtoItems_lead_count'     name='BtoItems[lead_count]'   value='<?php echo $q->lead_count; ?>'/></td> </tr>
			</table>
		</div>

		<div style='border: 0px solid orange; margin: 20px 60px 0px 0px; float: right; width: 40%;'>

			<table id='mfg_details'>
				<tr>   <td>Temp Low</td>     	<td><input   id='BtoItems_temp_low'      name='BtoItems[temp_low]'   value='<?php echo $q->temp_low; ?>'/></td> </tr>
				<tr>   <td>Temp High</td>     	<td><input   id='BtoItems_temp_high'     name='BtoItems[temp_high]'  value='<?php echo $q->temp_high; ?>'/></td> </tr>
				<tr>   <td>Process Flow</td>    
						<td>
							<select id='BtoItems_process_flow_id' name='BtoItems[process_flow_id]'>
								<?php
											if ( isset($data['selects']['process_flow']) ) {
												echo "<option></option>";
												foreach( $data['selects']['process_flow'] as $s => $arr ) {
													foreach( $arr as $k => $v ) {
														$selected = ( $k==$q->process_flow_id ? 'selected' : '' );
														echo "<option $selected value='" . $k."'>".$v."</option>";
													}
												}
											}
									?>
							</select>
						</td> </tr>


				<tr>   <td>Test</td> 
							<td>
							<select id='BtoItems_testing_id' name='BtoItems[testing_id]'>
								<?php
											if ( isset($data['selects']['testing']) ) {
												echo "<option></option>";
												foreach( $data['selects']['testing'] as $s => $arr ) {
													foreach( $arr as $k => $v ) {
														$selected = ( $k==$q->testing_id ? 'selected' : '' );
														echo "<option $selected value='" . $k."'>".$v."</option>";
													}
												}
											}
									?>
							</select>
						</td> </tr>

				<!-- Yes/No -->

				<tr>   	<td>NCNR</td>
						<td>
							<select id='BtoItems_ncnr'       name='BtoItems[ncnr]' >  
								<?php 	
									// echo "<option></option>";
									foreach( array(0,1) as $i ) {
										$yn = ($i===0 ? 'No' : 'Yes');
										$selected = ( $i===$q->ncnr ? "selected" : '' );
										echo "<option $selected value='$i' >$yn</option>";
									}
								?>
							</select>
						</td>
				</tr>

				<tr>   	<td>ITAR</td>
						<td>
							<select id='BtoItems_itar'       name='BtoItems[itar]' >  
								<?php 	
									// echo "<option></option>";
									foreach( array(0,1) as $i ) {
										$yn = ($i===0 ? 'No' : 'Yes');
										$selected = ( $i===$q->itar ? "selected" : '' );
										echo "<option $selected value='$i' >$yn</option>";
									}
								?>
							</select>
						</td>
				</tr>

				<tr>   	<td>Have Die</td>
						<td>
							<select id='BtoItems_have_die'       name='BtoItems[have_die]' >  
								<?php 	
									// echo "<option></option>";
									foreach( array(0,1) as $i ) {
										$yn = ($i===0 ? 'No' : 'Yes');
										$selected = ( $i===$q->have_die ? "selected" : '' );
										echo "<option $selected value='$i' >$yn</option>";
									}
								?>
							</select>
						</td>
				</tr>


				<tr>   	<td>SPA</td>
						<td>
							<select id='BtoItems_spa'       name='BtoItems[spa]' >  
								<?php 	
									// echo "<option></option>";
									foreach( array(0,1) as $i ) {
										$yn = ($i===0 ? 'No' : 'Yes');
										$selected = ( $i===$q->spa ? "selected" : '' );
										echo "<option $selected value='$i' >$yn</option>";
									}
								?>
							</select>
						</td>
				</tr>

				<tr>   	<td>Recreation</td>
						<td>
							<select id='BtoItems_recreation'       name='BtoItems[recreation]' >  
								<?php 	
									// echo "<option></option>";
									foreach( array(0,1) as $i ) {
										$yn = ($i===0 ? 'No' : 'Yes');
										$selected = ( $i===$q->recreation ? "selected" : '' );
										echo "<option $selected value='$i' >$yn</option>";
									}
								?>
							</select>
						</td>
				</tr>


				<tr>   	<td>Wip Product</td>
						<td>
							<select id='BtoItems_wip_product'       name='BtoItems[wip_product]' >  
								<?php 	
									// echo "<option></option>";
									foreach( array(0,1) as $i ) {
										$yn = ($i===0 ? 'No' : 'Yes');
										$selected = ( $i===$q->wip_product ? "selected" : '' );
										echo "<option $selected value='$i' >$yn</option>";
									}
								?>
							</select>
							<?php ?>
						</td>
				</tr>

			</table>

			<!--

				TODO: if Proposal Manager hasn't been notified yet, show this checkbox; figure out how and where to put it,,,

					<input type='checkbox' id='' name=''>Notify Proposal Manager


			-->

		</div>
	</div>
<!-- 
	<div style='border: 1px solid lightblue;'>
		<span class='terms'>Author's Notes:</span><br /><textarea rows="4" cols="80" name="BtoItems[salesperson_notes]" id="BtoItems_salesperson_notes" >< ?php echo $q->salesperson_notes; ?></textarea>
	</div> -->






<!-- 

<pre>


	Business Class			Broker
	Priority				Low Medium High
	Order Probability		(Low) 5% 10% 15% 20% 25% 30% 35% 40% 45% 50% ... 100% (high) 

	Requested Part Number	MC68HC711E9CFS2
	Generic Part Number		MC68HC711E9CFS2
	Quantity				500000

	Die Manufacturer		ADG (Analog Devices)            //  min 3 char search, autocompletion?
	Package Type			BGA
	Lead Count				128

	Process Flow			/B
	Testing					Datasheet

	Temp Low				35 (Celsius/Fahrenheit)
	Temp High				80

	NCNR					Yes/No
	ITAR					Yes/No
	Have Die				Yes/No
	SPA						Yes/No
	Recreation				Yes/No
	Wip Product				Yes/No

</pre>


< ?php

	$mfgs = 'http://lenscentos/iq2/protected/data/mfgs.inc'; //Yii::app()->baseUrl . '/protected/data/mfgs.inc';
	$m = json_decode( file_get_contents( $mfgs ) );
	$arrIt = new RecursiveIteratorIterator(new RecursiveArrayIterator($m));

	$searchFor = 'Panasonic';

	foreach ($arrIt as $sub) {
		$subArray = $arrIt->getSubIterator();
		// if ($subArray['mfgId'] === $searchFor) {

		if ( strlen(stristr($subArray['mfgId'] ,$searchFor)) > 0  ) {
			$outputArray[] = iterator_to_array($subArray);
		}
	}

	//if ( count( $outputArray ) === 0 ) {
		foreach ($arrIt as $sub) {
			$subArray = $arrIt->getSubIterator();
			//if ($subArray['mfgName'] === $searchFor) {
			if ( strlen(stristr($subArray['mfgName'] ,$searchFor)) > 0  ) {
				$outputArray[] = iterator_to_array($subArray);
			}
		}
	//}

	echo '<pre>['; print_r( $outputArray ); echo ']</pre>';

?>
 -->