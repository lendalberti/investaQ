<?php
/* @var $this BtoItemsController */
/* @var $model BtoItems */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quote_id'); ?>
		<?php echo $form->textField($model,'quote_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requested_part_number'); ?>
		<?php echo $form->textField($model,'requested_part_number',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'generic_part_number'); ?>
		<?php echo $form->textField($model,'generic_part_number',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity1'); ?>
		<?php echo $form->textField($model,'quantity1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity2'); ?>
		<?php echo $form->textField($model,'quantity2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity3'); ?>
		<?php echo $form->textField($model,'quantity3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'die_manufacturer_id'); ?>
		<?php echo $form->textField($model,'die_manufacturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'package_type_id'); ?>
		<?php echo $form->textField($model,'package_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lead_count'); ?>
		<?php echo $form->textField($model,'lead_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'process_flow_id'); ?>
		<?php echo $form->textField($model,'process_flow_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'testing_id'); ?>
		<?php echo $form->textField($model,'testing_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'priority_id'); ?>
		<?php echo $form->textField($model,'priority_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'temp_low'); ?>
		<?php echo $form->textField($model,'temp_low',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'temp_high'); ?>
		<?php echo $form->textField($model,'temp_high',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ncnr'); ?>
		<?php echo $form->textField($model,'ncnr'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'itar'); ?>
		<?php echo $form->textField($model,'itar'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'have_die'); ?>
		<?php echo $form->textField($model,'have_die'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spa'); ?>
		<?php echo $form->textField($model,'spa'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recreation'); ?>
		<?php echo $form->textField($model,'recreation'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wip_product'); ?>
		<?php echo $form->textField($model,'wip_product'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->