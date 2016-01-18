<?php
/* @var $this AttachmentsController */
/* @var $data Attachments */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_id')); ?>:</b>
	<?php echo CHtml::encode($data->quote_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
	<?php echo CHtml::encode($data->filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_type')); ?>:</b>
	<?php echo CHtml::encode($data->content_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
	<?php echo CHtml::encode($data->size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('md5')); ?>:</b>
	<?php echo CHtml::encode($data->md5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uploaded_date')); ?>:</b>
	<?php echo CHtml::encode($data->uploaded_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('uploaded_by')); ?>:</b>
	<?php echo CHtml::encode($data->uploaded_by); ?>
	<br />

	*/ ?>

</div>