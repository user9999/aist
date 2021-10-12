<?php

/* Строка чата */

class ChatLine extends ChatBase
{
    protected $text = '';
    
    protected $author = '';
    
    protected $page = '';
    
    public function save()
    {
        DB::query("
			INSERT INTO kvn_webchat_lines (author, page, text)
			VALUES (
				'".DB::esc($this->author)."',
				'".DB::esc($this->page)."',
				'".DB::esc($this->text)."'
		)");
        
        // Возвращаем объект MySQLi класса DB
        
        return DB::getMySQLiObject();
    }
}
