<?php
/* @var $this AttachmentsController */
/* @var $model Attachments */

$this->breadcrumbs=array(
	'Attachments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Attachments', 'url'=>array('index')),
	array('label'=>'Create Attachments', 'url'=>array('create')),
	array('label'=>'Update Attachments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Attachments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Attachments', 'url'=>array('admin')),
);
?>

<h1>View Attachments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'quote_id',
		'filename',
		'content_type',
		'size',
		'md5',
		'uploaded_date',
		'uploaded_by',
	),
)); ?>
