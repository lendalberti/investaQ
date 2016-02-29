<?php $this->layout = '//layouts/column1'; ?>

<div style='padding-bottom: 120px;'>
	<h1>Managing Quote Coordinators</h1>
	<a href='create' >Add new approver</a>
	<!-- <a href='xxxxxxx return_url  xxxxxxxxxxxx' >Return to Quote</a>    TODO       --> 
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bto-approvers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		// 'user_id',
		array(
				'name' => 'user_id',
			 	'value' => '$data->user->fullname',
			),
		// 'group_id',
		array(
				'name' => 'group_id',
			 	'value' => '$data->group->name',
			),
		// 'role_id',
		array(
				'name' => 'role_id',
			 	'value' => '$data->role->name',
			),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
