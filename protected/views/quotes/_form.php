<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'quotes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'quote_no'); ?>
		<?php echo $form->textField($model,'quote_no',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'quote_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_id'); ?>
		<?php echo $form->textField($model,'status_id'); ?>
		<?php echo $form->error($model,'status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'additional_notes'); ?>
		<?php echo $form->textArea($model,'additional_notes',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'additional_notes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'terms_conditions'); ?>
		<?php echo $form->textArea($model,'terms_conditions',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'terms_conditions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated'); ?>
		<?php echo $form->textField($model,'updated'); ?>
		<?php echo $form->error($model,'updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_acknowledgment'); ?>
		<?php echo $form->textArea($model,'customer_acknowledgment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'customer_acknowledgment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'risl'); ?>
		<?php echo $form->textArea($model,'risl',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'risl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturing_lead_time'); ?>
		<?php echo $form->textArea($model,'manufacturing_lead_time',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'manufacturing_lead_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expiration_date'); ?>
		<?php echo $form->textField($model,'expiration_date'); ?>
		<?php echo $form->error($model,'expiration_date'); ?>
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
		<?php echo $form->labelEx($model,'ready_to_order'); ?>
		<?php echo $form->textField($model,'ready_to_order'); ?>
		<?php echo $form->error($model,'ready_to_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bto'); ?>
		<?php echo $form->textField($model,'bto'); ?>
		<?php echo $form->error($model,'bto'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->