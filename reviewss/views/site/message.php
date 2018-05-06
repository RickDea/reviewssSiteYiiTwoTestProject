<?php
		$id = $result[id];
		$sender = $result[sender];
		$recipient = $result[recipient];
		$topic = $result[topic];
		$text = $result [text];
		$dateSend = $result[dateSend];

?>
<div class="container panel panel-default">
	<div class="panel-body">
		<div class="col-lg-2">
			<p>Отправитель: <a class = 'role-<?=$roleSender?>' href ="<?=Yii::$app->urlManager->createUrl(['site/user', 'name'=> $sender ])?>"><?=$sender?></a><p>
		</div>
		
		<div class="col-lg-2">
			<p>Получатель: <a class = 'role-<?=$roleRecipient?>' href ="<?=Yii::$app->urlManager->createUrl(['site/user', 'name'=> $recipient ])?>"><?=$recipient?></a><p>
		</div>
		
		<div class="col-lg-12">
			<p>Тема: <?=$topic?><p/>
		</div>
		
		<div class="col-lg-12">
			<p>Сообщение:<p/>
			<p><?=$text?><p/>
		</div>
		
		<div class="col-lg-12">
			<p>Отправленно:<?=$dateSend?><p/>
		</div>
	
	</div>
</div>
<?php
	$session = Yii::$app->session;
	$user = $session->get('log-in');
	if ($user == $recipient) {?>
		<a class = 'btn btn-primary' href =<?=Yii::$app->urlManager->createUrl(['site/send', 'n'=>$sender])?>> Ответить  </a>
	<?php }  
	
	if ($user == $sender) {?>
		<a class = 'btn btn-primary' href =<?=Yii::$app->urlManager->createUrl(['site/send', 'n'=>$recipient])?>> Написать еще  </a>
	<?php } ?>
