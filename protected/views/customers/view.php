<?php
/* @var $this CustomersController */
/* @var $model Customers */

$this->breadcrumbs=array(
	'Customers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Customers', 'url'=>array('index')),
	array('label'=>'Create Customers', 'url'=>array('create')),
	array('label'=>'Update Customers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Customers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Customers', 'url'=>array('admin')),
);
?>

<h1>View Customers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'address1',
		'address2',
		'city',
		'state_id',
		'country_id',
		'zip',
		'region_id',
		'customer_type_id',
		'territory_id',
		'vertical_market',
		'parent_id',
		'company_link',
		'syspro_account_code',
		'xmas_list',
		'candy_list',
		'strategic',
		'tier_id',
		'inside_salesperson_id',
		'outside_salesperson_id',
	),
)); ?>
