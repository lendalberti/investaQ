<?php
$this->breadcrumbs=array(
	'Stock Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StockItems', 'url'=>array('index')),
	array('label'=>'Manage StockItems', 'url'=>array('admin')),
);
?>

<h1>Create StockItems</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>