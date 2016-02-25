<?php

	$q  = $data['model']; 

				// 'attachments' => array(self::HAS_MANY, 'Attachments', 'quote_id'),
				// 'btoApprovals' => array(self::HAS_MANY, 'BtoApprovals', 'quote_id'),
				// 'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
				// 'contact' => array(self::BELONGS_TO, 'Contacts', 'contact_id'),
				// 'owner' => array(self::BELONGS_TO, 'Users', 'owner_id'),
				// 'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
				// 'lostReason' => array(self::BELONGS_TO, 'LostReasons', 'lost_reason_id'),
				// 'noBidReason' => array(self::BELONGS_TO, 'NoBidReasons', 'no_bid_reason_id'),
				// 'quoteType' => array(self::BELONGS_TO, 'QuoteTypes', 'quote_type_id'),
				// 'level' => array(self::BELONGS_TO, 'Levels', 'level_id'),
				// 'source' => array(self::BELONGS_TO, 'Sources', 'source_id'),
				// 'dieManufacturer' => array(self::BELONGS_TO, 'DieManufacturers', 'die_manufacturer_id'),
				// 'packageType' => array(self::BELONGS_TO, 'PackageTypes', 'package_type_id'),
				// 'processFlow' => array(self::BELONGS_TO, 'ProcessFlow', 'process_flow_id'),
				// 'testing' => array(self::BELONGS_TO, 'Testing', 'testing_id'),
				// 'priority' => array(self::BELONGS_TO, 'Priority', 'priority_id'),
				// 'leadQuality' => array(self::BELONGS_TO, 'LeadQuality', 'lead_quality_id'),
				// 'stockItems' => array(self::HAS_MANY, 'StockItems', 'quote_id'),



?>

	<div style='border: 0px solid blue; height: 100%; overflow: auto; '>

		<div style='border: 0px solid green; margin: 20px 0px 0px 60px; float: left; width: 40%;'>

			<table id='mfg_details'>
				<tr>   <td>Order Probability</td>    <td><input value='<?php echo $q->leadQuality->name; ?>'       readonly='readonly'  id='Quotes_lead_quality_id'       name='Quotes[lead_quality_id]' /></td> </tr>
				<tr>   <td>Requested Part No.</td>   <td><input value='<?php echo $q->requested_part_number; ?>' readonly='readonly'  id='Quotes_requested_part_number' name='Quotes[requested_part_number]' /></td> </tr>
				<tr>   <td>Generic Part No.</td>     <td><input value='<?php echo $q->generic_part_number; ?>' 	 readonly='readonly'  id='Quotes_generic_part_number'   name='Quotes[generic_part_number]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity1; ?>'			 readonly='readonly'  id='Quotes_quantity1' 			name='Quotes[quantity1]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity2; ?>' 			 readonly='readonly'  id='Quotes_quantity2' 			name='Quotes[quantity2]' /></td> </tr>
				<tr>   <td>Quantity</td>     		 <td><input value='<?php echo $q->quantity3; ?>' 			 readonly='readonly'  id='Quotes_quantity3' 			name='Quotes[quantity3]' /></td> </tr>
				<tr>   <td>Die Manufacturer</td>     <td><input value='<?php echo $q->dieManufacturer->long_name; ?>'   readonly='readonly'  id='Quotes_die_manufacturer_id'   name='Quotes[die_manufacturer_id]' /></td> </tr>
				<tr>   <td>Package Type</td>         <td><input value='<?php echo $q->packageType->name; ?>'       readonly='readonly'  id='Quotes_package_type_id'       name='Quotes[package_type_id]' /></td> </tr>
				<tr>   <td>Lead Count</td>           <td><input value='<?php echo $q->lead_count; ?>'            readonly='readonly'  id='Quotes_lead_count'            name='Quotes[lead_count]'   /></td> </tr>
			</table>
		</div>

		<div style='border: 0px solid orange; margin: 20px 60px 0px 0px; float: right; width: 40%;'>

			<table id='mfg_details'>
				<tr>   <td>Temp Low</td>     	<td><input readonly='readonly'  id='Quotes_temp_low'          name='Quotes[temp_low]'         value='<?php echo $q->temp_low; ?>'/></td> </tr>
				<tr>   <td>Temp High</td>     	<td><input readonly='readonly'  id='Quotes_temp_high'         name='Quotes[temp_high]'        value='<?php echo $q->temp_high; ?>'/></td> </tr>
				<tr>   <td>Process Flow</td>    <td><input readonly='readonly'  id='Quotes_process_flow_id'   name='Quotes[process_flow_id]'  value='<?php echo $q->processFlow->name; ?>'/></td> </tr>
				<tr>   <td>Testing</td>			<td><input readonly='readonly'  id='Quotes_testing_id'   	  name='Quotes[testing_id]'  	  value='<?php echo $q->testing->name; ?>'/></td> </tr> 

				<!-- Yes/No -->
				<tr>   	<td>NCNR</td>			<td><input readonly='readonly'  id='Quotes_ncnr'   		name='Quotes[ncnr]'     	value='<?php echo ( $q->ncnr == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>ITAR</td>			<td><input readonly='readonly'  id='Quotes_itar'   		name='Quotes[itar]'     	value='<?php echo ( $q->itar == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>Have Die</td>		<td><input readonly='readonly'  id='Quotes_have_die'    name='Quotes[have_die]'  	value='<?php echo ( $q->have_die == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>SPA</td>			<td><input readonly='readonly'  id='Quotes_spa'   		name='Quotes[spa]'  		value='<?php echo ( $q->spa == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>Recreation</td>		<td><input readonly='readonly'  id='Quotes_recreation'  name='Quotes[recreation]'  	value='<?php echo ( $q->recreation == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
				<tr>   	<td>Wip Product</td>	<td><input readonly='readonly'  id='Quotes_wip_product' name='Quotes[wip_product]'  value='<?php echo ( $q->wip_product == 1 ? 'Yes' : 'No' );  ?>'/></td> </tr> 
			</table>
		</div>
</div>

		<div style='border: 1px solid lightblue;'>

				<span style='font-weight: bold;'>Author's Notes:</span><br />
				<span id='Quotes_salesperson_notes'><?php echo $q->salesperson_notes; ?></span>

		</div>


	
