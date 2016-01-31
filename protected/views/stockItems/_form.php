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


	<div class="row">
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

		</table>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Save Changes'); ?>
		<?php echo CHtml::link('Cancel', '../../quotes/' . $model->quote_id ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->