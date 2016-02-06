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
		<?php echo $form->label($model,'part_no'); ?>
		<?php echo $form->textField($model,'part_no',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'line_note'); ?>
		<?php echo $form->textArea($model,'line_note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_code'); ?>
		<?php echo $form->textField($model,'date_code',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_1_24'); ?>
		<?php echo $form->textField($model,'qty_1_24'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_25_99'); ?>
		<?php echo $form->textField($model,'qty_25_99'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_100_499'); ?>
		<?php echo $form->textField($model,'qty_100_499'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_500_999'); ?>
		<?php echo $form->textField($model,'qty_500_999'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_1000_Plus'); ?>
		<?php echo $form->textField($model,'qty_1000_Plus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_Base'); ?>
		<?php echo $form->textField($model,'qty_Base'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_Custom'); ?>
		<?php echo $form->textField($model,'qty_Custom'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_NoBid'); ?>
		<?php echo $form->textField($model,'qty_NoBid',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_Available'); ?>
		<?php echo $form->textField($model,'qty_Available'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_1_24'); ?>
		<?php echo $form->textField($model,'price_1_24'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_25_99'); ?>
		<?php echo $form->textField($model,'price_25_99'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_100_499'); ?>
		<?php echo $form->textField($model,'price_100_499'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_500_999'); ?>
		<?php echo $form->textField($model,'price_500_999'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_1000_Plus'); ?>
		<?php echo $form->textField($model,'price_1000_Plus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_Base'); ?>
		<?php echo $form->textField($model,'price_Base'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_Custom'); ?>
		<?php echo $form->textField($model,'price_Custom'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_updated'); ?>
		<?php echo $form->textField($model,'last_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comments'); ?>
		<?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->