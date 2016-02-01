<?php
	Yii::app()->clientScript->registerScript('search', "
		
		$('a#remove_sig').click(function(){

			console.log('clicked on Remove...');

			var f = $('#upload-form > div:nth-child(2) > span:nth-child(2)').html();
			if ( f != 'n/a' ) {
				if ( confirm('Are you sure you want to remove ' + f + ' from your profile?' ) ) {
					return true;
				}
				else {
					return false;
				}
			} 
			return false;
			
		});

	");
?>


<span style='font-size: 24px; color: black;'>Changing your profile's signature</span>

<br />
<span style='color: red;'><?php echo $uploadMessage; ?></span>

<div class="form" style='margin-top: 20px;'>
    <?php
        $form = $this->beginWidget( 'CActiveForm', array(
                'id' => 'upload-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
    ?>

    <div class="row">
        <input name="uploaded_file" id="uploaded_file" type="file" /><br />
    </div>
    
    <div style='padding-top: 10px;'>
    	<span style='font-weight: bold;'>Signature file: </span><span style='padding: 2px 10px 2px 2px; border: 1px solid gray;'><?php echo $model->sig ? $model->sig : 'n/a'; ?></span><a style='padding-left: 10px;color: red; font-size: .8em;'' href='../update/<?php echo $model->id; ?>?sig=1' id='remove_sig'>Remove</a>    
    	</span>
    </div>
   
     <div style='padding-top: 130px;'>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Apply Change') . '<span style="padding-left: 10px;"><a href="' .  CController::createUrl('users/profile/'.$model->id) . '" >Cancel</a></span>'; ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

