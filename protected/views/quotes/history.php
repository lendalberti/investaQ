


<?php $this->layout = '//layouts/column1'; ?>

<h1>Quote History</h1>

<div style='height: 100px; border: 0px solid red; width: 100%'>

				<div style='float: left; padding: 5px 0px 0px 50px;'>
					<form class="searchform">
						<label for="searchBy">Lookup by:</label><br />
			            <select id="searchBy">
			                  <option value="1" selected>Part No.</option>
				   	    <input id="searchfield" class="searchfield" type="text"  />  
				   	    <input id="searchbutton" class="searchbutton" type="button" value="Go" />
					</form>
				</div>
				
</div>
<span style='clear: both'></span>

<table id='quotes_table' style=' table-layout:fixed; width:100%; padding-top: 10px;'>
	<thead>
		<tr>
			<th style='width:54px;'>Ouote ID</th>
			<th style='width:84px;'>Part No.</th>

			<th style='width:70px;'>Created</th>
			<th style='width:54px;'>Type</th>
			<th style='width:24px;'>Mfr</th>
			
			<th style='width:40px;'>Date Code</th>
			<th style='width:54px;'>Cust Name</th>
			<th style='width:94px;'>Location</th>
			
			<th style='width:54px;'>Contact</th>
			<th style='width:54px;'>Sales Person</th>
			<th style='width:44px;'>Status</th>
			
			<th style='width:54px;'>NoBid or Lost Reason</th>
			<th style='width:34px;'>Qty</th>
			<th style='width:44px;'>Unit Price</th>

		</tr>
	</thead> 

	<tbody>
		<?php
			setlocale(LC_MONETARY, 'en_US');
			foreach ( $quotes as $q ) {
				$ts = strtotime($q['Date']);
				echo "<tr><td>".$q['Opportunity_ID']."</td>";
				echo "<td>".$q['Part_Number']."</td>";

				echo "<td>".  date('M d Y', $ts) ."</td>";
				echo "<td>".$q['Type']."</td>";
				echo "<td>".$q['Mfr']."</td>";
				echo "<td>".$q['Date_Code']."</td>";

				echo "<td>".$q['Customer']."</td>";
				echo "<td>".$q['Location']."</td>";
				echo "<td>".$q['Contact']."</td>";
				echo "<td>".$q['Sales_Person']."</td>";

				echo "<td>".$q['Status']."</td>";
				echo "<td>".$q['No_Bid_Lost_Reason']."</td>";
				echo "<td>".number_format($q['Quantity'])."</td>";
				echo "<td>".money_format('%.2n', $q['Unit_Price'])."</td></tr>";
			} 
		?>
	</tbody>
</table>