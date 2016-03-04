

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

		  	<h3><span style='font-weight: bold;'>Assembly</span><span style='font-variant: small-caps;'> (<?php echo $assembly_coordinator; ?>)</span></h3>
		  	<div>
		   			<div style='margin: 10px 0px 50px 0px;'>
						<div style='margin-bottom: 15px;'>Current Status:<br /> <?php echo $assembly_bto_status; ?></div>
						<div>
							<span style='padding-right: 10px;'>
								<input type='button' id='approveItem_<?php echo $assembly_id; ?>' value='Approve' >	</span>
							<span style='padding-right: 10px;'>
								<input type='button' id='rejectItem_<?php echo $assembly_id; ?>' value='Reject'> </span>
							<span style='padding-right: 10px;'>
								<input type='button' id='holdItem_<?php echo $assembly_id; ?>' value='Hold'></span>
						</div>
					</div>

					<div>

						<table class='coordinator_table'>
							<tr><td>Assembly NRE Charge:</td><td><input type='text' id='' name=''> </td> </tr>
							<tr><td>Assembly Location:</td><td><input type='text' id='' name=''> </td> </tr>
							<tr><td>Bond Diagram?</td><td> <select><option>No</option><option>Yes</option></select></td> </tr>
							<tr><td>Assembly Lead Time (weeks):</td><td><input type='text' id='' name=''> </td> </tr>
							<tr><td>Customer Viewable Proposal Notes:</td><td><textarea rows="6" cols="30" name='' id='' ></textarea> </td> </tr>
							<tr><td>Internal Exception Notes: </td><td><textarea rows="6" cols="30" name='' id='' ></textarea> </td> </tr>
						</table>


					</div>

					<div style='margin:20px 0px 20px 0px;' >
						<span style='padding-right: 10px;'><input type='button' id='saveItemChanges_<?php echo $assembly_id; ?>' value='Save Changes' ></span>
					</div>
		   	</div>

		  	<h3><span style='font-weight: bold;'>Test</span><span style='font-variant: small-caps;'> (<?php echo $test_coordinator; ?>)</span></h3>
		  	<div>
		  			<div style='margin: 10px 0px 50px 0px;'>
						<div style='margin-bottom: 15px;'>Current Status: <br /><?php echo $test_bto_status; ?> </div>
						
						<div>
							<span style='padding-right: 10px;'>
								<input type='button' id='approveItem_<?php echo $test_id; ?>' value='Approve' ></span>
							<span style='padding-right: 10px;'>
								<input type='button' id='rejectItem_<?php echo $test_id; ?>' value='Reject'></span>
							<span style='padding-right: 10px;'>
								<input type='button' id='holdItem_<?php echo $test_id; ?>' value='Hold'></span>

						</div>
					</div>

					<div>

						<table class='coordinator_table'>
							<tr><td>Test BI NRE Charge:</td><td><input type='text' id='' name=''> </td> </tr>
							<tr><td>Test Software NRE Charge:</td><td><input type='text' id='' name=''> </td> </tr>
							<tr><td>Test Hardware NRE Charge:</td><td><input type='text' id='' name=''> </td> </tr>

							<tr><td>Software lead Time (weeks):</td><td><input type='text' id='' name=''> </td> </tr>
							<tr><td>Hardware lead Time (weeks):</td><td><input type='text' id='' name=''> </td> </tr>

							<tr><td>Customer Viewable Proposal Notes:</td><td><textarea rows="6" cols="30" name='' id='' ></textarea> </td> </tr>
							<tr><td>Internal Exception Notes:</td><td><textarea rows="6" cols="30" name='' id='' ></textarea> </td> </tr>
							
						</table>


					</div>

					<div style='margin:20px 0px 20px 0px;' >
						<span style='padding-right: 10px;'><input type='button' id='saveItemChanges_<?php echo $test_id; ?>' value='Save Changes' ></span>
					</div>
		   	</div>

			<h3><span style='font-weight: bold;'>Quality</span><span style='font-variant: small-caps;'> (<?php echo $quality_coordinator; ?>)</span></h3>
			<div>
				<div style='margin: 10px 0px 50px 0px;'>
					<div style='margin-bottom: 15px;'>Current Status:<br /> <?php echo $quality_bto_status; ?> </div>
					<div>
						<span style='padding-right: 10px;'>
							<input type='button' id='approveItem_<?php echo $quality_id; ?>' value='Approve' ></span>
						<span style='padding-right: 10px;'>
							<input type='button' id='rejectItem_<?php echo $quality_id; ?>' value='Reject'></span>
						<span style='padding-right: 10px;'>
							<input type='button' id='holdItem_<?php echo $quality_id; ?>' value='Hold'></span>
					</div>
				</div>
				<div>

					<table class='coordinator_table'>
						<tr><td>Customer Viewable Proposal Notes:</td><td><textarea rows="6" cols="30" name='' id='' ></textarea> </td> </tr>
						<tr><td>Internal Exception Notes:</td><td><textarea rows="6" cols="30" name='' id='' ></textarea> </td> </tr>
					</table>

				</div>

				<div style='margin:20px 0px 20px 0px;' >
					<span style='padding-right: 10px;'><input type='button' id='saveItemChanges_<?php echo $quality_id; ?>' value='Save Changes' ></span>
				</div>
			</div>

		</div>   <!-- coordinators_accordion -->


 