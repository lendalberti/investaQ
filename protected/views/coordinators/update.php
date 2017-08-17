<?php
/* @var $this CoordinatorsController */
/* @var $model Coordinators */

$this->breadcrumbs=array(
	'Coordinators'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Coordinators', 'url'=>array('index')),
	array('label'=>'Create Coordinators', 'url'=>array('create')),
	array('label'=>'View Coordinators', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Coordinators', 'url'=>array('admin')),
);
?>

<h1>Update Coordinators <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>