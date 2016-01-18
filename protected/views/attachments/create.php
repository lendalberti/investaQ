<?php
/* @var $this AttachmentsController */
/* @var $model Attachments */

$this->breadcrumbs=array(
	'Attachments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Attachments', 'url'=>array('index')),
	array('label'=>'Manage Attachments', 'url'=>array('admin')),
);
?>

<h1>Create Attachments</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>