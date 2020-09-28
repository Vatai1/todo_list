<?php
require_once 'config.php';
session_start();


//connect НЕ ТРОГАЙ СУКА ЭТУ ХУЙНЮ ВСЁ НАХУЙ ВЗОРВЁТСЯ
$dsn = "$driver:host=$host;dbname=$dbname";//Don't touch!!!
$conn = new PDO($dsn,$user,$passwd);//Don't touch!!!

//check connection или пиздец на случай моей криворукости
if(!$conn) echo 'FATAL ERROR, please, check "config.php" file';

//запрос в MariaDB Хуй знает нахуя я его написал , т.к. не юзаю его
function mysqlQuery($sql){
    global $conn;
    $response = $conn->query($sql);
    if(!$response) die('FATAL ERROR, check your SQL query');
    $result = $response->fetchColumn(0);
    return $result;

}
//Ебенит все сессии и куки к хуям собачим
function destroySession(){
    $_SESSION = [];
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(), '',time() - 3600, '/');
    }
    session_destroy();
    header('Location: index.php');
}

//Закидывает инфу о юзере в бд при условиях уникальности логина и мейла
function regUser($login,$name,$email,$password){
    if(!(checkLogin($login) & checkEmail($email))){
        global $conn;
        $password = hashPass($password);
        var_dump($password);
        $params = [':login'=>$login, ':name'=>$name, ':email'=>$email, ':password'=>$password];
        $sql = 'INSERT INTO users(login, name, email, password) VALUES(:login, :name, :email, :password)';
        $query = $conn->prepare($sql);
        $query->execute($params);
        $_SESSION['login'] = $login;
        header('Location: cabinet.php');

    }else{
        Echo 'Уже существует аккаунт с таким логином или почтой';
    }
}
function hashPass($password){
    return password_hash($password,PASSWORD_BCRYPT);
}

function authUser($login,$password){
    global $conn;
    if (checkLoginOrEmail($login)){
        if(checkPass($login,$password)){
            $_SESSION['login'] = $login;
            header('Location: cabinet.php');
            return true;
        }else return false;
    }else return false;
}


function checkLoginOrEmail($login){
   return (checkLogin($login) || checkEmail($login));
}

function checkLogin($login){
    global $conn;
    $sql ="SELECT EXISTS(SELECT login FROM users WHERE login=:login)";
    $query = $conn->prepare($sql);
    $query->execute(array(':login' => $login));
    $response = $query->fetchColumn();
    if($response) return true;
    else return false;
}
function checkEmail($email){
    global $conn;
    $sql ="SELECT EXISTS(SELECT email FROM users WHERE email=:email)";
    $query = $conn->prepare($sql);
    $query->execute(array(':email' => $email));
    $response = $query->fetchColumn();
    if($response) return true;
    else return false;
}
function checkPass($login,$password){
    global $conn;
    $sql = "SELECT password FROM users WHERE login=:login";
    $query = $conn->prepare($sql);
    $query->execute(array(':login' => $login));
    $response = $query->fetchColumn();
    return password_verify($password,$response);
}











