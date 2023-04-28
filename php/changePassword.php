<?php
    $login = $_POST['id'];
    $password = $_POST['password'];

    $connectUsers = 'sqlite:../data/database.sqlite';

    $newPasswordHashed = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo = new PDO($connectUsers);
        $req = $pdo->prepare('UPDATE Users SET password=? WHERE login=?;');
        $req->execute([$newPasswordHashed, $login]);
        $pdo = null;
    } catch (PDOException $e) {
        die('An error was occured');
    }
?>