 <?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;



$f = ActiveForm::begin(); ?>
	<?="<div class='col-lg-6'>"?>
		<?=$f->field($form, 'name')?>
		<?=$f->field($form, 'text')->textarea(['rows' => 15])?>
		<?=$f->field($form, 'image')?>
		<?=$f->field($form, 'imageOne')?>
		<?=$f->field($form, 'imageTwo')?>
		<?=$f->field($form, 'imageThree')?>	
	<?="</div>"?>
	<?="<div class='col-lg-6'>"?>
		<?="<div class='col-lg-5'>"?>
			<?=$f->field($form, 'star')
			->dropDownList([
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			],
			[
				'prompt' => 'Поставьте оценку'
			]);?>
		<?="</div>"?>
		
		<?="<div class='col-lg-12'>"?>
			<?=$f->field($form, 'type')
				->radioList([
					'film' => 'Фильм',
					'animation' => 'Мультипликация',
					'series' => 'Сериал'
			]);?>
		<?="</div>"?>	
		
		<?="<div class='col-lg-12'>"?>
			<?=$f ->field($form, 'genre')
				->checkboxList([
					'action' => 'Экшен',
					'comedy' => 'Комедия',
					'horror' => 'Хоррор',
					'detective' => 'Детектив',
					'fantasy' => 'Фэнтези',
					'dramma' => 'Драмма',
					'scienceFiction' => 'Научная фантастика',
			]);?>
			<?=Html::submitButton('Добавить',['class'=>"btn btn-success"]);?>
		<?="</div>"?>
		
		
	<?="</div>"?>
	

	
	
	
<?php
ActiveForm::end();
?>