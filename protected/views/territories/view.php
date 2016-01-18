<?php
/* @var $this TerritoriesController */
/* @var $model Territories */

$this->breadcrumbs=array(
	'Territories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Territories', 'url'=>array('index')),
	array('label'=>'Create Territories', 'url'=>array('create')),
	array('label'=>'Update Territories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Territories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Territories', 'url'=>array('admin')),
);
?>

<h1>View Territories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
