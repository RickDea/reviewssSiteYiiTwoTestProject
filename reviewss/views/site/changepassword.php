<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$f = ActiveForm::begin(); ?>

<?="<h2 class = $class >$message</h2>"?>
	<?=$f->field($form, 'oldPassword')->input('password')?>
	<?=$f->field($form, 'newPassword')->input('password')?>
	<?=$f->field($form, 'repitNewPassword')->input('password')?>
	<?/*=$f->field($form, 'verifyCode')->widget(Captcha::className(), ['template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',])*/?>
	<?=Html::submitButton('Сменить пароль',['class'=>"btn btn-success"]);?>
	
	
<?php
ActiveForm::end();
?>