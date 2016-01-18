<?php
/* @var $this TerritoriesController */
/* @var $model Territories */

$this->breadcrumbs=array(
	'Territories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Territories', 'url'=>array('index')),
	array('label'=>'Manage Territories', 'url'=>array('admin')),
);
?>

<h1>Create Territories</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>