<?php
/* @var $this QuotesController */
/* @var $data Quotes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_no')); ?>:</b>
	<?php echo CHtml::encode($data->quote_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->quote_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('owner_id')); ?>:</b>
	<?php echo CHtml::encode($data->owner_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiration_date')); ?>:</b>
	<?php echo CHtml::encode($data->expiration_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level_id')); ?>:</b>
	<?php echo CHtml::encode($data->level_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_id')); ?>:</b>
	<?php echo CHtml::encode($data->source_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('additional_notes')); ?>:</b>
	<?php echo CHtml::encode($data->additional_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('terms_conditions')); ?>:</b>
	<?php echo CHtml::encode($data->terms_conditions); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('lost_reason_id')); ?>:</b>
	<?php echo CHtml::encode($data->lost_reason_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_bid_reason_id')); ?>:</b>
	<?php echo CHtml::encode($data->no_bid_reason_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ready_to_order')); ?>:</b>
	<?php echo CHtml::encode($data->ready_to_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_part_number')); ?>:</b>
	<?php echo CHtml::encode($data->requested_part_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('generic_part_number')); ?>:</b>
	<?php echo CHtml::encode($data->generic_part_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity1')); ?>:</b>
	<?php echo CHtml::encode($data->quantity1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity2')); ?>:</b>
	<?php echo CHtml::encode($data->quantity2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity3')); ?>:</b>
	<?php echo CHtml::encode($data->quantity3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('die_manufacturer_id')); ?>:</b>
	<?php echo CHtml::encode($data->die_manufacturer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('package_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->package_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lead_count')); ?>:</b>
	<?php echo CHtml::encode($data->lead_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('process_flow_id')); ?>:</b>
	<?php echo CHtml::encode($data->process_flow_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('testing_id')); ?>:</b>
	<?php echo CHtml::encode($data->testing_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('priority_id')); ?>:</b>
	<?php echo CHtml::encode($data->priority_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temp_low')); ?>:</b>
	<?php echo CHtml::encode($data->temp_low); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temp_high')); ?>:</b>
	<?php echo CHtml::encode($data->temp_high); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ncnr')); ?>:</b>
	<?php echo CHtml::encode($data->ncnr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itar')); ?>:</b>
	<?php echo CHtml::encode($data->itar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('have_die')); ?>:</b>
	<?php echo CHtml::encode($data->have_die); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spa')); ?>:</b>
	<?php echo CHtml::encode($data->spa); ?>
	<br />

	*/ ?>

</div>