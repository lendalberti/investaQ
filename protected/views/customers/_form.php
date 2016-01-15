<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address1'); ?>
		<?php echo $form->textField($model,'address1',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'address1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address2'); ?>
		<?php echo $form->textField($model,'address2',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'address2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state_id'); ?>
		<?php echo $form->textField($model,'state_id'); ?>
		<?php echo $form->error($model,'state_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zip'); ?>
		<?php echo $form->textField($model,'zip',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'zip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->textField($model,'country_id'); ?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'class_id'); ?>
		<?php echo $form->textField($model,'class_id'); ?>
		<?php echo $form->error($model,'class_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'region_id'); ?>
		<?php echo $form->textField($model,'region_id'); ?>
		<?php echo $form->error($model,'region_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'territories'); ?>
		<?php echo $form->textField($model,'territories',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'territories'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vertical_market'); ?>
		<?php echo $form->textField($model,'vertical_market',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'vertical_market'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->textField($model,'parent_id'); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_link'); ?>
		<?php echo $form->textField($model,'company_link',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'company_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'syspro_account_code'); ?>
		<?php echo $form->textField($model,'syspro_account_code',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'syspro_account_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'xmas_list'); ?>
		<?php echo $form->textField($model,'xmas_list'); ?>
		<?php echo $form->error($model,'xmas_list'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'candy_list'); ?>
		<?php echo $form->textField($model,'candy_list'); ?>
		<?php echo $form->error($model,'candy_list'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'strategic'); ?>
		<?php echo $form->textField($model,'strategic'); ?>
		<?php echo $form->error($model,'strategic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tier_id'); ?>
		<?php echo $form->textField($model,'tier_id'); ?>
		<?php echo $form->error($model,'tier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inside_salesperson_id'); ?>
		<?php echo $form->textField($model,'inside_salesperson_id'); ?>
		<?php echo $form->error($model,'inside_salesperson_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'outside_salesperson_id'); ?>
		<?php echo $form->textField($model,'outside_salesperson_id'); ?>
		<?php echo $form->error($model,'outside_salesperson_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->