<?php
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
	$.fn.yiiGridView.update('quotes-grid', {
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
		'status_id',
		'user_id',
		'customer_id',
		'additional_notes',
		/*
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
		'bto',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
