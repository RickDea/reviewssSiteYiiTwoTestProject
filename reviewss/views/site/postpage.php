<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Users;

$this->registerJsFile('web/js/postPage.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]);

		$id = $result[id];
		$name = $result[postName];
		$author = $result[postAuthor];
		$text = $result[postText];
		$image = $result [postImage];
		$like = $result[postLike];
		$imageOne = $result[postImageOne];
		$imageTwo = $result[postImageTwo];
		$imageThree = $result[postImageThree];
		$date = $result[postDate];
		$star = $result[postStar];
		$type;

		function callB($in) {
			$out;
			switch ($in) {
				case 'action':
					$out = 'Экшен';
					break;
				case 'comedy':
					$out = 'Комедия';
					break;
				case 'horror':
					$out = 'Хоррор';
					break;
				case 'detective':
					$out = 'Детектив';
					break;
				case 'fantasy':
					$out = 'Фэнтези';
					break;
				case 'dramma':
					$out = 'Драмма';
					break;
				case 'scienceFiction':
					$out = 'Научная фантастика';
					break;
			}
			return $out;
		}
		
		$genre = array_map( "callB", explode(".",$result[postGenre]) );
		
		
		switch ($result[postType]) {
			case 'film':
				$type = 'Фильм';
				break;
				
			case 'animation':
				$type = 'Анимация';
				break;
				
			case 'series':
				$type = 'Сериал';
				break;	
		}	
?>
<?="<h2 class = $class >$message</h2>"?>

<div class="container panel panel-default">
	<div class="row panel-body">
	
		<div class="col-lg-4">
			<div class="col-lg-12">
				<image src=<?=$image?> width="100%" height="auto" alt=<?=$name?> />
			</div>
			
			<div class="col-lg-12">
				<p>Автор: <a class = 'role-<?=$roleAuthor?>' href ="<?=Yii::$app->urlManager->createUrl(['site/user', 'name'=> $author ])?>"><?=$author?></a></p>
				
				<p>Дата публикации: <?=$date?></p>	
			</div>
		</div>
		
		<div class="col-lg-8">
		
			<div class="col-lg-12">
				<h3><?=$name?></h3>
			</div>
			
			<div class="col-lg-2">
				<p><i><b><?=$type?></b></i></p>
			</div>
			
			<div class="col-lg-10">
				<p><b>Жанры</b>: <?php foreach($genre as $genr) {echo"$genr, ";} ?></p>
			</div>
			
			<div class="col-lg-12">
				<p>Оценка автора: <?=$star?></p>
			</div>
			
			<div class="col-lg-12">
				<p><?=$text?></p>
			</div>
			
			<div class="col-lg-12">
				<div class="row">
					<image class="col-lg-4" src=<?=$imageOne?> width="100%" height="auto" alt=<?=$name?> />
					<image class="col-lg-4" src=<?=$imageTwo?> width="100%" height="auto" alt=<?=$name?> />
					<image class="col-lg-4" src=<?=$imageThree?> width="100%" height="auto" alt=<?=$name?> />
				</div>
			</div>
					<div class="col-lg-12">
						<p>Оценок: <?=$like?></p>
					</div>
					<div>
						<div class="col-lg-1">
							<a class = 'btn btn-default' href ="<?=Yii::$app->urlManager->createUrl(['site/like', 'id'=> $id ])?>"> Like </a>
						</div>
						<div class="col-lg-6">
							<?php
								$objUser = new Users;
								$session = Yii::$app->session;
								$nameAut  = $author;
								$roleAut = $objUser->getRoleByUserName($nameAut);
								$nameUser = $session->get('log-in');
								$roleUser = $objUser->getRoleByUserName($nameUser);
								
								if ($nameUser != 'guest' && ($roleUser == 'admin' || ($roleUser == 'moder' && $roleAut !='admin')|| $nameUser == $nameAut)){
									$link = Yii::$app->urlManager->createUrl(['site/editpost', 'id'=> $id ]);
									echo "<a class = 'btn btn-warning' href =$link> Редактировать </a>";
								}
							?>
						</div>
					</div>
		</div>
	</div>	
</div>
<?php
//Вывод комментариев
foreach($comments as $comment) {
	$idCom = $comment[id];
	$nameAut  = $comment[userName];
	$roleAut = $objUser->getRoleByUserName($nameAut);
	$text = $comment[text];
	$date = $comment[dateCreate];
	$linlProfile =Yii::$app->urlManager->createUrl(['site/user', 'name'=> $nameAut]);
	$linkDelete =Yii::$app->urlManager->createUrl(['site/commentdel', 'idc'=> $idCom, 'idp'=>$id, 'a'=>$nameAut]);
	echo "
		<div class='container panel panel-default'>
			<div class='col-lg-7 panel-body'>
				<P><a class = 'role-$roleAut' href =$linlProfile> $nameAut</a></P>
				<p>$text</p>
				<p>$date</p>";
				if (   $nameUser != 'guest' && ($roleUser == 'admin' || ($roleUser == 'moder' && $roleAut !='admin')|| $nameUser == $nameAut)  ){
					echo "<a class = 'btn btn-default' href =$linkDelete> Удалить </a>";
				}
			echo"</div>
		</div>";
}
?>
<?=Html::submitButton ('Комментировать',['class'=>"btn btn-default", 'id'=>"butComment"])?>
<?="<div id='formAddComment'>"?>
<?php
$f = ActiveForm::begin(); ?>
	<?=$f->field($form, 'text')->textarea(['rows' => 3])?>
	<?=Html::submitButton ('Добавить',['class'=>"btn btn-success"])?>
<?php
ActiveForm::end();
?>
<?="</div>"?>
