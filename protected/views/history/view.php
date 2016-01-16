<?php
/* @var $this HistoryController */
/* @var $model History */

$this->breadcrumbs=array(
	'Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List History', 'url'=>array('index')),
	array('label'=>'Create History', 'url'=>array('create')),
	array('label'=>'Update History', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete History', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage History', 'url'=>array('admin')),
);
?>

<h1>View History #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'quote_id',
		'quote_no',
		'part_no',
		'created',
		'type_id',
		'manufacturer',
		'date_code',
		'customer_id',
		'location',
		'contact_id',
		'salesperson_id',
		'status_id',
		'lost_reason_id',
		'no_bid_reason_id',
		'quantity',
		'unit_price',
	),
)); ?>
