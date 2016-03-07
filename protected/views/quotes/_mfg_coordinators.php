

<?php

	$logged_in_as = Yii::app()->user->id;

	$item_id = $data['BtoItems_model']->id;
	$assembly_bto_status =  displayMfgQuoteStatus($data['BtoItemStatus'][Groups::ASSEMBLY-1]->status_id);
	$test_bto_status     =  displayMfgQuoteStatus($data['BtoItemStatus'][Groups::TEST-1]->status_id); 
	$quality_bto_status  =  displayMfgQuoteStatus($data['BtoItemStatus'][Groups::QUALITY-1]->status_id);  

	$criteria = new CDbCriteria();
	$criteria->addCondition("bto_item_id = $item_id" );
	$modelItems =  BtoItemStatus::model()->find($criteria);

	$assembly_coordinator = $data['BtoItemStatus'][Groups::ASSEMBLY-1]->coordinator->fullname;
	$test_coordinator     = $data['BtoItemStatus'][Groups::TEST-1]->coordinator->fullname;
	$quality_coordinator  = $data['BtoItemStatus'][Groups::QUALITY-1]->coordinator->fullname;

	$assembly_id = $data['BtoItemStatus'][Groups::ASSEMBLY-1]->coordinator->id . '_' . $item_id . '_' . Groups::ASSEMBLY;  //  approveItem_ $owner_id _ $item_id _ Groups::ASSEMBLY
	$test_id     = $data['BtoItemStatus'][Groups::TEST-1]->coordinator->id . '_' . $item_id . '_' . Groups::TEST ;
	$quality_id  = $data['BtoItemStatus'][Groups::QUALITY-1]->coordinator->id . '_' . $item_id . '_' . Groups::QUALITY ;

?>

	<div id="coordinators_accordion">

		<input type='hidden' id='assembly_coordinator' value='<?php echo $assembly_coordinator;  ?>'>
		<input type='hidden' id='test_coordinator' value='<?php echo $test_coordinator;  ?>'>
		<input type='hidden' id='quality_coordinator' value='<?php echo $quality_coordinator;  ?>'>

		<input type='hidden' id='logged_in_as' value='<?php echo $logged_in_as;  ?>'>

		<!-- *********************** Assembly *********************** -->
	  	<h3><span style='font-weight: bold;'>Assembly</span><span style='font-variant: small-caps;'> (<?php echo $assembly_coordinator; ?>)</span></h3>
		<form id='form_<?php echo $assembly_id; ?>' >
			<div class='flex_container'>
				<div class='flex_item'>
					<div style='margin: 10px 0px 50px 0px;'>
						<div style='margin-bottom: 15px;'> Current Status: <?php echo $assembly_bto_status; ?></div>
						<div>
							<span style='padding-right: 10px;'>
								<input type='button' id='approveItem_<?php echo $assembly_id; ?>' value='Approve' >	</span>
							<span style='padding-right: 10px;'>
								<input type='button' id='rejectItem_<?php echo $assembly_id; ?>' value='Reject'> </span>
							<span style='padding-right: 10px;'>
								<input type='button' id='holdItem_<?php echo $assembly_id; ?>' value='Hold'></span>
						</div>
					</div>
				</div>

				<div class='flex_item'>
					<table class='charges_leads'>
						<tr> <th></th>  <th>NRE Charge</th>   <th>Lead Time</th>  </tr>
						<tr> <td>Assembly</td>  <td><input type='text' size='10' id='Assembly_charge' name='Assembly[charge]'> </td>    
												<td><input type='text' size='10' id='Assembly_lead' name='Assembly[lead]' ></td>   </tr>
					</table>

					<div style='padding-bottom:4px;'><span style='font-size: .8em;'>Location      </span> <input type='text' id='Assembly_location' name='Assembly[location]'> </div>
					<div style='padding-bottom:4px;'><span style='font-size: .8em;'>Bond Diagram? </span> <input name='Assembly[bond_diagram]' type="radio">No <input name='Assembly[bond_diagram]' type="radio">Yes </div>
				</div>
				
				<div class='flex_item'>
					Proposal Notes
					<textarea  class='proposal_notes' rows="6" cols="30" id='Assembly_notes' name='Assembly[notes]' ></textarea> 
				</div>
				
				<div class='flex_item'>
					Proposal Notes - INTERNAL ONLY
					<textarea  class='proposal_notes_internal' rows="12" cols="40" id='Assembly_internal_notes' name='Assembly[internal_notes]' ></textarea> 
				</div>

				<span style='padding-left: 10px;'><input type='button' id='saveItemChanges_<?php echo $assembly_id; ?>' value='Save Changes' ></span>
			</div>
		</form>
		

		<!-- *********************** Test *********************** -->
		<h3><span style='font-weight: bold;'>Test</span><span style='font-variant: small-caps;'> (<?php echo $test_coordinator; ?>)</span></h3>
		<form id='form_<?php echo $test_id; ?>' >
			<div class='flex_container'>
				<div class='flex_item'>
					<div style='margin: 10px 0px 50px 0px;'>
						<div style='margin-bottom: 15px;'> Current Status: <?php echo $test_bto_status; ?></div>
						<div>
							<span style='padding-right: 10px;'>
								<input type='button' id='approveItem_<?php echo $test_id; ?>' value='Approve' >	</span>
							<span style='padding-right: 10px;'>
								<input type='button' id='rejectItem_<?php echo $test_id; ?>' value='Reject'> </span>
							<span style='padding-right: 10px;'>
								<input type='button' id='holdItem_<?php echo $test_id; ?>' value='Hold'></span>
						</div>
					</div>
				</div>

				<div class='flex_item'>
					<table class='charges_leads'>
						<tr> <th></th>  <th>NRE Charges</th>   <th>Lead Times</th>  </tr>
						<tr> <td>BI</td>          <td><input  id='Test_bi_charge' name='Test[bi_charge]' type='text' size='10'> </td>    <td><input type='text' size='10' ></td>   </tr>
						<tr> <td>Software</td>    <td><input  id='Test_sw_charge' name='Test[sw_charge]' type='text' size='10'> </td>    <td><input type='text' size='10'></td>   </tr>
						<tr> <td>Hardware</td>    <td><input  id='Test_hw_charge' name='Test[hw_charge]' type='text' size='10'> </td>    <td><input type='text' size='10'></td>   </tr>
					</table>
				</div>
				
				<div class='flex_item'>
					Proposal Notes
					<textarea class='proposal_notes' id='Test_notes' name='Test[notes]' rows="6" cols="30" ></textarea> 
				</div>
				
				<div class='flex_item'>
					Proposal Notes - INTERNAL ONLY
					<textarea  class='proposal_notes_internal'  id='Test_internal_notes' name='Test[internal_notes]'  rows="15" cols="40"  ></textarea> 
				</div>

				<span style='padding-left: 10px;'><input type='button' id='saveItemChanges_<?php echo $test_id; ?>' value='Save Changes' ></span>
			</div>
		</form>
		

		<!-- *********************** Quality *********************** -->
		<h3><span style='font-weight: bold;'>Quality</span><span style='font-variant: small-caps;'> (<?php echo $quality_coordinator; ?>)</span></h3>
		<form id='form_<?php echo $quality_id; ?>' >
			<div class='flex_container'>
				<div class='flex_item1'>
					<div style='margin: 10px 0px 50px 0px;'>
						<div style='margin-bottom: 15px;'> Current Status: <?php echo $quality_bto_status; ?></div>
						<div>
							<span style='padding-right: 10px;'>
								<input type='button' id='approveItem_<?php echo $quality_id; ?>' value='Approve' >	</span>
							<span style='padding-right: 10px;'>
								<input type='button' id='rejectItem_<?php echo $quality_id; ?>' value='Reject'> </span>
							<span style='padding-right: 10px;'>
								<input type='button' id='holdItem_<?php echo $quality_id; ?>' value='Hold'></span>
						</div>
					</div>
				</div>

				<div class='flex_item3'>
					Proposal Notes
					<textarea class='proposal_notes'  id='Quality_notes' name='Quality[notes]'  rows="8" cols="30"  ></textarea> 
				</div>


				<div class='flex_item4'>
					Proposal Notes - INTERNAL ONLY
					<textarea  class='proposal_notes_internal' id='Quality_internal_notes' name='Quality[internal_notes]'  rows="15" cols="40"  ></textarea> 
				</div>
				<span style='padding-left: 10px;'><input type='button' id='saveItemChanges_<?php echo $quality_id; ?>' value='Save Changes' ></span>
			</div>
		</form>
		
	</div>   <!-- coordinators_accordion -->
