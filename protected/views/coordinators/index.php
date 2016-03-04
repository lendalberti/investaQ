<?php
/* @var $this CoordinatorsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Coordinators',
);

$this->menu=array(
	array('label'=>'Create Coordinators', 'url'=>array('create')),
	array('label'=>'Manage Coordinators', 'url'=>array('admin')),
);
?>

<h1>Coordinators</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
