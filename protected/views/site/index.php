<?php $this->pageTitle=Yii::app()->name;  ?>

<!-- <span class='pageTitle'><?php echo CHtml::encode(Yii::app()->name); ?></span> -->
<!-- 
<div style='margin: 30px 10px 10px 10px;'>
	<ul>
		<li><a href='< ?php echo Yii::app()->homeUrl; ?>/quotes/index/stock'>Stock Quote</a></li>
		<li><a href='< ?php echo Yii::app()->homeUrl; ?>/quotes/index/mfg'>Manufacturing Quote</a></li>
		<li><a href='< ?php echo Yii::app()->homeUrl; ?>/quotes/index/srf'>Supplier Request Form</a></li>
</div> -->

<?php

		if ( Yii::app()->user->isLoggedIn ) { ?>
			<div id='dashboard_div'>
				<table id='dashboard_table' style='border: 1px solid lightblue;'><caption>My Quotes Board</caption>
					<tr>	<td>Pending</td>       <td><?php echo getMyQuoteCount(Status::WAITING_APPROVAL); ?></td>          <td>Ready</td>   	   <td><?php echo getMyQuoteCount(Status::READY); ?></td>   </tr>  
					<tr>	<td>Order Placed</td>  <td><?php echo getMyQuoteCount(Status::ORDER_PLACED); ?></td>              <td>Draft</td>       <td><?php echo getMyQuoteCount(Status::DRAFT); ?></td>   </tr>  
					<tr>	<td>Submitted</td>     <td><?php echo getMyQuoteCount(Status::SUBMITTED_CUSTOMER); ?></td>        <td>Won</td>         <td><?php echo getMyQuoteCount(Status::WON); ?></td>     </tr> 
					<tr>	<td>BTO Pending</td>   <td><?php echo getMyQuoteCount(Status::SUBMITTED_CUSTOMER); ?></td>        <td>Lost</td>        <td><?php echo getMyQuoteCount(Status::LOST); ?></td>    </tr>
					<tr>	<td>BTO Ready</td>   <td><?php echo getMyQuoteCount(Status::SUBMITTED_CUSTOMER); ?></td>          <td>NoBid</td>       <td><?php echo getMyQuoteCount(Status::NO_BID); ?></td>  </tr>
				</table>
			</div>
		<?php } ?>
