<?php
/* @var $this TerritoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Territories',
);

$this->menu=array(
	array('label'=>'Create Territories', 'url'=>array('create')),
	array('label'=>'Manage Territories', 'url'=>array('admin')),
);
?>

<h1>Territories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
