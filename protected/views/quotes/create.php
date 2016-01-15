<?php
$this->breadcrumbs=array(
	'Quotes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Quotes', 'url'=>array('index')),
	array('label'=>'Manage Quotes', 'url'=>array('admin')),
);
?>

<h1>Create Quotes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>