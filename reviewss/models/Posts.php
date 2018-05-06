<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Posts extends ActiveRecord
{
	public $message = '';
	public $colorMessage = 'greenMessage';
	//Поиск по ИД
	public function postGetById($id) {
		return $this->find()->where(['id' => $id])->one();
	}
	//Поиск имени по ИД
	public function postGetNameById($id) {
		return $this->find()->where(['id' => $id])->one()[postName];
	}
	//Вернуть последний созданный пост
	public function postGetLast() {
		return $this->find()->orderBy('id DESC')->one();
	}
	// Добавление поста
	public function postAdd($name, $text, $image,$imageOne, $imageTwo, $imageThree, $star, $type, $genre) {
		
		$session = Yii::$app->session;
		if ($session->get('log-in') != 'guest'){
			$this->	postName = $name;
			$this-> postAuthor = $session->get('log-in');
			$this-> postText = $text;
			$this-> postImage = $image;
			$this-> postImageOne = $imageOne;
			$this-> postImageTwo = $imageTwo;
			$this-> postImageThree = $imageThree;
			$this-> postStar = $star;
			$result -> postType = $type;
			$result -> postGenre = $genre;
			$this->save();
			$this->message = 'Отзыв успешно добавлен!';
		}
		else {
			$this->message = 'Вы не авторизированы!';
			$this->colorMessage ='redMessage';
		}
	}
	//Редактирование поста
	public function postEdit($role, $author, $roleAuthor, $id, $name, $text, $image,$imageOne, $imageTwo, $imageThree, $star, $type, $genre) {
		$session = Yii::$app->session;
		$nameUser = $session->get('log-in');
		$roleUser = $role;
		$a = $author;
		$roleAuthor = $roleAuthor;
		
		if	( $name != 'guest' && ($role == 'admin' || ($role == 'moder' && $roleAuthor !='admin')|| $a == $name)  ) {
			$result = $this->findOne(['id'=>$id]);
			$result -> postName = $name;
			$result -> postText = $text;
			$result -> postImage = $image;
			$result -> postImageOne = $imageOne;
			$result -> postImageTwo = $imageTwo;
			$result -> postImageThree = $imageThree;
			$result -> postStar = $star;
			$result -> postType = $type;
			$result -> postGenre = $genre;
			$result->save();
			$this->message = 'Отзыв успешно отредактирован!';
		}
		else {
			$this->message = 'У вас недостаточно прав!';
			$this->colorMessage ='redMessage';
		}
	}
	//Вернуть автора поста по ИД
	public function getAuthorPostById($id) {
		
		$result = $this->findOne(['id'=>$id]);
		return $result[postAuthor];	
	}
		//Добавить или убрать ИД пользователя из поля лайков поста
		public function like($idpost) {
				
		$session = Yii::$app->session;
		$likeMass = $this->findOne(['id'=>$idpost])[postLikeUsers];
		$likeMass = explode(".", $likeMass);
		$action='Like';
		foreach ($likeMass as $users) {
			if ($users == $session->get('log-in')) {
				$action='desLike';
				break;
			}
		}
		
		if ($action == 'Like') {
			array_push($likeMass, $session->get('log-in'));
			$likeMass = implode(".", $likeMass);
			$result = $this->findOne(['id'=>$idpost]);
			$result->postLikeUsers = $likeMass;
			$result->postLike = $result->postLike + 1;
			$result->save();
		}
		else {
			unset($likeMass[array_search($session->get('log-in'),$likeMass)]);
			$likeMass = implode(".", $likeMass);
			$result = $this->findOne(['id'=>$idpost]);
			$result->postLikeUsers = $likeMass;
			$result->postLike = $result->postLike - 1;
			$result->save();
		}

	}
	//Вернуть массив постов по массиву ИД от пользователя
	public function getPostByUsersPostList($listPost) {
		
		$result = $this->find()->where(['id'=>0])->all();
		$counter = 0;
		
		foreach ($listPost as $idPost){
			if ($idPost == 0) {continue;}
			$result[$counter] = $this ->find()->where(['id'=>$idPost])->one();
			$counter++; 
		}
		
		return $result;
	}
	//Добавление комментария к посту
	public function addCommentIdtoPost($idPost, $idComment) {
		$result = $this->findOne(['id'=>$idPost]);
		$comments = explode(".", $result[postComments]);
		array_push($comments, $idComment);
		$comments = implode(".", $comments);
		$result->postComments = $comments;
		$result->save();	
	}
	
	//Удаление комментария из поста
	public function deleteCommentIdtoPost($idPost, $idComment) {
		
		$session = Yii::$app->session;
		$comments = $this->findOne(['id'=>$idPost])[postComments];
		$comments = explode(".", $comments);
		unset($comments[array_search($idComment,$comments)]);
		$comments = implode(".", $comments);
		$result = $this->findOne(['id'=>$idPost]);
		$result->postComments = $comments;
		$result->save();	
	}
	//Вернуть массив ИД комментариев по ИД поста
	public function postGetCommentsListById($id) {
		
		return explode(".", $this->findOne(['id'=>$id])[postComments]);
		
	}
	//Поиск по параметрам фильтра
	public function postGetByFiltrParams($name, $author, $type, $genre) {
		$result = $this->find()->orderBy('id DESC');
		
		if ($author != '') {$result->andWhere(['postAuthor' => $author]);}
		if ($name != '') {$result->andWhere(['postName' => $name]);}
		if ($type != '') {$result->andWhere(['postType' => $type]);}
		if ($genre != '') {
			$genre=explode(".",$genre);

			$result->andWhere(['LIKE','postGenre', '%'.implode("%",$genre).'%' , false]); //
		}
		
		return $result;
	}
	
}
?>