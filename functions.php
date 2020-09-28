<?php
require_once 'config.php';


//connect
$dsn = "$driver:host=$host;dbname=$dbname";//Don't touch!!!
$conn = new PDO($dsn,$user,$passwd);

//check connection
if(!$conn) echo 'FATAL ERROR, please, check "config.php" file';


function mysqlQuery($sql){
    global $conn;
    $response = $conn->query($sql);
    if(!$response) die('FATAL ERROR, check your SQL query');
    $result = $response->fetchColumn(0);
    return $result;

}

function regUser($login,$name,$email,$password){
    if(checkLogin($login) & checkEmail($email)){
        global $conn;
        $password = hashPass($password);
        var_dump($password);
        $params = [':login'=>$login, ':name'=>$name, ':email'=>$email, ':password'=>$password];
        $sql = 'INSERT INTO users(login, name, email, password) VALUES(:login, :name, :email, :password)';
        $query = $conn->prepare($sql);
        $query->execute($params);
        echo 'true';
    }else{
        Echo 'Уже существует аккаунт с таким логином или почтой';
    }
}
function hashPass($password){
    return password_hash($password,PASSWORD_BCRYPT);
}

function auth($login,$password){
    global $conn;
    if (checkLogin($login) || checkEmail($login)){
        $sql = "SELECT password FROM users WHERE password=':password'";
        $query = $conn->prepare($sql);
        $query->execute(array(':password'=>$password));
        $response = $query->fetchColumn(0);
        hashPass($response);
        if($password == $response){
            header('Location: cabinet.php');
            return true;
        }
    }else return false;
}

function checkLogin(string $login){
    global $conn;
    $sql = "SELECT login FROM users WHERE login=:login";
    $query = $conn->prepare($sql);
    $query->execute(array(':login'=> $login));
    $result = $query->fetchColumn();
    if($login !== $result){
        return true;
    }else return false;
}
function checkEmail(string $email){
    global $conn;
    $sql = "SELECT email FROM users WHERE email=:email";
    $query = $conn->prepare($sql);
    $query->execute(array(':email'=> $email));
    $result = $query->fetchColumn();
    if($email !== $result){
        return true;
    }else return false;
}

function checkPass(string $passwd){
    global $conn;
    hashPass($passwd);
    $sql = "SELECT passwd FROM users WHERE passwd=:passwd";
    $query = $conn->prepare($sql);
    $query->execute(array(':passwd'=> $passwd));
    $result = $query->fetchColumn();
    $result = hashPass($result);
    if($passwd !== $result){
        return true;
    }else return false;
}










