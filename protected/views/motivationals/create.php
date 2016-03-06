<?php $this->layout = '//layouts/column1'; ?>

<div style='padding-bottom: 120px;'>
	<h1>Create Motivationals</h1>

	<a href='admin' >Cancel</a>
</div>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>