<?php $this->layout = '//layouts/column1'; ?>


<div style='padding-bottom: 120px; border: 0px solid red;'>
	<h1><span style='color: #2C6371;'>Manage Contacts</span></h1>
</div>


	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'contacts-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			'id',
			'first_name',
			'last_name',
			'email',
			'title',
			'phone1',
			/*
			'phone2',
			'address1',
			'address2',
			'city',
			'state_id',
			'zip',
			'country_id',
			*/
			array(
				'class'=>'CButtonColumn',
			),
		),
	)); ?>
