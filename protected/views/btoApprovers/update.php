<?php $this->layout = '//layouts/column1'; ?>

<div style='padding-bottom: 40px;'>
	<h1>Update User <?php echo $model->user->fullname; ?></h1>
	<a href='../admin' >Cancel</a>
</div>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>