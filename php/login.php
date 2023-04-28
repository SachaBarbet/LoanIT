<?php
    require '../init.php';

    if ($_SESSION['isLogged']) { header('location: ../index.php'); }

    $id = $_POST['id'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO($connect);
        $users = $pdo->query("SELECT userID, name, login, password, type FROM Users WHERE login='{$id}';");
        foreach($users as $user) {
            $userID = $user['userID'];
            $userName = $user['name'];
            $userLogin = $user['login'];
            $passwordHashed = $user['password'];
            $userType = $user['type'];
            break;
        }
        $pdo = null;
    } catch (PDOException $e) {
        die("An error was occured : {$e}");
    }

    if (password_verify($password, $passwordHashed)) {
        // Check s'il y a besoins de redéfinir le hash selon si l'algo a changer
        if (password_needs_rehash($passwordHashed, PASSWORD_DEFAULT)) {
            include './changePassword.php';
        }

        // Check si l'utilisateur est dans la liste des emprunteurs et donc s'il peut emprunter
        $_SESSION['isLenderValid'] = $userType > 0;

        // Mise à jour de la session si l'utilisateur se login
        if ($userType == 2) {
            $_SESSION['isAdmin'] = true;
        }

        $_SESSION['isLogged'] = true;
        $_SESSION['user'] = [
            'name' => $userName,
            'login' => $userLogin,
            'userID' => $userID
        ];
    }
    $_SESSION['tryLogin'] = true;

    header('location: ../index.php');
?>