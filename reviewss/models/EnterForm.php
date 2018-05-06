<?php
namespace app\models; 

use Yii;
use yii\base\Model;

class EnterForm extends Model
{
	
	public $name;
	public $pass1;
	public $verifyCode;
	
	
	public function rules()
    {
        return [
            
            [['name', 'pass1'], 'required', 'message' => 'Поле не заполнено'],
			['verifyCode', 'captcha', 'message' => 'Вызываю Уила Смитта...'],
			
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'name' => 'Имя пользователя',
            'pass1' => 'Пароль',
			'verifyCode' => 'Докажите, что вы не андройд',
            
        ];
    }
	
	
	
	
}
?>