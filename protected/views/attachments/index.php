<?php
/* @var $this AttachmentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Attachments',
);

$this->menu=array(
	array('label'=>'Create Attachments', 'url'=>array('create')),
	array('label'=>'Manage Attachments', 'url'=>array('admin')),
);
?>

<h1>Attachments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
