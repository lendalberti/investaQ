<?php
/* @var $this BtoItemsController */
/* @var $model BtoItems */

$this->breadcrumbs=array(
	'Bto Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BtoItems', 'url'=>array('index')),
	array('label'=>'Create BtoItems', 'url'=>array('create')),
	array('label'=>'Update BtoItems', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BtoItems', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BtoItems', 'url'=>array('admin')),
);
?>

<h1>View BtoItems #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'quote_id',
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
		'recreation',
		'wip_product',
		'created_date',
		'updated_date',
	),
)); ?>
