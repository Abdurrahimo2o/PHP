<?php
require 'functions.php';
require 'Database.php';
// require 'router.php';

$config = require ('config.php');

$db = new Database($config['database']);

$id = $_GET['id'];
$query = "SELECT * FROM posts where id = :id";

$posts = $db->query($query, [':id' => $id]) -> fetchAll(); 



dd($posts); 
?>