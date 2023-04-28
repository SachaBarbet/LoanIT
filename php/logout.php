<?php
    require '../init.php';

    $_SESSION['isLogged'] = false;
    $_SESSION['isAdmin'] = false;
    $_SESSION['isLenderValid'] = false;
    $_SESSION['user'] = ['name' => '', 'login' => '', 'userID' => ''];

    header("location: ../index.php");
?>