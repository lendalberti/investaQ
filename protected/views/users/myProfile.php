<?php $this->layout = '//layouts/column1'; ?>

<h1>My Profile</h1>

<div style='margin-bottom: 10px;'><a href='../profileUpdate/<?php echo Yii::app()->user->id; ?>'>Edit</a></div>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'first_name',
		'last_name',
		'email',
		'title',
		'phone',
		'fax',
		'sig',
	),
)); ?>

