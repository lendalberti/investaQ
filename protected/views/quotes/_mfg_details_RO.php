<?php

	$q  = $data['BtoItems_model']; 

?>

	<div style='border: 0px solid blue; height: 100%; overflow: auto; '>

		<div style='border: 0px solid green; margin: 20px 0px 0px 60px; float: left; width: 40%;'>

			<table id='mfg_details'>
				<tr>   <td>Order Probability</td>    <td><input value='<?php echo $q->order_probability; ?>'       readonly='readonly'  id='BtoItems_order_probability'       name='BtoItems[order_probability]' /></td> </tr>
				<tr>   <td>Requested Part No.</td>   <td><input value='<?php echo $q->requested_part_number; ?>' readonly='readonly'  id='BtoItems_requested_part_number' name='BtoItems[requested_part_number]' /></td> </tr>
				<tr>   <td>Generic Part No.</td>     <td><input value='<?php echo $q->generic_part_number; ?>' 	 readonly='readonly'  id='BtoItems_generic_part_number'   name='BtoItems[generic_part_number]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity1; ?>'			 readonly='readonly'  id='BtoItems_quantity1' 			name='BtoItems[quantity1]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity2; ?>' 			 readonly='readonly'  id='BtoItems_quantity2' 			name='BtoItems[quantity2]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity3; ?>' 			 readonly='readonly'  id='BtoItems_quantity3' 			name='BtoItems[quantity3]' /></td> </tr>
				<tr>   <td>Die Manufacturer</td>     <td><input value='<?php echo $q->dieManufacturer->long_name; ?>'   readonly='readonly'  id='BtoItems_die_manufacturer_id'   name='BtoItems[die_manufacturer_id]' /></td> </tr>
				<tr>   <td>Package Type</td>         <td><input value='<?php echo $q->packageType->name; ?>'       readonly='readonly'  id='BtoItems_package_type_id'       name='BtoItems[package_type_id]' /></td> </tr>
				<tr>   <td>Lead Count</td>           <td><input value='<?php echo $q->lead_count; ?>'            readonly='readonly'  id='BtoItems_lead_count'            name='BtoItems[lead_count]'   /></td> </tr>
			</table>
		</div>

		<div style='border: 0px solid orange; margin: 20px 60px 0px 0px; float: right; width: 40%;'>

			<table id='mfg_details'>
				<tr>   <td>Temp Low</td>     	<td><input readonly='readonly'  id='BtoItems_temp_low'          name='BtoItems[temp_low]'         value='<?php echo $q->temp_low; ?>'/></td> </tr>
				<tr>   <td>Temp High</td>     	<td><input readonly='readonly'  id='BtoItems_temp_high'         name='BtoItems[temp_high]'        value='<?php echo $q->temp_high; ?>'/></td> </tr>
				<tr>   <td>Process Flow</td>    <td><input readonly='readonly'  id='BtoItems_process_flow_id'   name='BtoItems[process_flow_id]'  value='<?php echo $q->processFlow->name; ?>'/></td> </tr>
				<tr>   <td>Testing</td>			<td><input readonly='readonly'  id='BtoItems_testing_id'   	  name='BtoItems[testing_id]'  	  value='<?php echo $q->testing->name; ?>'/></td> </tr> 

				<!-- Yes/No -->
				<tr>   	<td>NCNR</td>			<td><input readonly='readonly'  id='BtoItems_ncnr'   		name='BtoItems[ncnr]'     	value='<?php echo ( $q->ncnr == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>ITAR</td>			<td><input readonly='readonly'  id='BtoItems_itar'   		name='BtoItems[itar]'     	value='<?php echo ( $q->itar == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>Have Die</td>		<td><input readonly='readonly'  id='BtoItems_have_die'    name='BtoItems[have_die]'  	value='<?php echo ( $q->have_die == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>SPA</td>			<td><input readonly='readonly'  id='BtoItems_spa'   		name='BtoItems[spa]'  		value='<?php echo ( $q->spa == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>Recreation</td>		<td><input readonly='readonly'  id='BtoItems_recreation'  name='BtoItems[recreation]'  	value='<?php echo ( $q->recreation == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>Wip Product</td>	<td><input readonly='readonly'  id='BtoItems_wip_product' name='BtoItems[wip_product]'  value='<?php echo ( $q->wip_product == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
			</table>
		</div>
</div>

		<!-- <div style='border: 1px solid lightblue;'>

				<span style='font-weight: bold;'>Author's Notes:</span><br />
				<span id='BtoItems_salesperson_notes'>< ?php echo $q->salesperson_notes; ?></span>

		</div>

 -->
	
