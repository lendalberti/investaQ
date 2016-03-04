

<?php

	$item_id = $data['BtoItems_model']->id;
	$assembly_bto_status =  displayMfgQuoteStatus($data['BtoItemStatus'][Groups::ASSEMBLY-1]->status_id);
	$test_bto_status     =  displayMfgQuoteStatus($data['BtoItemStatus'][Groups::TEST-1]->status_id); 
	$quality_bto_status  =  displayMfgQuoteStatus($data['BtoItemStatus'][Groups::QUALITY-1]->status_id);  

	$assembly_id = "$item_id" . "_" . Groups::ASSEMBLY ;
	$test_id     = "$item_id" . "_" . Groups::TEST ;
	$quality_id  = "$item_id" . "_" . Groups::QUALITY ;

	$criteria = new CDbCriteria();
	$criteria->addCondition("bto_item_id = $item_id" );
	$modelItems =  BtoItemStatus::model()->find($criteria);

	$assembly_coordinator = $data['BtoItemStatus'][Groups::ASSEMBLY-1]->coordinator->fullname;
	$test_coordinator     = $data['BtoItemStatus'][Groups::TEST-1]->coordinator->fullname;
	$quality_coordinator  = $data['BtoItemStatus'][Groups::QUALITY-1]->coordinator->fullname;

?>

		<div id="coordinators_accordion">

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
						Assembly NRE Charge: <br />
						Assembly Location: <br />
						Bond Diagram? <br />
						Package Type: <br />
						Assembly Lead Time (weeks): <br />

						Customer Viewable Proposal Notes: <br />
						Internal Exception Notes: <br />
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
						Test BI NRE Charge: <br />

						Test Software NRE Charge: <br />
						Software lead Time (weeks):

						Test Hardware NRE Charge: <br />
						Hardware lead Time (weeks):

						Customer Viewable Proposal Notes: <br />
						Internal Exception Notes: <br />
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
					Customer Viewable Proposal Notes: <br />
					Internal Exception Notes: <br />
				</div>

				<div style='margin:20px 0px 20px 0px;' >
					<span style='padding-right: 10px;'><input type='button' id='saveItemChanges_<?php echo $quality_id; ?>' value='Save Changes' ></span>
				</div>
			</div>

		</div>   <!-- coordinators_accordion -->


 