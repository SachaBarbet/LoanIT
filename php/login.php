<?php
    require '../init.php';

    if ($_SESSION['isLogged']) { header('location: ../index.php'); }

    $id = $_POST['id'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO($connectUsers);
        $users = $pdo->query("SELECT name, lastname, login, password, type FROM Users WHERE login='" . $id."';");
        foreach($users as $user) {
            $passwordHashed = $user["password"];
            $userType = $user["type"];
            break;
        }
        $pdo = null;
    } catch (PDOException $e) {
        die('An error was occured : '. $e);
    }

    if (password_verify($password, $passwordHashed)) {
        // Check s'il y a besoins de redéfinir le hash selon si l'algo a changer
        if (password_needs_rehash($passwordHashed, PASSWORD_DEFAULT)) {
            include './changePassword.php';
        }

        // Mise à jour de la session si l'utilisateur se login
        if ($userType === 1) $_SESSION['isAdmin'] = true;
        $_SESSION['isLogged'] = true;
        $_SESSION['user'] = [
            'name' => $user['name'],
            'lastname' => $user['lastname'],
            'login' => $user['login']
        ];
    }
    $_SESSION['tryLogin'] = true;

    header('location: ../index.php');
?>