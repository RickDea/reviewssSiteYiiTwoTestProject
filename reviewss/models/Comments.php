<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{
	public $message = '';
	public $colorMessage = 'greenMessage';
	
	// Добавление комментария в БД
	public function addComment($text, $targetPost) {
		$session = Yii::$app->session;
		$this->userName = $session->get('log-in');
		$this->targetPosts = $targetPost;
		$this->text = $text;
		$this->save();
	}
	//Удаление комментария
	public function deleteComment($id) {
		$result= $this->findOne(['id'=> $id])->delete();
		
	}
	//Получить последний добавленный комментарий
	public function commentGetLastId(){
		return $this->find()->orderBy('id DESC')->one()[id];
	}
	//Получить массив коммпентариев по массиву их ИД
	public function commentGetByPostList($list){
		
		$result = $this->find()->where(['id'=>0])->all();
		$counter = 0;
		foreach ($list as $idComment){
			if ($idComment == 0) {continue;}
			$result[$counter] = $this ->find()->where(['id'=>$idComment])->one();
			$counter++; 
		}
		return $result;

	}
	
}
?>