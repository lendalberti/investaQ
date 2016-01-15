<?php $this->pageTitle=Yii::app()->name;  ?>

<span class='pageTitle'><?php echo CHtml::encode(Yii::app()->name); ?></span>

<div style='margin: 30px 10px 10px 10px;'>
	<ul>
		<li><a href='<?php echo Yii::app()->homeUrl; ?>/quotes/index/stock'>Stock Quote</a></li>
		<li><a href='<?php echo Yii::app()->homeUrl; ?>/quotes/index/mfg'>Manufacturing Quote</a></li>
		<li><a href='<?php echo Yii::app()->homeUrl; ?>/quotes/index/srf'>Supplier Request Form</a></li>
</div>
