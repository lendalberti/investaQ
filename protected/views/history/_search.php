<?php
/* @var $this HistoryController */
/* @var $model History */
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
		<?php echo $form->label($model,'quote_no'); ?>
		<?php echo $form->textField($model,'quote_no',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'part_no'); ?>
		<?php echo $form->textField($model,'part_no',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type_id'); ?>
		<?php echo $form->textField($model,'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_code'); ?>
		<?php echo $form->textField($model,'date_code',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_id'); ?>
		<?php echo $form->textField($model,'contact_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'salesperson_id'); ?>
		<?php echo $form->textField($model,'salesperson_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status_id'); ?>
		<?php echo $form->textField($model,'status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lost_reason_id'); ?>
		<?php echo $form->textField($model,'lost_reason_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'no_bid_reason_id'); ?>
		<?php echo $form->textField($model,'no_bid_reason_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unit_price'); ?>
		<?php echo $form->textField($model,'unit_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->