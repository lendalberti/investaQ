<?php
/* @var $this TerritoriesController */
/* @var $model Territories */

$this->breadcrumbs=array(
	'Territories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Territories', 'url'=>array('index')),
	array('label'=>'Create Territories', 'url'=>array('create')),
	array('label'=>'View Territories', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Territories', 'url'=>array('admin')),
);
?>

<h1>Update Territories <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>