<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'items-form',
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
		<?php echo $form->labelEx($model,'part_no'); ?>
		<?php echo $form->textField($model,'part_no',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'part_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'manufacturer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'line_note'); ?>
		<?php echo $form->textArea($model,'line_note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'line_note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_code'); ?>
		<?php echo $form->textField($model,'date_code',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'date_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_1_24'); ?>
		<?php echo $form->textField($model,'qty_1_24'); ?>
		<?php echo $form->error($model,'qty_1_24'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_25_99'); ?>
		<?php echo $form->textField($model,'qty_25_99'); ?>
		<?php echo $form->error($model,'qty_25_99'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_100_499'); ?>
		<?php echo $form->textField($model,'qty_100_499'); ?>
		<?php echo $form->error($model,'qty_100_499'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_500_999'); ?>
		<?php echo $form->textField($model,'qty_500_999'); ?>
		<?php echo $form->error($model,'qty_500_999'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_1000_Plus'); ?>
		<?php echo $form->textField($model,'qty_1000_Plus'); ?>
		<?php echo $form->error($model,'qty_1000_Plus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_Base'); ?>
		<?php echo $form->textField($model,'qty_Base'); ?>
		<?php echo $form->error($model,'qty_Base'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_Custom'); ?>
		<?php echo $form->textField($model,'qty_Custom'); ?>
		<?php echo $form->error($model,'qty_Custom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_NoBid'); ?>
		<?php echo $form->textField($model,'qty_NoBid',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'qty_NoBid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_Available'); ?>
		<?php echo $form->textField($model,'qty_Available'); ?>
		<?php echo $form->error($model,'qty_Available'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_1_24'); ?>
		<?php echo $form->textField($model,'price_1_24'); ?>
		<?php echo $form->error($model,'price_1_24'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_25_99'); ?>
		<?php echo $form->textField($model,'price_25_99'); ?>
		<?php echo $form->error($model,'price_25_99'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_100_499'); ?>
		<?php echo $form->textField($model,'price_100_499'); ?>
		<?php echo $form->error($model,'price_100_499'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_500_999'); ?>
		<?php echo $form->textField($model,'price_500_999'); ?>
		<?php echo $form->error($model,'price_500_999'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_1000_Plus'); ?>
		<?php echo $form->textField($model,'price_1000_Plus'); ?>
		<?php echo $form->error($model,'price_1000_Plus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_Base'); ?>
		<?php echo $form->textField($model,'price_Base'); ?>
		<?php echo $form->error($model,'price_Base'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_Custom'); ?>
		<?php echo $form->textField($model,'price_Custom'); ?>
		<?php echo $form->error($model,'price_Custom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_updated'); ?>
		<?php echo $form->textField($model,'last_updated'); ?>
		<?php echo $form->error($model,'last_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comments'); ?>
		<?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->