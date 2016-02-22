<?php $this->layout = '//layouts/column1'; ?>
<div style='padding-bottom: 120px; border: 0px solid red;'>
	<h1><span style='color: #2C6371;'>Manage Customers</span></h1>
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'customers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'address1',
		'address2',
		'city',
		'state_id',
		/*
		'country_id',
		'zip',
		'region_id',
		'customer_type_id',
		'territory_id',
		'vertical_market',
		'parent_id',
		'company_link',
		'syspro_account_code',
		'xmas_list',
		'candy_list',
		'strategic',
		'tier_id',
		'inside_salesperson_id',
		'outside_salesperson_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
