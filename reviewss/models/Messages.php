<?php
namespace app\models;
use Yii;
use yii\widgets\LinkPager;
use yii\db\ActiveRecord;

class Messages extends ActiveRecord
{
	
	public $message = '';
	public $colorMessage = 'greenMessage';
	// Добавления сообщения в БД
	public function send($toUserId, $topic, $text){
		$session = Yii::$app->session;
		$sender = $session->get('log-in');
		
		$this->sender = $sender;
		$this->recipient = $toUserId;
		$this->topic = $topic;
		$this->text = $text;
		$this->save();
		$this->message = 'Сообщение отправлено'; 
	}
	//Вернуть ИД последнего сообщения
	public function getLastMessageId() {
		return $this ->find()->orderBy('id DESC')->one()[id];
	}
	//Поиск сообщения по ИД
	public function getMessageById($id) {
		return $this->find()->where(['id' => $id])->one();
	}
	//Чек права на просмотр сообщения (только для отправителя/получателя)
	public function legetimMessageById($id) {
		$session = Yii::$app->session;
		$user = $session->get('log-in');
		$sender= $this->find()->where(['id' => $id])->one()[sender];
		$recipient= $this->find()->where(['id' => $id])->one()[recipient];
		
		if ($user == $sender || $user == $recipient) {
		return true;
		}
		else {
			return false;
		}
	}
	//Получение массива сообщений по массиву их ИД
	public function getMessageByUserMessList($listMassage) {
		
		$result = $this->find()->where(['id'=>0])->all();
		$counter = 0;
		
		foreach ($listMassage as $idMess){
			if ($idMess == 0) {continue;}
			//array_push($result, );
			
			$result[$counter] = $this ->find()->where(['id'=>$idMess])->one();
			$counter++; 
		}
		
		return $result;
	}
	// Смена статуса письма при прочтении
	public function changeStatus($id, $status){
		$result = $this->findOne(['id' => $id]);
		$result-> status = $status;
		$result->save();
	}
	
}
?>