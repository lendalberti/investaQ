<?php
$this->breadcrumbs=array(
	'Stock Items'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List StockItems', 'url'=>array('index')),
	array('label'=>'Create StockItems', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('stock-items-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Stock Items</h1>

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
	'id'=>'stock-items-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'quote_id',
		'part_no',
		'manufacturer',
		'line_note',
		'date_code',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
