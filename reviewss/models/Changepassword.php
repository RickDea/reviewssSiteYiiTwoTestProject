<?php

namespace app\models;

use Yii;
use yii\base\Model; 


class Changepassword extends Model
{
	public $oldPassword;
	public $newPassword;
	public $repitNewPassword;
	
	public function rules()
    {
        return [
            
            [['oldPassword', 'newPassword', 'repitNewPassword'], 'required', 'message' => 'Поле не заполнено'],
			['newPassword', 'compare', 'compareAttribute' => 'repitNewPassword', 'message' => 'Пароли не совпадают'],
			['repitNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают'],
			//['verifyCode', 'captcha', 'message' => 'Вызываю Уила Смитта...'],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'oldPassword' => 'Введите текущий пароль',
            'newPassword' => 'Введите новый пароль',
            'repitNewPassword' => 'Повторите новый пароль',
			//'verifyCode' => 'Докажите, что вы не андройд',	
        ];
    }
	
	
	
	
	
}
?>