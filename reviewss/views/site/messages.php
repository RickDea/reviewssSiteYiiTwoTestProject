<?php
	use yii\widgets\LinkPager;		
?>
<?="<h2 class = $class >$message</h2>"?>

<h2><a href ="<?=Yii::$app->urlManager->createUrl(['site/messages', 't'=>'in'])?>"> Входящие </a>
		/
<a href ="<?=Yii::$app->urlManager->createUrl(['site/messages', 't'=>'out'])?>"> Исходящие </a></h2>

<div class="container panel panel-default">
	<div class="panel-body">
	<?php if ($type == 'in') { ?>
		<div class="col-lg-12 ">
			<h3>Входящие: </h3>
			<?php
				foreach ($result as $message){
					$sender = $message[sender];
					$topic = $message[topic];
					$date = $message[dateSend];
					$status = $message[status];
					$link = Yii::$app->urlManager->createUrl(['site/message', 'id'=>$message[id]]);
					$linkSender = Yii::$app->urlManager->createUrl(['site/user', 'name'=>$sender]);
					echo "<a class='message-$status list-group-item' href=$link>От кого: $sender <br/> Тема: $topic<br /> Дата: $date <br /></a>";
				}
			?>
		</div>
	<?php }?>
	<?php if ($type == 'out') { ?>
		<div class="col-lg-12">
			<h3>Исходящие: </h3>
			<?php
				foreach ($result as $message){
					$recipient = $message[recipient];
					$topic = $message[topic];
					$date = $message[dateSend];
					$status = $message[status];
					$link = Yii::$app->urlManager->createUrl(['site/message', 'id'=>$message[id]]);
					$linkRecipient = Yii::$app->urlManager->createUrl(['site/user', 'name'=>$recipient]);
					echo "<a class='message-$status list-group-item' href=$link>Кому: $recipient <br/> Тема: $topic<br /> Дата: $date <br /></a>";
				}
			?>
		</div>
	<?php }?>
			
	</div>
</div>
<a class = 'btn btn-primary' href =<?=Yii::$app->urlManager->createUrl(['site/send'])?>> Написать сообщение </a><br />
<?=LinkPager::widget(['pagination'=>$pagination]) ?>
