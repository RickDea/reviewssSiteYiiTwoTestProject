<?="<h2 class = $class >$message</h2>"?>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$f = ActiveForm::begin(); ?>


	<?=$f->field($form, 'name')?>
	<?=$f->field($form, 'pass1')->input('password')?>
	<?=$f->field($form, 'verifyCode')->widget(Captcha::className(), ['template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',])?>
	<?=Html::submitButton ('Войти',['class'=>"btn btn-success"])?>
	
	
<?php
ActiveForm::end();

?>