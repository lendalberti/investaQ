<?php
/* @var $this QuotesController */
/* @var $model Quotes */

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
		'quote_type_id',
		'status_id',
		'owner_id',
		'customer_id',
		'created_date',
		'updated_date',
		'expiration_date',
		'level_id',
		'source_id',
		'additional_notes',
		'terms_conditions',
		'customer_acknowledgment',
		'risl',
		'manufacturing_lead_time',
		'lost_reason_id',
		'no_bid_reason_id',
		'ready_to_order',
		'requested_part_number',
		'generic_part_number',
		'quantity1',
		'quantity2',
		'quantity3',
		'die_manufacturer_id',
		'package_type_id',
		'lead_count',
		'process_flow_id',
		'testing_id',
		'priority_id',
		'temp_low',
		'temp_high',
		'ncnr',
		'itar',
		'have_die',
		'spa',
	),
)); ?>
