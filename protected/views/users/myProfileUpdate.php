<div class="form">

	<?php 

	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'users-form',
		'enableAjaxValidation'=>false,
	)); 

	Yii::app()->clientScript->registerScript('search', "
		
		$('#upload_sig').click(function(){
			//console.log('uploading new file...');
			$('#upload_div').show();
			return true;
		});

		$('#upload_sig').click(function() {
			$('#choose_file_button').toggle();
		});

		
	");


	?>



	<h1>Updating Your Profile</h1>

		<?php echo $form->errorSummary($model); ?>

			 	<div class="row">
					<?php echo $form->labelEx($model,'title'); ?>
					<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
					<?php echo $form->error($model,'title'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'phone'); ?>
					<?php echo $form->textField($model,'phone',array('size'=>45,'maxlength'=>45)); ?>
					<?php echo $form->error($model,'phone'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'fax'); ?>
					<?php echo $form->textField($model,'fax',array('size'=>45,'maxlength'=>45)); ?>
					<?php echo $form->error($model,'fax'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'sig'); ?>
					<?php echo $form->textField($model,'sig',array('size'=>25,'maxlength'=>25, 'readonly'=>'readonly')); ?>
					<span style='padding-left: 5px;' >   <a style='color: red; font-size: .8em;'' href='../uploadSig/<?php echo $model->id; ?>' id='upload_sig'>Change</a>    </span>
					<?php echo $form->error($model,'sig'); ?>
				</div>

				<div class="row buttons" style='margin-top: 50px;'>
					<?php echo CHtml::submitButton('Save Changes'); ?>
					<?php echo CHtml::link('Cancel', '../../Users/profile/'.$model->id); ?>
				</div>

		<?php $this->endWidget(); ?>

	    </form>
	</div>


</div>