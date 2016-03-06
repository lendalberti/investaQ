
<?php $this->layout = '//layouts/column1'; ?>

<div style='padding-bottom: 120px;'>
	<h1>Update Motivational <?php echo $model->id; ?></h1>
</div>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>