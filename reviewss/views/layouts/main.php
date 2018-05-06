<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use app\models\Users;
AppAsset::register($this);

$session = Yii::$app->session;
if (!$session->has('log-in') || !$session->has('ip')) {
	$session->open();
	$session->set('log-in', 'guest');
	$session->set('ip', hash('sha256', $_SERVER['REMOTE_ADDR']),false);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => "ReviewsS",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	
	if ($session->get('log-in') == 'guest') {
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav navbar-right'],
			'items' => [
				['label' => 'На главную', 'url' => ['/site/index']],
				['label' => 'Войти', 'url' => ['/site/enter']],
				['label' => 'Регистрация', 'url' => ['/site/registr']],				
			],
		]);
	}
	else {
		$obj = new Users;
		$count = $obj->counterMessage();
		
		if ($count == 0) {
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					['label' => 'На главную', 'url' => ['/site/index']],
					['label' => 'Привет, '.$session->get('log-in'),'items' => [
						['label' => 'Мой профиль', 'url' => ['/site/profile', 't'=>'my']],
						['label' => 'Мои сообщения', 'url' => ['/site/messages', 't'=>'in']],
					],
					],
					['label' => 'Выйти', 'url' => ['/site/log_out']],	
				],
			]);
		}
		else {
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					['label' => 'На главную', 'url' => ['/site/index']],
					['label' => 'Привет, '.$session->get('log-in'),'items' => [
						['label' => 'Мой профиль', 'url' => ['/site/profile', 't'=>'my']],
						['label' => 'Мои сообщения', 'url' => ['/site/messages', 't'=>'in']],
					],
					],
					['label' => $count, 'url' => ['/site/messages', 't'=>'in']],
					['label' => 'Выйти', 'url' => ['/site/log_out']],	
				],
			]);
			
		}
	}
	
	
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; By RickDea <?= date('Y') ?></p>

        <p class="pull-right">
		<a href ="<?=Yii::$app->urlManager->createUrl(['site/rules'])?>"> Правила </a>
		/
		<a href ="<?=Yii::$app->urlManager->createUrl(['site/about'])?>"> О сайте </a>
		</p> <br />
		<p class="blockquote text-center"> TEST_Version 2.0.68.24.(3)</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
