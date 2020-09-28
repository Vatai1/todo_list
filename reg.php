<?php
require_once 'functions.php';

//Начало регистрации пользователя
if(isset($_POST['register'])) {

    $login    = $_POST['login'];
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    regUser($login,$name,$email,$password);
}



?>

<form method="post">
    <input name="login"type="text"    placeholder="Login" required> <br><br>
    <input name="name"type="text"    placeholder="Your name" required> <br><br>
    <input name="email"type="email"   placeholder="Your email address" required> <br><br>
    <input name="password"type="password"placeholder="Password" required> <br><br>
    <input name="register"type="submit">


</form>
