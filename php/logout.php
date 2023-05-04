<?php require '../init.php';


// Déconnexion de l'utilisateur
$_SESSION['isLogged'] = false;
$_SESSION['isAdmin'] = false;
$_SESSION['isLenderValid'] = false;
$_SESSION['user'] = ['name' => '', 'login' => '', 'userID' => ''];

header("location: ../index.php");
exit();
?>