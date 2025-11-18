<?php
global $conn;
$servername= "localhost";
$username="root";
$password = "";

try{

$options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION , PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ] ;
$conn = new PDO("mysql:host=$servername;dbname=trade" , $username , $password , $options) ;
return $conn;
}catch (PDOException $e){
    echo "connection faild: " . $e->getMessage();
}