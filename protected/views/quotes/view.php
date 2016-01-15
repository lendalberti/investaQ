<?php
$this->breadcrumbs=array(
	'Quotes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Quotes', 'url'=>array('index')),
	array('label'=>'Create Quotes', 'url'=>array('create')),
	array('label'=>'Update Quotes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Quotes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Quotes', 'url'=>array('admin')),
);
?>

<h1>View Quotes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'quote_no',
		'status_id',
		'user_id',
		'customer_id',
		'additional_notes',
		'terms_conditions',
		'created',
		'updated',
		'customer_acknowledgment',
		'risl',
		'manufacturing_lead_time',
		'expiration_date',
		'lost_reason_id',
		'no_bid_reason_id',
		'ready_to_order',
		'type',
	),
)); ?>
