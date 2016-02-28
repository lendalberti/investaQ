<?php $this->layout = '//layouts/column1'; ?>

<div style='padding-bottom: 120px;'>
	<h1>View Motivational #<?php echo $model->id; ?></h1>
</div>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'saying',
	),
)); ?>
