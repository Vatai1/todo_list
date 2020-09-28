<?php
require_once 'functions.php';
if($_POST['auth']){
    $password = $_POST['password'];
    $login = $_POST['login'];
    auth($login,$password);
}



?>


<form method="post">
    Ваш логин или email адрес<input  name='login'type="text" required>
    Ваш пароль <input  name='email'type="password" required>
    <input name="auth" type="submit" required>
    
    
</form>


