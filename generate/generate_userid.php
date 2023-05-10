<?php require './init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ./dashboard.php');
    exit();
}


// Génère une liste des userID pour le select
try {
    $pdo = new PDO($connectBis);
    $resultReq = $pdo->query("SELECT userID, login FROM Users");
    $users = $resultReq->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
} catch (PDOException $e) {
    die($e);
}

foreach ($users as $user) {
    echo "<option value='{$user['userID']}'>{$user['userID']} - {$user['login']}</option>";
}
?>