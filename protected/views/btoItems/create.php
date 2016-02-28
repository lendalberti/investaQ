<?php
/* @var $this BtoItemsController */
/* @var $model BtoItems */

$this->breadcrumbs=array(
	'Bto Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BtoItems', 'url'=>array('index')),
	array('label'=>'Manage BtoItems', 'url'=>array('admin')),
);
?>

<h1>Create BtoItems</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>