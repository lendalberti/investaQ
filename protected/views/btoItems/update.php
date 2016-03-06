<?php
/* @var $this BtoItemsController */
/* @var $model BtoItems */

$this->breadcrumbs=array(
	'Bto Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BtoItems', 'url'=>array('index')),
	array('label'=>'Create BtoItems', 'url'=>array('create')),
	array('label'=>'View BtoItems', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BtoItems', 'url'=>array('admin')),
);
?>

<h1>Update BtoItems <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>