<?php
/* @var $this QuotesController */
/* @var $model Quotes */

$this->breadcrumbs=array(
	'Quotes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Quotes', 'url'=>array('index')),
	array('label'=>'Create Quotes', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#quotes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Quotes</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'quotes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'quote_no',
		'quote_type_id',
		'status_id',
		'owner_id',
		'customer_id',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
