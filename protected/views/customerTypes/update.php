<?php
/* @var $this CustomerTypesController */
/* @var $model CustomerTypes */

$this->breadcrumbs=array(
	'Customer Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CustomerTypes', 'url'=>array('index')),
	array('label'=>'Create CustomerTypes', 'url'=>array('create')),
	array('label'=>'View CustomerTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CustomerTypes', 'url'=>array('admin')),
);
?>

<h1>Update CustomerTypes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>