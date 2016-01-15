<?php
$this->breadcrumbs=array(
	'Quotes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Quotes', 'url'=>array('index')),
	array('label'=>'Create Quotes', 'url'=>array('create')),
	array('label'=>'View Quotes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Quotes', 'url'=>array('admin')),
);
?>

<h1>Update Quotes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>