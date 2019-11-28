<<<<<<< HEAD
<?php
include ('../db.php');


try {
    $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']); //pdo的連接方式

} catch (PDOException $e) {
    echo "Database connection failed.";
    exit;
}

$sql = 'SELECT * FROM todos ORDER BY `order` ASC';//ASC是遞增排序法 DESC是遞減排序法
$statement = $pdo->prepare($sql);
$statement->execute();
$todos = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

 
<script>
    var todos = <?= json_encode($todos, JSON_NUMERIC_CHECK);?>;
</script>

=======
<?php
include ('../db.php');


try {
    $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']); //pdo的連接方式

} catch (PDOException $e) {
    echo "Database connection failed.";
    exit;
}

$sql = 'SELECT * FROM todos ORDER BY `order` ASC';//ASC是遞增排序法 DESC是遞減排序法
$statement = $pdo->prepare($sql);
$statement->execute();
$todos = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

 
<script>
    var todos = <?= json_encode($todos, JSON_NUMERIC_CHECK);?>;
</script>

>>>>>>> add php todo list
