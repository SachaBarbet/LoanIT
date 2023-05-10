<?php require '../init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ../dashboard.php');
    exit();
}


// Add a new user

if (!isset($_POST['name']) || empty($_POST['name'])) {
    header('location: ../dashboard.php');
    exit();
}

if (!isset($_POST['password']) || empty($_POST['password'])) {
    header('location: ../dashboard.php');
    exit();
}

if (!isset($_POST['observation']) || empty($_POST['observation'])) {
    header('location: ../dashboard.php');
    exit();
}

if (!isset($_POST['type']) || empty($_POST['type'])) {
    header('location: ../dashboard.php');
    exit();
}

$name = $_POST['name'];
$password = $_POST['password'];
$observation = $_POST['observation'];
$type = $_POST['type'];

// Get biggest user ID for the login
try {
    $pdo = new PDO($connect);
    $userID = $pdo->query("SELECT userID FROM Users ORDER BY userID DESC")->fetchAll(PDO::FETCH_ASSOC)[0]["userID"];
    $pdo = null;
} catch (PDOException $e) {
    die("Error : " . $e);
}

$login = $name . "#" . ($userID + 1);

try {
    $pdo = new PDO($connect);
    $req = $pdo->prepare("INSERT INTO Users (name, login, password, observation, type) VALUES (?, ?, ?, ?, ?);");
    $req->execute([$name, $login, $password, $observation, $type]);
    $req->closeCursor();
    $pdo = null;
} catch (PDOException $e) {
    die("Error : " . $e);
}

header('location: ../dashboard.php');
exit();
?>