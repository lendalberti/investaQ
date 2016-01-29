<?php
$this->breadcrumbs=array(
	'Stock Items',
);

$this->menu=array(
	array('label'=>'Create StockItems', 'url'=>array('create')),
	array('label'=>'Manage StockItems', 'url'=>array('admin')),
);
?>

<h1>Stock Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
