<?php
    require '../init.php';

    $_SESSION['isLogged'] = false;
    $_SESSION['isAdmin'] = false;
    $_SESSION['user'] = ['name' => '', 'lastname' => '', 'login' => ''];

    header("location: ../index.php");
?>