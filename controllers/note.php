<?php

$config = require ('config.php');
$db = new Database($config['database']);

$heading = " Note";



$note = $db -> query('SELECT * FROM notes where id = :id', [
    'id' => $_GET['id']
])->fetch();
 
if(! $note){
    abort();
};

$currentUserId = 1;

if($note['user_id'] != $currentUserId){
    abort(Response::FORBIDDEN); 
}

require "views/note.view.php";  