<?php $this->layout = '//layouts/column1'; ?>


<h1>Viewing Quote No. <?php echo $model->quote_no; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
		 	'label' => 'Customer',
		 	'value' =>  $model->customer->name,
		 	'type' => 'raw',
		),
		
		array(
		 	'label' => 'Contact',
		 	'value' =>  $model->contact->fullname,
		 	'type' => 'raw',
		),
		array(
		 	'label' => 'Quote Type',
		 	'value' =>  $model->quoteType->name,
		 	'type' => 'raw',
		),

		array(
		 	'label' => 'Status',
		 	'value' =>  $model->status->name,
		 	'type' => 'raw',
		),
		
		array(
		 	'label' => 'Created by',
		 	'value' =>  $model->owner->fullname,
		 	'type' => 'raw',
		),
		array(
		 	'label' => 'Create on',
		 	'value' =>  Date('M d, Y', strtotime(($model->created_date) ) ),
		 	'type' => 'raw',
		),
		array(
		 	'label' => 'Expires on',
		 	'value' =>  Date('M d, Y', strtotime(($model->expiration_date)) ), 
		 	'type' => 'raw',
		),
		

		array(
		 	'label' => 'Source',
		 	'value' =>  $model->source->name,
		 	'type' => 'raw',
		),
		array(
		 	'label' => 'Level',
		 	'value' =>  $model->level->name,
		 	'type' => 'raw',
		),

		// 'additional_notes',
		// 'terms_conditions',
		// 'customer_acknowledgment',
		// 'risl',
		// 'manufacturing_lead_time',
		// 'lost_reason_id',
		// 'no_bid_reason_id',
		// 'ready_to_order',
		// 'requested_part_number',
		// 'generic_part_number',
		// 'quantity1',
		// 'quantity2',
		// 'quantity3',
		// 'die_manufacturer_id',
		// 'package_type_id',
		// 'lead_count',
		// 'process_flow_id',
		// 'testing_id',
		// 'priority_id',
		// 'temp_low',
		// 'temp_high',
		// 'ncnr',
		// 'itar',
		// 'have_die',
		// 'spa',
	),
)); ?>
