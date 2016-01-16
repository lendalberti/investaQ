<?php
/* @var $this ItemsController */
/* @var $data Items */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_id')); ?>:</b>
	<?php echo CHtml::encode($data->quote_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('part_no')); ?>:</b>
	<?php echo CHtml::encode($data->part_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('line_note')); ?>:</b>
	<?php echo CHtml::encode($data->line_note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_code')); ?>:</b>
	<?php echo CHtml::encode($data->date_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_1_24')); ?>:</b>
	<?php echo CHtml::encode($data->qty_1_24); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_25_99')); ?>:</b>
	<?php echo CHtml::encode($data->qty_25_99); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_100_499')); ?>:</b>
	<?php echo CHtml::encode($data->qty_100_499); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_500_999')); ?>:</b>
	<?php echo CHtml::encode($data->qty_500_999); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_1000_Plus')); ?>:</b>
	<?php echo CHtml::encode($data->qty_1000_Plus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_Base')); ?>:</b>
	<?php echo CHtml::encode($data->qty_Base); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_Custom')); ?>:</b>
	<?php echo CHtml::encode($data->qty_Custom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_NoBid')); ?>:</b>
	<?php echo CHtml::encode($data->qty_NoBid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_Available')); ?>:</b>
	<?php echo CHtml::encode($data->qty_Available); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_1_24')); ?>:</b>
	<?php echo CHtml::encode($data->price_1_24); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_25_99')); ?>:</b>
	<?php echo CHtml::encode($data->price_25_99); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_100_499')); ?>:</b>
	<?php echo CHtml::encode($data->price_100_499); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_500_999')); ?>:</b>
	<?php echo CHtml::encode($data->price_500_999); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_1000_Plus')); ?>:</b>
	<?php echo CHtml::encode($data->price_1000_Plus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_Base')); ?>:</b>
	<?php echo CHtml::encode($data->price_Base); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_Custom')); ?>:</b>
	<?php echo CHtml::encode($data->price_Custom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_updated')); ?>:</b>
	<?php echo CHtml::encode($data->last_updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comments')); ?>:</b>
	<?php echo CHtml::encode($data->comments); ?>
	<br />

	*/ ?>

</div>