<?php
header('Content-Type: application/json; charset=utf-8');
include ('../../db.php');

try {
    $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']); //pdo的連接方式

} catch (PDOException $e) {
    echo "Database connection failed.";
    exit;
}



//Complete code
//load todo
$sql = 'SELECT is_complete FROM todos WHERE id = :id';
 $statement = $pdo ->prepare($sql); 
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement->execute();//執行$statement
$todo = $statement->fetch(PDO::FETCH_ASSOC);
//toggle complete status  確認complete狀態  
//save
$sql = 'UPDATE todos SET is_complete = :is_complete WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$statement->bindValue(':is_complete', !$todo['is_complete'], PDO::PARAM_INT);//驚嘆號是反狀態 原本是true變為fales
$result = $statement->execute();//執行$statement


//回傳資料給前端
if  ($result) {
    echo json_encode(['id' => $_POST['id'], 'is_complete' =>!$todo['is_complete']]); //資料庫回傳資料已json格式 向$pdo索取lastInsertId(最後插入的id)
}  else 
 {
    echo 'error';
 }
