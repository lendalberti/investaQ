

<?php

	$item_id = $data['BtoItems_model']->id;
	$assembly_bto_status =  displayMfgQuoteStatus($data['BtoStatus'][BtoGroups::ASSEMBLY-1]->status_id);
	$test_bto_status     =  displayMfgQuoteStatus($data['BtoStatus'][BtoGroups::TEST-1]->status_id); 
	$quality_bto_status  =  displayMfgQuoteStatus($data['BtoStatus'][BtoGroups::QUALITY-1]->status_id);  

	$assembly_id = "$item_id" . "_" . BtoGroups::ASSEMBLY ;
	$test_id     = "$item_id" . "_" . BtoGroups::TEST ;
	$quality_id  = "$item_id" . "_" . BtoGroups::QUALITY ;

	$criteria = new CDbCriteria();
	$criteria->addCondition("bto_item_id = $item_id" );
	$modelItems =  BtoStatus::model()->find($criteria);

	$assembly_approver = $data['BtoStatus'][BtoGroups::ASSEMBLY-1]->approver->fullname;
	$test_approver     = $data['BtoStatus'][BtoGroups::TEST-1]->approver->fullname;
	$quality_approver  = $data['BtoStatus'][BtoGroups::QUALITY-1]->approver->fullname;



?>



			<!--   BTO Approvers -->
			<div id="approvers_accordion" style='margin-top: 20px;'>


				<input type='hidden' id='itemID' value='<?php echo $item_id; ?>' >

				<h3><span 'font-weight: bold;'>Assembly</span><span style='font-variant: small-caps;'> (<?php echo $assembly_approver; ?>)</span></h3>
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

				<h3><span 'font-weight: bold;'>Test</span><span style='font-variant: small-caps;'> (<?php echo $test_approver; ?>)</span></h3>
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

				<h3><span 'font-weight: bold;'>Quality</span><span style='font-variant: small-caps;'> (<?php echo $quality_approver; ?>)</span></h3>
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
			</div> <!--    approvers_accordion -->
 