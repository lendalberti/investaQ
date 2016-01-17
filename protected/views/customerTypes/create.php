<?php
/* @var $this CustomerTypesController */
/* @var $model CustomerTypes */

$this->breadcrumbs=array(
	'Customer Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomerTypes', 'url'=>array('index')),
	array('label'=>'Manage CustomerTypes', 'url'=>array('admin')),
);
?>

<h1>Create CustomerTypes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>