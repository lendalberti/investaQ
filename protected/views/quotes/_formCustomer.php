

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<h2>Customer Form</h2>

	<?php echo $form->errorSummary($modelCustomers); ?>


	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'name'); ?>
		<select><option>Cust 1</option><option>Cust 2</option><option>Cust 3</option></select>
		<!-- // < ?php echo $form->textField($modelCustomers,'quote_no',array('size'=>45,'maxlength'=>45)); ?> -->
		<?php echo $form->error($modelCustomers,'name'); ?>
	</div> 

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'name'); ?>
		<?php echo $form->textField($modelCustomers,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelCustomers,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'address1'); ?>
		<?php echo $form->textField($modelCustomers,'address1',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelCustomers,'address1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'address2'); ?>
		<?php echo $form->textField($modelCustomers,'address2',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelCustomers,'address2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'city'); ?>
		<?php echo $form->textField($modelCustomers,'city',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelCustomers,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'state_id'); ?>
		<?php echo $form->textField($modelCustomers,'state_id'); ?>
		<?php echo $form->error($modelCustomers,'state_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'country_id'); ?>
		<?php echo $form->textField($modelCustomers,'country_id'); ?>
		<?php echo $form->error($modelCustomers,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'zip'); ?>
		<?php echo $form->textField($modelCustomers,'zip',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelCustomers,'zip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'region_id'); ?>
		<?php echo $form->textField($modelCustomers,'region_id'); ?>
		<?php echo $form->error($modelCustomers,'region_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'customer_type_id'); ?>
		<?php echo $form->textField($modelCustomers,'customer_type_id'); ?>
		<?php echo $form->error($modelCustomers,'customer_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'territory_id'); ?>
		<?php echo $form->textField($modelCustomers,'territory_id'); ?>
		<?php echo $form->error($modelCustomers,'territory_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'vertical_market'); ?>
		<?php echo $form->textField($modelCustomers,'vertical_market',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelCustomers,'vertical_market'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'parent_id'); ?>
		<?php echo $form->textField($modelCustomers,'parent_id'); ?>
		<?php echo $form->error($modelCustomers,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'company_link'); ?>
		<?php echo $form->textField($modelCustomers,'company_link',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelCustomers,'company_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'syspro_account_code'); ?>
		<?php echo $form->textField($modelCustomers,'syspro_account_code',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($modelCustomers,'syspro_account_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'xmas_list'); ?>
		<?php echo $form->textField($modelCustomers,'xmas_list'); ?>
		<?php echo $form->error($modelCustomers,'xmas_list'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'candy_list'); ?>
		<?php echo $form->textField($modelCustomers,'candy_list'); ?>
		<?php echo $form->error($modelCustomers,'candy_list'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'strategic'); ?>
		<?php echo $form->textField($modelCustomers,'strategic'); ?>
		<?php echo $form->error($modelCustomers,'strategic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'tier_id'); ?>
		<?php echo $form->textField($modelCustomers,'tier_id'); ?>
		<?php echo $form->error($modelCustomers,'tier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'inside_salesperson_id'); ?>
		<?php echo $form->textField($modelCustomers,'inside_salesperson_id'); ?>
		<?php echo $form->error($modelCustomers,'inside_salesperson_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelCustomers,'outside_salesperson_id'); ?>
		<?php echo $form->textField($modelCustomers,'outside_salesperson_id'); ?>
		<?php echo $form->error($modelCustomers,'outside_salesperson_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($modelCustomers->isNewRecord ? 'Create' : 'Save'); ?>
	</div> 

<?php $this->endWidget(); ?>


</div><!-- form -->