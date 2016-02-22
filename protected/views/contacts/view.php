<?php $this->layout = '//layouts/column1'; ?>


<h1>View Contacts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'email',
		'title',
		'phone1',
		'phone2',
		'address1',
		'address2',
		'city',
		'state_id',
		'zip',
		'country_id',
	),
)); ?>
