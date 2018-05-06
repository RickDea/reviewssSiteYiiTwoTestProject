<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use yii\data\Pagination;

//Классы формочек
use app\models\EnterForm;
use app\models\RegistrForm;
use app\models\Changepassword;
use app\models\AddCommentForm;
use app\models\AddPostForm; 
use app\models\EditPostForm;
use app\models\SendMessageForm; 
use app\models\SearchForm;

//Классы для таблиц
use app\models\Users;
use app\models\Posts;
use app\models\Messages;
use app\models\Comments;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	// My code
	
	//Чек привзяки сессия == ip
	private function check() {
		$obj = new Users;
		
		if ($obj->antiHack()) {
			return $this->redirect(['index']);
		}	
	}
	//Регистрация
	public function actionRegistr()
    {
		$form = new RegistrForm();
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$obj = new Users();
			$obj -> registr($form["name"],$form["pass1"],$form["email"]); 
			
			return $this->render('registr', [
				'form' => $form,
				'message' => $obj -> message,
				'class' => $obj -> colorMessage,
			]);
		}
		else {
			return $this->render('registr', [
				'form' => $form,
			]);
		}
    }
	
	//Вход
	public function actionEnter()
    {
		$form = new EnterForm();
		
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$obj = new Users();
			$obj -> enter($form["name"],$form["pass1"]); 
			
			if ($obj->message == '') {
				return $this->redirect(['index']);
			}
			else {
				
				return $this->render('enter', [
				'message' => $obj->message,
				'class' =>$obj->colorMessage,
				'form' => $form,
			]);
				
			}
		}
		else {
			return $this->render('enter', [
				'form' => $form,
				'message' => '',
				'class' =>''	,
			]);
		}
    }
	
	//Страница правил сайта
	public function actionRules()
    {
		
        return $this->render('rules', [
            'form' => $form,
        ]);
    }
	//Страница о сайте
	public function actionAbout()
    {
		$form = new EnterForm();
		
        return $this->render('about', [
            'form' => $form,
        ]);
    }
	//Выход
	public function actionLog_out()
	{
		$obj = new Users();
		$obj->logOut();
		
		return $this->redirect(['index']);	
	}
	//Личный профиль пользователя
	public function actionProfile($t)
	{
		
		$this->check();
		$obj = new Users;
		$result = $obj->find()->where(['userName' => $obj->name()])->all();	
		$objPost = new Posts;
		
		if ($t == 'my') {
			$posts = $objPost -> getPostByUsersPostList(explode(".", $obj->find()->where(['userName' => $obj->name()])->one()[userPost]));
		}
			elseif ($t == 'like') {
				$posts = $objPost -> getPostByUsersPostList(explode(".", $obj->find()->where(['userName' => $obj->name()])->one()[userLike]));
			}
				else {
					return $this->redirect(['index']);
				}
			
		$pagination = new Pagination([
			'defaultPageSize' => 10,
			'totalCount' => count($posts),
			
		]);
		
		$posts = array_reverse($posts);
		$posts = array_slice($posts,$pagination->offset,$pagination->limit );

		return $this->render('profile',[
		'result' => $result,
		'posts' => $posts,
		'pagination' => $pagination,
		'type' => $t,
		]);
	}
	
	//Смена пароля пользователя
	public function actionChangepassword()
    {
		$this->check();
		
		$form = new Changepassword();
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$obj = new Users();
			$obj -> changeUserPassword($form["oldPassword"], $form["newPassword"]); 
			
			return $this->render('changepassword', [
				'form' => $form,
				'message' => $obj -> message,
				'class' => $obj ->colorMessage,
			]);
		}
		else {
			return $this->render('changepassword', [
				'form' => $form,
			]);
		}
    }
	//Страница рецензии
	public function actionPostpage($id)
	{
		$objR = new Users;
		$session = Yii::$app->session;
		$roleUser = $objR->getRoleByUserName($session->get('log-in'));
		
		
		$obj = new Posts;
		$result = $obj ->postGetById($id);
		
		$form = new AddCommentForm;
		$objComment = new Comments;
		
		//Добавление комментария
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			
			if ($objR->checkUserByName($session->get('log-in'))) { //Если пользователь зарегистрирован
				$text = $form["text"];
				$objComment->addComment($text, $id);
				$obj->addCommentIdtoPost($id, $objComment->commentGetLastId());
				$comments = $objComment->commentGetByPostList($obj->postGetCommentsListById($id));
				
				$form = new AddCommentForm;
				
				return $this->render('postpage',[
				'result' => $result,
				'role' => $roleUser,
				'roleAuthor' => $objR -> getRoleByUserName($result[postAuthor]),
				'form' => $form,
				'comments' => $comments,
				]);	
			}
			else {
				$comments = $objComment->commentGetByPostList($obj->postGetCommentsListById($id));
				
				return $this->render('postpage',[
				'result' => $result,
				'role' => $roleUser,
				'roleAuthor' => $objR -> getRoleByUserName($result[postAuthor]),
				'form' => $form,
				'comments' => $comments,
				]);	
			}
		}
		else {
			
			$comments = $objComment->commentGetByPostList($obj->postGetCommentsListById($id));
			return $this->render('postpage',[
			'result' => $result,
			'role' => $roleUser,
			'roleAuthor' => $objR -> getRoleByUserName($result[postAuthor]),
			'form' => $form,
			'comments' => $comments,
			]);	
		}		
	}
	//Добавление рецензии
	public function actionAddpost()
	{
		$this->check();
		$form = new AddPostForm();
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$objPost = new Posts();
			
			$type= Yii::$app->request->post()['EditPostForm']['type'];
			$genre=implode(".", Yii::$app->request->post()['EditPostForm']['genre']);
			
			$objPost -> postAdd($form["name"], $form["text"], $form["image"], 
			$form["imageOne"], $form["imageTwo"], $form["imageThree"], $form["star"], $type, $genre); 
			
			$objUser = new Users;
			$objUser -> userCreatePost($objPost -> postGetLast()[id]);
			
			
			return $this->render('postpage', [
				'result' => $objPost -> postGetLast(),
				'message' => $objPost -> message,
				'class' => $objPost -> colorMessage,
			]);
		}
		else {
			return $this->render('addpost', [
				'form' => $form,
			]);
		}	
	}
	
	//Редактирование рецензии
	public function actionEditpost($id)
	{
		$this->check();
		$obj = new Posts(); 
		$form = new EditPostForm($obj->postGetById($id));
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			
			$objR = new Users;
			$session = Yii::$app->session;
			
			$role = $objR->getRoleByUserName($session->get('log-in'));
			$author = $obj->getAuthorPostById($id);
			$roleAuthor = $objR->getRoleByUserName($author);
			
			$type= Yii::$app->request->post()['EditPostForm']['type'];
			$genre=implode(".", Yii::$app->request->post()['EditPostForm']['genre']);
						
			$obj -> postEdit($role, $author,$roleAuthor, $id, $form["name"], $form["text"], $form["image"], 
			$form["imageOne"], $form["imageTwo"], $form["imageThree"], $form["star"], $type, $genre); 

			return $this->redirect(['postpage', 'id'=>$id]);

		}
		else {
			return $this->render('editpost', [
				'form' => $form,
				'id' => $id,
			]);
		}
		
	}
	
	// Главная страница
	 public function actionIndex($n='',$a='',$t='',$g='') // Название, автор, тип, жанры
    {
		//Фильтры:
		$form = new SearchForm;
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$name = $form["name"];
			$author = $form["author"];
			$type = Yii::$app->request->post()['SearchForm']['type'];
			if (gettype(Yii::$app->request->post()['SearchForm']['genre']) == 'array'){ 
				$genre = implode(".", Yii::$app->request->post()['SearchForm']['genre']);
				
			}
			else {$genre='';}
			return $this->redirect(['index', 'n'=>$name, 'a'=>$author, 't'=>$type, 'g'=>$genre]);
			
			
		}
		
		else {
			$objPost = new Posts;
			$posts = $objPost->postGetByFiltrParams($n, $a, $t, $g);
			
			$pagination = new Pagination([
				'defaultPageSize' => 9,
				'totalCount' => $posts->count(),
				
			]);
			
			$posts = $posts->offset($pagination->offset)->limit($pagination->limit)->all();
			
			
			return $this->render('index', [
				'posts' => $posts,
				'pagination' => $pagination,
				'form' => $form,
			]);
		}
    }
	
	// Лайк записи
	public function actionLike($id)
	{
		$objUser = new Users;
		$session = Yii::$app->session;
		$name = $session->get('log-in');
		if ($objUser->checkUserByName($name)) {
			$objPost = new Posts;
			$objUser->like($id);
			$objPost->like($id);
			
			return $this->redirect(['postpage', 'id'=>$id]);
		}
		else {
			return $this->redirect(['postpage', 'id'=>$id]);
		}
		
	}
	//Публичный профиль пользователя
	public function actionUser($name)
	{
		
		$obj = new Users;
		
		if ($obj->checkUserByName($name)) {
			$result = $obj->find()->where(['userName' => $name])->one();
			$objPost = new Posts;
			
			$posts = $objPost -> getPostByUsersPostList(explode(".", $obj->find()->where(['userName' => $name])->one()[userPost]));
						
			$pagination = new Pagination([
				'defaultPageSize' => 10,
				'totalCount' => count($posts),
				
			]);
			
			$posts = array_reverse($posts);
			$posts = array_slice($posts,$pagination->offset,$pagination->limit );
			
			return $this->render('profilepublic',[
			'result' => $result,
			'posts' => $posts,
			'pagination' => $pagination,
			]);
		
		}
		else {
			return $this->redirect(['index']);
		}
		
	}
	
	//Сообщения пользователя
	public function actionMessages($t)
	{
		$this->check();
		$session = Yii::$app->session;
		$name = $session->get('log-in');
		
		$objUser = new Users;
		
		$messageIn = $objUser->userGetMessInByName($name);
		$messageOut = $objUser->userGetMessOutByName($name);
		
		$objMess = new Messages;
		
		
		if ($t == 'in') {
			$result = $objMess -> getMessageByUserMessList($messageIn);
		}
			elseif ($t == 'out') {
				$result = $objMess -> getMessageByUserMessList($messageOut);
			}
				else {
					return $this->redirect(['index']);
				}
			
		$pagination = new Pagination([
			'defaultPageSize' => 5,
			'totalCount' => count($result),
			
		]);
		$result = array_reverse($result);
		$result = array_slice($result,$pagination->offset,$pagination->limit );

		return $this->render('messages',[
		'result' => $result,
		'pagination' => $pagination,
		'type' => $t,
		]);	
	}
	
	
	// Отправка сообщения
	public function actionSend($n='')
	{
		$this->check();
		$form = new SendMessageForm;
		
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			
			$objUser = new Users;
			
			if ($objUser->checkUserByName($form["toUser"])) {
				$objMess = new Messages;
				$objMess->send($form["toUser"],$form["topic"],$form["text"]);
				$lastId = $objMess->getLastMessageId();
				$objUser->sendMessage($lastId, $form["toUser"],$form["text"]);
				
				$form = new SendMessageForm;
				return $this->render('send',[
					'message' => 'Сообщение отправлено',
					'class' => 'greenMessage',
					'form' => $form,	
				]);	
				
			}
			else {
				
				return $this->render('send',[
					'message' => 'Пользователь не найден!',
					'class' => 'redMessage',
					'form' => $form,
				]);	
			}
		}
		else {
			$form->toUser = $n;
			return $this->render('send',[
			'message' => '',
			'class' => '',
			'form' => $form,	
			]);	
		}
	}
	
	
	// Страница сообщения
	public function actionMessage($id)
	{
		$objMess = new Messages;

		if ($objMess->legetimMessageById($id)) {
			$objUser = new Users;
			$result = $objMess->getMessageById($id);
			
			$session = Yii::$app->session;
			$name = $session->get('log-in');
			if ($result[status] == 'new' && $name == $result[recipient]) {
				$objMess->changeStatus ($result[id], 'basic');
				$objUser -> messageWasReafer();
			}
			
			$roleSender = $objUser -> getRoleByUserName($result[sender]);
			$roleRecipient = $objUser -> getRoleByUserName($result[recipient]);

			return $this->render('message',[
			'roleSender'=> $roleSender,
			'roleRecipient'=> $roleRecipient,
			'result' => $result
			]);	
		}
		else {
			return $this->redirect(['index']);
		}	
	}
	//Удаление комментария
	public function actionCommentdel($idc, $idp, $a){
		$session = Yii::$app->session;
		$obj = new Users;
		$name = $session->get('log-in');
		$role = $obj-> getRoleByUserName($name);
		$roleAuthor = $obj-> getRoleByUserName($a);
		$this->check();
		if ( $name != 'guest' && ($role == 'admin' || ($role == 'moder' && $roleAuthor !='admin')|| $a == $name)  ) {
		
			$objCom = new Comments;
			$objPost = new Posts;
			$objCom->deleteComment($idc);
			$objPost->deleteCommentIdtoPost($idp, $idc);
			
			return $this->redirect(['postpage', 'id'=>$idp]);
		}
		else {
			
			return $this->redirect(['postpage', 'id'=>$idp]);
		}
		
	}
	
	

	
}
