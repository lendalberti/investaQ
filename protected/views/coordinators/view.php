<?php
/* @var $this CoordinatorsController */
/* @var $model Coordinators */

$this->breadcrumbs=array(
	'Coordinators'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Coordinators', 'url'=>array('index')),
	array('label'=>'Create Coordinators', 'url'=>array('create')),
	array('label'=>'Update Coordinators', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Coordinators', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Coordinators', 'url'=>array('admin')),
);
?>

<h1>View Coordinators #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'group_id',
	),
)); ?>
