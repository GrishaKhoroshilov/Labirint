<?php


namespace App\model\game;


use src\utils\App;

class User
{
    public $id;
    public $chatId;
    public function __construct($chatId)
    {
        $userData = App::app()->db->select('SELECT * FROM users WHERE chat_id = :chat_id', [
            ':chat_id' => $chatId
        ]);
        if (!$userData) {
            App::app()->db->insert('users', [
                'chat_id' => $chatId
            ]);
            $userData = App::app()->db->select('SELECT * FROM users WHERE chat_id = :chat_id', [
                ':chat_id' => $chatId
            ]);
        }
        $this->id = $userData['id'];
        $this->chatId = $userData['chat_id'];
    }
}