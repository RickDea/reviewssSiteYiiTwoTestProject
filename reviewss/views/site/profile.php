<?php
use yii\widgets\LinkPager;

$session = Yii::$app->session;
$log =$session->get('log-in');
$ip = $session->get('ip');
$name = $result[0][userName];
$email = $result[0][email];
$date = $result[0][dateCreateAccount];
$authorPost = $result[0][userPost];
$likePost = $result[0][userLike];

switch ($result[0][rule]) {
	case 'user':
		$role = 'Пользователь';
		break;
		
	case 'moder':
		$role = 'Редактор';
		break;
		
	case 'admin':
		$role = 'Администратор';
		break;	
}
?>
<div class="container">
	<div class="col-lg-12 panel panel-default">
		<div class="col-lg-12 panel-body">
			<h2>Информация о пользователе:	</h2><br />
			<p>Имя пользователя: <span class="role-<?=$result[0][rule]?>"><?=$name?></span><p>
			<p>Электронная почта: <?=$email?><p>
			<p>Дата регистрации: <?=$date?><p>
			<p>Группа: <span class="role-<?=$result[0][rule]?>"><?=$role?></span><p>
			<a href ="<?=Yii::$app->urlManager->createUrl(['site/changepassword'])?>"> Сменить пароль </a>
		</div>
	</div>
<h2><a href ="<?=Yii::$app->urlManager->createUrl(['site/profile', 't'=>'my'])?>"> Мои рецензии </a>
		/
<a href ="<?=Yii::$app->urlManager->createUrl(['site/profile', 't'=>'like'])?>"> Понравившиеся рецензии </a></h2>

	
	<div class="row mod-row col-lg-12">
	
	<?php if ($type =='my') {?>
	
		<div class="col-lg-6 panel panel-default">
			<div class="col-lg-12 panel-body">
				<h2>Мо рецензии: </h2><br />
				<?php
						foreach ($posts as $post) {
								$postName = $post[postName];
								$link = Yii::$app->urlManager->createUrl(['site/postpage', 'id'=>$post[id]]);
								echo "<a href =$link>$postName</a><br />";
						}	
				?>
			</div>
		</div>
	<?php } ?>
	<?php if ($type =='like') {?>	
		
		<div class="col-lg-6 panel panel-default">
			<div class="col-lg-12 panel-body">
				<h2>Понравившиеся рецензии: </h2><br />
				<?php
						foreach ($posts as $post) {
								$postName = $post[postName];
								$link = Yii::$app->urlManager->createUrl(['site/postpage', 'id'=>$post[id]]);
								echo "<a href =$link>$postName</a><br />";
							
						}	
				?>
			</div>
		</div>
	<?php } ?>
	</div>
</div>
<?=LinkPager::widget(['pagination'=>$pagination]) ?>