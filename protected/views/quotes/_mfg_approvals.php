
<?php

	$q  = $data['model']; 

	if ( !Yii::app()->user->isProposalManager ) {
		if ( $q->status_id == Status::BTO_PENDING ) {
			$s = "Process approval is pending...";
		}
		else if ( $q->status_id == Status::DRAFT ) {
			$s = "Quote hasn't been submitted for approval yet.";
		}
		else {
			$s = "Unknown status...";
		}
		echo "<span id='process_approval_status' style='color: #2C6371; font-size: 1.1em;'>$s</span>";
	}
	else { ?>


<div class="container_16" style='border: 0px solid gray; '>
   
	<div class='grid_4' style='background-color: yellow; height: 50px;'>
		Current Status: PENDING
	</div>

	
	<div class='push_2'>
		<div class='grid_2' style='background-color: lightgreen; height: 50px;'>
		Assembly
		</div>
		<div class='grid_2' style='background-color: lightgreen; height: 50px;'>
		Production
		</div>
		<div class='grid_2' style='background-color: lightgreen; height: 50px;'>
		Testing
		</div>
		<div class='grid_2' style='background-color: lightgreen; height: 50px;'>
		Quality
		</div>
	</div>


	<div class='grid_14' style='margin-top: 10px; background-color: lightblue; height: 150px;'>
	Notes:
	</div>

	<div class='grid_5' style='margin-top: 10px; background-color: pink; height: 150px;'>
	Add Note
	</div>



	

</div><!-- container -->


































<?php } ?>
