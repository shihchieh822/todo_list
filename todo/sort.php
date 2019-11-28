<?php
header('Content-Type: application/json; charset=utf-8');
include ('../../db.php');

try {
    $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']); //pdo的連接方式

} catch (PDOException $e) {
    echo "Database connection failed.";
    exit;
}

//sort
$sql = 'UPDATE todos SET `order` = :order  WHERE id = :id ';
 $statement = $pdo ->prepare($sql); 
 foreach ($_POST['orderPair'] as $key => $orderPair) {
 $statement -> bindValue(':order', $orderPair['order'], PDO::PARAM_INT );
$statement->bindValue(':id', $orderPair['id'], PDO::PARAM_INT);
$result = $statement->execute(); //執行$statement
}

//回傳資料給前端
if  (!$result) { 
     echo 'error';//資料庫回傳資料已json格式 向$pdo索取lastInsertId(最後插入的id)
} 
