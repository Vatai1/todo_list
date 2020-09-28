<?php
require_once 'functions.php';
if(isset($_POST['auth'])){
    $password = $_POST['password'];
    $login = $_POST['login'];
    if(!authUser($login,$password)) echo 'НЕВЕРНЫЙ ПАРОЛЬ!';
}



?>


<form method="post">
    Ваш логин или email адрес<input  name='login'type="text" required>
    Ваш пароль <input  name='password'type="password" required>
    <input name="auth" type="submit" required>
    
    
</form>


