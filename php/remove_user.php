<?php require '../init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ../index.php');
    exit();
}


// Suppression d'un utilisateur
if (!isset($_POST['userID']) || empty($_POST['userID'])) {
    header('location: ../dashboard.php');
    exit();
}

$userID = $_POST['userID'];

try {
    $pdo = new PDO($connect);
    $req = $pdo->prepare("DELETE FROM Users WHERE userID=?;");
    $req->execute([$userID]);
    $req->closeCursor();
    $pdo = null;
} catch (PDOException $e) {
    die("Error : " . $e);
}

header('location: ../dashboard.php');
exit();
?>