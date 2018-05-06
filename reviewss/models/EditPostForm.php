<?php

namespace app\models;

use Yii;
use yii\base\Model;

class EditPostForm extends Model
{
	public $name;
	public $text;
	public $image;
	public $imageOne;
	public $imageTwo;
	public $imageThree;
	public $star;
	public $type;
	public $genre;
	
	public function __construct($result){
		$this -> name = $result[postName];
		$this -> text = $result[postText];
		$this -> image = $result[postImage];
		$this -> imageOne = $result[postImageOne];
		$this -> imageTwo = $result[postImageTwo];
		$this -> imageThree = $result[postImageThree];
		$this -> star = $result[postStar];
		$this -> type = $result[postType];
		$this -> genre = explode(".", $result[postGenre]);
	}
	
	public function rules()
    {
        return [
            
            [['name', 'text', 'image', 'imageOne', 'imageTwo', 'imageThree', 'star'], 'required', 'message' => 'Поле не заполнено'],
			
			['text', 'string', 'length' => [300, 9999],'message' => 'Имя пользователя некорректно', 'tooShort' => 'Минимум 300 символов!', 'tooLong' => ''],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
			'text' => 'Текст рецензии',
			'image' => 'Url ссылка на основное изображение',
			'imageOne' => 'Url ссылка на дополнительное изображение/кадр',
			'imageTwo' => 'Url ссылка на дополнительное изображение/кадр',
			'imageThree' => 'Url ссылка на дополнительное изображение/кадр',
			'star' => 'Оценка',
			'type' => 'Тип',
			'genre' => 'Жанры',
        ];
    }	
}
?>