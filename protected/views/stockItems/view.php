<?php
$this->breadcrumbs=array(
	'Stock Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StockItems', 'url'=>array('index')),
	array('label'=>'Create StockItems', 'url'=>array('create')),
	array('label'=>'Update StockItems', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StockItems', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StockItems', 'url'=>array('admin')),
);
?>

<h1>View StockItems #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'quote_id',
		'part_no',
		'manufacturer',
		'line_note',
		'date_code',
		'qty_1_24',
		'qty_25_99',
		'qty_100_499',
		'qty_500_999',
		'qty_1000_Plus',
		'qty_Base',
		'qty_Custom',
		'qty_NoBid',
		'qty_Available',
		'price_1_24',
		'price_25_99',
		'price_100_499',
		'price_500_999',
		'price_1000_Plus',
		'price_Base',
		'price_Custom',
		'last_updated',
		'comments',
	),
)); ?>
