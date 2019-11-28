<?php
header('Content-Type: application/json; charset=utf-8');
include ('../../db.php');

try {
    $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']); //pdo的連接方式

} catch (PDOException $e) {
    echo "Database connection failed.";
    exit;
}



//insert 插入前端所輸入的資料
$sql = 'INSERT INTO todos (content, is_complete, `order`)
           VALUES (:content, :is_complete, :order)';//sql指令
 $statement = $pdo ->prepare($sql); 
 $statement -> bindValue(':content', $_POST['content'], PDO::PARAM_STR );
$statement->bindValue(':is_complete', 0, PDO::PARAM_INT);//complete直接從後台設定
$statement->bindValue(':order', $_POST['order'], PDO::PARAM_INT);
$result = $statement->execute();//執行$statement

//回傳資料給前端
if  ($result) {
     echo json_encode(['id' => $pdo->lastInsertId()]);//資料庫回傳資料已json格式 向$pdo索取lastInsertId(最後插入的id)
} 
