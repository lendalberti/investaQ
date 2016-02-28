<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bto-approvers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropdownList( $model, 'user_id', CHtml::listData( Users::model()->findAll( array('order' => 'first_name') ), 'id', 'fullname'), array('empty' => '') ); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->dropdownList( $model, 'group_id', CHtml::listData( BtoGroups::model()->findAll( array('order' => 'name') ), 'id', 'name'), array('empty' => '') ); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_id'); ?>
		<?php echo $form->dropdownList( $model, 'role_id', CHtml::listData( Roles::model()->findAll( array('order' => 'name') ), 'id', 'name'), array('empty' => '') ); ?>
		<?php echo $form->error($model,'role_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->