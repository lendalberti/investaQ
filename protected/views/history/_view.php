<?php
/* @var $this HistoryController */
/* @var $data History */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_id')); ?>:</b>
	<?php echo CHtml::encode($data->quote_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_no')); ?>:</b>
	<?php echo CHtml::encode($data->quote_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('part_no')); ?>:</b>
	<?php echo CHtml::encode($data->part_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_id')); ?>:</b>
	<?php echo CHtml::encode($data->type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_code')); ?>:</b>
	<?php echo CHtml::encode($data->date_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_id')); ?>:</b>
	<?php echo CHtml::encode($data->contact_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('salesperson_id')); ?>:</b>
	<?php echo CHtml::encode($data->salesperson_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lost_reason_id')); ?>:</b>
	<?php echo CHtml::encode($data->lost_reason_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_bid_reason_id')); ?>:</b>
	<?php echo CHtml::encode($data->no_bid_reason_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_price')); ?>:</b>
	<?php echo CHtml::encode($data->unit_price); ?>
	<br />

	*/ ?>

</div>