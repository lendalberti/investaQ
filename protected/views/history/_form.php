<?php
/* @var $this HistoryController */
/* @var $model History */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'history-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'quote_id'); ?>
		<?php echo $form->textField($model,'quote_id'); ?>
		<?php echo $form->error($model,'quote_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quote_no'); ?>
		<?php echo $form->textField($model,'quote_no',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'quote_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'part_no'); ?>
		<?php echo $form->textField($model,'part_no',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'part_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->textField($model,'type_id'); ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'manufacturer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_code'); ?>
		<?php echo $form->textField($model,'date_code',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'date_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_id'); ?>
		<?php echo $form->textField($model,'contact_id'); ?>
		<?php echo $form->error($model,'contact_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'salesperson_id'); ?>
		<?php echo $form->textField($model,'salesperson_id'); ?>
		<?php echo $form->error($model,'salesperson_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_id'); ?>
		<?php echo $form->textField($model,'status_id'); ?>
		<?php echo $form->error($model,'status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lost_reason_id'); ?>
		<?php echo $form->textField($model,'lost_reason_id'); ?>
		<?php echo $form->error($model,'lost_reason_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'no_bid_reason_id'); ?>
		<?php echo $form->textField($model,'no_bid_reason_id'); ?>
		<?php echo $form->error($model,'no_bid_reason_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_price'); ?>
		<?php echo $form->textField($model,'unit_price'); ?>
		<?php echo $form->error($model,'unit_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->