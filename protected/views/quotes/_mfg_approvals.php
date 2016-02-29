
<?php

	$q                 = $data['model']; 
	$approversNotified = $data['BtoItems_model']->approvers_notified;

	$blank   = Yii::app()->request->baseUrl . "/images/New/button_blank.png";
	$pending = Yii::app()->request->baseUrl . "/images/New/button_yellow.png";
	$ready   = Yii::app()->request->baseUrl . "/images/New/button_green.png";
	$blocked = Yii::app()->request->baseUrl . "/images/New/button_red.png";



	if (  $q->status_id == Status::BTO_PENDING && Yii::app()->user->isProposalManager ) {
		if ( !$approversNotified ) {  ?>
			<div class="container_15 grid_outline_350">
			
				<div class='grid_16 ' style='margin-bottom: 50px;'>
					<span style='padding-left: 68px; color: #a31128; '>Select BTO Approvers to notify and then click Send:</span>
					<div class='push_1' style='font-variant: small-caps; margin-top: 10px;'>

						<div class='grid_3 '>
							<span style='font-weight: bold;'> Assembly</span><br />   
								<select id='approver_Assembly'>
									<?php 
											echo "<option></option>";
											foreach( $data['bto_approvers'][BtoGroups::ASSEMBLY] as $k=>$v ) {
												foreach( $v as $id => $fullname ) {
													echo "<option value='$id'>$fullname</option>";
												}
											} 
									?>
								</select>
							</span>
						</div>

						<div class='grid_3 '>
							<span style='font-weight: bold;'> Production</span><br />   
								<select id='approver_Production'>
									<?php 
											echo "<option></option>";
											foreach( $data['bto_approvers'][BtoGroups::PRODUCTION] as $k=>$v ) {
												foreach( $v as $id => $fullname ) {
													echo "<option value='$id'>$fullname</option>";
												}
											} 
									?>
								</select>
							</span>
						</div>

						<div class='grid_3 '>
							<span style='font-weight: bold;'> Test</span><br />   
								<select id='approver_Test'>
									<?php 
											echo "<option></option>";
											foreach( $data['bto_approvers'][BtoGroups::TEST] as $k=>$v ) {
												foreach( $v as $id => $fullname ) {
													echo "<option value='$id'>$fullname</option>";
												}
											} 
									?>
								</select>
							</span>
						</div>

						<div class='grid_3 '>
							<span style='font-weight: bold;'> Quality</span><br />   
								<select id='approver_Quality'>
									<?php 
											echo "<option></option>";
											foreach( $data['bto_approvers'][BtoGroups::QUALITY] as $k=>$v ) {
												foreach( $v as $id => $fullname ) {
													echo "<option value='$id'>$fullname</option>";
												}
											} 
									?>
								</select>
							</span>
						</div>

					</div>

					<div class="clear">&nbsp;</div>
					<div class='push_1' style='font-variant: small-caps; margin-top: 10px;'>
						<div class='grid_8 '>
							<input type='text' id='approver_notification_message' name='' placeholder="Enter notification message" size='70' /> 
							<input type='button' id='button_NotifyApprovers'  value='Send' style='margin-top: 5px;padding: 10px; font-weight: bold;'/>
						</div>
					</div>
				</div>
			</div>
		<?php } else { ?>

			<div class="container_16" style='padding-bottom: 20px; border: 0px solid red; '>
			   
				 <div class='grid_4 grid_outline_50' > 
					Current Status:<span style='font-weight: bold; color: #a31128'> PENDING </span>
					<br />
					<select>
						<option>Update status to...</option>
						<option>Pending</option>
						<option>Approved</option>
						<option>Rejected</option>
					</select>

				</div>
				
				<div class='push_3'>

					<div class='grid_2 grid_outline_50'>
					<span class='button_StatusTitle'>Assembly</span>
					<br /><img src='<?php echo $pending;?>' id='status_Assembly'  width="30" height="30">
					</div>

					<div class='grid_2 grid_outline_50'>
					<span class='button_StatusTitle'>Production</span>
					<br /><img src='<?php echo $pending; ?>' id='status_Production' width="30" height="30">
					</div>
					
					<div class='grid_2 grid_outline_50'>
					<span class='button_StatusTitle'>Test</span>
					<br /><img src='<?php echo $blocked; ?>' id='status_Test' width="30" height="30">
					</div>

					<div class='grid_2 grid_outline_50'>
					<span class='button_StatusTitle'>Quality</span>
					<br /><img src='<?php echo $ready; ?>' id='status_Quality' width="30" height="30">
					</div>

				</div>

				<div class='grid_16' style='padding: 20px 0px 0px 5px;'><span style='font-weight: bold;'>Messages:</span></div>
				<div class='grid_16 grid_outline_150'>
					<?php 
							foreach( $data['bto_comments'] as $row ) {
								echo "<span style='font-size: .8em;' >$row</span><br />";
							}
					?>
				</div>

				<div class='push_1'>
					<div class='grid_16 ' style='padding-top: 5px; margin-top: 10px; '>
						<input id='coordinator_notification_message'  style='font-family: Courier; padding: 5px;' type='text' placeholder='Enter a message for your coordinators...' size='70'>
						<input type='button' id='button_SendMessage' value='Send Message'> 
					</div>
				</div>

				<!-- <div class='push_1' > -->
					<div class='grid_2' style='padding-top: 10px; margin-top: 10px;'>
						
					</div>
				<!-- </div> -->

				<div class="clear">&nbsp;</div>

				<div class='grid_16' style='padding: 20px 0px 0px 5px;'><span style='font-weight: bold;'>Attachments:</span></div>
				<div class='grid_16 grid_outline_80'>
					<?php 
							foreach( $data['attachments'] as $row ) {
								echo "<span style='font-size: .8em;' >$row</span><br />";
							}
					?>
				</div>

			</div><!-- container -->


			<div class="clear">&nbsp;</div>

			<!--   BTO Approvers -->
			<div id="approvers_accordion" style='display: none; margin-top: 50px;'>
				<h3>Assembly</h3>
				<div>
						<span style='font-size: .9em; font-weight: bold;'>xxxxxxxxxxx</span>
						<span style='padding-left: 500px;font-size: .9em; font-weight: normal;'>Status: PENDING</span>
				</div>

				<h3>Production</h3>
				<div>
						<span style='font-size: .9em; font-weight: bold;'>xxxxxxxxxxx</span>
						<span style='padding-left: 500px;font-size: .9em; font-weight: normal;'>Status: PENDING</span>
				   
				</div>

				<h3>Test</h3>
				<div>
						<span style='font-size: .9em; font-weight: bold;'>xxxxxxxxxxx</span>
						<span style='padding-left: 500px;font-size: .9em; font-weight: normal;'>Status: PENDING</span>
				</div>

				<h3>Quality</h3>
				<div>
						<span style='font-size: .9em; font-weight: bold;'>xxxxxxxxxxx</span>
						<span style='padding-left: 500px;font-size: .9em; font-weight: normal;'>Status: PENDING</span>
				</div>
			</div> <!--    approvers_accordion -->
 

		<?php } ?>
	<?php } 


	else if ( $q->status_id == Status::DRAFT ) {
		$s = "Quote hasn't been submitted for approval yet.";
		echo "<span id='process_approval_status' style='color: #2C6371; font-size: 1.1em;'>$s</span>";
	}
	else if (  $q->status_id == Status::BTO_PENDING && !Yii::app()->user->isProposalManager ) {
		$s = "Process approval is pending...";
		echo "<span id='process_approval_status' style='color: #2C6371; font-size: 1.1em;'>$s</span>";
	}
	else {
		$s = "Unknown status...";
		echo "<span id='process_approval_status' style='color: #2C6371; font-size: 1.1em;'>$s</span>";
	}


?>


