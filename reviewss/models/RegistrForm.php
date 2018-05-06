<?php

namespace app\models;

use Yii;
use yii\base\Model; 


class RegistrForm extends Model
{
	
	public $name;
	public $email;
	public $pass1;
	public $pass2;
	public $verifyCode;
	
	public function rules()
    {
        return [
            
            [['name', 'email', 'pass1', 'pass2'], 'required', 'message' => 'Поле не заполнено'],
			['email', 'email', 'message' => 'Электронный адрес не корректен'],
			['pass1', 'compare', 'compareAttribute' => 'pass2', 'message' => 'Пароли не совпадают'],
			['pass2', 'compare', 'compareAttribute' => 'pass1', 'message' => 'Пароли не совпадают'],
			['verifyCode', 'captcha', 'message' => 'Вызываю Уила Смитта...'],
			['name', 'string', 'length' => [3, 9],'message' => 'Имя пользователя некорректно', 'tooShort' => 'Слишком коротко...', 'tooLong' => 'Слишком длинно...'],
			[['pass1', 'pass2'], 'string', 'length' => [7, 30],'message' => 'Пароль некорректн', 'tooShort' => 'Минимум 7 символов...', 'tooLong' => 'Слишком длинно...'],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'name' => 'Имя пользователя',
            'email' => 'Электронный адрес',
            'pass1' => 'Пароль',
            'pass2' => 'Повторите пароль',
			'verifyCode' => 'Докажите, что вы не андройд',
			
        ];
    }
	
	
	
	
	
}
?>