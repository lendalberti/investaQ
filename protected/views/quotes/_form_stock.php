<?php
/* @var $this QuotesController */
/* @var $model Quotes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'quotes-form',
	'enableAjaxValidation'=>false,
)); ?>


<h1>Create Stock Quote</h1>



	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'quote_no'); ?>
		<?php echo $form->textField($model,'quote_no',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'quote_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quote_type_id'); ?>
		<?php echo $form->textField($model,'quote_type_id'); ?>
		<?php echo $form->error($model,'quote_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_id'); ?>
		<?php echo $form->textField($model,'status_id'); ?>
		<?php echo $form->error($model,'status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_id'); ?>
		<?php echo $form->textField($model,'owner_id'); ?>
		<?php echo $form->error($model,'owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
		<?php echo $form->error($model,'updated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expiration_date'); ?>
		<?php echo $form->textField($model,'expiration_date'); ?>
		<?php echo $form->error($model,'expiration_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'level_id'); ?>
		<?php echo $form->textField($model,'level_id'); ?>
		<?php echo $form->error($model,'level_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_id'); ?>
		<?php echo $form->textField($model,'source_id'); ?>
		<?php echo $form->error($model,'source_id'); ?>
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
		<?php echo $form->labelEx($model,'requested_part_number'); ?>
		<?php echo $form->textField($model,'requested_part_number',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'requested_part_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'generic_part_number'); ?>
		<?php echo $form->textField($model,'generic_part_number',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'generic_part_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity1'); ?>
		<?php echo $form->textField($model,'quantity1'); ?>
		<?php echo $form->error($model,'quantity1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity2'); ?>
		<?php echo $form->textField($model,'quantity2'); ?>
		<?php echo $form->error($model,'quantity2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity3'); ?>
		<?php echo $form->textField($model,'quantity3'); ?>
		<?php echo $form->error($model,'quantity3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'die_manufacturer_id'); ?>
		<?php echo $form->textField($model,'die_manufacturer_id'); ?>
		<?php echo $form->error($model,'die_manufacturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'package_type_id'); ?>
		<?php echo $form->textField($model,'package_type_id'); ?>
		<?php echo $form->error($model,'package_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lead_count'); ?>
		<?php echo $form->textField($model,'lead_count'); ?>
		<?php echo $form->error($model,'lead_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'process_flow_id'); ?>
		<?php echo $form->textField($model,'process_flow_id'); ?>
		<?php echo $form->error($model,'process_flow_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'testing_id'); ?>
		<?php echo $form->textField($model,'testing_id'); ?>
		<?php echo $form->error($model,'testing_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'priority_id'); ?>
		<?php echo $form->textField($model,'priority_id'); ?>
		<?php echo $form->error($model,'priority_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temp_low'); ?>
		<?php echo $form->textField($model,'temp_low',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'temp_low'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temp_high'); ?>
		<?php echo $form->textField($model,'temp_high',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'temp_high'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ncnr'); ?>
		<?php echo $form->textField($model,'ncnr'); ?>
		<?php echo $form->error($model,'ncnr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itar'); ?>
		<?php echo $form->textField($model,'itar'); ?>
		<?php echo $form->error($model,'itar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'have_die'); ?>
		<?php echo $form->textField($model,'have_die'); ?>
		<?php echo $form->error($model,'have_die'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spa'); ?>
		<?php echo $form->textField($model,'spa'); ?>
		<?php echo $form->error($model,'spa'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->