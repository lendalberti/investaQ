<?php $this->layout = '//layouts/column1'; ?>

<div style='padding-bottom: 120px;'>
	<h1>Manage Motivationals</h1>

	<a href='create' >Add new saying</a>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'motivationals-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'saying',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
