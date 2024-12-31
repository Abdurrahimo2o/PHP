<?php

use Core\Database;
use Core\Validator;
use Core\App;

$email = $_POST['email'];
$password = $_POST['password'];

// validate the form
$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = 'Please enter a valid email address';
}
if (!Validator::string($password, 7, 255)) {
    $errors['password'] = 'Please enter a valid password of at least 7 characters';
}

if (!empty($errors)) {
    return view('registration/create.view.php', [
        'errors' => $errors,
    ]); 
}

$db = App::resolve(Database::class);

//check if the account already exists
$user = $db->query('SELECT * FROM users WHERE email = :email',[
    'email' => $email
]) -> find();

if($user) {
    // then someone with that email already exists and has an account
    // If yes, redirect to login page
    header('location: /');
    exit();
    }else {
        // If not, save the one database, and then log the user in, and redirect  
        $db->query('INSERT INTO users (email, password) VALUES (:email, :password)', [
            'email' => $email,
            'password' => $password,
        ]);
    }

    //mark that the user is logged in

    $_SESSION['user'] = [
        'email' => $email,
    ];

    header('location: /');
    exit();

// view('registration/store.view.php');