
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
			
				<!-- <div class='grid_16 ' style='margin-bottom: 50px;'>
					<span style='padding-left: 68px; color: #a31128; '>Select Process Coordinators</span>
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
 -->
				<!-- 	<div class="clear">&nbsp;</div>
					<div class='push_1' style='font-variant: small-caps; margin-top: 10px;'>
						<div class='grid_8 '>
							<input type='text' id='approver_notification_message' name='' placeholder="Enter notification message" size='70' /> 
							<input type='button' id='button_NotifyApprovers'  value='Send' style='margin-top: 5px;padding: 10px; font-weight: bold;'/>
						</div>
					</div>
 -->

				<div><span id='link_SendMesage' >Send a message to your coordinators</span></div>
				<div class="clear">&nbsp;</div>

				<div style='margin-left: 80px;'>
					<div id='div_SendMessage' style='display: none; width: 800px; height: 600px; border: 0px solid lightgreen; margin: 10px;'>

						<div class='grid_16 ' style='margin: 10px;'>

							<!-- <span style='padding-left: 10px; color: #a31128; '>Select Process Coordinators</span> -->
							<div class='push_1' style='font-variant: small-caps; margin-top: 10px;'>

								<div class='grid_3 '>
								<span style='padding-left: 0px; color: #a31128; font-weight: bold;'>Select Process <br /> Coordinators</span>
								</div>

								<div class='grid_3 ' style='text-align: center;'>
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
								</div>

								<div class='grid_3 ' style='text-align: center;'>
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
								</div>

								<div class='grid_3 ' style='text-align: center;'>
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
								</div>

								<div class='grid_3 ' style='text-align: center;'>
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
								</div>
							</div>

							<div class="clear">&nbsp;</div>

							<div style='margin-top: 20px; padding: 10px 0px 0px 10px; background-color: lightgray; height: 30px;'>
								<span style='padding: 0;font-weight: bold;'>Subject:</span>
								<input id='text_Subject' placeholder='Enter subject here...' size='50'>
							</div>
							<div>
								<textarea id='text_Message' placeholder='Enter message here and click "Send"...'></textarea>
								<input type='button' id='button_SendMessage' value='Send' style='margin: 5px; padding: 5px 10px 5px 10px;'>
							</div>
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
				<div class='grid_16 grid_outline_Msg'>
					<?php 
							foreach( $data['bto_messages'] as $row ) {
								echo "<span style='font-size: .8em;' >$row</span><br />";
							}
					?>
				</div>

				<div class="clear">&nbsp;</div>
					
				<div><span id='link_SendMesage' >Send a message to your coordinators</span></div>
				<div id='div_SendMessage' style='display: none; width: 600px; height: 400px; border: 0px solid lightgray; margin: 10px;'>

					<div style='margin-top: 20px; padding: 10px 0px 0px 10px; background-color: lightgray; height: 30px;'>
						<span style='padding: 0;font-weight: bold;'>Subject:</span>
						<input id='text_Subject' placeholder='Enter subject here...' size='50'>
					</div>
					<div>
						<textarea id='text_Message' placeholder='Enter message here and click "Send"...'></textarea>
						<input type='button' id='button_SendMessage' value='Send' style='margin: 5px; padding: 5px 10px 5px 10px;'>
					</div>

				</div>

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


