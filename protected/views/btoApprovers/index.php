<?php $this->layout = '//layouts/column1'; ?>

<h1>Manufacturing Quote Approvers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
