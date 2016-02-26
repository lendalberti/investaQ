
<?php

	$q                 = $data['model']; 
	$approversNotified = $data['BtoItems_model']->approvers_notified;

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
	else if ( !$approversNotified ) {  ?>

	<div class="container_16" style='border: 0px solid gray; '>
	
		<div class='grid_16 ' style='margin-bottom: 50px;'>
			<span style='padding-left: 68px; color: #a31128; '>Select BTO Approvers to notify and then click Send:</span>
			<div class='push_1' style='font-variant: small-caps; margin-top: 10px;'>

				<div class='grid_3 '>
					<span style='font-weight: bold;'> Assembly</span><br />   <select><option>Select an approver</option><option>N/A</option><option>Jaime Vaitcher</option><option>Chuck Shermer</option><option>Trevor Pounder</option></select></span>
				</div>
				<div class='grid_3 '>
					<span style='font-weight: bold;'>Production</span><br />   <select><option>Select an approver</option><option>N/A</option><option>Rene Grandmaison</option></select></span>
				</div>
				<div class='grid_3 '>
					<span style='font-weight: bold;'>Testing</span><br />   <select><option>Select an approver</option><option>N/A</option><option>Peter Crudele</option><option>Gary Francona</option></select></span>
				</div>
				<div class='grid_3 '>
					<span style='font-weight: bold;'>Quality</span><br />   <select><option>Select an approver</option><option>N/A</option><option>Steve Lombard</option><option>Bob Buchanon</option><option>Steve Herschfeld</option></select></span>
				</div>
			</div>

			<div class="clear">&nbsp;</div>
			<div class='push_1' style='font-variant: small-caps; margin-top: 10px;'>
				<div class='grid_8 '>
					<input type='text' id='approver_notification_message' name='' placeholder="Enter notification message" size='70' style='margin-top: 15px; padding: 10px; '/> 
					<input type='button' id='button_NotifyApprovers'  value='Send' style='margin-top: 5px;padding: 10px; font-weight: bold;'/>
				</div>
			</div>
		</div>

<?php } else { ?>

		<div class="clear">&nbsp;</div>
	   
	    <div class='grid_4 grid_outline_50' >
			Current Status: PENDING
		</div>
		
		<div class='push_2'>
			<div class='grid_2 grid_outline_50'>
			Assembly
			</div>
			<div class='grid_2 grid_outline_50'>
			Production
			</div>
			<div class='grid_2 grid_outline_50'>
			Testing
			</div>
			<div class='grid_2 grid_outline_50'>
			Quality
			</div>
		</div>


		<div class='grid_14 grid_outline_150'>
		Notes:
		</div>

		<div class='grid_9 grid_outline_50'>
		Add Note
		</div>

		<div class='push_2' >
			<div class='grid_3 grid_outline_50'>
				Save Changes
			</div>
		</div>

		<div class="clear">&nbsp;</div>

		<div class='push_6' >
			<div class='grid_3 grid_outline_20'> 
				Notify all groups
			</div>
		</div>


		<div class='grid_14 grid_outline_80'> 
		Attachments:
		</div>

	</div><!-- container -->

	<!--   BTO Approvers -->
	<div id="approvers_accordion" style='margin-top: 50px;'>
		<h3>Assembly</h3>
		<div>
		    <p>
		    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
		    </p>
		</div>

		<h3>Production</h3>
		<div>
				<span style='font-size: .9em; font-weight: bold;'>Rene Grandmaison</span>
				<span style='padding-left: 500px;font-size: .9em; font-weight: normal;'>Status: PENDING</span>
		    <p>
		    



		    </p>
		</div>

		<h3>Testing</h3>
		<div>
		    <p>
		    Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
		    Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
		    ac tellus pellentesque semper. Sed ac felisMauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.. Sed commodo, magna quis
		    lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
		    </p>
		    <ul>
		      <li>List item one</li>
		      <li>List item two</li>
		      <li>List item three</li>
		    </ul>
		</div>

		<h3>Quality</h3>
		<div>
		    <p>
		    Cras dictum. Pellentesque habitant morbi tristique senectus et netus
		    et malesuada fames ac turpis egestas. VestMauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.ibulum ante ipsum primis in
		    faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
		    mauris vel est.
		    </p>
		    <p>
		    Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
		    Class aptent taciti Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
		    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
		    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
		    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.sociosqu ad litora torquent per conubia nostra, per
		    inceptos himenaeos.
		    </p>
		</div>
	</div> <!--    approvers_accordion -->
 

<?php } ?>
