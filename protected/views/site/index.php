<?php $this->pageTitle=Yii::app()->name; ?>

<span class='pageTitle'><?php echo Yii::app()->user->isLoggedIn ? CHtml::encode(Yii::app()->name) : ''; ?></span>

