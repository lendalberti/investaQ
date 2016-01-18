
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contacts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<h2>Contact Form</h2>

	<?php echo $form->errorSummary($modelContacts); ?>
 
	<div class="row">
		<?php echo $form->labelEx($modelContacts,'first_name'); ?>
		<?php echo $form->textField($modelContacts,'first_name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'last_name'); ?>
		<?php echo $form->textField($modelContacts,'last_name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'email'); ?>
		<?php echo $form->textField($modelContacts,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'title'); ?>
		<?php echo $form->textField($modelContacts,'title',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'phone1'); ?>
		<?php echo $form->textField($modelContacts,'phone1',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'phone1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'phone2'); ?>
		<?php echo $form->textField($modelContacts,'phone2',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'phone2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'address1'); ?>
		<?php echo $form->textField($modelContacts,'address1',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'address1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'address2'); ?>
		<?php echo $form->textField($modelContacts,'address2',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'address2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'city'); ?>
		<?php echo $form->textField($modelContacts,'city',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'state_id'); ?>
		<?php echo $form->textField($modelContacts,'state_id'); ?>
		<?php echo $form->error($modelContacts,'state_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'zip'); ?>
		<?php echo $form->textField($modelContacts,'zip',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelContacts,'zip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContacts,'country_id'); ?>
		<?php echo $form->textField($modelContacts,'country_id'); ?>
		<?php echo $form->error($modelContacts,'country_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($modelContacts->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>


</div><!-- form -->