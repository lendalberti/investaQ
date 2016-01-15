<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_no')); ?>:</b>
	<?php echo CHtml::encode($data->quote_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('additional_notes')); ?>:</b>
	<?php echo CHtml::encode($data->additional_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('terms_conditions')); ?>:</b>
	<?php echo CHtml::encode($data->terms_conditions); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated')); ?>:</b>
	<?php echo CHtml::encode($data->updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_acknowledgment')); ?>:</b>
	<?php echo CHtml::encode($data->customer_acknowledgment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('risl')); ?>:</b>
	<?php echo CHtml::encode($data->risl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturing_lead_time')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturing_lead_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiration_date')); ?>:</b>
	<?php echo CHtml::encode($data->expiration_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lost_reason_id')); ?>:</b>
	<?php echo CHtml::encode($data->lost_reason_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_bid_reason_id')); ?>:</b>
	<?php echo CHtml::encode($data->no_bid_reason_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ready_to_order')); ?>:</b>
	<?php echo CHtml::encode($data->ready_to_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bto')); ?>:</b>
	<?php echo CHtml::encode($data->bto); ?>
	<br />

	*/ ?>

</div>