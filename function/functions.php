<?php
require_once "db.php";
function checkuser($email)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch();
}

function createuser($name, $email, $password)
{
    global $conn;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users SET name=? , email=? , password=? ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $email, $hash]);
}

function checkpassword($password)
{
 return strlen($password) >= 5;
}

function getuserbyid($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

