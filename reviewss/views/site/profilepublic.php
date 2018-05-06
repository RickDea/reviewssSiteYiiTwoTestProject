<?php
use yii\widgets\LinkPager;
$name = $result[userName];
$email = $result[email];
$date = $result[dateCreateAccount];
$authorPost = $result[userPost];
$likePost = $result[userLike];

switch ($result[rule]) {
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
			<p>Имя пользователя: <span class="role-<?=$result[rule]?>"><?=$name?></span><p>
			<p>Дата регистрации: <?=$date?><p>
			<p>Группа: <span class="role-<?=$result[rule]?>"><?=$role?></span><p>
			<?php
				$session = Yii::$app->session;
				$nameUser = $session->get('log-in');	
				if ($name != $nameUser && $nameUser!='guest') {
			
			?>
				<a class = 'btn btn-primary' href =<?=Yii::$app->urlManager->createUrl(['site/send', 'n'=>$name])?>> Отправить сообщение  </a>
			<?php } ?>	
		</div>
	</div>
	
	<div class="row mod-row col-lg-12">
		<div class="col-lg-6 panel panel-default">
			<div class="col-lg-12 panel-body">
				<h2>Рецензии пользователя (<span class="role-<?=$result[rule]?>"><?=$name?></span>):</h2><br />
				<?php
						foreach ($posts as $post) {
								$postName = $post[postName];
								$link = Yii::$app->urlManager->createUrl(['site/postpage', 'id'=>$post[id]]);
								echo "<a href =$link>$postName</a><br />";
							}
						

				?>
			</div>
		</div>
		
	</div>
</div>
<?=LinkPager::widget(['pagination'=>$pagination]) ?>