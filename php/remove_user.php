<?php require '../init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ../index.php');
    exit();
}


// Suppression d'un utilisateur
?>