<?php
//Database config
$driver = 'mysql';//Your database
$host   = 'localhost';//Ip of your database
$user   = 'root';  //User
$passwd = 'n1p2zh';//Password
$dbname = 'todo';//database name
$charset= '';//recommended charset is UTF-8 (utf8)
$opt    = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];//options