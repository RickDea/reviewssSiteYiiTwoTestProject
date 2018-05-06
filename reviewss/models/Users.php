<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
	
	public $message = '';
	public $colorMessage = 'greenMessage';
	
	//Функция для хеша
	public function hashcode($str){
		
		return hash( 'sha256', $str, false );
	}
	//Регистрация
	public function registr($name, $pass, $email){
		
		$pass = $this->hashcode($pass);
		$count = $this->find()
		->where(['userName' => $name])
		->count();
		
		if ($count == 0) {
		
			$this->userName = $name;
			$this->userPassword = $pass;
			$this->email = $email;
			$this->save();
			$this->message = 'Пользователь успешно добавлен!';
		}
		else {
			$this->message = 'Имя пользователя уже используется';
			$this->colorMessage = 'redMessage';
		}
		
	}
	
	public function message() {
		return $this->message;
	}
	//Вход
	public function enter($name, $pass){
		$pass = $this->hashcode($pass);
		$count = $this->find()
		->where(['userName' => $name,'userPassword' => $pass])
		->count();
		
		if ($count == 1) {
			
			$session = Yii::$app->session;
			$session->open();
			$session->set('log-in', $name);
			$session->set('ip',$this->hashcode($_SERVER['REMOTE_ADDR']));
			$this->message = '';
		}
		else {
			$this->message = 'Имя пользователя или пароль неверен!';
			$this->colorMessage = 'redMessage';
		}
		
	}
	//Выход
	public function logOut() {
		$session = Yii::$app->session;
		$session->destroy();
		$session->open();
		$session->set('log-in', 'guest');
		$session->set('ip',$this->hashcode($_SERVER['REMOTE_ADDR']));
	}
	//Смена пароля
	public function changeUserPassword($oldPassword, $newPassword) {
		$newPassword = $this->hashcode($newPassword);
		$oldPassword = $this->hashcode($oldPassword);
		$session = Yii::$app->session;
		
		$count = $this->find()
		->where(['userName' => $session->get('log-in'),'userPassword' => $oldPassword])
		->count();
		
		if ($count == 1) {
			$result = $this->findOne(['userName'=>$session->get('log-in')]);
			$result->userPassword = $newPassword;
			$result->save();
			$this->message = 'Новый пароль успешно установлен!';
		}
		
		else {
			$this->message = 'Введен неверный пароль!';
			$this->colorMessage = 'redMessage';
		}
		
	}
	
	public function name() {
		$session = Yii::$app->session;
		return $session->get('log-in');
	}
	//Получение роли пользователя по имени
	public function getRoleByUserName($name) {
		$result = $this->findOne(['userName'=>$name]);
		return $result[rule];
	}
	//Добавление или изъятие ИД записи из (понравившихся)
	public function like($idpost) {
				
		$session = Yii::$app->session;
		$likeMass = $this->findOne(['userName'=>$session->get('log-in')])[userLike];
		$likeMass = explode(".", $likeMass);
		$action='Like';
		foreach ($likeMass as $id) {
			if ($id == $idpost) {
				$action='desLike';
				break;
			}
		}
		
		if ($action == 'Like') {
			array_push($likeMass, $idpost);
			$likeMass = implode(".", $likeMass);
			$result = $this->findOne(['userName'=>$session->get('log-in')]);
			$result->userLike = $likeMass;
			$result->save();
		}
		else {
			unset($likeMass[array_search($id,$likeMass)]);
			$likeMass = implode(".", $likeMass);
			$result = $this->findOne(['userName'=>$session->get('log-in')]);
			$result->userLike = $likeMass;
			$result->save();	
		}

	}  
	
	public function userCreatePost($idpost) { // Добавлене ID отзыва в "созданные пользователем"
		
		$session = Yii::$app->session;
		if($session->get('log-in') != 'guest') {
			$postsMass = $this->findOne(['userName'=>$session->get('log-in')])[userPost];
			$postsMass = explode(".", $postsMass);
			array_push($postsMass, $idpost);
			$postsMass = implode(".", $postsMass);
			$result = $this->findOne(['userName'=>$session->get('log-in')]);
			$result-> userPost = $postsMass;		
			$result-> save();
		}
	}
	//Поиск пользователя в БД по Имени
	public function userGetByName($name) {
		return $this->find()->where(['userName' => $name])->one();
	}
	//Отправка сообщения
	public function sendMessage($idMessage, $nameToUser){
		$session = Yii::$app->session;
		$sender = $session->get('log-in');
		
		
		// Добавление сообщения отправителю
		$senderEdit = $this->findOne(['userName'=>$sender]); 
		$messageList = explode(".", $senderEdit[userMessageOut]);
		array_push($messageList, $idMessage);
		$messageList = implode(".", $messageList);
		$senderEdit->userMessageOut = $messageList;
		$senderEdit->save();	
			
		// Добавление сообщения получателю
		$recipientEdit = $this->findOne(['userName'=>$nameToUser]);
		$messageList2 = explode(".", $recipientEdit[userMessageIn]);
		array_push($messageList2, $idMessage);
		$messageList2 = implode(".", $messageList2);
		$recipientEdit->userMessageIn = $messageList2;
		$recipientEdit->counterNewMessage = $recipientEdit->counterNewMessage +1;
		$recipientEdit->save();
	}
	//Проверка наличия пользователя в БД
	public function checkUserByName($name){
		$count = $this->find()
		->where(['userName' => $name])
		->count();
		
		$session = Yii::$app->session;
		
		
		if ($count == 1 && $session->get('log-in') != 'guest') {
			return true;
		}
		else {
			return false;
		}
	}
	//Получение массива входящих соощений
	public function userGetMessInByName($name) {
		return explode(".", $this->find()->where(['userName' => $name])->one()[userMessageIn]);
	}
	//Получение массива исходящих соощений
	public function userGetMessOutByName($name) {
		return explode(".", $this->find()->where(['userName' => $name])->one()[userMessageOut]);
	}
	//Количество непрочтенных сообщений
	public function counterMessage() {
		$session = Yii::$app->session;
		return $this->find()->where(['userName'=> $session->get('log-in')])->one()[counterNewMessage];
	}
	//Уменьшение количества непрочтенных сообщений
	public function messageWasReafer() {
		$session = Yii::$app->session;
		$result = $this->findOne(['userName'=>$session->get('log-in')]);
		$result->counterNewMessage = $result->counterNewMessage - 1;
		$result->save();	
	}
	//Сравнение текущего IP пользователя с IP при создании сессии 
	public function antiHack() {
		$session = Yii::$app->session;
		if ( $session->get('ip') != $this->hashcode($_SERVER['REMOTE_ADDR']) ) {
			$this->logOut();
			return true;
		}
		else {
			return false;
		}
	}
}
?>