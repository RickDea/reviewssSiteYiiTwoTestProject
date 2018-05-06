<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SearchForm extends Model
{
	public $name;
	public $author;
	public $type;
	public $genre;
	
	
	public function rules()
    {
        return [
        [['name','author'], 'string', 'length' => [0, 100],'message' => '', 'tooShort' => '', 'tooLong' => ''], 		     
        ];
    }
	
	public function attributeLabels()
    {
        return [
			'name' => 'Название:',
			'author' => 'Автор:',
			'type' => 'Тип:',
			'genre' => 'Жанры:',
		
        ];
    }	
}
?>