<?php
use yii\widgets\LinkPager;
use app\models\Users;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerJsFile('web/js/mainPage.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<?="<h2 class = $class >$message</h2>"?>
<div class="site-index">
<h3>Рецензии наших пользователей:</h3>
<?php
$session = Yii::$app->session;
?>


<?=Html::submitButton('',['id'=>"butFiltrOpen",'class'=>"glyphicon glyphicon-search"]);?>
<?='<br />'?><?='<br />'?>


<?="<div class='container'> <div class='row mod-row'>"?>

<?="<div id='searchForm' class='col-lg-12  panel panel-default' style='display: none'>"?>
	<?php $f = ActiveForm::begin(); ?>
		
		
		
		<?="<div class='col-lg-6'>"?>
			<?="<div class='col-lg-12'>"?>
				<?=$f->field($form, 'name')?>
			<?="</div>"?>
			<?="<div class='col-lg-12'>"?>
				<?=$f->field($form, 'author')?>
			<?="</div>"?>
			<?="<div class='col-lg-12'>"?>
				<?=$f ->field($form, 'genre')
					->inline(true)
					->checkboxList([
						'action' => 'Экшен',
						'comedy' => 'Комедия',
						'horror' => 'Хоррор',
						'detective' => 'Детектив',
						'fantasy' => 'Фэнтези',
						'dramma' => 'Драмма',
						'scienceFiction' => 'Научная фантастика',
					]);?>
			<?="</div>"?>
		<?="</div>"?>
		
		
		<?="<div class='col-lg-6'>"?>
			<?="<div class='col-lg-12'>"?>
				<?=$f->field($form, 'type')
					->radioList([
						'' => 'Все',
						'film' => 'Фильм',
						'animation' => 'Мультипликация',
						'series' => 'Сериал'
					]);?>
			<?="</div>"?>

			<?="<div class='col-lg-12'>"?>
				<?=Html::submitButton('Искать',['class'=>"btn btn-success"]);?>
			<?="</div>"?>
	
		<?="</div>"?>
		
		
		
	<?php
	ActiveForm::end();
	?>
<?="</div>"?>




<?php
//Вывод постов
foreach ($posts as $post) {
	$objUser = new Users;
	$roleAuthor = $objUser -> getRoleByUserName($post->postAuthor);
	$text = mb_substr($post->postText,0,130).'...';
	$link = Yii::$app->urlManager->createUrl(['site/postpage', 'id'=> $post->id]);
	$linlProfile =Yii::$app->urlManager->createUrl(['site/user', 'name'=> $post->postAuthor]);
	echo "
		
			<div class='col-lg-4  panel panel-default'>
				<div class'panel-body'>
					<div class='col-lg-12'>
						<a href ='$link'> <h3>$post->postName</h3> </a>			
					</div>
					
					<div class='row'>
						<div class='col-lg-5'>
							<image src=$post->postImage width='100%' height='auto' alt=$post->postName/>

							<div class='col-lg-12'>
								<P>Автор: <a class = 'role-$roleAuthor' href =$linlProfile> <span>$post->postAuthor</span> </a></P>
							</div>

						</div>
						
						<div class='col-lg-7'>
							<div class='col-lg-12'>
								<p>$text</p>
							</div>
							<div class='col-lg-12'>
								<p>Оценок: $post->postLike</p>
							</div>
						</div>
					</div>
					
				</div>
				
			</div>

	";
}
echo "</div></div>";
?>
<?=LinkPager::widget(['pagination'=>$pagination]) ?>
</div>
<?php
if ($session->get('log-in') != 'guest'){
	$linkAdd = Yii::$app->urlManager->createUrl(['site/addpost']);
	echo "<a class = 'btn btn-primary' href =$linkAdd> Добавить рецензию </a> <br />";
}
?>
