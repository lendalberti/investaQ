
<?php

	if ( !Yii::app()->user->isProposalManager ) {
		if ( $data['model']->status_id == Status::BTO_PENDING ) {
			$s = "Process approval is pending...";
		}
		else if ( $data['model']->status_id == Status::DRAFT ) {
			$s = "Quote hasn't been submitted for approval yet.";
		}
		else {
			$s = "Unknown status...";
		}
		echo "<span id='process_approval_status' style='color: #2C6371; font-size: 1.1em;'>$s</span>";
	}
	else {
		// user is Proposal Manager
		echo "<span id='process_approval_status' style='color: #2C6371; font-size: 1.1em;'>As Proposal Manager you get to see a different screen...</span>";







































		
	}

	

?>