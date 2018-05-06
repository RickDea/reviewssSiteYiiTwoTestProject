<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddCommentForm extends Model
{
	public $text;
	
	
	public function rules()
    {
        return [
            
            [['text'], 'required', 'message' => 'Поле не заполнено'],
			['text', 'string', 'length' => [1, 300],'message' => '', 'tooShort' => '', 'tooLong' => 'Не более 300 символов'],
        ];
    }
	
	public function attributeLabels()
    {
        return [
			'text' => 'Введите ваш комментарий:',
		
        ];
    }	
}
?>