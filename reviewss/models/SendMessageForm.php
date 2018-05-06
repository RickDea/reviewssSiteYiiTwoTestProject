<?php

namespace app\models;

use Yii;
use yii\base\Model; 

class SendMessageForm extends Model
{
	public $toUser;
	public $topic;
	public $text;

	
	public function rules()
    {
        return [
            
            [['topic', 'text', 'toUser'], 'required', 'message' => 'Поле не заполнено'],
			
			['topic', 'string', 'length' => [1, 30],'message' => 'Текст некорректный', 'tooShort' => 'Не менее 1 символа', 'tooLong' => 'Не более 30 символов'],
			['text' , 'string', 'length'=> [1, 300],'message' => 'Текст некорректный', 'tooShort' => 'Не менее 1 символа', 'tooLong' => 'Не более 300 символов'],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'toUser' => 'Кому:',
			'topic' => 'Тема:',
			'text' => 'Сообщение:',
        ];
    }
	
}
?>