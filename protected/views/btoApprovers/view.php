<?php $this->layout = '//layouts/column1'; ?>

<div style='padding-bottom: 120px;'>
	<h1>View User <?php echo $model->user->fullname; ?></h1>
	<a href='create' >Add New</a>
</div>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		// 'user_id',
		array(
				 	'label' => 'User',
				 	'value' =>  $model->user->fullname,
				 	'type' => 'raw',
				 ),
		// 'group_id',
		array(
				 	'label' => 'Group',
				 	'value' =>  $model->group->name,
				 	'type' => 'raw',
				 ),
		// 'role_id',
		array(
				 	'label' => 'Role',
				 	'value' =>  $model->role->name,
				 	'type' => 'raw',
				 ),
	),
)); ?>
