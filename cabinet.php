<?php
require_once 'functions.php';
if(isset($_SESSION['login'])){
    echo $_SESSION['login'] . ', добро пожаловать в личный кабинет!';
}else{
    die('Нет доступа!');
}
if(isset($_POST['logout'])) destroySession();
?>


<form method="post">
    <input name="logout" type="submit">
</form>


