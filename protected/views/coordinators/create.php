<?php
/* @var $this CoordinatorsController */
/* @var $model Coordinators */

$this->breadcrumbs=array(
	'Coordinators'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Coordinators', 'url'=>array('index')),
	array('label'=>'Manage Coordinators', 'url'=>array('admin')),
);
?>

<h1>Create Coordinators</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>