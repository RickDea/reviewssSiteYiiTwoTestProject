<?="<h2 class = $class >$message</h2>"?>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$f = ActiveForm::begin(); ?>
<?="<div class='col-lg-6'>"?>
		<?=$f->field($form, 'toUser')?>
		<?=$f->field($form, 'topic')?>
		<?=$f->field($form, 'text')->textarea(['rows' => 7])?>

		<?=Html::submitButton('Отправить',['class'=>"btn btn-success"]);?>
		
<?="</div>"?>

<?php
ActiveForm::end();
?>
