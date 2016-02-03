<?php $this->layout = '//layouts/column1'; ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'items-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php setlocale(LC_MONETARY, 'en_US');  ?>


	<?php echo "<span style='font-weight: bold; font-size: .9em; '>Total Available: </span>"; ?>
		<span style='color: red; font-size: 1.2em; padding-left: 5px; padding-right: 5px; '><?php echo number_format($model->qty_Available); ?></span>
	<?php echo "<span style='font-weight: bold; font-size: .9em;'> for Part No.<span style='padding-left:10px; color: red;font-size: 1.2em;'>".$model->part_no."</span> </span>"; ?>


 	<?php
 			$dpf = Yii::app()->params['DISTRIBUTOR_PRICE_FLOOR'];
 			$min_custom_price =  money_format("%6.2n", $model->price_Base * $dpf );  
 	?>


	<div class="row">

		<input type='hidden' name='distributor_price_floor' id='distributor_price_floor' value='<?php echo Yii::app()->params['DISTRIBUTOR_PRICE_FLOOR']; ?>' > 
 
		<table style='width: 300px;'>
			<tr><td></td><td></td><td></td></tr>
			<tr style='background-color: gray; color: white; font-weight: bold;'>
				<td></td><td>Quantity</td><td>Price</td>
			</tr>

			<tr>
				<td style='text-align: right;'><?php echo "<span style='font-weight: bold;'>1-24</span>"; ?></td>
				<td><?php echo $form->textField($model,'qty_1_24',array('size'=>10,'maxlength'=>10)); ?></td>
				<td><span style='font-size: .8em; color: green;'><?php echo money_format('%.2n',$model->price_1_24); ?></span></td>
				<td><?php echo $form->error($model,'qty_1_24'); ?></td>
			</tr>

			<tr>
				<td style='text-align: right;'><?php echo "<span style='font-weight: bold;'>25-99</span>"; ?></td>
				<td><?php echo $form->textField($model,'qty_25_99',array('size'=>10,'maxlength'=>10)); ?></td>
				<td><span style='font-size: .8em; color: green;'><?php echo money_format('%.2n',$model->price_25_99); ?></span></td>
				<td><?php echo $form->error($model,'qty_25_99'); ?></td>
			</tr>

			<tr>
				<td style='text-align: right;'><?php echo "<span style='font-weight: bold;'>100-499</span>"; ?></td>
				<td><?php echo $form->textField($model,'qty_100_499',array('size'=>10,'maxlength'=>10)); ?></td>
				<td><span style='font-size: .8em; color: green;'><?php echo money_format('%.2n',$model->price_100_499); ?></span></td>
				<td><?php echo $form->error($model,'qty_100_499'); ?></td>
			</tr>

			<tr>
				<td style='text-align: right;'><?php echo "<span style='font-weight: bold;'>500-999</span>"; ?></td>
				<td><?php echo $form->textField($model,'qty_500_999',array('size'=>10,'maxlength'=>10)); ?></td>
				<td><span style='font-size: .8em; color: green;'><?php echo money_format('%.2n',$model->price_500_999); ?></span></td>
				<td><?php echo $form->error($model,'qty_500_999'); ?></td>
			</tr>

			<tr>
				<td style='text-align: right;'><?php echo "<span style='font-weight: bold;'>1000+</span>"; ?></td>
				<td><?php echo $form->textField($model,'qty_1000_Plus',array('size'=>10,'maxlength'=>10)); ?></td>
				<td><span style='font-size: .8em; color: green;'><?php echo money_format('%.2n',$model->price_1000_Plus); ?></span></td>
				<td><?php echo $form->error($model,'qty_1000_Plus'); ?></td>
			</tr>

			<tr>
				<td style='text-align: right;'><?php echo "<span style='font-weight: bold;'>Base</span>"; ?></td>
				<td><?php echo $form->textField($model,'qty_Base',array('size'=>10,'maxlength'=>10)); ?></td>
				<td><span style='font-size: .8em; color: green;'><?php echo money_format('%.2n',$model->price_Base); ?></span></td>
				<td><?php echo $form->error($model,'qty_Base'); ?></td>
			</tr>

			<tr>
				<td style='text-align: right;'><?php echo "<span style='font-weight: bold;'>Custom</span>"; ?></td>
				<td><?php echo $form->textField($model,'qty_Custom',array('size'=>10,'maxlength'=>10)); ?></td>
				<td><?php echo $form->textField($model,'price_Custom',array('size'=>10,'maxlength'=>10)); ?></td>
				<td><?php echo $form->error($model,'qty_Custom'); ?></td>
			</tr>

			<tr style='font-size: .8em;' >
				<td colspan='3' style='padding: 10px 0px 10px 0px; background-color: lightyellow; color: #a31128; font-weight: bold;'>NOTE: 
							<span style='padding: 20px 0px 20px 0px;color: #a31128; font-weight: normal;'>Approval is needed if custom price is <br />
								less than <span id='min_custom_price' style='color: blue;'><?php echo $min_custom_price; ?></span>  (<?php echo $dpf*100; ?>% of Distributor Price) 
							</span>
				</td>
			</tr>
			
		</table>
	</div>

	<div class="row">
			<?php echo "<span style='font-weight: bold;'>Comments</span>"; ?><br />
			<?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row buttons" style='margin-top: 20px;'>
		<?php echo CHtml::submitButton('Save Changes'); ?>
		<?php echo CHtml::link('Cancel', '../../quotes/update/' . $model->quote_id ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->